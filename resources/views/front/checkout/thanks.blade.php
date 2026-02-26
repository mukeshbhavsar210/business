@extends('front.layouts.app')

@section('content')    

@if (Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success')}}
    </div>
@endif

<div class="container">
    <div class="order-summary">
        <div class="card">
            <div class="card-header">
                <h2>Thank You</h2>
            </div>
            <div class="card-body">
                <h4 class="mb-4">Order ID: {{ $id }}</h4>

                <table class="table table-border">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Name</th>
                            <th scope="col">Color</th>
                            <th scope="col">Size</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    @php
                                        $thumb = $item->product->images->first();
                                    @endphp
                                                                        
                                    @if($thumb->image)
                                        <img src="{{ asset('uploads/product/small/'.$thumb->image) }}" width="80" class="img-fluid rounded">
                                    @endif                                                    
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    @if($item->color)
                                        <small class="text-muted">{{ $item->color }}</small><br>
                                    @endif
                                </td>
                                <td>
                                    @if($item->size)
                                        <small class="text-muted">{{ $item->size }}</small><br>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $item->qty }} </small>                    
                                </td>
                                <td>
                                    <strong>₹{{ number_format($item->total,2) }}</strong>
                                </td>                            
                            </tr>
                        @endforeach            
                    </tr>
                    </tbody>
                </table>

                <div class="totals text-end">
                    <p>Subtotal: ₹{{ number_format($order->subtotal,2) }}</p>
                    <p>Shipping: ₹{{ number_format($order->shipping,2) }}</p>
                    @if($order->discount > 0)
                        <p>Discount: -₹{{ number_format($order->discount,2) }}</p>
                    @endif
                    <h5>Grand Total: ₹{{ number_format($order->grandtotal,2) }}</h5>
                </div>
            </div>            
        </div>
    </div> 
</div>   
@endsection