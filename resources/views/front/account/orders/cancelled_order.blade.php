<div class="status cancelled">
    <div class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"><path fill="#282C3F" fill-rule="nonzero" d="M15.854 8.146a.495.495 0 0 0-.703 0L12 11.296l-3.15-3.15a.495.495 0 0 0-.704 0 .495.495 0 0 0 0 .703L11.297 12l-3.15 3.15a.5.5 0 1 0 .35.85.485.485 0 0 0 .349-.146l3.15-3.15 3.151 3.15a.5.5 0 0 0 .35.147.479.479 0 0 0 .35-.147.495.495 0 0 0 0-.703L12.702 12l3.15-3.15a.495.495 0 0 0 0-.704z"></path></svg>
    </div>
    <div class="name">
        <p><b>Cancelled</b></p>
        <p class="text-muted tiny-font">As per your request on: {{ \Carbon\Carbon::parse($order->created_date)->format('d M Y') }}</p>
    </div>
</div>

<div class="product-details">
    @foreach($order->items as $item)
        <a href="#" class="product-details-link" data-bs-toggle="modal" data-bs-target="#cancelledOrder_{{ $order->id }}" >
            @include('front.account.orders.product_card')
        </a>
    @endforeach                                                                                     
</div>
                                 
<div class="modal fade" id="cancelledOrder_{{ $order->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancelled Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                

                <div class="mb-3">
                    <p><strong>Reason:</strong></p>
                    <p>{{ $order->cancel_reason ?? 'No reason provided' }}</p>
                    <p class="tiny-font text-muted">Order cancelled on: {{ \Carbon\Carbon::parse($order->cancelled_at)->format('d M Y') }}</p>
                </div>

                <div class="mb-3">
                    <p><strong>Comments:</strong></p>
                    <p>{{ $order->cancel_comments ?? 'No reason provided' }}</p>
                </div>

                <div>
                    <p><strong>Refund details:</strong></p>
                    <p class="underline">Total Refund Amount: <b>1,430.00</b></p>
                    <p class="tiny-font text-muted">Platform Fee, as applicable, will be refunded in case of full order cancellation</p>
                </div>
            </div>
        </div>
    </div>
</div>