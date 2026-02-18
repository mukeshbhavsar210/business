@extends('front.layouts.app')

@section('content')

<div class="container-small">
    <div class="small-title">
        <div class="row">
            <div class="col-md-3 col-12">
                <h4>Account</h4>
                <p>{{ $userDetails->first_name }} {{ $userDetails->last_name }}</p>
            </div>
            <div class="col-md-9 col-12">
                @include('front.account.common.message')
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-12">
            @include('front.account.common.sidebar')  
        </div>
        <div class="col-md-9 col-12">
            <h3>Saved Address</h3>

            <div class="card mt-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-9 col-8">
                            <h5>Default Address</h5>
                        </div>
                        <div class="col-md-3 col-4">
                            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addAddress">+ Add New Address</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9 col-8">
                            <h6 class="mb-2 h6"><b>{{ $address->first_name }} {{ $address->last_name }}</b></h6>
                            <p class="text-muted">{{ $address->address }}</p>
                            <p  class="text-muted">{{ $address->locality }}, {{ $address->city }} - {{ $address->zip }}</p>
                            <p class="text-muted">{{ $address->country->name }}.</p>
                            <p class="mt-2 text-muted">Mobile: {{ $address->mobile }}</p>
                        </div>
                        <div class="col-md-3 col-4">
                            <div class="float-end">{{ $address->address_type }}</div>                            
                        </div>
                    </div>
                </div>
                <div class="card-footer">                    
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editAddress">Edit</button>
                    <button type="button" class="btn btn-dark" >Remove</button>                    
                </div>
            </div>            
            
            <div class="modal fade" id="editAddress" tabindex="-1" aria-labelledby="editAddressLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editAddressLabel">Edit Address</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <form action="{{ route('account.updateAddress') }}" method="POST" id="addressForm" name="addressForm">
                            @csrf

                            <div class="modal-body">
                                <div class="modal-scroll">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first_name">First Name <span class="required">*</span></label>
                                                <input value={{ (!empty($address)) ? $address->first_name : '' }} type="text" name="first_name" id="first_name" placeholder="Enter Your First Name" class="form-control">
                                                <p></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="last_name">Last Name</label>
                                                <input value={{ (!empty($address)) ? $address->last_name : '' }} type="text" name="last_name" id="last_name" placeholder="Enter Your Last Name" class="form-control">
                                                <p></p>
                                            </div>
                                        </div>                      
                                        <div class="col-md-12 col-12">                 
                                            <div class="form-group">
                                                <label for="mobile">Mobile <span class="required">*</span></label>
                                                <input value={{ (!empty($address)) ? $address->mobile : '' }} type="text" name="mobile" id="mobile" placeholder="Enter Your Mobile" class="form-control">
                                                <p></p>
                                            </div>
                                        </div>                                    
                                        <div class="col-md-6 col-6">
                                            <div class="form-group">
                                                <label for="zip">Pincode <span class="required">*</span></label>
                                                <input value={{ (!empty($address)) ? $address->zip : '' }}  type="text" name="zip" id="zip" placeholder="Enter Your Zip" class="form-control">
                                                <p></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6">
                                            <div class="form-group">
                                                <label for="country">State <span class="required">*</span></label>
                                                <select name="country_id" id="country_id" class="form-select">
                                                    <option value="">Select a Country</option>
                                                    @if ($countries->isNotEmpty())
                                                        @foreach ($countries as $country)
                                                            <option {{ (!empty($address) && $address->country_id == $country->id) ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <p></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="address">Address (House No, Building, Street, Area) <span class="required">*</span></label>
                                                <textarea name="address" id="address" cols="30" rows="5" class="form-control">{{ (!empty($address)) ? $address->address : '' }}</textarea>
                                                <p></p>
                                            </div>                                        
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="locality">Locality/Town <span class="required">*</span></label>
                                                        <input value={{ (!empty($address)) ? $address->locality : '' }} type="text" name="locality" id="locality" placeholder="Enter Your locality" class="form-control">
                                                        <p></p>
                                                    </div>
                                                </div>                                                                                       
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="City">City/District <span class="required">*</span></label>
                                                        <input value={{ (!empty($address)) ? $address->city : '' }} type="text" name="city" id="city" placeholder="Enter Your City" class="form-control">
                                                        <p></p>
                                                    </div>
                                                </div>                                                   
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">                                                    
                                                    @php 
                                                        $addressType = old('address_type', auth()->user()->address->address_type ?? '');
                                                    @endphp
                                                        
                                                    <label for="City">Types of address <span class="required">*</span></label>
                                                    <div class="w-100 mb-3">
                                                        <input type="radio" name="address_type" id="home" value="Home"
                                                            {{ old('address_type', optional(auth()->user()->address)->address_type) == 'Home' ? 'checked' : '' }}>

                                                        <label for="home">Home</label>
                                                        <input type="radio" name="address_type" id="office" value="Office"                                                            
                                                            {{ old('address_type', optional(auth()->user()->address)->address_type) == 'Office' ? 'checked' : '' }} >

                                                        <label for="office">Office</label>
                                                    </div>                                                                                                      
                                                    <p></p>
                                                </div>
                                            </div>  
                                            <hr />
                                            <div class="col-md-12 col-12">
                                                <div class="form-check mt-3">
                                                    <input type="checkbox" class="form-check-input" name="default_address" id="default_address" value="1"
                                                        {{ old('default_address', optional(auth()->user()->address)->default_address) ? 'checked' : '' }}>

                                                    <label class="form-check-label" for="default_address">Make this as my default Address</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>            
            </div>  

            <div class="modal fade" id="addAddress" tabindex="-1" aria-labelledby="addAddressLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="addAddressLabel">Add Address</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <form action="" id="create_addressForm" name="create_addressForm">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first_name">First Name</label>
                                            <input value={{ (!empty($address)) ? $address->first_name : '' }} type="text" name="first_name" id="first_name" placeholder="Enter Your First Name" class="form-control">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="last_name">Last Name</label>
                                            <input value={{ (!empty($address)) ? $address->last_name : '' }} type="text" name="last_name" id="last_name" placeholder="Enter Your Last Name" class="form-control">
                                            <p></p>
                                        </div>
                                    </div>                      
                                    <div class="col-md-12 col-12">                 
                                        <div class="form-group">
                                            <label for="mobile">Mobile</label>
                                            <input value={{ (!empty($address)) ? $address->mobile : '' }} type="text" name="mobile" id="mobile" placeholder="Enter Your Mobile" class="form-control">
                                            <p></p>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-6 col-6">
                                        <div class="form-group">
                                            <label for="zip">Zip</label>
                                            <input value={{ (!empty($address)) ? $address->zip : '' }}  type="text" name="zip" id="zip" placeholder="Enter Your Zip" class="form-control">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6">
                                        <div class="form-group">
                                            <label for="state">State</label>
                                            <input value={{ (!empty($address)) ? $address->state : '' }}  type="text" name="state" id="state" placeholder="Enter Your State" class="form-control">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea name="address" id="address" cols="30" rows="5" class="form-control">{{ (!empty($address)) ? $address->address : '' }}</textarea>
                                            <p></p>
                                        </div>                                        
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="locality">Apartment</label>
                                                    <input value={{ (!empty($address)) ? $address->locality : '' }} type="text" name="locality" id="locality" placeholder="Enter Your locality" class="form-control">
                                                    <p></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="City">City</label>
                                                    <input value={{ (!empty($address)) ? $address->city : '' }} type="text" name="city" id="city" placeholder="Enter Your City" class="form-control">
                                                    <p></p>
                                                </div>
                                            </div>                                            
                                            <div class="col-md-6 col-6">
                                                <div class="row">
                                                    <div class="col-md-8 col-6">
                                                        <div class="form-group">
                                                            <label for="country">Country</label>
                                                            <select name="country_id" id="country_id" class="form-select">
                                                                <option value="">Select a Country</option>
                                                                @if ($countries->isNotEmpty())
                                                                    @foreach ($countries as $country)
                                                                        <option {{ (!empty($address) && $address->country_id == $country->id) ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <p></p>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>            
            </div>  
        </div>            
    </div>
</div>

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
