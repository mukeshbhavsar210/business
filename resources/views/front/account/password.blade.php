@extends('front.layouts.app')

@section('content')

<div class="container-small">
    <div class="small-title">
        <h4>Account</h4>
        {{-- <p>{{ $address->first_name }} {{ $address->last_name }}</p> --}}
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
                            <h5 class="h5 mt-3 mb-4">Change Password</h5>
                            
                            <form action="" method="post" name="changePasswordForm" id="changePasswordForm" >                                
                                <div class="form-group">
                                    <label for="old_password">Old Password</label>
                                    <input type="password" name="old_password" id="old_password" placeholder="Old Password" class="form-control">
                                    <p></p>
                                </div>                            
                                <div class="form-group mt-3">
                                    <label for="new_password">New Password</label>
                                    <input type="password" name="new_password" id="new_password" placeholder="New Password" class="form-control">
                                    <p></p>
                                </div>                            
                                <div class="form-group mt-3">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Old Password" class="form-control">
                                    <p></p>
                                </div>                                                        
                                <button class="btn btn-primary mt-1" type="submit" id="submit">Change Password</button>
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
 $("#changePasswordForm").submit(function(event){
        event.preventDefault();

        $("#submit").prop('disbled','true');

        $.ajax({
            url: '{{ route("account.processChangePassword") }}',
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response){
                $("#submit").prop('disbled','false');
                if (response.status == true){

                    $('#old_password').removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    $('#new_password').removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    $('#confirm_password').removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');

                    window.location.href = '{{ route("account.changePassword") }}'

                } else {
                    var errors = response.errors;

                    if(errors.old_password){
                        $('#old_password').addClass('is-invalid').siblings('p').html(errors.old_password).addClass('invalid-feedback');
                    } else {
                        $('#old_password').removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }

                    if(errors.new_password){
                        $('#new_password').addClass('is-invalid').siblings('p').html(errors.new_password).addClass('invalid-feedback');
                    } else {
                        $('#new_password').removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }

                    if(errors.confirm_password){
                        $('#confirm_password').addClass('is-invalid').siblings('p').html(errors.confirm_password).addClass('invalid-feedback');
                    } else {
                        $('#confirm_password').removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                }
            }
        })
    })
</script>
@endsection
