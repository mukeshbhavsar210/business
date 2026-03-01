@extends('front.layouts.app')

@section('content')

<form action=" " name="orderForm" id="orderForm" method="POST">
    @csrf

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
                        'default_address_id',
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
                                <input type="radio" name="default_address_id" value="{{ $address->id }}" class="address-radio" {{ $defaultAddressId == $address->id ? 'checked' : '' }}>

                                <div class="address-content w-100">
                                    <h5 class="mb-2">
                                        <b>{{ $address->name }}</b>
                                        <span class="badge bg-dark text-light">
                                            {{ $address->address_type }}
                                        </span>
                                    </h5>
                                    <p class="text-muted mb-0">{{ $address->address }}</p>
                                    <p class="text-muted mb-0">{{ $address->locality }}, {{ $address->city }} - {{ $address->zip }}, {{ $address->state->name }}.</p>                                                        
                                    <p class="text-muted mt-2">Mobile: {{ $address->mobile }}</p>
                                                                
                                    <ul class="flex mt-3 d-none control-btn">
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

                                    {{-- <x-customer-address-form 
                                        :states="$states"
                                        :action="route('customer.address.update', $address->id)" 
                                        method="PUT" 
                                        title="Edit Address" 
                                        buttonText="Edit Address"
                                        modalId="editAddressModal"
                                    /> --}}

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
            <div class="cart-summery">
                <div class="part">
                    <h6>Delivery Estimates</h6>
                    <p>Estimated delivery by 2 Mar 2026</p>
                </div>

                <div class="part">
                    <h6>Price Details</h6>

                    @foreach (Cart::content() as $item)
                        <div class="repeate-row">
                            <div class="left">{{ $item->name }} x {{ $item->qty }}</div>
                            <div class="right">₹{{ $item->price*$item->qty }}</div>
                        </div>                        
                    @endforeach

                    <div class="repeate-row total-amount">
                        <div class="left">SubTotal</div>
                        <div class="right">₹{{ Cart::subtotal() }}</div>
                    </div>

                    {{-- <div class="repeate-row">
                        <div class="left">Discount on MRP</div>
                        <div class="right"><span id="discount_value">₹{{ $item->compare_price }}</span></div>
                    </div> --}}

                    <div class="repeate-row">
                        <div class="left">Discount on MRP</div>
                        <div class="right"><span id="discount_value">₹{{ $discount }}</span></div>
                    </div>
                    
                    {{-- <div class="repeate-row">
                        <div class="left">Subtotal</div>
                        <div class="right">₹{{ Cart::subtotal() }}</div>
                    </div>  --}}
                    
                    <div class="repeate-row">
                        <div class="left">Platform fees</div>
                        <div class="right"><span id="shippingAmount">₹ {{ number_format($totalShiipingCharge,2) }}</span></div>
                    </div>                                                      
                    <div class="repeate-row total-amount">
                        <div class="left">Total Amount</div>
                        <div class="right"><span id="grandTotal">₹{{ number_format($grandTotal,2) }}</span></div>
                    </div>
                </div>                                                                    
            
                <div id="discount-response-wrapper">
                    @if (Session::has('code'))
                        <div class="mt-4" id="discount-response">
                            <strong>{{ Session::get('code')->code }}</strong>
                            <a class="btn btn-sm btn-danger" id="remove-discount"><i class="fa fa-times"></i></a>
                        </div>
                    @endif
                </div>
                
                <div class="part">
                    <h6>Payment Method</h6>
                    <div class="btn-group w-100 mb-3" role="group">
                        <input type="radio" class="btn-check" name="payment_method" id="payment_cod" value="cod" autocomplete="off" checked>
                        <label class="btn btn-outline-primary" for="payment_cod">COD</label>

                        <input type="radio" class="btn-check" name="payment_method" id="payment_razorpay" value="razorpay" autocomplete="off">
                        <label class="btn btn-outline-primary" for="payment_razorpay">RazorPay</label>
                    </div>
                    
                        <button id="cod-form" class="btn-primary btn btn-block w-100" type="submit">Pay Now COD</button>
                        <button id="razorpay-form" class="btn-primary btn btn-block w-100 d-none" type="submit">Pay Now</button>                
                    </div>         
                </div>
            </div>  
        </div>
    </div>
</form>                 

    {{-- <form action="{{ route('checkout.razorpay') }}" method="POST">
        @csrf
        <script src="https://checkout.razorpay.com/v1/checkout.js"
            data-key="{{ env('RAZORPAY_KEY_ID') }}"
            data-amount = "{{ Cart::subtotal() }}"
            data-buttontext = "Make Payment"
            data-image = " "
            data-notes.customer_name = "Mukesh Bhavsar"
            data-notes.customer_email = "mukeshbhavsar210@gmail.com"
            data-notes.product_name = "Laptop"
            data-notes.quantity = "1"
            data-prefill.name=""
            data-prefill.contact="9978835005"
        >
        </script>
    </form> --}}


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
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response){
                    var errors = response.errors;
                    $('button[type="submit"]').prop('disabled', false);

                    //front thankyou page
                    if(response.status == false){
                        if(errors.name){
                            $("#name").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.name)
                        } else {
                            $("#name").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('')
                        }
                      
                        if(errors.state){
                            $("#state").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.state)
                        } else {
                            $("#state").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('')
                        }

                        if(errors.address){
                            $("#address").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.address)
                        } else {
                            $("#address").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('')
                        }

                        if(errors.city){
                            $("#city").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.city)
                        } else {
                            $("#city").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('')
                        }

                        if(errors.zip){
                            $("#zip").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.zip)
                        } else {
                            $("#zip").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('')
                        }

                        if(errors.mobile){
                            $("#mobile").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.mobile)
                        } else {
                            $("#mobile").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('')
                        }
                    } else {
                        window.location.href="{{ url('thanks/') }}/"+response.orderId;
                    }

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

        $('body').on('click','#remove-discount',function(){
            $.ajax({
                url: '{{ route("front.removeCoupon") }}',
                type: 'post',
                data: {state_id: $('#state').val()},
                dataType: 'json',
                success: function(response){
                    if(response.status == true) {
                        $("#shippingAmount").html(response.shippingCharge);
                        $("#grandTotal").html(response.grandTotal);
                        $("#discount_value").html(response.discount);
                        $("#discount-response").html();
                        $("#discount_code").val('');
                    }
                }
            })
        })


        $(document).on('change', 'input[name="default_address_id"]', function() {    
            $('.default').removeClass('active');
            $(this).closest('.default').addClass('active');
        });        
    </script>
@endsection
