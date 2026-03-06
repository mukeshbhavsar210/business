@extends('front.layouts.app')

@section('title', 'My Orders')

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
                    @if($order->address)
                        <p>Mobile: {{ $order->address->mobile }}</p>
                        <p>Email: {{ $order->user->email }}</p>
                    @endif                    
                </div>

                <div class="part">
                    <p><span class="text-muted">Shipping address:</span></p>
                    @if($order->address)
                        <p class="mt-2 mb-2"><b>{{ $order->address->name }}</b><br>
                            {{ $order->address->address }} <br>
                            {{ $order->address->city }}, {{ $order->address->state->name ?? '' }}-{{ $order->address->zip }}
                        </p>                        
                    @endif
                </div>       
                
                <div class="part">
                    <p><span class="text-muted">Payment mode:</span></p>
                    <p class="mt-1">
                        @if($order->payment_mode == 'cod')
                            Cash/Pay on Delivery
                        @else
                            Amount paid with onine tranaction
                        @endif
                    </p>
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