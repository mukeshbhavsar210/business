@extends('front.layouts.app')

@section('title', 'Register Account')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-6">1</div>
        <div class="col-md-6">
            <div class="login-form">
                <h4 class="modal-title">Register Account</h4>
                <p class="tiny-font">Join us now to be a part of {{ config('app.name') }} family.</p>

                <form action="" method="post" name="registrationForm" id="registrationForm" class="mt-3">                    
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Name" id="name" name="name">
                        <p></p>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Email" id="email" name="email">
                        <p></p>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Phone" id="phone" name="phone">
                        <p></p>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                                <p></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Confirm Password" id="password_confirmation" name="password_confirmation">
                                <p></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex-end">
                        {{-- <a href="#" class="forgot-link">Forgot Password?</a> --}}
                        <p class="mt-2">Already have an account? <a href="{{ route('account.login') }}"><b>Login</b></a></p>
                        <button type="submit" class="btn btn-primary">Register Account</button>
                    </div>                
                </form>                
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')

<script type="text/javascript">
    
</script>

@endsection
