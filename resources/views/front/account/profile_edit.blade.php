@extends('front.layouts.app')

@section('content')

<div class="container-small">
    <div class="small-title">
        <h4>Account</h4>
        <p>{{ $userDetails->name }}</p>
    </div>

    <div class="row">
        <div class="col-md-3 col-12">
            @include('front.account.common.sidebar')  
        </div>
        <div class="col-md-9 col-12">
            @include('front.account.common.message')

            <div class="orders-details">
                <h5 class="h5 mb-4">Edit Details</h5>

                    <form action="" id="profileForm" name="profileForm">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input value={{ $user->phone }} type="text" name="phone" id="phone" placeholder="Enter Your Phone" class="form-control">
                                    <p></p>
                                </div>
                            </div>     
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input value={{ $user->email }} type="text" name="email" id="email" placeholder="Enter Your Email" class="form-control">
                                    <p></p>
                                </div>
                            </div>                           
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input value={{ $user->name }} type="text" name="name" id="name" placeholder="Enter Your Name" class="form-control">
                                    <p></p>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                @php $gender = auth()->user()->gender ?? ''; @endphp
                                <div class="form-group">
                                    <label for="name">Birthdate</label><br />
                                    <div class="btn-group mt-2 mb-3" role="group">                                    
                                        <input type="radio" class="btn-check" name="gender" id="male" value="male"
                                            {{ $gender == 'male' ? 'checked' : '' }} autocomplete="off">
                                        <label class="btn btn-outline-primary" for="male">Male</label>

                                        <input type="radio" class="btn-check" name="gender" id="female" value="female"
                                            {{ $gender == 'female' ? 'checked' : '' }} autocomplete="off">
                                        <label class="btn btn-outline-primary" for="female">Female</label>
                                    </div>
                                </div>
                            </div>                                                        
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="mobile">Alternate mobile details</label>
                                    <input value={{ $user->mobile }} type="text" name="mobile" id="mobile" placeholder="Enter Alternate mobile" class="form-control">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="birthdate">Birthday</label>
                                    <input value={{ $user->birthdate }} type="text" name="birthdate" id="birthdate" placeholder="Enter birthdate" class="form-control">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <button class="btn btn-primary mt-2 w-100">Save Details</button>
                            </div>
                        </div>
                    </form>                       
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