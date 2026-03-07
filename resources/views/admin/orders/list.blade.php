@extends('admin.layouts.app')

@section('content')

@include('admin.message')

<div class="card mb-0">
    <div class="card-body pb-0">
        <div class="page-title">
            <h4>Orders</h4> 
            <span class="counts">{{ $totalOrders }}</span>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">                                    
        <div class="tab-content">
            <div class="table-responsive browser_users">
                <table class="table table-text mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-top-0" width="55">ID</th>
                            <th class="border-top-0" width="150">Product</th>
                            <th class="border-top-0">Products details</th>
                            <th class="border-top-0 text-end" width="80">Size</th>
                            <th class="border-top-0 text-end" width="80">Color</th>
                            <th class="border-top-0 text-end" width="190">Amount</th>                            
                            <th class="border-top-0 text-end" width="190">Courier</th>                            
                            <th class="border-top-0 text-end" width="120">Status</th> 
                        </tr>
                    </thead>
                    <tbody >
                        @foreach($orders as $key => $order)
                            <tr>
                                <td>
                                    <p class="mt-2">{{ $order->id }}</p>
                                </td>
                                <td>
                                    <div class="img-group">
                                        @foreach($order->items as $item)
                                            @php
                                                $productImage = $item->product->images->first();
                                            @endphp
                                                                        
                                            <a href="{{ route('front.product', $item->product->slug) }}" target="_blank" class="user-avatar position-relative d-inline-block ms-n2">
                                                @if($productImage && !empty($productImage->image))
                                                    <img src="{{ asset('uploads/product/small/'.$productImage->image) }}" height="80" class="thumb-md shadow-sm rounded-circle" />
                                                @else
                                                    <img src="{{ asset('admin-assets/img/default-150x150.png') }}" height="80" class="thumb-md shadow-sm rounded-circle" />
                                                @endif
                                            </a>       
                                            <span class="counts">{{ $order->items->count() }}</span>                                    
                                        @endforeach
                                    </div>
                                </td>                        
                                <td>                                    
                                    @foreach($order->items as $item)                                                                                    
                                        <a href="{{ route('orders.detail',$order->id) }}" title="{{ $order->id }}">                                            
                                            <p><strong>{{ $item->product->title }} </strong></p>
                                        </a>                                        
                                    @endforeach
                                </td>
                                <td class="text-end">
                                    @foreach($order->items as $item)                                                                                    
                                        <p class="text-muted">{{ $item->product->size->code }}</p>
                                    @endforeach
                                </td>
                                <td class="text-end">
                                    @foreach($order->items as $item)                                                                                    
                                        <p class="text-muted">{{ $item->product->size->code }}</p>
                                    @endforeach
                                </td>
                                <td class="text-end">
                                    <h5 class="mb-0">₹{{ number_format($order->grandtotal,2) }}</h5>                                
                                    <p class="m-0 text-muted tiny-font">
                                        {{ $order->payment_method }} ({{ $order->payment_status }})<br />
                                        Order on: {{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}
                                    </p>
                                </td>                                                        
                                <td class="text-end">
                                    <h5 class="mb-0">{{ $order->latestStatus->courier ?? '-' }}</h5>
                                    <p class="m-0 text-muted tiny-font">
                                        {{ $order->latestStatus->tracking_number ?? '-' }}                                        
                                    </p>
                                    <p class="m-0 text-muted tiny-font">
                                        {{ Str::limit($order->latestStatus->note, 20, '...') }}                                        
                                    </p>
                                </td>                                                                
                                <td class="text-end">
                                    <p class="mt-2">                                
                                        <a href="#" class="track-order-btn" data-order-id="{{ $order->id }}" data-bs-toggle="modal" data-bs-target="#orderTrackingModal">
                                            @php
                                                $status = $order->latestStatus->status ?? 'confirmed';

                                                $badgeClasses = [
                                                    'Confirmed'         => 'bg-secondary',
                                                    'Shipped'           => 'bg-primary',
                                                    'Out for Delivery'  => 'bg-warning',
                                                    'Delivered'         => 'bg-success',
                                                    'Cancelled'         => 'bg-danger'
                                                ];
                                            @endphp

                                            <span class="badge {{ $badgeClasses[$status] ?? 'bg-dark' }}">
                                                {{ ucfirst(str_replace('_',' ',$status)) }}
                                            </span>
                                        </a>                                
                                    </p>                    
                                </td>                       
                            </tr>                    
                        @endforeach
                    </tbody>
                </table>  

                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="orderTrackingModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">                                                                        
                <ul class="track-placed-order" id="trackingTimeline">
                    <li>Loading...</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection


@section('customJs')
<script>
    $(document).ready(function(){        
        $('.track-order-btn').click(function(){            
            let orderId = $(this).data('order-id');

            let url = "{{ route('orders.order.tracking', ':id') }}";
            url = url.replace(':id', orderId);

            $.ajax({
                url: url,
                type: "GET",
                success: function(response){
                    let html = '';
                    if(response.length === 0){
                        html = '<li>No tracking available</li>';
                    }else{
                        response.forEach(function(status){
                            html += `
                                <li class="active">
                                    <svg fill="#cccccc" width="22px" height="22px" viewBox="0 0 24 24">
                                        <path d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm5.676,8.237-6,5.5a1,1,0,0,1-1.383-.03l-3-3a1,1,0,1,1,1.414-1.414l2.323,2.323,5.294-4.853a1,1,0,1,1,1.352,1.474Z"/>
                                    </svg>
                                    <p><b>${status.status.replaceAll('_',' ')}</b><br />
                                    <span class="text-muted tiny-font">on ${status.date}</span>
                                    </p>
                                </li>
                            `;
                        });
                    }
                    $('#trackingTimeline').html(html);
                }
            });
        });
    });
</script>
@endsection