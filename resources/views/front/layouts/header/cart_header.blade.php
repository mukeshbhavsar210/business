<header class="cart-header">
    <div class="container">
        <div class="row">
            <nav class="navbar navbar-expand-lg">							
                <div class="col-md-2 col-2">
                    <a href="{{ route('front.home') }}" class="logo" >
                        <img src="{{ asset('front-assets/images/logo.png') }}" alt="Business">
                    </a>
                </div>
                <div class="col-md-8 col-6">                    
                    <ol class="checkout-steps">
                        <li class="{{ request()->routeIs('front.cart') ? 'active' : '' }}" >BAG</li>
                        <li class="divider"></li>
                        <li>PAYMENT</li>
                    </ol>
                </div>
                <div class="col-md-2 col-4">
                    <p class="float-end">100% Secure</p>
                </div>											
            </nav>
        </div>							
    </div>    
</header>