@extends('front.layouts.app')

@section('content')

<div class="container-small">
    <div class="small-title">
        <h4>Account</h4>
        <p>{{ currentUserName() }}</p>
    </div>
        
    <div class="row">            
        <div class="col-md-3 col-12">                
            @include('front.account.common.sidebar')  
        </div>
        <div class="col-md-9 col-12">
            <div class="details-accounts">
                <div class="part">
                    <p><span class="text-muted">Placed on:</span> {{ $order->created_at->format('d M Y') }}</p>
                    <p><span class="text-muted">Order No.</span> {{ $order->id }}</p>
                    <p><span class="text-muted">Price Details:</span> <b>Total: ₹{{ $order->grandtotal }}</b></p>
                </div>

                <div class="part">
                    <p><span class="text-muted">Update sent to:</span></p>
                    <p>{{ $order->mobile }}</p>
                    <p>{{ $order->user->email }}</p>
                </div>

                <div class="part">
                    <p><span class="text-muted">Shipping address:</span></p>
                    <p class="mt-2"><b>{{ $order->name }}</b><br>
                        {{ $order->address }} <br>
                        {{ $order->city }}, {{ $order->state->name ?? '' }}-{{ $order->zip }}
                    </p>
                </div>       
                
                <div class="part">
                    <p><span class="text-muted">Payment mode:</span></p>
                    <p class="mt-2">Cash/Pay on Delivery</p>
                </div>

                <div class="part">
                    <p class="mb-3"><b>Item in this order</b></p>

                    <div class="product-card">
                        @foreach($order->orderItems as $item)
                            <a href="{{ route('account.orderDetail',$order->id) }}" class="details">
                                <div class="image">
                                    <img src="{{ asset('uploads/product/small/'.$item->product->images->first()->image ?? '') }}"  class="img-fluid">
                                </div>
                                <div>{{ $item->product->title }} </div>
                            </a>
                        @endforeach
                    </div>                         
                </div>
            </div>
        </div>
    </div>
@endsection