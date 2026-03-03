<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\CustomerAddress;
use App\Models\DiscountCoupon;
use App\Models\ShippingCharge;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;
use App\Models\ProductVariant;
use App\Models\State;
use App\Models\Wishlist;
use Razorpay\Api\Api;

class CartController extends Controller {
    public function addToCart(Request $request) {
        $product = Product::with(['product_images','variants'])
            ->find($request->product_id);

        if (!$product) {
            return response()->json([
                "status" => false,
                "message" => "Product not found"
            ]);
        }

        $variantId = $request->variant_id;
        $size      = $request->size ?? 'Default Size';
        $color     = $request->color ?? null;

        // Get selected variant (if exists)
        $variant = null;
        if (!empty($variantId)) {
            $variant = $product->variants->where('id', $variantId)->first();
        }

        // Determine correct image
        $image = $variant && $variant->image
                    ? $variant->image
                    : optional($product->product_images->first())->image;

        // Unique rowId check (product + variant + size)
        $alreadyExists = false;

        foreach (Cart::content() as $item) {
            if (
                $item->id == $product->id &&
                $item->options->variant_id == $variantId &&
                $item->options->size == $size
            ) {
                $alreadyExists = true;
                break;
            }
        }

        if (!$alreadyExists) {
            Cart::add([
                'id'      => $product->id,
                'name'    => $product->title,
                'qty'     => 1,
                'price'   => $product->price, // You can change price based on variant
                'weight'  => 0,
                'options' => [
                    'short_description' => $product->short_description,
                    'compare_price'     => $product->compare_price,
                    'productImage'      => $image,
                    'variant_id'        => $variantId,
                    'size'              => $size,
                    'color'             => $color,
                    'return_days'       => $product->return_days,
                    'delivery_min_days' => $product->delivery_min_days,
                    'delivery_max_days' => $product->delivery_max_days,
                ]
            ]);

            $status  = true;
            $message = $product->title . ' added to Bag.';
            session()->flash('success', $message);
        } else {
            $status  = false;
            $message = $product->title.' already added in cart';
        }
        return response()->json([
            "status"    => $status,
            "message"   => $message,
            "cartCount" => Cart::count(),
        ]);
    }




