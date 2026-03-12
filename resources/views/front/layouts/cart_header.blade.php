<header class="cart-header">
    <div class="container">
        <div class="row">
            <nav class="navbar navbar-expand-lg">							
                <div class="col-md-2 col-3">
                    <a href="{{ route('front.home') }}" class="logo" >
                        <img src="{{ asset('front-assets/images/logo.svg') }}" alt="Business">
                    </a>
                </div>
                <div class="col-md-8 col-8">                    
                    <ol class="checkout-steps">
                        <li class="{{ request()->routeIs('front.cart') ? 'active' : '' }}" >BAG</li>
                        <li class="divider"></li>
                        <li>PAYMENT</li>
                    </ol>
                </div>
                <div class="col-md-2 col-12">
                    <p class="float-end">100% Secure</p>
                </div>											
            </nav>
        </div>							
    </div>    
</header>