@extends('front.layouts.app')

@section('title', 'Checkout' . (Cart::count() > 0 ? ' (' . Cart::count() . ')' : ''))

@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-8 col-12 left-border">
                @include('front.layouts.message')

                <x-customer-address-form 
                    :states="$states"
                    :action="route('customer.address.store')" 
                    method="POST" 
                    title="Add New Address" 
                    buttonText="Create Address"
                    modalId="createAddressModal"
                />

                @include('front.layouts.shippingaddress')

                @if (Auth::check())
                    <div class="delivery-time">
                        <div class="address">
                            @foreach($address as $value) 
                                @if($value->default_address == 1)                                        
                                    <p>Delivery to: <b>{{ $value->name }}, {{ $value->zip }}</b></p>
                                    <p class="tiny-font mt-1">{{ $value->address }},</p>
                                    <p class="tiny-font">{{ $value->locality }}, {{ $value->city }}, {{ $value->state->name }}</p>    
                                @endif                                        
                            @endforeach
                        </div>
                        <div class="btn-right">
                            <a href="#" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#deliveryAddress">Change Address</a>
                        </div>                                
                    </div>
                @else
                    <div class="delivery-time">
                        <div class="address">
                            <p>Login to get delivery at your place.</p>
                        </div>
                        <div class="btn-right">
                            <a href="#" class="btn btn-primary float-end checkoutBtn" >Login</a>
                        </div> 
                    </div>
                @endif
                
                <div class="shpping-address">
                    <div class="row mb-1">
                        <div class="col-md-9 col-12">
                            <h5 class="title mt-2">Select Delivery Address</h5>
                        </div>
                        <div class="col-md-3 col-12">
                            @if(!in_array('Home', $addressTypes) || !in_array('Office', $addressTypes))
                                <a href="#" class="btn btn-outline-dark float-end" data-bs-toggle="modal" data-bs-target="#createAddressModal">
                                    + Add New Address
                                </a>
                            @endif
                        </div>
                    </div>

                    @php
                        $defaultAddressId = old(
                            'customer_address_id',
                            optional($address->firstWhere('default_address', 1))->id
                        );
                    @endphp

                    @foreach($address as $address)                                                
                        <div class="card mb-3 default-card">
                            <div class="card-header">
                                <p>{{ $address->default_address ? 'Default address' : 'Other address' }}</p>
                            </div>
                            <label class="address-card">
                                <div class="card-body">                                    
                                    <label class="custom-radio">
                                        <input type="radio" name="customer_address_id" value="{{ $address->id }}" class="address-radio" {{ $defaultAddressId == $address->id ? 'checked' : '' }} checked>
                                        <span class="radio-mark"></span>
                                    </label>

                                    <div class="address-content w-100">
                                        <div class="row">
                                            <div class="col-9">                                            
                                                <h5 class="mb-2">
                                                    <b>{{ $address->name }}</b>
                                                    <span class="badge bg-dark text-light">
                                                        {{ $address->address_type }}
                                                    </span>
                                                </h5>
                                                <p class="text-muted mb-0">{{ $address->address }}</p>
                                                <p class="text-muted mb-0">{{ $address->locality }}, {{ $address->city }} - {{ $address->zip }}, {{ $address->state->name }}.</p>                                                        
                                                <p class="text-muted mt-0">Mobile: {{ $address->mobile }}</p>
                                            </div>

                                            <div class="col-3 d-none control-btn">
                                                <ul class="flex">
                                                    <li><a href="#" class="btn btn-outline-danger btn-sm">Remove</a></li>
                                                    <li>
                                                        <a href="#"
                                                            class="btn btn-outline-dark btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editAddressModal"                                                
                                                            data-id="{{ $address->id }}"
                                                            data-name="{{ $address->name }}"
                                                            data-mobile="{{ $address->mobile }}"
                                                            data-address="{{ $address->address }}"
                                                            data-state="{{ $address->state_id }}">
                                                            Edit
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                                        
                                        <div class="d-none control-btn">
                                            {{-- <x-customer-address-form 
                                                :states="$states"
                                                :action="route('customer.address.update', $address->id)" 
                                                method="PUT" 
                                                title="Edit Address" 
                                                buttonText="Edit Address"
                                                modalId="editAddressModal"
                                            /> --}}

                                            <div class="form-group mt-3">
                                                <label>Order notes</label>
                                                <textarea name="note" id="note" cols="30" rows="3" placeholder="Order Notes (optional)" class="form-control mt-2"></textarea>
                                            </div>
                                        </div>
                                    </div>                                 
                                </div>
                            </label>
                        </div>                        
                    @endforeach          
                    
                    <x-customer-address-form 
                        :states="$states"
                        action=""
                        method="PUT"
                        modalId="editAddressModal"
                    />
                    
                    @if(!in_array('Home', $addressTypes) || !in_array('Office', $addressTypes))                    
                        <a href="#" class="add-address" data-bs-toggle="modal" data-bs-target="#createAddressModal">
                            + Add New Address
                        </a>
                    @endif                                            
                </div>               
            </div>

            <div class="col-md-4 col-12">
                <form name="orderForm" id="orderForm" method="POST">
                    @csrf
                        <input type="radio" name="customer_address_id" value="{{ $address->id }}" class="address-radio" {{ $defaultAddressId == $address->id ? 'checked' : '' }} checked>
                        
                        <x-order-summary 
                            :shippingCharge="$shipping_charge"
                            :couponDiscount="$coupon_discount ?? 0"
                            :couponCode="$coupon_code ?? ''"
                            buttonType="pay"
                        />
                </form>
            </div>  
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

