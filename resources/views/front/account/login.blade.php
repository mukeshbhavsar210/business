@extends('front.layouts.app')

@section('content')
    <div class="container">
        @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif

        @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
        
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="login-form">
                    <form action="{{ route('account.authenticate') }}" method="post" >
                        @csrf
                        <h4 class="modal-title mb-4">Login to Your Account</h4>
                        <div class="form-group">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" >
                            @error('password')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group small">
                            <a href="#" class="forgot-link">Forgot Password?</a>
                        </div>
                        <input type="submit" class="btn btn-dark btn-block btn-lg" value="Login">
                    </form>
                    <div class="text-center small">Don't have an account? <a href="{{ route('account.register') }}">Sign up</a></div>
                </div>
            </div>
        </div>
    </div>
@endsection