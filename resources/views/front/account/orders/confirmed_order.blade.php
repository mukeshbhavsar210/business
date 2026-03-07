<div class="status confirmed">
    <div class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#FFFFFF" fill-rule="nonzero" d="M19.173 7.059l-7.232-4a.469.469 0 0 0-.454 0l-7.232 4A.503.503 0 0 0 4 7.5v9c0 .185.098.355.255.441l7.232 4a.469.469 0 0 0 .454 0l7.232-4a.503.503 0 0 0 .256-.441v-9a.503.503 0 0 0-.256-.441zm-7.459-2.992L17.922 7.5 15.33 8.933 9.123 5.5l2.591-1.433zm-.482 15.6L4.964 16.2V8.334l6.268 3.466v7.866zm.482-8.734L5.507 7.5l2.591-1.433L14.305 9.5l-2.59 1.433zm6.75 5.267l-6.268 3.466V11.8l6.268-3.466V16.2z"></path></svg>
    </div>
    <div class="name">
        <p><b>Confirmed</b></p>
        <p class="date">
            Arriving by 
            {{ \Carbon\Carbon::parse($order->shipped_date)->format('d M') }} - 
            {{ \Carbon\Carbon::parse($order->shipped_date)->format('d M') }}
        </p>
    </div>
</div>

<div class="product-details">
    @foreach($order->items as $item)
        <a href="{{ route('account.orderDetail',$order->id) }}" class="product-details-link">  
            @include('front.account.orders.product_card')
        </a>
    @endforeach
    
    <div class="product-details-link">
        <div class="group flex">                                            
            <a href="#" class="btn btn-outline-dark w-50" data-bs-toggle="modal" data-bs-target="#cancelOrder_{{ $order->id }}">Cancel</a>
            {{-- <a href="#" class="btn btn-outline-dark w-50 track-order-btn" data-order-id="{{ $order->id }}"
                data-bs-toggle="modal"
                data-bs-target="#orderTrackingModal">Track</a> --}}

                <button 
                    class="btn btn-outline-dark w-50 track-order-btn"
                    data-order-id="{{ $order->id }}"
                    data-bs-toggle="modal"
                    data-bs-target="#orderTrackingModal">
                    Track
                </button>
        </div>
    </div>
</div>

<div class="modal fade" id="cancelOrder_{{ $order->id }}" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="cancelOrderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelOrderLabel">Cancel Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="{{ route('account.order.cancel', $order->id) }}">
                @csrf
                <div class="modal-body">    
                    <p class="mb-1"><b>Reason for Cancellation</b></p>
                    <p class="tiny-font">Please tell us correct reason for cancellation. This information is only used to improve our service</p>
                    <hr />
                    <div class="reason-group mb-3 mt-3">
                        <label class="custom-radio">
                            <input type="radio" name="cancel_reason" value="Incorrect size ordered" required>
                            <span class="radio-mark"></span>
                            Incorrect size ordered
                        </label>

                        <label class="custom-radio">
                            <input type="radio" name="cancel_reason" value="Product not required anymore" required>
                            <span class="radio-mark"></span>
                            Product not required anymore
                        </label>

                        <label class="custom-radio">
                            <input type="radio" name="cancel_reason" value="Cash issue" required>
                            <span class="radio-mark"></span>
                            Cash issue
                        </label>

                        <label class="custom-radio">
                            <input type="radio" name="cancel_reason" value="Ordered by mistake">
                            <span class="radio-mark"></span>
                            Ordered by mistake
                        </label>

                        <label class="custom-radio">
                            <input type="radio" name="cancel_reason" value="Wants to change style/color">
                            <span class="radio-mark"></span>
                            Wants to change style/color
                        </label>

                        <label class="custom-radio">
                            <input type="radio" name="cancel_reason" value="Delayed Delivery Cancellation">
                            <span class="radio-mark"></span>
                            Delayed Delivery Cancellation
                        </label>
                    
                        <label class="custom-radio">
                            <input type="radio" name="cancel_reason" value="Duplicate order">
                            <span class="radio-mark"></span>
                            Duplicate order
                        </label>
                    </div>                                                                    
                    <textarea name="cancel_comments" class="form-control" placeholder="Additional comments" rows="3"></textarea>                        
                </div>

                <div class="modal-footer">
                    <div class="flex">
                        <div>
                            <p class="mt-2">Refund Details</p>                                
                        </div>
                        <div>
                        <button type="submit" class="btn btn-danger mt-3">Cancel Order</button>
                        </div>
                    </div>                                                    
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="orderTrackingModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Tracking</h5>
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

@section('customJs')
<script>
    $(document).ready(function(){        
        $('.track-order-btn').click(function(){
            let orderId = $(this).data('order-id');

            let url = "{{ route('account.order.tracking', ':id') }}";
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
                                    <p>
                                        <b>${status.status.replaceAll('_',' ')}</b><br>
                                        on ${status.date}
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