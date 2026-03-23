<?php

namespace App\Http\Controllers;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\CustomerAddress;
use App\Models\DiscountCoupon;
use App\Models\OrderStatusHistory;
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
use Illuminate\Support\Facades\Mail;

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
                $item->options->size == $size &&
                $item->options->color == $color
            ) {
                $alreadyExists = true;
                break;
            }
        }

        if (!$alreadyExists) {
            $discountPercent = 0;

            if ($product->discount) {
                $discountPercent = $product->discount->percentage;
            }
            // ✅ Get discount percent safely
            $discountPercent = (int) optional($product->discount)->percentage;
            //$discountPercent = optional($product->discounts->first())->percentage ?? 0;

            // ✅ Calculate discount price
            $discount_price = $product->price;

            if ($discountPercent > 0) {
                $discount_price = $product->price - ($product->price * $discountPercent / 100);
            }

            Cart::add([
                'id'      => $product->id,
                'name'    => $product->title,
                'qty'     => 1,                
                'price'   => round($product->price),                
                'weight'  => 0,
                'options' => [
                    'original_price'    => $product->price,
                    'discount_price'    => round($discount_price),
                    'discount_percent'  => $discountPercent,                    
                    'short_description' => $product->short_description,                    
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

    public function wishlistToCart(Request $request) { 
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
            // ✅ Get discount percent safely
            $discountPercent = optional($product->discounts->first())->percentage ?? 0;

            // ✅ Calculate discount price
            $discount_price = $product->price;

            if ($discountPercent > 0) {
                $discount_price = $product->price - ($product->price * $discountPercent / 100);
            }

            Cart::add([
                'id'      => $product->id,
                'name'    => $product->title,
                'qty'     => 1,                
                'price'   => round($product->price),                
                'weight'  => 0,
                'options' => [
                    'original_price'    => $product->price,
                    'discount_price'    => round($discount_price),
                    'discount_percent'  => $discountPercent,                    
                    'short_description' => $product->short_description,                    
                    'productImage'      => $image,
                    'variant_id'        => $variantId,
                    'size'              => $size,
                    'color'             => $color,
                    'return_days'       => $product->return_days,
                    'delivery_min_days' => $product->delivery_min_days,
                    'delivery_max_days' => $product->delivery_max_days,
                ]
            ]);

            // ✅ Remove from wishlist
            Wishlist::where('id', $request->wishlist_id)
                    ->where('user_id', auth()->id())
                    ->delete();

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
        $appliedCouponId = session('coupon_discount.id'); 

        $coupons = DiscountCoupon::where('status', 1)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                ->orWhere('expires_at', '>=', now());
            })
            ->get();   
        
        if(auth()->check()){
            $address = auth()->user()->addresses()->with('state')->get();
            $customerAddress = Auth::user()->address;
        }else{
            $address = collect(); // empty collection
        }
        $addressTypes = CustomerAddress::pluck('address_type')->toArray();        
        $states = State::orderBy('name', 'ASC')->get(); 
        $delivery_address = CustomerAddress::with('state')->get();
        $homeExists = CustomerAddress::where('user_id', auth()->id())
            ->where('address_type', 'Home')
            ->exists();        

        $qty = Cart::count();
        $selectedIds = $request->cart_ids ?? [];
        $shipping_charge = 0;
        $customerAddress = CustomerAddress::where('user_id', Auth::id())->first();        

        if($customerAddress){
            $shippingInfo = ShippingCharge::where('state_id', $customerAddress->state_id)->first();

            if($shippingInfo && Cart::count() > 0){
                $shipping_charge = $shippingInfo->amount;
            }
        }

        $cartItems = Cart::content()->filter(function($item) use ($selectedIds){
            return in_array($item->rowId, $selectedIds);
        });

        // IMPORTANT: remove formatting to avoid string math
        $cartItems = Cart::content();

        $discount_price = $cartItems->sum(function ($item) {
            return ($item->options->discount_price ?? 0) * $item->qty;
        });

        // $discount_percentage = $cartItems->sum(function ($item) {
        //     return ($item->options->discount_percent ?? 0) * $item->qty;
        // });
                
        $discountPrice = $discount_price;
        //$discountPercent = $discount_percentage;
        $store_discount = session()->get('coupon_discount');
        $coupon_discount = session()->get('coupon_discount.discount', 0);
        $coupon_code = session()->get('coupon_discount.code', 0);        
            
        //dd(Cart::content());
        //dd(session('coupon_discount'));                

        return view('front.checkout.cart', [
            'discountPrice'         => $discountPrice,
            //'discountPercent'       => $discountPercent,
            'store_discount'        => $store_discount,
            'coupon_code'           => $coupon_code,
            'coupon_discount'       => $coupon_discount,
            'homeExists'            => $homeExists,            
            'delivery_address'      => $delivery_address,
            'address'               => $address,
            'addressTypes'          => $addressTypes,
            'states'                => $states,
            'cartContent'           => $cartContent,
            'coupons'               => $coupons,
            'appliedCouponId'       => $appliedCouponId,
            'shipping_charge'       => $shipping_charge,
        ]);
    }   

     // Generate Razorpay Order
    public function processCheckout_latest(Request $request) {
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
        $amount = floatval($request->amount) * 100; // Convert to paise   

        $order = $api->order->create([
            'receipt' => 'order_'.rand(1000, 9999),
            'amount'  => $amount, // Amount in paise (₹100)
            'currency' => 'INR',
            'payment_capture' => 1 // Auto capture payment
        ]);
        //Cart::destroy();

        return response()->json([
            'order_id' => $order['id'],
            'key' => config('services.razorpay.key'),
            'amount' => $order['amount'],
        ]);
    }

    // Verify Payment
     public function verifyPayment(Request $request) {
        $amount = $request->amount ?? 0;
        $order_notes = $request->order_notes;                
        $country = $request->country;
        $address_type = $request->address_type; 

        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            $attributes = [
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            //Step 1: apply validations while make orders
            $validator = Validator::make($request->all(),[
               
            ]);

            if ($validator->fails()){
                return response()->json([
                    'message' => 'Please fix the errors',
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }

            $user = Auth::user();

            if ($address_type === 'home') {
                CustomerAddress::where('user_id', $user->id)
                                ->whereNotNull('delivery_at')
                                ->update(['delivery_at' => null]);

                $homeAddress = CustomerAddress::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'type' => 'home'
                    ],
                    [
                        'country_id' => $country,
                        'notes' => $order_notes,
                        'delivery_at' => 'home',
                    ]
                );
            } elseif ($address_type === 'office') {
                $officeAddress = CustomerAddress::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'type' => 'office'
                    ],
                    [
                        'country_id' => $country,
                        'notes' => $order_notes,
                        'delivery_at' => 'office',
                    ]
                );
            }
            
            //Step 3: Store data in orders table
            $discountCodeId = NULL;
            $promoCode = '';
            $shipping = 0;
            $discount = 0;
            $subTotal = Cart::subtotal(2,'.','');

            // Apply Discount
            if (session()->has('coupon_discount')) {
                $code = session()->get('coupon_discount');
                if($code->type == 'percent'){
                    $discount = ($code->discount_amount/100)*$subTotal;
                } else {
                    $discount = $code->discount_amount;
                }
                $discountCodeId = $code->id;
                $promoCode = $code->code;
            }

            // Calculate shipping
            $shippingInfo = ShippingCharge::where('state_id', $request->state)->first();

            $totalQty = 0;
            foreach (Cart::content() as $item){
                $totalQty += $item->qty;
            }

            if ($shippingInfo != null) {
                $shipping = $totalQty*$shippingInfo->amount;
                $grandTotal = ($subTotal-$discount)+$shipping;
            } else {
                $shippingInfo = ShippingCharge::where('state_id','rest_of_world')->first();
                $shipping = $totalQty*$shippingInfo->amount;
                $grandTotal = ($subTotal - $discount)+$shipping;
            }

            //Update product stock
            $productData = Product::find($item->id);
            if($productData->track_qty == 'Yes'){
                $currentQty = $productData->qty;
                $updatedQty = $currentQty-$item->qty;
                $productData->qty = $updatedQty;
                $productData->save();
            }   

            $order = Order::create([
                'user_id' => $user->id,
                'product_id' => $item->id,
                'customer_address_id' => $item->customer_address_id,                
                'subtotal' => $subTotal,
                'shipping' => $shipping,
                'coupon_code' => $promoCode,
                'coupon_code_id' => $discountCodeId,
                'discount' => $discount,
                // 'qty' => $item->qty,
                // 'price' => $item->price,
                'grandtotal' => $grandTotal,
                'status' => 'pending',
            ]);        
            
            foreach (Cart::content() as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->id,                    
                    'product_variant_id' => $item->options->variant_id,
                    'name' => $item->name,                    
                    'color' => $item->options->color,
                    'size' => $item->options->size,                    
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'total' => $item->price * $item->qty,                    
                ]);
            }

            Payment::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'variant_id' => $item->variant_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_order_id' => $request->razorpay_order_id,
                'payment_mode' => $request->payment_mode ?? 'Online',
                'amount' => $item->price * $item->qty,
                'status' => 'Paid',
                'currency' => $request->currency ?? 'INR',
                'payment_data' => json_encode($request->all()),               
            ]);

            //SHIPROCKET ORDER
            if ($request->payment_status === 'success') {
                $payment = $order->payment;
                $payment->status = 'Paid';
                $payment->save();
        
                // Create shipping order in Shiprocket
                //$response = ShiprocketService::createOrder($order);
        
                if (isset($response['order_id'])) {
                    $order->shiprocket_order_id = $response['order_id'];
                    $order->awb_code = $response['awb_code'] ?? null;
                    $order->courier_name = $response['courier_company_id'] ?? null;
                    $order->shipment_status = 'Shipped';
                    $order->save();
                }
        
                return redirect()->route('thankyou')->with('success', 'Order placed & shipped.');
            }

            //Send confirmed order email
            //orderEmail($order->id, 'customer');

             // ✅ 1. Send email to Customer
            $customerMailData = [
                'order' => $order,
                'userType' => 'customer',
            ];

            Mail::send('email.order', ['mailData' => $customerMailData], function ($message) use ($customerMailData) {
                $message->to($customerMailData['order']->user->email)
                        ->subject('Thank You for Your Order! Keep shopping');
            });

            // ✅ 2. Send email to Admin
            $adminMailData = [
                'order' => $order,
                'userType' => 'admin',
            ];

            Mail::send('email.order', ['mailData' => $adminMailData], function ($message) use ($adminMailData) {
                $message->to('info@heavenprints.in') // Replace with actual admin email or config value
                        ->subject('New Order Received');
            });

            Cart::destroy();

            session()->forget(['grand_total']);

            return response()->json([
                'status' => 'success', 
                'orderId' => $order->id,
                'message' => 'Payment verified successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Payment Verification Failed: ' . $e->getMessage());
            return response()->json(['status' => 'failed', 'message' => 'Payment verification failed'], 500);
        }
    }

    public function processCheckout(Request $request) {
        // Step 1: Validate selected shipping address
        $validator = Validator::make($request->all(), [
            'customer_address_id' => 'required|exists:customer_addresses,id',
            'payment_method' => 'required|in:cod,razorpay'
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
        $selectedAddress = CustomerAddress::where('id', $request->customer_address_id)
            ->where('user_id', $user->id)
            ->first();

        if (!$selectedAddress) {
            return response()->json([
                'message' => 'Invalid shipping address selected.',
                'status'  => false
            ]);
        }

        // Step 3: Calculate Subtotal
        //$subTotal = Cart::subtotal(2, '.', '');
        $subTotal = 0;
        foreach (Cart::content() as $item) {
            $price = $item->options->discount_price ?? $item->price;
            $subTotal += $price * $item->qty;
        }

        $discount = 0;
        $shipping = 0;
        $discountCodeId = null;
        $promoCode = '';

        // Step 4: Apply Coupon (if exists)
        if(session()->has('coupon_discount')){
            $coupon = session('coupon_discount');

            if($coupon['type'] == 'percent'){
                $discount = ($coupon['value'] / 100) * $subTotal;
            }else{
                $discount = $coupon['value'];
            }

            $discountCodeId = $coupon['id'];
            $promoCode = $coupon['code'];
        }

        // Step 5: Calculate Shipping Based On Selected Address State
        $qty = Cart::content()->sum('qty');

        $shippingInfo = ShippingCharge::where('state_id', $selectedAddress->state_id)->first();

        if ($shippingInfo) {
            $shipping = $shippingInfo->amount ?? 0;
        } else {
            $restState = ShippingCharge::where('state_id', 'rest_of_state')->first();
            $shipping = $qty * ($restState->amount ?? 0);
        }

        $grandTotal = ($subTotal - $discount) + $shipping;

        // Step 6: Create Order
        $order = new Order;
        $order->user_id = $user->id;
        $order->product_id = $order->id;
        $order->product_variant_id = $item->options->variant_id ?? null;
        $order->customer_address_id = $request->customer_address_id;
        $order->subtotal = $subTotal;
        $order->shipping = $shipping;
        $order->discount = $discount;
        $order->grandtotal = $grandTotal;
        $order->coupon_code_id = $discountCodeId;
        $order->coupon_code = $promoCode;
        $order->payment_status = 'not paid';
        $order->payment_method = $request->payment_method;        
        $order->save();

        OrderStatusHistory::create([
            'order_id' => $order->id,
            'courier' => 'Shadofox',
            'note' => 'note',
            'status' => 'confirmed',
            'date' => now()
        ]);

        // Step 7: Store Order Items + Update Stock
        foreach (Cart::content() as $item) {
            $orderItem = new OrderItem;
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item->id;
            $orderItem->qty = $item->qty;
            $orderItem->price = $item->price;                       
            $orderItem->product_variant_id = $item->options->variant_id ?? null;
            $orderItem->size = $item->options->size ?? null;                        
            $orderItem->color = $item->options->color;
            $orderItem->total = $subTotal;  
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

        if($order->coupon_id){
            DiscountCoupon::where('id',$order->coupon_id)->increment('used_count');
        }

        // Step 8: Send Order Confirmation Email
        orderEmail($order->id, 'customer');

        // Step 9: Clear Cart & Coupon
        Cart::destroy();
        session()->forget('coupon_discount');

        // Step 10: Handle COD
        if($request->payment_method == 'cod'){
            return response()->json([
                'status' => true,
                'orderId' => $order->id,
                'payment_method' => 'cod'
            ]);
        }

        // Setp 11: Razorpay payment
        $grandTotal = $request->grand_total;
        
        $api = new Api(config('razorpay.key'),config('razorpay.secret'));        

        $orderData = [
            'receipt'         => 'order_'.$order->id,
            'amount'          => $grandTotal * 100, // Razorpay uses paise
            'currency'        => 'INR',            
        ];

        $razorpayOrder = $api->order->create($orderData);

        return response()->json([
            'status' => true,
            'orderId' => $order->id,
            'razorpay_order_id' => $razorpayOrder['id'],
            'amount' => $orderData['amount'],
            'key' => config('razorpay.key')
        ]);
       
        return response()->json([
            'message' => 'Order placed successfully.',
            'orderId' => $order->id,
            'payment_method' => $request->payment_method,
            'status'  => true,
        ]);
    }

    public function thankyou($id){
        $order = Order::where('id', $id)
                ->where('user_id', auth()->id()) // 🔐 security
                ->with([
                    'orderItems.product',
                    'orderItems.product.images',
                    'orderItems.variant',
                    'address.state'
                ])
                ->firstOrFail();

        return view('front.checkout.thanks',[
            'id' => $id,
            'order' => $order,
        ]);
    }

    public function updateDefaultAddress(Request $request) {
        $request->validate([
            'address_id' => 'required'
        ]);
        
        $addressId = $request->address_id;
        $userId = auth()->id();

        CustomerAddress::where('user_id', $userId)->update([
            'default_address' => 0
        ]);

        CustomerAddress::where('id', $addressId)->update([
            'default_address' => 1
        ]);

        // DELETE ADDRESS
        if($request->action == 'delete'){
            $address = CustomerAddress::where('id',$addressId)
                        ->where('user_id',$userId)
                        ->first();

            $wasDefault = $address->default_address;
            $address->delete();

            // If deleted address was default
            if($wasDefault == 1){
                $otherAddress = CustomerAddress::where('user_id',$userId)->first();
                if($otherAddress){
                    $otherAddress->update([
                        'default_address' => 1
                    ]);
                }
            }

            return back()->with('success','Address deleted successfully');
        }

        return redirect()->back()->with('success','Default address updated');
    }

    public function bulkAction(Request $request) {        

        $checkedIds = $request->cart_ids ?? [];
        
        foreach (Cart::content() as $item) {
            if (!in_array($item->rowId, $checkedIds)) {
                Cart::remove($item->rowId);
            }
        }

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

    public function payment(Request $request) {
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
        $homeExists = CustomerAddress::where('user_id', auth()->id())
            ->where('address_type', 'Home')
            ->exists();

        $totalQty = Cart::count(); // total items qty
        $shipping_charge = 0;

        if ($customerAddress) {
            $shippingInfo = ShippingCharge::where('state_id', $customerAddress->state_id)->first();

            if ($shippingInfo) {
                $shipping_charge = $totalQty * $shippingInfo->amount;
            }
        }

        // IMPORTANT: remove formatting to avoid string math
        $price_total = $cartItems->sum(function($item){
            return $item->price * $item->qty;
        });

        $price_discount = $cartItems->sum(function($item){
            return $item->options->compare_price * $item->qty;
        });

        $sub_total = $price_total - $price_discount;        
        $coupon_discount = session()->get('discount', 0);
        $grand_total = max($sub_total + $shipping_charge - $coupon_discount, 0);

        return view('front.checkout.payment', [
            'homeExists'            => $homeExists,
            'states'                => $states,
            'address'               => $address,
            'addressTypes'          => $addressTypes,
            'cartItems'             => $cartItems,
            'price_total'           => $price_total,
            'price_discount'        => $price_discount,
            'coupon_discount'       => $coupon_discount,
            'shipping_charge'       => $shipping_charge,            
            'grand_total'           => $grand_total
        ]);        
    }

    public function selectItem(Request $request) {
        $selected = session()->get('checkout_items', []);

        if($request->checked == "true"){
            $selected[$request->id] = $request->id;
        }else{
            unset($selected[$request->id]);
        }

        session()->put('checkout_items', $selected);

        return response()->json(['success'=>true]);
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

    public function applyCoupon(Request $request) {
        $coupon = DiscountCoupon::findOrFail($request->coupon_id);

        // Get cart subtotal as number
        $cartTotal = (float) str_replace(',', '', Cart::subtotal());

        // Coupon expiry check
        if ($coupon->expires_at && now()->gt($coupon->expires_at)) {
            return back()->with('error', 'Coupon expired');
        }

        // Minimum cart value check
        if ($coupon->min_amount && $cartTotal < $coupon->min_amount) {
            return back()->with('error', 'Minimum cart value not reached');
        }

        // Calculate discount
        if ($coupon->type == 'percent') {
            $discount = ($cartTotal * $coupon->discount_amount) / 100;
        } else {
            $discount = $coupon->discount_amount;
        }

        // Prevent discount > cart total
        $discount = min($discount, $cartTotal);

        // Store coupon in session
        session()->put('coupon_discount', [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->discount_amount,
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
        if(session()->has('coupon_discount')){
            session()->forget('coupon_discount');
        }

        return response()->json([
            'status' => true,
            'message' => 'Coupon removed successfully'
        ]);
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

    public function failed(){
        return view("front.checkout.failed");
    }   

     public function getOrderSummary2(Request $request){
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

            $discountString = '<div id="discount-response">
                <div class="card-body p-2">
                    <strong>'.session()->get('code')->code.'</strong>
                    <a id="remove-discount"><i class="fa fa-times"></i></a>
                </div>
            </div>';
        }
        //Appy Discount end here


        if($request->country_id > 0){
            $shippingInfo = ShippingCharge::where('country_id', $request->country_id)->first();

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
                $shippingInfo = ShippingCharge::where('country_id','rest_of_world')->first();
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

    public function getProductColors($id) {
        $product = Product::with('colors')->find($id);

        return response()->json([
            'colors' => $product->colors->map(function($color){
                return [
                    'id' => $color->id,
                    'name' => $color->name,
                    'code' => $color->code // optional (hex color)
                ];
            })
        ]);
    }

    public function getProductSizes($id) {
        $product = Product::with('sizes')->find($id);

        return response()->json([
            'sizes' => $product->sizes->map(function($size){
                return [
                    'id' => $size->id,
                    'name' => $size->name,
                    'code' => $size->code 
                ];
            })
        ]);
    }

}
