<div class="cart-summery">                    
    @if(session()->has('coupon_discount'))
        <div class="part">
            <h5>Coupon</h5>
            <div class="repeate-row">
                <div class="left">
                    <div class="flex">
                        <div>
                            <svg height="45px" width="45px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                viewBox="0 0 505 505" xml:space="preserve">
                            <circle style="fill:#FD8469;" cx="252.5" cy="252.5" r="252.5"/>
                            <path style="fill:#FFFFFF;" d="M382.3,296.1l26.3-26.3c9.6-9.6,9.6-25,0-34.6l-26.3-26.3c-4.6-4.6-7.2-10.8-7.2-17.3v-37.2
                                c0-13.5-11-24.5-24.5-24.5h-37.2c-6.5,0-12.7-2.6-17.3-7.2l-26.3-26.3c-9.6-9.6-25-9.6-34.6,0l-26.3,26.3
                                c-4.6,4.6-10.8,7.2-17.3,7.2h-37.2c-13.5,0-24.5,11-24.5,24.5v37.2c0,6.5-2.6,12.7-7.2,17.3l-26.3,26.3c-9.6,9.6-9.6,25,0,34.6
                                l26.3,26.3c4.6,4.6,7.2,10.8,7.2,17.3v37.2c0,13.5,11,24.5,24.5,24.5h37.2c6.5,0,12.7,2.6,17.3,7.2l26.3,26.3c9.6,9.6,25,9.6,34.6,0
                                l26.3-26.3c4.6-4.6,10.8-7.2,17.3-7.2h37.2c13.5,0,24.5-11,24.5-24.5v-37.2C375.1,306.9,377.7,300.7,382.3,296.1z"/>
                            <path style="fill:#4CDBC4;" d="M241.2,207.7c0,9-3.2,16.6-9.6,22.8c-6.4,6.2-14.5,9.3-24.2,9.3s-17.8-3.1-24.2-9.4
                                c-6.4-6.3-9.6-13.9-9.6-22.8c0-8.9,3.2-16.5,9.6-22.8c6.4-6.2,14.5-9.4,24.2-9.4s17.7,3.1,24.2,9.4
                                C238,191.1,241.2,198.7,241.2,207.7z M329.1,171.5L214.3,331.7h-39.4l115-160.1h39.2V171.5z M200.5,215.8c1.8,2.1,4,3.1,6.8,3.1
                                c2.7,0,5-1,6.9-3.1c1.8-2.1,2.7-4.8,2.7-8.1s-0.9-6.1-2.7-8.4c-1.8-2.2-4.1-3.3-6.8-3.3s-4.9,1.1-6.8,3.3c-1.8,2.2-2.7,5-2.7,8.4
                                S198.7,213.8,200.5,215.8z M331.4,301.4c0,9-3.2,16.6-9.6,22.8c-6.4,6.2-14.5,9.3-24.2,9.3s-17.8-3.1-24.2-9.4
                                c-6.4-6.2-9.6-13.9-9.6-22.8s3.2-16.5,9.6-22.8s14.5-9.4,24.2-9.4s17.7,3.1,24.2,9.4C328.2,284.8,331.4,292.4,331.4,301.4z
                                M290.8,309.5c1.8,2.1,4,3.1,6.8,3.1s5-1,6.9-3.1c1.8-2.1,2.8-4.8,2.8-8.1c0-3.4-0.9-6.2-2.8-8.4c-1.8-2.2-4.1-3.3-6.8-3.3
                                c-2.7,0-4.9,1.1-6.8,3.3c-1.8,2.2-2.8,5-2.8,8.4S289,307.5,290.8,309.5z"/>
                            </svg>
                        </div>
                        <div>
                            <b>1 Coupon applied ({{ session('coupon_discount.code') }})</b>
                            <p class="compare-discount tiny-font">You saved additional - ₹{{ $coupon_discount }}</p>                                                    
                        </div>
                    </div>
                </div>
                <div class="right">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#discount" class="btn btn-outline-danger btn-sm">Edit</a>                                            
                </div>
            </div>
        </div>
    @endif
    
    <div class="part">
        <h6>Delivery Estimates</h6>
        @foreach (Cart::content() as $item)
            <div class="repeate-row">
                {{ $item->name }}
                <p class="tiny-font">Delivery between </p>
            </div>                        
        @endforeach        
    </div>

    <div class="part">                            
        <h5>Price Details (<span class="selected-items">0</span> <span>items</span>)</h5>
        
        @if (Cart::count() > 0)    
            <div class="repeate-row">
                <div class="left">Total MRP</div>
                <div class="right">₹<span class="mrp_total">0.00</span></div>
            </div>

            <div class="repeate-row priceDetailsBox">
                <div class="left">Discount on MRP</div>
                <div class="right">
                    <span class="compare-discount">- ₹{{ number_format($discountPrice ?? $item->price, 2) }}</span>
                </div>
            </div>

            @if(session()->has('coupon_discount'))
                <div class="repeate-row priceDetailsBox">
                    <div class="left">
                        Coupon Discount ({{ $coupon_code }})                                        
                        <form action="{{ route('front.removeCoupon') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                        </form>                                        
                    </div>
                    <div class="right">
                         <input type="hidden" id="coupon_discount" value="{{ $coupon_discount }}">
                        <span class="compare-discount" id="discount_value">- ₹{{ $coupon_discount }}</span>
                    </div>
                </div>                               
            @else
                <div class="repeate-row">
                    <div class="left">Coupon Discount</div>
                    <div class="right">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#discount">Apply Discount</a>
                    </div>
                </div>
            @endif
            
            @if (Auth::check())
                <div class="repeate-row priceDetailsBox" >
                    <div class="left">Platform Fee</div>
                    <input type="hidden" id="shipping_charge" value="{{ $shipping_charge }}">
                    <div class="right" id="shippingAmount">₹{{ number_format($shipping_charge,2) }}</div>
                </div> 
            @endif            

            <div class="repeate-row total-amount">
                <div class="left">Total Amount</div>
                <div class="right">₹ <span class="total_amount">0.00</span></div>
                {{-- <div class="right"><strong id="grandTotal">₹{{ number_format($grandTotal,2) }}</strong></div> --}}
            </div> 
        @endif
    </div> 
                                
    <div class="mt-2">
        <div class="btn-group w-100 mb-3" role="group">
            <input type="radio" class="btn-check" name="payment_method" id="payment_cod" value="cod" autocomplete="off" checked>
            <label class="btn btn-outline-primary" for="payment_cod">COD</label>

            <input type="radio" class="btn-check" name="payment_method" id="payment_razorpay" value="razorpay" autocomplete="off">
            <label class="btn btn-outline-primary" for="payment_razorpay">RazorPay</label>
        </div>
        
        <button id="cod-form" class="btn-primary btn btn-block w-100" type="submit">Pay on COD</button>
        <button id="razorpay-form" class="btn-primary btn btn-block w-100 d-none" type="submit">Pay ₹{{ number_format($grandTotal,2) }}</button>                
    </div>                            
