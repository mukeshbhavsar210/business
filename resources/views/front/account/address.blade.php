@extends('front.layouts.app')

@section('content')

<div class="container-small">
    <div class="small-title">
        <div class="row">
            <div class="col-md-3 col-12">
                <h4>Account</h4>
                <p>{{ $userDetails->name }}</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-12">
            @include('front.account.common.sidebar')  
        </div>
        <div class="col-md-9 col-12">
            <div class="orders-details">

                @include('front.account.common.message')

                <div class="user-details-repeate">
                    <div class="row justify-content-center">
                        <div class="col-md-12">                        
                            <div class="row">
                                <div class="col-md-6 col-6">
                                    <h5 class="h5 mb-4">Saved Address</h5>
                                </div>
                                <div class="col-md-6 col-6">
                                    @if(!in_array('Home', $addressTypes) || !in_array('Office', $addressTypes))
                                        <button type="button" class="btn btn-outline-dark float-end" data-bs-toggle="modal" data-bs-target="#createAddressModal">+ Add New Address</button>
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
                                <div class="card mb-3">
                                    <div class="card-header {{ $defaultAddressId == $value->id ? '' : 'd-none' }}">
                                        <p><b>{{ $defaultAddressId == $value->id ? 'Default address for shipping' : '' }}</b></p>
                                        {{-- {{ $defaultAddressId == $value->id ? 'Default' : 'Home' }} --}}
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-10 col-8">
                                                <label class="address-card {{ $defaultAddressId == $value->id ? 'active' : '' }}">
                                                    {{-- <input type="radio"
                                                        name="default_address_id"
                                                        value="{{ $value->id }}"
                                                        class="address-radio me-3"
                                                        {{ old('default_address_id', 
                                                                $value->where('default_address', 1)->first()->id ?? ''
                                                            ) == $value->id ? 'checked' : '' }}> --}}

                                                    <div class="address-content w-100">
                                                        <h6><b>{{ $value->name }}</b> 
                                                            <span>{{ $value->address_type }}</span>
                                                        </h6>
                                                        <p class="text-muted mb-0">{{ $value->address }}</p>
                                                        <p class="text-muted mb-0">{{ $value->locality }}, {{ $value->city }} - {{ $value->zip }}, {{ $value->state->name }}.</p>                                                        
                                                        <p class="text-muted mt-2">Mobile: {{ $value->mobile }}</p>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-md-2 col-4">
                                                <div class="btn-group-sm">
                                                    <button type="button" class="btn btn-outline-danger">R</button>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editAddress_{{ $value->id }}">Edit</button>
                                                </div>        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach 
                        </div>
                    </div>            
                </div>
            </div>             
        </div>            
    </div>
</div>

{{-- <x-customer-address-form 
    :address="$address"
    :states="$states"
    :action="route('customer.address.update', $address->id)" 
    method="PUT" 
    title="Edit Address" 
    buttonText="Update Address"
    modalId="editAddressModal"
/> --}}

<x-customer-address-form     
    :states="$states"
    :action="route('customer.address.store')" 
    method="POST" 
    title="Add New Address" 
    buttonText="Create Address"
    modalId="createAddressModal"
/>

@endsection

@section('customJs')
<script>
    $("#addressForm").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('account.updateAddress') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                var modal = bootstrap.Modal.getInstance(document.getElementById('editAddress'));
                modal.hide();
                location.reload();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });
</script>
@endsection
