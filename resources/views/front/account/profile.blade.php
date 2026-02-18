@extends('front.layouts.app')

@section('content')

<div class="container-small">
    <div class="small-title">
        <h4>Account</h4>
        <p>{{ $address->first_name }} {{ $address->last_name }}</p>
    </div>

    <div class="row">
        <div class="col-md-3 col-12">
            @include('front.account.common.sidebar')  
        </div>
        <div class="col-md-9 col-12">
            @include('front.account.common.message')        
            
            <div class="orders-details">
                <div class="user-details-repeate">
                    <div class="row justify-content-center">
                        <div class="col-md-8">                        
                            <h5 class="h5 mt-3 mb-4">Profile Details</h5>                              
                            <div class="row">
                                <div class="col-md-6 col-6">Full Name</div>
                                <div class="col-md-6 col-6">{{ $user->name }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-6">Mobile Number</div>
                                <div class="col-md-6 col-6">{{ $user->phone }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-6">Email ID</div>
                                <div class="col-md-6 col-6">{{ $user->email }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-6">Alternate Mobile</div>
                                <div class="col-md-6 col-6">{{ $user->mobile }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-6">Gender</div>
                                <div class="col-md-6 col-6">{{ $user->gender }}</div>
                            </div>   
                            <div class="row">
                                <div class="col-md-6 col-6">Date of Birth</div>
                                <div class="col-md-6 col-6">{{ $user->birthdate }}</div>
                            </div>           
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <a href="{{ route('account.profile.edit') }}" class="btn btn-primary w-100">Edit Profile</a>
                                </div>
                            </div>                         
                        </div>
                    </div>
                </div>                                
            </div>                   
        </div>            
    </div>
</div>

@endsection

@section('customJs')
<script>
    $("#profileForm").submit(function(event){
        event.preventDefault();

        $.ajax({
            url: '{{ route("account.updateProfile") }}',
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response){
                if (response.status == true){

                    $('#profileForm #name').removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    $('#profileForm #email').removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    $('#profileForm #phone').removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');

                    window.location.href = '{{ route("account.profile") }}'

                } else {
                    var errors = response.errors;
                    if(errors.name){
                        $('#profileForm #name').addClass('is-invalid').siblings('p').html(errors.name).addClass('invalid-feedback');
                    } else {
                        $('#profileForm #name').removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }

                    if(errors.email){
                        $('#profileForm #email').addClass('is-invalid').siblings('p').html(errors.email).addClass('invalid-feedback');
                    } else {
                        $('#profileForm #email').removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }

                    if(errors.phone){
                        $('#profileForm #phone').addClass('is-invalid').siblings('p').html(errors.phone).addClass('invalid-feedback');
                    } else {
                        $('#profileForm #phone').removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                }
            }
        })
    })


</script>
@endsection