</div>

<div class="modal fade" id="discount" tabindex="-1" aria-labelledby="discountLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('coupon.apply') }}" method="POST" id="couponForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="discountLabel">Apply Coupon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="apply-coupan mb-2">
                        <input type="text" placeholder="Enter coupon Code" class="form-control" name="discount_code" id="discount_code" value="{{ old('discount_code', session('coupon_code')) }}">
                    </div>
                    
                    <div class="scroll-body">
                        @php
                            $selectedCoupon = session('coupon_discount.id');
                        @endphp

                        @foreach($coupons as $coupon)
                            <div class="coupon-box {{ old('coupon_id', $selectedCoupon) == $coupon->id ? 'active' : '' }}">
                            <label>
                                <div class="left">
                                    <label class="custom-radio">
                                        <input 
                                            type="radio"
                                            name="coupon_id"
                                            value="{{ $coupon->id }}"
                                            data-code="{{ $coupon->code }}"
                                            {{ old('coupon_id', $selectedCoupon) == $coupon->id ? 'checked' : '' }}
                                        >
                                        <span class="radio-mark"></span>
                                    </label>
                                </div>

                                <div class="right">
                                    <div class="code-details">
                                        <div class="code">{{ $coupon->code }}</div>
                                    </div>

                                    <p class="title">{{ $coupon->name }}</p>

                                    <p class="text-muted">
                                        @if($coupon->type == 'percent')
                                            {{ $coupon->discount_amount }}% off
                                        @else
                                            ₹{{ $coupon->discount_amount }} off
                                        @endif
                                        on minimum purchase of <b>₹{{ $coupon->min_amount }}</b>.
                                    </p>

                                    <p class="text-muted">
                                        Expire on:
                                        {{ \Carbon\Carbon::parse($coupon->expires_at)->format('jS F Y | h:i A') }}
                                    </p>
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="modal-footer-extra">                                
                    <div class="max-savings">
                        <p>Maximum savings:</p> 
                        @if(session()->has('coupon_discount'))
                            {{-- ({{ session('coupon_discount.code') }}) --}}
                            <p class="discount-text">₹{{ number_format(session('coupon_discount.discount'),2) }}</p>
                        @endif
                    </div>
                    <div>
                        <button class="btn btn-primary btn-big" type="submit" data-bs-dismiss="modal">Apply</button>
                    </div>                                
                </div>                                    
            </form>
        </div>
    </div>
</div>   