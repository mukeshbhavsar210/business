<?php

use App\Mail\OrderEmail;
use App\Models\Category;
use App\Models\State;
use App\Models\CustomerAddress;
use App\Models\Wishlist;
use App\Models\Order;
use App\Models\Page;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

    function getCategories() {
        return Category::with([
                'subCategories.subSubCategories'
            ])
            ->withCount('products')
            ->orderBy('menu_order', 'asc')
            ->where('status', 1)
            ->where('showHome', 'Yes')
            ->orderBy('id', 'DESC')
            ->take(4)
            ->get();
    }

    function getProductImage($productId){
        return ProductImage::where('product_id',$productId)->first();
    }

    function wishlistCount() {
        if (Auth::check()) {
            return Wishlist::where('user_id', Auth::id())->count();
        }
        return 0;
    }

    function orderEmail($orderId, $userType="customer"){
        $order = Order::where('id',$orderId)->with('items')->first();

        if($userType == 'customer'){
            $subject = 'Thanks for your order';
            $email = $order->email;
        } else {
            $subject = 'You have received an order';
            $email = env('ADMIN_EMAIL');
        }

        $mailData = [
            'subject' => $subject,
            'order' => $order,
            'userType' => $userType,
        ];

        //Mail::to($email)->send(new OrderEmail($mailData));
    }

    function getStateInfo($id){
        return State::where('id',$id)->first();
    }

    function staticPages(){
        $pages = Page::orderBy('menu_order','ASC')->get();
        return $pages;
    }

    
?>
