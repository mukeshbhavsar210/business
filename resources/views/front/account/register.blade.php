@extends('front.layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="login-form">
                <form action="" method="post" name="registrationForm" id="registrationForm">
                    <h4 class="modal-title mb-3">Register Now</h4>
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
                    
                    <div class="form-group small">
                        <a href="#" class="forgot-link">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn btn-dark btn-block btn-lg" value="Register">Register</button>
                </form>
                <div class="text-center small">Already have an account? <a href="{{ route('front.home') }}">Login Now</a></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')

<script type="text/javascript">
    
</script>

@endsection
