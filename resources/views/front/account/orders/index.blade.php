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
                    <div class="row">            
                        <div class="col-md-6 col-12">
                            <h3>All Orders</h3>
                            <p>From anytime</p>
                        </div>
                        <div class="col-md-6 col-12">1</div>
                    </div>
                    
                    <div class="order-history">
                        @if ($orders->isNotEmpty())
                            @foreach ($orders as $order)
                                <div class="individual">
                                    @if ($order->status == 'confirmed')
                                        @include('front.account.orders.confirmed_order')
                                    @elseif ($order->status == 'shipped')                                       
                                        @include('front.account.orders.shipped_order')
                                    @elseif ($order->status == 'delivered')
                                        @include('front.account.orders.delivered_order')
                                    @elseif ($order->status == 'cancelled')
                                        @include('front.account.orders.cancelled_order')                                        
                                    @endif
                                </div>
                            @endforeach
                            @else
                                Orders not found                                    
                        @endif                                                
                    </div>
                </div>       
            </div>
        </div>
    </div>



@endsection