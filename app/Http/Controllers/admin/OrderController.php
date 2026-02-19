<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller {
    public function index(Request $request) {
        $orders = Order::with([
                        'user',
                        'orderItems.product.images',
                        'orderItems.product.size',
                        'orderItems.product.color'
                    ])
                    ->latest('orders.created_at');

        if($request->get('keyword') != ""){
            $orders = $orders->whereHas('user', function($query) use ($request){
                $query->where('name','like','%'.$request->keyword.'%')
                    ->orWhere('email','like','%'.$request->keyword.'%');
            })
            ->orWhere('id','like','%'.$request->keyword.'%');
        }

        $orders = $orders->paginate(10);

        return view('admin.orders.list', compact('orders'));
    }



    public function detail($orderId){

        $order = Order::select('orders.*','states.name as stateName' )
            ->where('orders.id',$orderId)
            ->leftJoin('states','states.id','orders.state_id')
            ->first();

        $orderItems = OrderItem::where('order_id',$orderId)->get();

        return view('admin.orders.detail',[
            'order' => $order,
            'orderItems' => $orderItems,
        ]);
    }

    public function changeOrderStatus(Request $request, $orderId){
        $order = Order::find($orderId);
        $order->status = $request->status;
        $order->shipped_date = $request->shipped_date;
        $order->save();

        $message = 'Order status updated successfully';

        session()->flash('success',$message);

        return response()->json([
            'status' => true,
            'message' => $message,
        ]);
    }

    public function sendInvoiceEmail(Request $request, $orderId){
        orderEmail($orderId, $request->userType);

        $message = 'Order email sent successfully';

        session()->flash('success',$message);

        return response()->json([
            'status' => true,
            'message' => $message,
        ]);
    }
}
