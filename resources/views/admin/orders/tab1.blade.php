<div class="tab-pane active" id="delivered" role="tabpanel">
    <div class="table-responsive browser_users">
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
                @if ($delivered_orders->isNotEmpty())
                    @foreach($delivered_orders as $order)                            
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
                                    @if ($order->status == 'delivered')
                                        <span class="badge bg-success">Delivered</span>                                    
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
        {{ $delivered_orders->links() }}
    </div>
</div>