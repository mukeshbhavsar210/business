@extends('admin.layouts.app')

@section('content')

@include('admin.message')

    <div class="card mb-0">
        <div class="card-body pb-0">        
            <div class="row">
                <div class="row">
                    <div class="col-sm-9 col-12 d-flex">
                        <h3>Orders</h3>  
                        <span class="counts">{{ $orders->total() }}</span>
                    </div>
                    <div class="col-sm-3 col-12 d-flex">
                        <div class="flexContainer">
                            <form action="" method="get" >
                                <div class="d-flex">
                                    <div class="card-title">
                                        <button type="button" onclick="window.location.href='{{ route('orders.index') }}'" class="btn btn-default btn-sm">
                                            <?xml version="1.0" encoding="utf-8"?>
                                                <svg width="20px" height="20px" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                                                <g fill="none" fill-rule="evenodd" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" transform="matrix(0 1 1 0 2.5 2.5)">
                                                <path d="m3.98652376 1.07807068c-2.38377179 1.38514556-3.98652376 3.96636605-3.98652376 6.92192932 0 4.418278 3.581722 8 8 8s8-3.581722 8-8-3.581722-8-8-8"/>
                                                <path d="m4 1v4h-4" transform="matrix(1 0 0 -1 0 6)"/>
                                                </g>
                                            </svg>
                                        </button>
                                    </div>
                
                                    <div class="card-tools">
                                        <div class="input-group input-group searchMain">
                                            <input value="{{ Request::get('keyword') }}" type="text" name="keyword" class="form-control float-right" placeholder="Search">
                
                                            <div class="input-group-append">
                                                <button type="submit" class="btn">
                                                    <i class="iconoir-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>                        
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body pt-1">            
            <table class="table table-text mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="border-top-0" width="40">ID</th>
                        <th class="border-top-0">Products details</th>
                        <th class="border-top-0 text-end" width="100">Amount</th>
                        <th class="border-top-0 text-end" width="140">Customer</th>
                        <th class="border-top-0 text-end" width="100">AWB</th>
                        <th class="border-top-0 text-end" width="100">Courier</th>                        
                        <th class="border-top-0 text-end" width="130">Order Date</th>
                        <th class="border-top-0 text-end" width="130">Status</th> 
                    </tr>
                </thead>
                <tbody>
                    @if ($orders->isNotEmpty())
                        @foreach($orders as $order)                            
                            <tr>
                                <td>
                                    <p class="mt-4"><a href="{{ route('orders.detail',$order->id) }}">{{ $order->id }}</a></p>
                                </td>
                                <td>                                   
                                    @foreach($order->items as $item)
                                        <div class="mb-2">                                            
                                            @php
                                                $productImage = $item->product->images->first();
                                            @endphp                                                           
                                            <div class="d-flex align-items-center">                              
                                                <a href="{{ route('front.product', $item->product->slug) }}" target="_blank">
                                                    @if($productImage && !empty($productImage->image))
                                                        <img src="{{ asset('uploads/product/small/'.$productImage->image) }}" height="90" class="me-3 align-self-center rounded" />
                                                    @else
                                                        <img src="{{ asset('admin-assets/img/default-150x150.png') }}" height="90" class="me-3 align-self-center rounded" />
                                                    @endif
                                                </a>
                                                <div class="flex-grow-1 text-truncate">
                                                    <h5 class="product-title">
                                                        <a href="{{ route('front.product', $item->product->slug) }}" target="_blank">{{ Str::limit($item->product->title, 75, '...') }}</a>
                                                    </h5>
                                                    <div class="small-fonts">
                                                        <p class="mb-0 text-muted">Color: {{ $item->product->color->name }}, Size: {{ $item->product->size->code }}</p>
                                                        <p class="mb-0 text-muted">{{ $item->qty }} x ₹{{ number_format($item->product->price,2) }}</p>                                                        
                                                    </div>
                                                </div>
                                            </div>                                             
                                        </div>                                                                                                                                          
                                    @endforeach                                        
                                </td>
                                <td class="text-end">
                                    <p class="mb-0 mt-2">₹{{ number_format($order->grandtotal,2) }}</p>
                                </td>
                                <td class="text-end">
                                    <p class="mb-0 mt-2">{{ $order->name }}</p>
                                    <p class="mb-0 text-muted">{{ $order->mobile }}</p>
                                    <p class="mb-0 text-muted">{{ $order->city }}</p>
                                </td>
                                <td class="text-end"><p class="mb-0 mt-2">{{ $order->awb_code ?? '-' }}</p></td>
                                <td class="text-end"><p class="mb-0 mt-2">{{ $order->courier_name ?? '-' }}</p></td>                                
                                <td class="text-end">
                                    <p class="mt-2">{{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</p>
                                </td>
                                <td class="text-end">
                                    <p class="mb-0 mt-2">
                                        @if (!empty($order->shipped_date))
                                            {{ \Carbon\Carbon::parse($order->shipped_date)->format('d M, Y')}}
                                        @else
                                            No
                                        @endif
                                    </p>
                                    <p class="mb-1">
                                        @if ($order->status == 'pending')
                                            <span class="badge bg-danger">Pending</span>
                                        @elseif ($order->status == 'shipped')
                                            <span class="badge bg-info">Shipped</span>
                                        @elseif ($order->status == 'delivered')
                                            <span class="badge bg-success">Delivered</span>
                                        @else
                                            <span class="badge bg-danger">Cancelled</span>
                                        @endif
                                    </p>
                                </td>
                            </tr>
                        @endforeach   
                        @else
                        <tr>
                            <td>Records not found</td>
                        </tr>
                    @endif                 
                </tbody>
            </table>
        </div>

        <div class="card-body clearfix">
            {{ $orders->links() }}
        </div>
</div>    
@endsection
