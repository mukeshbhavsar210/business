@extends('front.layouts.app')

@section('content')
    <div class="container-small">
        <div class="small-title">
            <h4>Account</h4>
            <p>User name</p>
        </div>
        
        <div class="row">            
            <div class="col-md-3 col-12">
                <div class="sticky">
                    @include('front.account.common.sidebar')  
                </div>
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
                                    <div class="status">
                                        <div class="icon-status"></div>
                                        <div>
                                            @if ($order->status == 'pending')
                                                <span class="pending">Pending</span>
                                            @elseif ($order->status == 'shipped')
                                                <span class="shipped">Shipped</span>
                                            @elseif ($order->status == 'delivered')
                                                <span class="delivered">Delivered</span>
                                            @else
                                                <span class="cancelled">Cancelled</span>
                                            @endif
                                            <p class="date">On {{ \Carbon\Carbon::parse($order->created_at)->format('D, d M Y') }}</p>
                                        </div>
                                    </div>

                                    <div class="product-details">
                                        @foreach($order->items as $item)                                                    
                                            @php
                                                $productImage = getProductImage($item->product_id)
                                            @endphp

                                            <a href="{{ route('account.orderDetail',$order->id) }}" class="product-details-link">
                                                @if (!empty($productImage->image))
                                                    <img class="product" src="{{ asset('uploads/product/small/'.$productImage->image) }}" >
                                                @else
                                                    <img class="product" src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" />
                                                @endif
                                                {{ $item->name }}
                                                {{ $item->qty }}
                                                {{ $item->price }}
                                            </a>
                                            {{-- {{ $item->qty }} x {{ $item->price }} <br> --}}
                                        @endforeach
                                            ₹ {{ number_format($order->grandtotal,2) }}
                                        <div class="gaps">
                                            <p>Exchange/Return window closed on Sun, 2 Mar 2025</p>
                                            <p>Rate & Review to win MynCash!</p>
                                        </div>
                                    </div>
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