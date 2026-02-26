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
                return redirect()->route('account.login')
                    ->withInput($request->only('email'))
                    ->with('error','Either email/password is incorrect.');
            }

        } else {
            return redirect()->route('account.login')
            ->withErrors($validator)
            ->withInput($request->only('email'));
        }
    }

    public function dashboard(){
        $userId = Auth::user()->id;        
        $user = User::where('id',$userId)->first();
        $userDetails = CustomerAddress::where('user_id',$userId)->first();

        return view('front.account.dashboard',[
            'user' => $user,            
            'userDetails' => $userDetails
        ]);
    }

    

    public function address(){
        $userId = Auth::user()->id;
        $states = State::orderBy('name','ASC')->get();
        $user = User::where('id',$userId)->first();        
        $address = auth()->user()->addresses()->with('state')->get();
        $userDetails = CustomerAddress::where('user_id',$userId)->first();  
        $addressTypes = CustomerAddress::pluck('address_type')->toArray();      

        return view('front.account.address',[
            'user' => $user,
            'states' => $states,
            'address' => $address,
            'addressTypes' => $addressTypes,
            'userDetails' => $userDetails,
        ]);
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
        $countries = State::orderBy('name','ASC')->get();
        $user = User::where('id',$userId)->first();
        $address = CustomerAddress::where('user_id',$userId)->first();

        return view('front.account.profile',[
            'user' => $user,
            'countries' => $countries,
            'address' => $address
        ]);
    }

    public function profileEdit(){
        $userId = Auth::user()->id;
        $user = User::where('id',$userId)->first();
        $userDetails = CustomerAddress::where('user_id',$userId)->first();

        return view('front.account.profile_edit',[
            'user' => $user,
            'userDetails' => $userDetails
        ]);
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


    public function updateAddress(Request $request){
        $userId = Auth::user()->id;

        $validator = Validator::make($request->all(),[
            'first_name' => 'required|min:5',
            'last_name' => 'required',
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
                    'default_address' => $request->default_address,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
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


    public function logout(){
        Auth::logout();
        return redirect()->route('account.login')->with('success','You successfully logged out!');;
    }

    public function orders(){
        $user = Auth::user();
        $userId = Auth::user()->id;
        $orders = Order::with('items.product', 'items.product.color', 'items.product.size')
                    ->where('user_id', $user->id)
                    ->latest()
                    ->get();
        $userDetails = CustomerAddress::where('user_id',$userId)->first();

        $data['orders'] = $orders;
        $data['userDetails'] = $userDetails;

        return view('front.account.order', $data);
    }

    public function orderDetail($id){
        $user = Auth::user();
        $userId = Auth::user()->id;
        $order = Order::where('user_id',$user->id)->where('id',$id)->first();
        $data['order'] = $order;

        $orderItems = OrderItem::where('order_id',$id)->get();
        $data['orderItems'] = $orderItems;

        $orderItemsCount = OrderItem::where('order_id',$id)->count();
        $userDetails = CustomerAddress::where('user_id',$userId)->first();

        $data['orderItemsCount'] = $orderItemsCount;
        $data['userDetails'] = $userDetails;

        return view('front.account.order-detail',$data);
    }

    public function wishlist(){
        $wishlists = Wishlist::where('user_id', Auth::user()->id)->with('product')->get();
        $data['wishlists'] = $wishlists;
        return view('front.account.wishlist', $data);
    }

    public function removeProductFromWishlist(Request $request){
        $wishlist = Wishlist::where('user_id',Auth::user()->id)->where('product_id',$request->id)->first();

        if($wishlist == null){
            session()->flash('error','Product already removed.');
            return response()->json([
                'status' => true,
            ]);
        } else {
            Wishlist::where('user_id',Auth::user()->id)->where('product_id',$request->id)->delete();
            session()->flash('success','Product removed successfully.');
            return response()->json([
                'status' => true,
            ]);
        }
    }

    public function changePasswordForm (){
        return view('front.account.password');
    }

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
