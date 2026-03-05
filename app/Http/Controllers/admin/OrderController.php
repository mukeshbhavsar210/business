<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller {
    public function index(Request $request) {
        $statuses = ['confirmed', 'delivered', 'shipped', 'cancelled'];
        $orders = [];

        foreach ($statuses as $status) {
            $query = Order::with($this->orderRelations())
                ->where('status', $status)
                ->latest('orders.created_at');

            // Apply search only for delivered (if needed)
            if ($status === 'delivered' && $request->filled('delivered_keyword')) {
                $keyword = $request->delivered_keyword;

                $query->where(function ($q) use ($keyword) {
                    $q->whereHas('user', function ($sub) use ($keyword) {
                        $sub->where('name', 'like', "%{$keyword}%")
                            ->orWhere('email', 'like', "%{$keyword}%");
                    })
                    ->orWhere('id', 'like', "%{$keyword}%");
                });
            }

            $orders[$status] = $query->paginate(10, ['*'], $status . '_page');
        }

        return view('admin.orders.list', [
            'confirmed_orders' => $orders['confirmed'],
            'delivered_orders' => $orders['delivered'],            
            'shipped_orders' => $orders['shipped'],
            'cancelled_orders' => $orders['cancelled'],
        ]);
    }

    private function orderRelations() {
        return [
            'user',
            'items',
            'orderItems.product.images',
            'orderItems.product.size',
            'orderItems.product.color'
        ];
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