    public function cart() {
        $cartContent = Cart::content();
        $appliedCouponId = session('applied_coupon_id'); 

        $coupons = DiscountCoupon::where('status', 1)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                ->orWhere('expires_at', '>=', now());
            })
            ->get();     
            
        //dd(Cart::content());        

        return view('front.checkout.cart', [
            'cartContent' => $cartContent,
            'coupons'     => $coupons,
            'appliedCouponId'     => $appliedCouponId,
        ]);
    }



    public function bulkAction(Request $request) {
        $cartIds = $request->cart_ids;   // rowIds
        $action  = $request->action;     // remove or wishlist

        if (!$cartIds || count($cartIds) == 0) {
            return back()->with('error', 'No items selected.');
        }

        // REMOVE ITEMS
        if ($action === 'remove') {
            foreach ($cartIds as $rowId) {
                Cart::remove($rowId);
            }
            return back()->with('success', 'Selected items removed.');
        }

        // MOVE TO WISHLIST
        if ($action === 'wishlist') {
            foreach ($cartIds as $rowId) {
                $item = Cart::get($rowId);
                if ($item) {
                    // Optional: prevent duplicate wishlist entry
                    $exists = Wishlist::where('user_id', auth()->id())
                        ->where('product_id', $item->id)
                        ->exists();

                    if (!$exists) {
                        Wishlist::create([
                            'user_id'   => auth()->id(),
                            'product_id'=> $item->id,
                        ]);
                    }
                    Cart::remove($rowId);
                }
            }
            return back()->with('success', 'Selected items moved to wishlist.');
        }

        return back();
    }

    public function address(Request $request) {
        $selectedIds = $request->cart_ids ?? [];

        if(empty($selectedIds)){
            return back()->with('error','Please select at least one item');
        }

        $cartItems = Cart::content()->filter(function($item) use ($selectedIds){
            return in_array($item->rowId, $selectedIds);
        });

         if (Cart::count() == 0) {
            return redirect()->route('front.cart');
        }

        if (!Auth::check()) {
            if (!session()->has('url.intended')) {
                session(['url.intended' => url()->current()]);
            }
            return redirect()->route('front.home');
        }

        $address = auth()->user()->addresses()->with('state')->get();
        $addressTypes = CustomerAddress::pluck('address_type')->toArray();
        $customerAddress = Auth::user()->address;
        $states = State::orderBy('name', 'ASC')->get();

        $totalQty = Cart::count(); // total items qty
        $totalShippingCharge = 0;

        if ($customerAddress) {
            $shippingInfo = ShippingCharge::where('state_id', $customerAddress->state_id)->first();

            if ($shippingInfo) {
                $totalShippingCharge = $totalQty * $shippingInfo->amount;
            }
        }

        // IMPORTANT: remove formatting to avoid string math
        $subTotal = (float) Cart::subtotal(2, '.', '');

        $discount = session()->get('discount', 0);

        $grandTotal = max($subTotal + $totalShippingCharge - $discount, 0);

        $totalMRP = $cartItems->sum(function($item){
            return $item->options->compare_price * $item->qty;
        });

        $sellingTotal = $cartItems->sum(function($item){
            return $item->price * $item->qty;
        });

        $totalDiscount = $totalMRP - $sellingTotal;
        $totalAmount = $sellingTotal;

        return view('front.checkout.address', [
            'cartItems'             => $cartItems,
            'totalMRP'              => $totalMRP,
            'totalDiscount'         => $totalDiscount,
            'totalAmount'           => $totalAmount,
            'states'                => $states,
            'address'               => $address,
            'addressTypes'          => $addressTypes,
            'totalShiipingCharge' => $totalShippingCharge,
            'discount'            => $discount,
            'subTotal'            => $subTotal,
            'grandTotal'          => $grandTotal
        ]);        
    }
    

    public function checkout() {
        if (Cart::count() == 0) {
            return redirect()->route('front.cart');
        }

        if (!Auth::check()) {
            if (!session()->has('url.intended')) {
                session(['url.intended' => url()->current()]);
            }
            return redirect()->route('front.home');
        }

        $address = auth()->user()->addresses()->with('state')->get();
        $addressTypes = CustomerAddress::pluck('address_type')->toArray();
        $customerAddress = Auth::user()->address;
        $states = State::orderBy('name', 'ASC')->get();

        $totalQty = Cart::count(); // total items qty
        $totalShippingCharge = 0;

        if ($customerAddress) {
            $shippingInfo = ShippingCharge::where('state_id', $customerAddress->state_id)->first();

            if ($shippingInfo) {
                $totalShippingCharge = $totalQty * $shippingInfo->amount;
            }
        }

        // IMPORTANT: remove formatting to avoid string math
        $subTotal = (float) Cart::subtotal(2, '.', '');

        $discount = session()->get('discount', 0);

        $grandTotal = max($subTotal + $totalShippingCharge - $discount, 0);

        //dd(session('cart'));

        return view('front.checkout.address', [
            'states'              => $states,
            'address'             => $address,
            'addressTypes' => $addressTypes,
            'totalShiipingCharge' => $totalShippingCharge,
            'discount'            => $discount,
            'subTotal'            => $subTotal,
            'grandTotal'          => $grandTotal
        ]);
    }

    public function processCheckout(Request $request) {
        // Step 1: Validate selected shipping address
        $validator = Validator::make($request->all(), [
            'default_address_id' => 'required|exists:customer_addresses,id',
            'payment_method'     => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please fix the errors',
                'status'  => false,
                'errors'  => $validator->errors()
            ]);
        }

        $user = Auth::user();

        // Step 2: Get Selected Address (Security Check: must belong to user)
        $selectedAddress = CustomerAddress::where('id', $request->default_address_id)
            ->where('user_id', $user->id)
            ->first();

        if (!$selectedAddress) {
            return response()->json([
                'message' => 'Invalid shipping address selected.',
                'status'  => false
            ]);
        }

        // Step 3: Calculate Subtotal
        $subTotal = Cart::subtotal(2, '.', '');
        $discount = 0;
        $shipping = 0;
        $discountCodeId = null;
        $promoCode = '';

        // Step 4: Apply Coupon (if exists)
        if (session()->has('code')) {
            $code = session()->get('code');

            if ($code->type == 'percent') {
                $discount = ($code->discount_amount / 100) * $subTotal;
            } else {
                $discount = $code->discount_amount;
            }

            $discountCodeId = $code->id;
            $promoCode = $code->code;
        }

        // Step 5: Calculate Shipping Based On Selected Address State
        $totalQty = Cart::content()->sum('qty');

        $shippingInfo = ShippingCharge::where('state_id', $selectedAddress->state_id)->first();

        if ($shippingInfo) {
            $shipping = $totalQty * $shippingInfo->amount;
        } else {
            $restState = ShippingCharge::where('state_id', 'rest_of_state')->first();
            $shipping = $totalQty * ($restState->amount ?? 0);
        }

        $grandTotal = ($subTotal - $discount) + $shipping;

        // Step 6: Create Order
        $order = new Order;
        $order->user_id = $user->id;
        $order->subtotal = $subTotal;
        $order->shipping = $shipping;
        $order->discount = $discount;
        $order->grandtotal = $grandTotal;
        $order->coupon_code_id = $discountCodeId;
        $order->coupon_code = $promoCode;
        $order->payment_status = 'not paid';
        $order->status = 'pending';

        // Shipping Address Data
        $order->name = $selectedAddress->name;
        $order->mobile = $selectedAddress->mobile;
        $order->address = $selectedAddress->address;
        $order->locality = $selectedAddress->locality;
        $order->city = $selectedAddress->city;
        $order->zip = $selectedAddress->zip;
        $order->state_id = $selectedAddress->state_id;
        $order->save();

        // Step 7: Store Order Items + Update Stock
        foreach (Cart::content() as $item) {
            $orderItem = new OrderItem;
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item->id;            
            $orderItem->product_variant_id = $item->options->variant_id ?? null;
            $orderItem->size = $item->options->size ?? null;            
            $orderItem->name = $item->name;
            $orderItem->qty = $item->qty;
            $orderItem->price = $item->price;
            $orderItem->total = $item->price * $item->qty;            
            $orderItem->save();

            // Update Variant Stock
            $variant = ProductVariant::find($item->id);
            if ($variant) {
                $variant->qty -= $item->qty;
                $variant->save();
            }

            // Update Stock
            $product = Product::find($item->id);
            if ($product && $product->track_qty == 'Yes') {
                $product->qty -= $item->qty;
                $product->save();
            }
        }

        // Step 8: Send Order Confirmation Email
        orderEmail($order->id, 'customer');

        // Step 9: Clear Cart & Coupon
        Cart::destroy();
        session()->forget('code');

        return response()->json([
            'message' => 'Order placed successfully.',
            'orderId' => $order->id,
            'status'  => true,
        ]);
    }

    public function thankyou($id){
        $order = Order::with(['orderItems.product', 'orderItems.product.images', 'orderItems.variant'])->findOrFail($id);

        return view('front.checkout.thanks',[
            'id' => $id,
            'order' => $order,
        ]);
    }


    public function updateCartOption(Request $request) {
        $rowId = $request->rowId;

        if (!$rowId) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid request.'
            ]);
        }

        $item = Cart::get($rowId);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Item not found'
            ]);
        }

        // Only update qty
        if ($request->has('qty')) {
            $qty = (int) $request->qty;

            if ($qty <= 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Quantity must be greater than 0.'
                ]);
            }
            
            Cart::update($rowId, $request->qty);

            return response()->json([
                'status' => true,
                'message' => 'Quantity updated successfully'
            ]);
        }
        
        $options = $item->options->toArray();

        if ($request->has('color')) {
            $options['color'] = $request->color;
        }

        if ($request->has('size')) {
            $options['size'] = $request->size;
        }

        // Important: DO NOT overwrite whole options blindly
        Cart::update($rowId, [
            'options' => $options
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cart updated successfully.'
        ]);
    }

    
    public function updateItem(Request $request) {
        $rowId = $request->rowId;
        $item = Cart::get($rowId);

        if(!$item){
            return response()->json([
                'status' => false,
                'message' => 'Item not found'
            ]);
        }

        // Remove old item
        Cart::remove($rowId);

        // Add again with updated data
        Cart::add(
            $item->id,
            $item->name,
            $request->qty,
            $item->price,
            [
                'size' => $request->size,
                'color' => $request->color,
                'short_description' => $item->options->short_description,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Cart updated successfully'
        ]);
    }

    public function updateCart(Request $request){
        $rowId = $request->rowId;
        $qty = $request->qty;

        $itemInfo = Cart::get($rowId);
        $product = Product::find($itemInfo->id);

        //check qty available in stock
        if($product->track_qty == "Yes"){
            if($qty <= $product->qty ){
                Cart::update($rowId, $qty);
                $message = 'Cart updated successfully';
                $state = true;
                session()->flash('success',$message);
            } else {
                $message = 'Requested qty('.$qty.') not available in stock.';
                $state = false;
                session()->flash('error',$message);
            }
        } else {
            Cart::update($rowId, $qty);
            $message = 'Cart updated successfully';
            $state = true;
            session()->flash('success',$message);
        }

        return response()->json([
            "status"=> $state,
            "message"=> $message
        ]);
    }

    public function deleteItem(Request $request){
        $rowId = $request->rowId;
        $itemInfo = Cart::get($rowId);

        if($itemInfo == null ){
            $errorMessage = 'Item not found in cart.';
            session()->flash('error',$errorMessage);
            return response()->json([
                "status"=> false,
                "message"=> $errorMessage,
            ]);
        }

        Cart::remove($request->rowId);

        $success = 'Item removed from Bag.';
        session()->flash('success',$success);
        return response()->json([
            "status"=> true,
            "message"=> $success,
        ]);
    }


    public function moveToWishlist(Request $request){
        $rowId = $request->rowId;
        $itemInfo = Cart::get($rowId);

        if($itemInfo == null ){
            $errorMessage = 'Item not found in cart.';
            return response()->json([
                "status"=> false,
                "message"=> $errorMessage,
            ]);
        }

        // Prevent duplicate wishlist entry
        $alreadyExists = Wishlist::where('user_id', auth()->id())
                            ->where('product_id', $itemInfo->id)
                            ->exists();

        if(!$alreadyExists){
            Wishlist::create([
                'user_id'    => auth()->id(),
                'product_id' => $itemInfo->id,
            ]);
        }

        // Remove from cart
        Cart::remove($rowId);

        return response()->json([
            "status"=> true,
            "message"=> "Item moved to wishlist successfully.",
        ]);
    }


    public function checkout_old(){
        $discount = 0;
        //if cart is empty redirect to cart page
        if (Cart::count() == 0) {
            return redirect()->route('front.cart');
        }

        //if user is not logged in then redirect to login page
        if (Auth::check() == false) {
            if (!session()->has('url.intended')) {
                session(['url.intended' => url()->current()]);
            }

            return redirect()->route('account.login');
        }

        //$customerAddress = CustomerAddress::find(Auth::user()->id);
        $customerAddress = CustomerAddress::where('user_id', Auth::id())->first();
        
        session()->forget('url.intended');

        $states = State::orderBy('name','ASC')->get();

        //Calcuting shipping charges
        if($customerAddress != '' ){
            $userState = $customerAddress->state_id;
            $shippingInfo = ShippingCharge::where('state_id', $userState)->first();

            //echo $shippingInfo->amount;
            $totalQty = 0;
            $totalShiipingCharge = 0;
            $grandTotal = 0;
            foreach (Cart::content() as $item){
                $totalQty += $item->qty;
            }

            $totalShiipingCharge = $totalQty*$shippingInfo->amount;
            $grandTotal = Cart::subtotal(2,'.','')+$totalShiipingCharge;

        } else {
            $grandTotal = Cart::subtotal(2,'.','');
            $totalShiipingCharge = 0;
        }                        

        return view('front.checkout.index',[
            'states' => $states,
            'customerAddress' => $customerAddress,
            'totalShiipingCharge' => $totalShiipingCharge,
            'discount' => $discount,
            'grandTotal' => $grandTotal
        ]);
    }

    public function getOrderSummary(Request $request){

        $subTotal = Cart::subtotal(2,'.','');
        $discount = 0;
        $discountString = '';

        //Appy Discount start here
        if (session()->has('code')) {
            $code = session()->get('code');

            if($code->type == 'percent'){
                $discount = ($code->discount_amount/100)*$subTotal;
            } else {
                $discount = $code->discount_amount;
            }

            $discountString = '<div class="mt-4" id="discount-response">
                <strong>'.session()->get('code')->code.'</strong>
                <a class="btn btn-sm btn-danger" id="remove-discount"><i class="fa fa-times"></i></a>
            </div>';
        }
        //Appy Discount end here


        if($request->state_id > 0){

            $shippingInfo = ShippingCharge::where('state_id', $request->state_id)->first();

            $totalQty = 0;
            foreach (Cart::content() as $item){
                $totalQty += $item->qty;
            }

            if ($shippingInfo != null) {

                $shippingCharge = $totalQty*$shippingInfo->amount;
                $grandTotal = ($subTotal-$discount)+$shippingCharge;

                return response()->json([
                    'status' => true,
                    'grandTotal' => number_format($grandTotal,2),
                    'discount' => number_format($discount,2),
                    'discountString' => $discountString,
                    'shippingCharge' => number_format($shippingCharge,2),
                ]);
            } else {

                $shippingInfo = ShippingCharge::where('state_id','rest_of_state')->first();
                $shippingCharge = $totalQty*$shippingInfo->amount;
                $grandTotal = ($subTotal-$discount)+$shippingCharge;

                return response()->json([
                    'status' => true,
                    'grandTotal' => number_format($grandTotal,2),
                    'discount' => number_format($discount,2),
                    'discountString' => $discountString,
                    'shippingCharge' => number_format($shippingCharge,2),
                ]);
            }
        } else {
            return response()->json([
                'status' => true,
                'grandTotal' => number_format(($subTotal-$discount),2),
                'discount' => number_format($discount,2),
                'discountString' => $discountString,
                'shippingCharge' => number_format(0,2),
            ]);
        }
    }

    // public function applyCoupon(Request $request) {
    //     $couponCode = $request->coupon;

    //     // Example: Flat 100 discount
    //     if ($couponCode == "SAVE100") {
    //         session()->put('discount', 100);
    //         session()->put('coupon', $couponCode);
    //         return back()->with('success', 'Coupon applied!');
    //     }

    //     return back()->with('error', 'Invalid coupon code');
    // }

    // public function applyCoupon(Request $request) {
    //     $coupon = DiscountCoupon::findOrFail($request->coupon_id);

    //     $cartTotal = session('cart_total');

    //     // Minimum amount check
    //     if ($coupon->min_amount && $cartTotal < $coupon->min_amount) {
    //         return back()->with('error', 'Minimum cart value not reached');
    //     }

    //     if ($coupon->type == 'percent') {
    //         $discount = ($cartTotal * $coupon->value) / 100;
    //     } else {
    //         $discount = $coupon->value;
    //     }

    //     session([
    //         'coupon' => $coupon->code,
    //         'discount' => $discount
    //     ]);

    //     return back()->with('success', 'Coupon applied successfully!');
    // }

    public function applyCoupon(Request $request) {
        $coupon = DiscountCoupon::findOrFail($request->coupon_id);

        // Get cart total properly
        $cartTotal = (float) str_replace(',', '', Cart::subtotal());

        // Expiry check
        if ($coupon->expires_at && now()->gt($coupon->expires_at)) {
            return back()->with('error', 'Coupon expired');
        }

        // Minimum amount check
        if ($coupon->min_amount && $cartTotal < $coupon->min_amount) {
            return back()->with('error', 'Minimum cart value not reached');
        }

        // Calculate discount
        if ($coupon->type == 'percent') {
            $discount = ($cartTotal * $coupon->discount_amount) / 100;
        } else {
            $discount = $coupon->discount_amount;
        }

        $discount = min($discount, $cartTotal);

        session([
            'coupon_id' => $coupon->id,
            'coupon_code' => $coupon->code,
            'discount' => $discount
        ]);

        return back()->with('success', 'Coupon applied successfully!');
    }

    public function applyDiscount(Request $request){
        $code = DiscountCoupon::where('code', $request->code)->first();

        if($code == null){
            return response()->json([
                'status' => false,
                'message' => 'Invalid discount coupon',
            ]);
        }

        //Check if coupon start date is valid or not
        $now = Carbon::now();

        if($code->starts_at != ""){
            $startDate = Carbon::createFromFormat('Y-m-d H:i:s',$code->starts_at);

            if($now->lt($startDate)){
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid discount coupon',
                ]);
            }
        }

        if($code->expires_at != ""){
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s',$code->expires_at);

            if($now->gt($endDate)){
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid discount coupon',
                ]);
            }
        }

        //Max uses check start here
        if($code->max_uses > 0){
            $couponUsed = Order::where('coupon_code_id', $code->id)->count();

            if($couponUsed >= $code->max_uses){
                return response()->json([
                    'status' => false,
                    'message' => 'Discount code expired.',
                ]);
            }
        }

        //Max uses user check start here
        if($code->max_uses_user > 0){
            $couponUsedByUser = Order::where(['coupon_code_id' => $code->id, 'user_id' => Auth::user()->id ])->count();

            if($couponUsedByUser >= $code->max_uses_user){
                return response()->json([
                    'status' => false,
                    'message' => 'You already used this coupon!',
                ]);
            }
        }

        $subTotal = Cart::subtotal(2,'.','');

        //Min amount condition check
        if($code->min_amount > 0){
            if($subTotal < $code->min_amount){
                return response()->json([
                    'status' => false,
                    'message' => 'Your min amount must be ₹ '.$code->min_amount.'.00',
                ]);
            }
        }


        session()->put('code',$code);

        return $this->getOrderSummary($request);
    }

    public function removeCoupon() {
        session()->forget(['coupon_id', 'coupon_code', 'discount']);

        return back()->with('success', 'Coupon removed successfully!');
    }

    //Razorpay
    public function razorpayPayment(Request $request){
        if(isset($request->razorpay_payment_id) && $request->razorpay_payment_id != ''){

            $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
            $payment = $api->payment->fetch($request->razorpay_payment_id);
            $response = $payment->capture(array('amount'=>$payment->amount));

            $payment = new Payment();
            $payment->payment_id = $response['id'];
            $payment->product_name = $response['notes']['product_name'];
            $payment->quantity = $response['notes']['quantity'];
            $payment->amount = $response['amount']/1000;
            $payment->currency = $response['currency'];
            $payment->customer_name = $response['notes']['customer_name'];
            $payment->customer_email = $response['notes']['customer_email'];
            $payment->payment_status = $response['status'];
            $payment->payment_method = 'Razorpay';
            $payment->save();

            return redirect()->route('checkout.success');

        } else {
            return redirect()->route('checkout.failed');
        }
    }

    public function razorpaySuccess(){
        return view("front.checkout.success");
    }

    public function razorpayFailed(){
        return view("front.checkout.failed");
    }
}
