<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
    public function index(){
        $states = State::get();
        $data['states'] = $states;

        $shippings = ShippingCharge::select('shipping_charges.*','states.name')->leftJoin('states','states.id','shipping_charges.state_id')->get();

        $data['shippings'] = $shippings;
        return view('admin.shipping.index', $data);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'state_id' => 'required',
            'amount' => 'required|numeric',
        ]);

        if($validator->passes()){
            $count = ShippingCharge::where('state_id',$request->state)->count();
            if($count > 0){
                session()->flash('error','Shipping already added as you selected state.');
                return response()->json([
                    'status' => true,
                ]);
            }

            $shipping = new ShippingCharge();
            $shipping->state_id = $request->state_id;
            $shipping->amount = $request->amount;
            $shipping->save();

            session()->flash('success','Shipping added successfully');

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

    public function destroy($id){
        $shippingCharge = ShippingCharge::find($id);

        if ($shippingCharge == null) {
            session()->flash('error','Shipping not found');

            return response()->json([
                'status' => true,
            ]);
        }

        $shippingCharge->delete();

        session()->flash('success','Shipping deleted successfully');

        return response()->json([
            'status' => true,
        ]);

    }
}
