<div class="status shipped">
    <div class="icon"></div>
    <div class="name">
        <p><b>Shipped</b></p>
        <p class="date">On {{ \Carbon\Carbon::parse($order->shipped_date)->format('D, d M Y') }}</p>
    </div>
</div>

<div class="product-details">
    @foreach($order->items as $item)  
        <a href="#" class="product-details-link" data-bs-toggle="modal" data-bs-target="#shippedOrder_{{ $order->id }}" >  
            @include('front.account.orders.product_card')
        </a>
    @endforeach
</div>
                                      
<div class="modal fade" id="shippedOrder_{{ $order->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Shipped Order: {{ $order->id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p>
                    <strong>Order Placed:</strong>
                    {{ $order->created_at->format('d M Y') }}
                </p>

                <p class="text-success">
                    <strong>Estimated Delivery:</strong>
                    {{ \Carbon\Carbon::parse($order->estimated_delivery)->format('d M Y') }}
                </p>                

                @foreach($order->items as $item)
                    @php
                        $productImage = getProductImage($item->product_id)
                    @endphp

                    <div class="align-items-center shipped_stage">
                        <div class="image">
                            @if (!empty($productImage->image))
                                <img class="product" src="{{ asset('uploads/product/small/'.$productImage->image) }}" >
                            @else
                                <img class="product" src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" />
                            @endif 
                        </div>
                        <div class="title">
                            <strong>{{ $item->product->title }}</strong><br>
                            Qty: {{ $item->quantity }}                        
                        </div>
                    </div>
                @endforeach

                @php
                    $stage = $order->delivery_stage;                         
                @endphp

                <div class="delivery-tracker">
                    <div class="progress-container justify-content-between">
                        @php
                            $steps = ['placed','packed','shipped','out_for_delivery','delivered'];
                            $stage = $order->delivery_status;   // 👈 from orders table
                        @endphp

                        <div class="delivery-tracker d-flex justify-content-between text-center">
                            @foreach($steps as $step)
                                @php
                                    $isActive = array_search($stage, $steps) >= array_search($step, $steps);
                                @endphp

                                <div class="step {{ $isActive ? 'active' : '' }}">
                                    <div class="circle"></div>
                                    <small>{{ ucwords(str_replace('_',' ',$step)) }}</small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>