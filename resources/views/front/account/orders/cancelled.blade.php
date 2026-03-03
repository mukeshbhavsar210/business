@extends('front.layouts.app')

@section('content')
    <div class="container-small">
        <div class="small-title">
            <h4>Account</h4>
            <p>{{ $userDetails->name }}</p>
        </div>
        
        <div class="row">            
            <div class="col-md-3 col-12">                
                @include('front.account.common.sidebar')  
            </div>
            <div class="col-md-9 col-12">
                <div class="details-accounts">
                    <div class="order-history">
                        <h3>Order Cancelled</h3>

                        <p>{{ $totalCancelledItems }} Item is a cancelled</p>

                        @forelse($orders as $order)
                            <div class="card mb-4">
                                <div class="card-body">                                        
                                    <p><strong>Reason:</strong> {{ $order->cancel_reason }}</p>                                                                        
                                    @foreach($order->items as $item)
                                        <div class="d-flex align-items-center mb-3">
                                            <img src="{{ asset('uploads/product/small/'.$item->product->image) }}" width="80" class="me-3">
                                            {{ $item->product->title }}                            
                                            Quantity: {{ $item->quantity }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <p>No cancelled orders found.</p>
                        @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection