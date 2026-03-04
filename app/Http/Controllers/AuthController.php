<?php

namespace App\Http\Controllers;

use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\State;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        return view('front.account.login');
    }

    public function register(Request $request){
        return view('front.account.register');
    }

    public function processRegister(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed',
        ]);

        if($validator->passes()) {

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->save();

            session()->flash('success','You have beed registered successfully');

            return response()->json([

                'status' => true,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function authenticate(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->passes()) {

            if(Auth::attempt(['email' => $request->email,'password' => $request->password], $request->get('remember'))) {

                if (session()->has('url.intended')) {
                    return redirect(session()->get('url.intended'));
                }

                return redirect()->route('account.profile');

            } else {
                return redirect()->route('front.home')
                    ->withInput($request->only('email'))
                    ->with('error','Either email/password is incorrect.');
            }

        } else {
            return redirect()->route('front.home')
            ->withErrors($validator)
            ->withInput($request->only('email'));
        }
    }

    public function dashboard(){
        $userId = Auth::user()->id;        
        $user = User::where('id',$userId)->first();        

        return view('front.account.dashboard',[
            'user' => $user,                        
        ]);
    }

    

    public function address(){
        $userId = Auth::user()->id;
        $user = User::where('id',$userId)->first();        
        $address = auth()->user()->addresses()->with('state')->get();
        $addressTypes = CustomerAddress::pluck('address_type')->toArray();  
        $states = State::orderBy('name','ASC')->get();
        
        $data = [
            'user'   => $user,       
            'states' => $states,
            'address' => $address,
            'addressTypes' => $addressTypes,        
            
        //     'createAddress' => [
        //         'title' => 'Create Address',
        //         'modal_id' => 'createAddressModal',
        //         'action' => route('customer.address.store'),
        //         'modal_size' => null,
        //         'method' => 'POST',
        //         'button' => 'Create Address',
        //         'button_class' => 'w-100',
        //         'modal_body' => 'customer-address',
        //         'fields' => [
        //             [
        //                 'type' => 'text',
        //                 'name' => 'name',
        //                 'label' => 'Name',                        
        //                 'animate_label' => 'floating-input',
        //                 'col' => 'col-6 mt-2'
        //             ],
        //             [
        //                 'type' => 'text',
        //                 'name' => 'mobile',
        //                 'label' => 'Mobile',                        
        //                 'animate_label' => 'floating-input',
        //                 'col' => 'col-6 mt-2'
        //             ],
        //             [
        //                 'type' => 'textarea',
        //                 'name' => 'address',
        //                 'label' => 'address',                        
        //                 'animate_label' => 'floating-input',
        //                 'col' => 'col-12'
        //             ],
        //             [
        //                 'type' => 'text',
        //                 'name' => 'locality',
        //                 'label' => 'Locality',                        
        //                 'animate_label' => 'floating-input',
        //                 'col' => 'col-6'
        //             ],
        //             [
        //                 'type' => 'text',
        //                 'name' => 'city',
        //                 'label' => 'City',                        
        //                 'animate_label' => 'floating-input',
        //                 'col' => 'col-6'
        //             ],
        //             [
        //                 'type' => 'select',
        //                 'name' => 'state',
        //                 'label' => 'State',
        //                 'options' => $states->pluck('name','id')->toArray(),
        //                 'animate_label' => null,
        //                 'col' => 'col-6'
        //             ],
        //             [
        //                 'type' => 'text',
        //                 'name' => 'zip',
        //                 'label' => 'Pin Code',                        
        //                 'animate_label' => 'floating-input',
        //                 'col' => 'col-6'
        //             ],                    
        //             [
        //                 'type' => 'radio',
        //                 'name' => 'address_type',
        //                 'label' => 'Address Type',
        //                 'default' => 'Home',
        //                 'options' => [
        //                     'Home' => 'Home',
        //                     'Office' => 'Office',
        //                 ],
        //                 'animate_label' => null,
        //                 'col' => 'col-12'
        //             ],
        //             [
        //                 'type' => 'checkbox',
        //                 'name' => 'default_address',
        //                 'label' => 'Make this as my default Address',    
        //                 'default' => 'Select State',                    
        //                 'animate_label' => null,
        //                 'col' => 'col-12'
        //             ],
                    
        //         ]
        //     ],
        

        // 'EditAddress' => [
        //         'title' => 'Edit Address',
        //         'modal_id' => 'editAddressModal',   
        //         'action' => route('account.processChangePassword'),
        //         'method' => 'POST',
        //         'button' => 'Edit Password',
        //         'button_class' => 'w-100',   
        //         'modal_body' => 'customer-address',             
        //         'fields' => [
        //             [
        //                 'type' => 'password',
        //                 'name' => 'current_password',
        //                 'label' => 'Current Password',
        //                 'col' => 'col-md-12'
        //             ],
        //             [
        //                 'type' => 'password',
        //                 'name' => 'new_password',
        //                 'label' => 'New Password',
        //                 'col' => 'col-md-12'
        //             ],
        //             [
        //                 'type' => 'password',
        //                 'name' => 'new_password_confirmation',
        //                 'label' => 'Confirm Password',
        //                 'col' => 'col-md-12'
        //             ],
        //         ]
        //     ]
        ];  

        return view('front.account.address', $data);
    }

    public function updateAddress(Request $request){
        $userId = Auth::user()->id;

        $validator = Validator::make($request->all(),[
            'name' => 'required|min:5',            
            'mobile' => 'required',            
            'address' => 'required|min:30',
            'city' => 'required',            
            'zip' => 'required'
        ]);

        if($validator->passes()){
            CustomerAddress::updateOrCreate(
                ['user_id' => $userId],
                [
                    'user_id' => $userId,
                    'address_type' => $request->address_type,
                    'default_address' => $request->has('default_address') ? 1 : 0,
                    'name' => $request->name,                    
                    'mobile' => $request->mobile,
                    'email' => $request->email,
                    'address' => $request->address,
                    'locality' => $request->locality,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip' => $request->zip,
                    'state_id' => $request->state_id
                ]
            );

            session()->flash('success','Address updated successfully.');

            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully.'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ]);
        }
    }

     public function cards(){
        $userId = Auth::user()->id;
        $countries = State::orderBy('name','ASC')->get();
        $user = User::where('id',$userId)->first();
        $address = CustomerAddress::where('user_id',$userId)->first();

        return view('front.account.cards',[
            'user' => $user,
            'countries' => $countries,
            'address' => $address
        ]);
    }

    public function profile(){
        $userId = Auth::user()->id;
        $state = State::orderBy('name','ASC')->get();
        $user = User::where('id',$userId)->first();
        $address = CustomerAddress::where('user_id',$userId)->first();

        $data = [
            'user'          => $user,        
            
            'profileFormConfig' => [
                'title' => 'Edit Profile',
                'modal_id' => 'editProfileModal',                
                'action' => route('account.updateProfile'),
                'modal_size' => null,
                'method' => 'POST',
                'button' => 'Update Profile',
                'button_class' => 'w-100',          
                'modal_body' => null,
                'fields' => [
                    [
                        'type' => 'text',
                        'name' => 'name',
                        'label' => 'Name',                        
                        'animate_label' => 'floating-input',
                        'col' => 'col-6 mt-2'
                    ],
                    [
                        'type' => 'text',
                        'name' => 'phone',
                        'label' => 'Phone',                        
                        'animate_label' => 'floating-input',
                        'col' => 'col-6 mt-2'
                    ],
                    [
                        'type' => 'email',
                        'name' => 'email',
                        'label' => 'Email',                        
                        'animate_label' => 'floating-input',
                        'col' => 'col-12 mt-2'
                    ],                    
                    [
                        'type' => 'text',
                        'name' => 'mobile',
                        'label' => 'Mobile',                        
                        'animate_label' => 'floating-input',
                        'col' => 'col-6 mt-2'
                    ],                                   
                    [
                        'type' => 'date',
                        'name' => 'birthdate',
                        'label' => 'Birthdate',                        
                        'animate_label' => 'floating-input',
                        'col' => 'col-6 mt-2'
                    ],
                    [
                        'type' => 'file',
                        'name' => 'image',
                        'label' => 'User Photo',
                        'col' => 'col-6 mt-2'
                    ],
                    [
                        'type' => 'radio',
                        'name' => 'gender',
                        'label' => 'Gender',
                        'options' => [
                            'male' => 'Male',
                            'female' => 'Female',
                        ],
                        'col' => 'col-6'
                    ],     
                    
                ]
            ],
        

        'passwordFormConfig' => [
                'title' => 'Change Password',
                'modal_id' => 'editPasswordModal',   
                'action' => route('account.processChangePassword'),
                'method' => 'POST',
                'button' => 'Update Password',
                'button_class' => 'w-100',
                'modal_body' => null,      
                'fields' => [
                    [
                        'type' => 'password',
                        'name' => 'current_password',
                        'label' => 'Current Password',
                        'col' => 'col-12'
                    ],
                    [
                        'type' => 'password',
                        'name' => 'new_password',
                        'label' => 'New Password',
                        'col' => 'col-6'
                    ],
                    [
                        'type' => 'password',
                        'name' => 'new_password_confirmation',
                        'label' => 'Confirm Password',
                        'col' => 'col-6'
                    ],
                ]
            ]
        ];  

        return view('front.account.profile', $data);
    }

    public function updateProfile(Request $request){
        $userId = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$userId.',id',
            'phone' => 'required',
        ]);

        if($validator->passes()){
            $user = User::find($userId);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->mobile = $request->mobile;
            $user->birthdate = $request->birthdate;
            $user->gender = $request->gender;
            $user->save();

            session()->flash('success','Profile updated successfully.');

            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully.'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ]);
        }
    }

    public function logout(){
        Auth::logout();

        return redirect()->route('front.home')->with('success','You successfully logged out!');;
    }


    public function orders(){
        $user = Auth::user();
        $userId = Auth::user()->id;
        $orders = Order::with('items.product', 'items.product.color', 'items.product.size')
                    ->where('user_id', $user->id)
                    ->latest()
                    ->get();

                     $userId = Auth::user()->id;        

        // $orders = Order::where('user_id', auth()->id())
        //     ->where('status', 'cancelled')
        //     ->with('items.product')
        //     ->latest()
        //     ->get();

        $totalCancelledItems = $orders->sum(function ($order) {
            return $order->items->sum('quantity');
        });
        
        $data['orders'] = $orders;        
        $data['totalCancelledItems'] = $totalCancelledItems; 

        return view('front.account.orders.index', $data);
    }


    public function viewOrder($id) {
        $userId = Auth::user()->id;        
        $order = Order::where('id', $id)
                    ->where('user_id', auth()->id()) // 🔐 security
                    ->with([
                        'orderItems.product',
                        'orderItems.product.images',
                        'orderItems.variant',
                        'state'
                    ])
                    ->firstOrFail();

        return view('front.account.orders.placed_order', compact('order'));
    }
    
    public function orderDetail($id){
        $user = Auth::user();
        $userId = Auth::user()->id;
        $order = Order::where('user_id',$user->id)->where('id',$id)->first();
        $data['order'] = $order;

        $orderItems = OrderItem::where('order_id',$id)->get();
        $data['orderItems'] = $orderItems;

        $orderItemsCount = OrderItem::where('order_id',$id)->count();        

        $data['orderItemsCount'] = $orderItemsCount;        

        return view('front.account.orders.detail',$data);
    }

    public function cancelOrder(Request $request, Order $order) {
        // Security check
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Prevent cancelling shipped/completed orders
        // if (!in_array($order->status, ['pending', 'processing'])) {
        //     return back()->with('error', 'Order cannot be cancelled.');
        // }

        $request->validate([
            'cancel_reason' => 'required|string',
            'cancel_comments' => 'nullable|string|max:500',
        ]);

        $order->update([
            'status' => 'cancelled',
            'cancel_reason' => $request->cancel_reason,
            'cancel_comments' => $request->cancel_comments,
            'cancelled_at' => now(),
        ]);

        return redirect()
            ->route('account.orders')
            ->with('success', 'Order cancelled successfully.');
    }

    public function wishlist(){
        $wishlist = Wishlist::where('user_id', Auth::user()->id)->with(['product'])->get();
        
        $data['wishlist'] = $wishlist;

        return view('front.account.wishlist', $data);
    }


    public function removeProductFromWishlist(Request $request) {
        if (!Auth::check()) {
            return response()->json(['status' => false]);
        }

        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();

            return response()->json([
                'status' => true,
                'message' => 'Item removed from wishlist',
                'wishlistCount' => Wishlist::where('user_id', Auth::id())->count()
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Item removed from wishlist'
        ]);
    }

    // public function removeProductFromWishlist(Request $request){
    //     $wishlist = Wishlist::where('user_id',Auth::user()->id)->where('product_id',$request->id)->first();

    //     if($wishlist == null){
    //         session()->flash('error','Product already removed.');
    //         return response()->json([
    //             'status' => true,
    //         ]);
    //     } else {
    //         Wishlist::where('user_id',Auth::user()->id)->where('product_id',$request->id)->delete();
    //         session()->flash('success','Product removed successfully.');
    //         return response()->json([
    //             'status' => true,
    //         ]);
    //     }
    // }   

    public function changePassword(Request $request){
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required|min:5|same:confirm_password',
            'confirm_password' => 'required'
        ]);

        if ($validator->passes()) {
            $user = User::select('id','password')->where('id',Auth::user()->id)->first();

            if(!Hash::check($request->old_password,$user->password)){
                session()->flash('error','Your old password is incorrect, please try again.');
                return response()->json([
                    'status' => true,
                ]);
            }

            User::where('id',$user->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            session()->flash('success','You have successfully changed your password.');
            return response()->json([
                'status' => true,
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' =>  $validator->errors()
            ]);
        }
    }


    public function address_store(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'address' => 'required',
            'city' => 'required',
            // 'state' => 'required',
            'zip' => 'required',
        ]);

        $validated['user_id'] = auth()->id();

        CustomerAddress::create($validated);

        return back()->with('success', 'Shipping address added successfully');
    }
    

    public function address_update(Request $request, $id) {
        //$address = CustomerAddress::findOrFail($id);
        $address = CustomerAddress::where('user_id', auth()->id())->first();

        $validated = $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'address' => 'required',
            'city' => 'required',
            // 'state' => 'required',
            'zip' => 'required',
        ]);

        $address->update($validated);

        return back()->with('success', 'Shipping Address updated successfully');
    }

}
