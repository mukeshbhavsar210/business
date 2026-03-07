


<div class="modal fade" id="login" tabindex="-1" aria-labelledby="loginLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginLabel">Login to Your Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('account.authenticate') }}" method="post" >
                @csrf
                <div class="modal-body">
                    <div class="form-group">                        
                        <input type="text" class="form-control floating-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                        <label class="floating-label">Email</label>
                        @error('email')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">                        
                        <input type="password" class="form-control floating-input @error('password') is-invalid @enderror" name="password" >
                        <label class="floating-label">Password</label>
                        @error('password')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>                    
                </div>

                <div class="modal-footer">
                    <div>                        
                        <a href="#" data-bs-toggle="modal" data-bs-target="#forgot" class="btn btn-outline-dark">Forgot Password?</a>                        
                    </div>
                    <div>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#register" class="btn btn-outline-dark caps-btn">Register</a>
                        <input type="submit" class="btn btn-primary caps-btn checkoutBtn" value="Login">
                    </div>                    
                </div> 
            </form>            
        </div>
    </div>
</div>

<div class="modal fade" id="register" tabindex="-1" aria-labelledby="registerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerLabel">Register Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="" method="post" name="registrationForm" id="registrationForm">                    
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control floating-input" id="name" name="name">
                        <label class="floating-label">Name</label>
                        <p></p>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <input type="text" class="form-control floating-input" placeholder="Email" id="email" name="email">
                                <label class="floating-label">Email</label>
                                <p></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <input type="text" class="form-control floating-input" id="phone" name="phone">
                                <label class="floating-label">Phone</label>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <input type="password" class="form-control floating-input" id="password" name="password">
                                <label class="floating-label">Password</label>
                                <p></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="password" class="form-control floating-input" id="password_confirmation" name="password_confirmation">
                                <label class="floating-label">Confirmed Password</label>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-outline-dark checkoutBtn">Login</a>
                    <input type="submit" class="btn btn-primary" value="Register Account">
                </div> 
            </form>    
        </div>
    </div>
</div>

<div class="modal fade" id="forgot" tabindex="-1" aria-labelledby="forgotLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="forgotLabel">Forgot Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="" method="post" name="forgotPasswordForm" id="forgotPasswordForm">                    
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control floating-input" placeholder="Email" id="email" name="email">
                        <label class="floating-label">Email</label>
                        <p></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-primary checkoutBtn">Login</a>
                    <input type="submit" class="btn btn-primary" value="Send Reset Link">
                </div> 
            </form>    
        </div>
    </div>
</div>