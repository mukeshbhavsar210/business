<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller {
    public function index(Request $request) {
        $delivered_orders = Order::with([
                        'user',
                        'items',
                        'orderItems.product.images',
                        'orderItems.product.size',
                        'orderItems.product.color'
                    ])
                    ->where('status','delivered')
                    ->latest('orders.created_at');   
                    
        $pending_orders = Order::with([
                        'user',
                        'items',
                        'orderItems.product.images',
                        'orderItems.product.size',
                        'orderItems.product.color'
                    ])
                    ->where('status','pending')
                    ->latest('orders.created_at'); 

        $shipped_orders = Order::with([
                        'user',
                        'items',
                        'orderItems.product.images',
                        'orderItems.product.size',
                        'orderItems.product.color'
                    ])
                    ->where('status','shipped')
                    ->latest('orders.created_at'); 

        $cancelled_orders = Order::with([
                        'user',
                        'items',
                        'orderItems.product.images',
                        'orderItems.product.size',
                        'orderItems.product.color'
                    ])
                    ->where('status','cancelled')
                    ->latest('orders.created_at'); 

        if($request->get('delivered_keyword') != ""){
            $delivered_orders = $delivered_orders->whereHas('user', function($query) use ($request){
                $query->where('name','like','%'.$request->delivered_keyword.'%')
                    ->orWhere('email','like','%'.$request->delivered_keyword.'%');
            })
            ->orWhere('id','like','%'.$request->delivered_keyword.'%');
        }

        if($request->get('pending_keyword') != ""){
            $pending_orders = $pending_orders->whereHas('user', function($query) use ($request){
                $query->where('name','like','%'.$request->pending_keyword.'%')
                    ->orWhere('email','like','%'.$request->pending_keyword.'%');
            })
            ->orWhere('id','like','%'.$request->pending_keyword.'%');
        }

        if($request->get('shipped_keyword') != ""){
            $shipped_orders = $shipped_orders->whereHas('user', function($query) use ($request){
                $query->where('name','like','%'.$request->shipped_keyword.'%')
                    ->orWhere('email','like','%'.$request->shipped_keyword.'%');
            })
            ->orWhere('id','like','%'.$request->shipped_keyword.'%');
        }

        if($request->get('cancelled_keyword') != ""){
            $cancelled_orders = $cancelled_orders->whereHas('user', function($query) use ($request){
                $query->where('name','like','%'.$request->cancelled_keyword.'%')
                    ->orWhere('email','like','%'.$request->cancelled_keyword.'%');
            })
            ->orWhere('id','like','%'.$request->cancelled_keyword.'%');
        }

        $delivered_orders = $delivered_orders->paginate(10);
        $pending_orders = $pending_orders->paginate(10);
        $shipped_orders = $shipped_orders->paginate(10);
        $cancelled_orders = $cancelled_orders->paginate(10);

        return view('admin.orders.list', compact(
                    'delivered_orders', 
                    'pending_orders', 
                    'shipped_orders',
                    'cancelled_orders'
                ));
    }



    public function detail($orderId){
        $order = Order::select('orders.*','states.name as stateName' )
            ->where('orders.id',$orderId)
            ->leftJoin('states','states.id','orders.state_id')
            ->first();

        $orderItems = OrderItem::with('product.images')->where('order_id',$orderId)->get();

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
