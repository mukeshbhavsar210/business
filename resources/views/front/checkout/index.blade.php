@extends('front.layouts.app')

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

            <form action=" " name="orderForm" id="orderForm" method="POST">
                <div class="shpping-address">
                    <div class="row">
                        <div class="col-md-9 col-12">
                            <h5 class="title">Select Delivery Address</h5>
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

                    @foreach($address as $value)                                                
                        <div class="card mb-3 default-card">
                            <div class="card-header">
                                <p>{{ $value->default_address ? 'Default address' : 'Other address' }}</p>
                            </div>
                            <label class="address-card w-100">
                                <div class="card-body">                            
                                    <input type="radio" name="default_address_id" value="{{ $value->id }}" class="address-radio" {{ $defaultAddressId == $value->id ? 'checked' : '' }}>

                                    <div class="address-content w-100">
                                        <h5 class="mb-2">
                                            <b>{{ $value->name }}</b>
                                            <span class="badge bg-dark text-light">
                                                {{ $value->address_type }}
                                            </span>
                                        </h5>
                                        <p class="text-muted mb-0">{{ $value->address }}</p>
                                        <p class="text-muted mb-0">{{ $value->locality }}, {{ $value->city }} - {{ $value->zip }}, {{ $value->state->name }}.</p>                                                        
                                        <p class="text-muted mt-2">Mobile: {{ $value->mobile }}</p>
                                    </div>
                                    
                                    <ul class="flex mt-3 d-none control-btn">
                                        <li><a href="#" class="btn btn-outline-dark">Remove</a></li>
                                        <li><a href="#" class="btn btn-outline-dark">Edit</a></li>
                                    </ul>                                    
                                </div>
                            </label>                        
                        </div>                        
                    @endforeach                                                                                                         
                                        
                                            
                                            {{-- <form action="{{ route('checkout.select.address') }}" method="POST">
                                                @csrf --}}
                                            {{-- </form> --}}

                                            {{--<div class="default coupon-box">                         
                                                <label>
                                                    <div class="left">
                                                        <input type="radio" name="default_address_id" value="1">
                                                    </div>
                                                    <div class="right">                               
                                                        <h6 class="mb-2 h6"><b>{{ $customerAddress->name }}</b> 
                                    <span class="address-type">{{ $customerAddress->address_type }}</span>
                                </h6>
                                <p class="text-muted">{{ $customerAddress->address }}</p>
                                <p class="text-muted">{{ $customerAddress->locality }}, {{ $customerAddress->city }}-{{ $customerAddress->zip }},</p>
                                <p class="text-muted">{{ $customerAddress->state->name }}.</p>
                                <p class="mt-2 text-muted">Mobile: {{ $customerAddress->mobile }}</p>                            
                            </div>
                        </label>
                    </div> --}}
                    
                    @if(!in_array('Home', $addressTypes) || !in_array('Office', $addressTypes))
                        <div class="add-address">
                            <a href="#" class="link-primary" data-bs-toggle="modal" data-bs-target="#createAddressModal">
                                + Add New Address
                            </a>
                        </div>
                    @endif                                            
                </div>   
            </form>
        </div>

        <div class="col-md-4 col-12">
            <div class="cart-summery">
                <div class="part">
                    <h6>Delivery Estimates</h6>
                    <p>Estimated delivery by 2 Mar 2026</p>
                </div>

                <div class="part">
                    @foreach (Cart::content() as $item)
                        <h6>Price Details {{ $item->qty }}</h6>

                        <div class="repeate-row">
                            <div class="left">Total MRP</div>
                            <div class="right">₹{{ $item->price*$item->qty }}</div>
                        </div>                                
                    @endforeach
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
            </div>                                                          
            
            <div id="discount-response-wrapper">
                @if (Session::has('code'))
                    <div class="mt-4" id="discount-response">
                        <strong>{{ Session::get('code')->code }}</strong>
                        <a class="btn btn-sm btn-danger" id="remove-discount"><i class="fa fa-times"></i></a>
                    </div>
                @endif
            </div>
                                
            <h3 class="card-title h5 mb-3">Payment Method</h3>
            <div class="">
                <input checked type="radio" name="payment_method" value="cod" id="payment_cod" >
                <label for="payment_cod" class="form-check=label">COD</label>
            </div>
            <div class="">
                <input type="radio" name="payment_method" value="cod" id="payment_razorpay" >
                <label for="payment_razorpay" class="form-check=label">RazorPay</label>
            </div>
            <div class="card-body p-0 mt-3" id="cod-form">
                <button class="btn-dark btn btn-block w-100" type="submit">Pay Now COD</button>
            </div>
            <div class="card-body p-0 d-none mt-3" id="razorpay-form">
                <div class="card-body p-0" id="card-payment-form">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="card_number" class="mb-2">Card Number</label>
                                <input type="text" name="card_number" id="card_number" placeholder="Valid Card Number" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="expiry_date" class="mb-2">Expiry Date</label>
                                <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="expiry_date" class="mb-2">CVV Code</label>
                                <input type="text" name="expiry_date" id="expiry_date" placeholder="123" class="form-control">
                            </div>
                        </div>
                    </div>
                    <button class="btn-dark btn btn-block w-100" type="submit">Pay Now</button>
                </div>
            </div>             
        </div>                   

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
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response){
                    var errors = response.errors;
                    $('button[type="submit"]').prop('disabled', false);

                    //front thankyou page
                    if(response.status == false){
                        if(errors.first_name){
                            $("#first_name").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.first_name)
                        } else {
                            $("#first_name").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('')
                        }

                        if(errors.last_name){
                            $("#last_name").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.last_name)
                        } else {
                            $("#last_name").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('')
                        }

                        if(errors.email){
                            $("#email").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.email)
                        } else {
                            $("#email").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('')
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

                        if(errors.state){
                            $("#state").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.state)
                        } else {
                            $("#state").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('')
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
