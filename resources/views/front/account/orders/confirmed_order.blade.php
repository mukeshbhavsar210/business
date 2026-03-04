<div class="status confirmed">
    <div class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#FFFFFF" fill-rule="nonzero" d="M19.173 7.059l-7.232-4a.469.469 0 0 0-.454 0l-7.232 4A.503.503 0 0 0 4 7.5v9c0 .185.098.355.255.441l7.232 4a.469.469 0 0 0 .454 0l7.232-4a.503.503 0 0 0 .256-.441v-9a.503.503 0 0 0-.256-.441zm-7.459-2.992L17.922 7.5 15.33 8.933 9.123 5.5l2.591-1.433zm-.482 15.6L4.964 16.2V8.334l6.268 3.466v7.866zm.482-8.734L5.507 7.5l2.591-1.433L14.305 9.5l-2.59 1.433zm6.75 5.267l-6.268 3.466V11.8l6.268-3.466V16.2z"></path></svg>
    </div>
    <div class="name">
        <p><b>Confirmed</b></p>
        <p class="date">On {{ \Carbon\Carbon::parse($order->shipped_date)->format('D, d M Y') }}</p>
    </div>
</div>

<div class="product-details">
    @foreach($order->items as $item)
        <a href="{{ route('account.orderDetail',$order->id) }}" class="product-details-link">  
            @include('front.account.orders.product_card')
        </a>
    @endforeach
</div>

<div class="group flex mt-3">                                            
    <a href="#" class="btn btn-outline-dark w-50" data-bs-toggle="modal" data-bs-target="#cancelOrder_{{ $order->id }}">Cancel</a>
    <a href="#" class="btn btn-outline-dark w-50" data-bs-toggle="modal" data-bs-target="#trackOrder">Track</a>
</div>

<div class="modal fade" id="cancelOrder_{{ $order->id }}" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="cancelOrderLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="cancelOrderLabel">Cancel Order No: {{ $order->id }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form method="POST" action="{{ route('account.order.cancel', $order->id) }}">
            @csrf
            <div class="modal-body">    
                <h5>Select Reason for Cancellation</h5>
                <p>Please tell us correct reason for cancellation. This information is only used to improve our service</p>

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

<div class="modal fade" id="trackOrder" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="trackOrderLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="trackOrderLabel">Track Order</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            ...
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Understood</button>
        </div>
        </div>
    </div>
</div>