@endsection

@section('customJs')
    <script>
        $("#payment_cod").click(function(){
            if ($(this).is(":checked") == true){
                $("#cod-form").removeClass('d-none');
                $("#razorpay-form").addClass('d-none');
            }
        });

        $("#payment_razorpay").click(function(){
            if ($(this).is(":checked") == true){
                $("#cod-form").addClass('d-none');
                $("#razorpay-form").removeClass('d-none');
            }
        });



        $("#orderForm").submit(function(event){
            event.preventDefault();

            $('button[type="submit"]').prop('disabled', true);

            $.ajax({
                url: '{{ route("front.processCheckout") }}',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',

                success:function(response){
                    $('button[type="submit"]').prop('disabled', false);
                    if(response.status == false){
                        console.log(response.errors);
                    }else{
                        window.location.href = "{{ url('thanks') }}/"+response.orderId;
                    }
                },

                error:function(xhr){
                    console.log(xhr.responseText);
                    $('button[type="submit"]').prop('disabled', false);
                }
            });
        });

        $("#state").change(function(){
            $.ajax({
                url: '{{ route("front.getOrderSummary") }}',
                type: 'post',
                data: {state_id: $(this).val()},
                dataType: 'json',
                success: function(response){
                    if(response.status == true)
                        $("#shippingAmount").html(response.shippingCharge);
                        $("#grandTotal").html(response.grandTotal);
                    }
            });
        });

        $("#apply-discount").click(function(){
            $.ajax({
                url: '{{ route("front.applyDiscount") }}',
                type: 'post',
                data: {code: $("#discount_code").val(), state_id: $('#state').val()},
                dataType: 'json',
                success: function(response){
                    if(response.status == true) {
                        $("#shippingAmount").html(response.shippingCharge);
                        $("#grandTotal").html(response.grandTotal);
                        $("#discount_value").html(response.discount);
                        $("#discount-response-wrapper").html(response.discountString);
                    } else {
                        $("#discount-response-wrapper").html("<span class='text-danger'>"+response.message+"</span>");
                    }
                }
            })
        });

        $(document).ready(function(){
            function updateCartSummary(){
                let mrp_total = 0;
                let price_discount = 0;
                let selectedCount = 0;
                let shipping_cost = 0;
                let coupon_discount = parseFloat($('#coupon_discount').val()) || 0;
                let shipping_charge = parseFloat($('#shipping_charge').val()) || 0;

                $('.item-checkbox:checked').each(function(){
                    let rowId = $(this).data('rowid'); // cart rowId
                    let price   = parseFloat($(this).data('price')) || 0;
                    let qty     = parseInt($(this).data('qty')) || 1;
                    let discount_percentage = parseFloat($(this).data('discount_percentage')) || 0;

                    let mrp = price * qty;
                    let discount = (discount_percentage);    
                    let discount_amount = (mrp * discount) / 100;                

                    mrp_total += mrp - discount_amount;
                    price_discount += mrp * qty;
                    selectedCount++;
                });

                // apply coupon
                let afterCoupon = mrp_total - coupon_discount;

                if(afterCoupon < 0){
                    afterCoupon = 0;
                }                

                // add shipping
                let total_amount = afterCoupon;

                // Show / hide price box
                if(selectedCount > 0){
                    total_amount += shipping_charge;
                    $('.priceDetailsBox').removeClass('d-none');                    
                }else{
                    shipping_charge = 0;
                    $('.priceDetailsBox').addClass('d-none');                    
                }

                // Update UI
                $('#selectedCount').text(selectedCount);
                $('.selected-items').text(selectedCount);
                $('.mrp_total').text(mrp_total.toFixed(2));
                $('.price_discount').text(price_discount.toFixed(2));
                $('.coupon_discount').text(coupon_discount.toFixed(2));
                $('.shipping_charge').text(shipping_cost.toFixed(2));
                $('.total_amount').text(total_amount.toFixed(2));
            }            

            updateCartSummary();
        });        

        $(document).on('change', 'input[name="customer_address_id"]', function() {    
            $('.default').removeClass('active');
            $(this).closest('.default').addClass('active');
        });        
    </script>
@endsection