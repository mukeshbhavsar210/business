<div class="tab-pane active" id="pending" role="tabpanel">
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
                    <th class="border-top-0 text-end" width="100">Order Date</th>
                    <th class="border-top-0 text-end" width="100">Status</th> 
                </tr>
            </thead>
            <tbody id="orderAccordion">
                @foreach($pending_orders as $key => $order)
                    <tr data-bs-toggle="collapse" data-bs-target="#orderItems{{ $order->id }}" class="accordion-toggle cursor-pointer">
                        <td>
                            <a href="{{ route('orders.detail',$order->id) }}">
                                {{ $order->id }}
                            </a>
                            <i class="bi bi-chevron-down me-2"></i>
                        </td>
                        
                        <td>{{ $order->items->count() }} Item(s)</td>
                        <td class="text-end">₹{{ number_format($order->grandtotal,2) }}</td>
                        <td class="text-end">{{ $order->name }}</td>
                        <td class="text-end">{{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</td>
                        <td class="text-end">
                            @if ($order->status == 'pending')
                                <span class="badge bg-danger">Pending</span>
                            @endif
                        </td>
                    </tr>
    
                    <tr id="orderItems{{ $order->id }}" class="collapse {{ $key == 0 ? 'show' : '' }}" data-bs-parent="#orderAccordion">
                        <td></td>
                        <td colspan="7">
                            @foreach($order->items as $item)
                                @php
                                    $productImage = $item->product->images->first();
                                @endphp

                                <div class="d-flex align-items-center mb-1 border-bottom pb-1">
                                    <a href="{{ route('front.product', $item->product->slug) }}" target="_blank">
                                        @if($productImage && !empty($productImage->image))
                                            <img src="{{ asset('uploads/product/small/'.$productImage->image) }}" height="80" class="me-3 rounded" />
                                        @else
                                            <img src="{{ asset('admin-assets/img/default-150x150.png') }}" height="80" class="me-3 rounded" />
                                        @endif
                                    </a>

                                    <div class="flex-grow-1">
                                        <strong>{{ $item->product->title }}</strong>
                                        <div class="small text-muted">
                                            Color: {{ $item->product->color->name }},
                                            Size: {{ $item->product->size->code }}
                                        </div>
                                        <div class="small text-muted">
                                            {{ $item->qty }} x ₹{{ number_format($item->product->price,2) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>                                         
    </div>
</div>

