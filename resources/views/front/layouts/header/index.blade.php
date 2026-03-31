<header class="header">    
    <div class="row row-hide">
        <nav class="navbar navbar-expand-lg">							
            <div class="col-md-7 col-8">
                <div class="logo-controls">                
                    @include('front/layouts/header/mobile_menu')
                    @include('front/layouts/header/default_menu')
                </div>
            </div>        
            <div class="col-md-5 col-4">
                <div class="search-controls">                                      
                    <form class="search-form desktop-form d-none d-md-block" action="{{ route('front.shop') }}">
                        <div class="search-control">
                            <span class="sprites search-icon"></span> 
                            <input value="{{ Request::get('search') }}" type="text" placeholder="Search for products, brands and more" class="form-control" name="search" id="search">
                        </div>
                    </form>
                    
                    <ul class="icon-controls">
                        <li class="item d-block d-md-none">
                            <a href="javascript:0" class="search-btn"><span class="sprites search-icon"></span></a>
                        </li>
                        <li class="item d-none d-md-block">
                            <div class="hover-parent">
                                <a href="{{ route('account.profile') }}" class="link">
                                    <span class="sprites user-icon"></span>     
                                    @if (Auth::check())
                                        <span class="d-none d-md-block">Account</span>
                                    @else
                                        <span class="d-none d-md-block">Profile</span>
                                    @endif
                                </a>

                                <div class="hover-content">
                                    @if (Auth::check())
                                        <p><b>Hello {{ Auth::user()->name }}</b></p>
                                        {{ Auth::user()->phone }}
                                        <hr />
                                    @else
                                        <p><b>Welcome</b></p>
                                        <p class="text-muted tiny-font">To access account and manage orders</p>
                                        <a class="btn btn-primary mt-2 checkoutBtn" href="#" >Login / Signup</a>                                                
                                        <hr />
                                    @endif

                                    {{-- <div class="social-btns">                            
                                        <h5>Login with your accounts</h5>
                                        <div class="groups">
                                            <div>
                                                <a href="{{ url('auth/google') }}" class="google-btn account-btn">
                                                    <span class="sprites"></span>
                                                    Login with Google
                                                </a>
                                            </div>
                                            <div>
                                                <a href="{{ url('auth/facebook') }}" class="facebook-btn account-btn">
                                                    <span class="sprites"></span>
                                                    Log in with Facebook
                                                </a>
                                            </div>                  
                                        </div>          
                                    </div> --}}

                                    @php
                                        $guestAttr = 'data-bs-toggle=modal data-bs-target=#login href=javascript:void(0)';
                                    @endphp

                                    <ul class="navbar-listings">
                                        <li>
                                            <a class="{{ request()->routeIs(['account.dashboard', 'account.orderDetail', 'account.order.view', 'account.orders.cancelled']) ? 'active' : '' }}"
                                                @if(Auth::check()) href="{{ route('account.dashboard') }}" 
                                                @else 
                                                {!! $guestAttr !!} 
                                                @endif
                                                >Dashboard
                                            </a>
                                        </li>
                                        <li>
                                            <a class="{{ request()->routeIs(['account.orders', 'account.orderDetail', 'account.order.view', 'account.orders.cancelled']) ? 'active' : '' }}"
                                                @if(Auth::check()) href="{{ route('account.orders') }}" 
                                                @else 
                                                {!! $guestAttr !!} 
                                                @endif
                                                >Orders
                                            </a>
                                        </li>
                                        <li>
                                            <a class="{{ request()->routeIs(['account.wishlist']) ? 'active' : '' }}"
                                                @if(Auth::check()) 
                                                href="{{ route('account.wishlist') }}" 
                                                @else 
                                                {!! $guestAttr !!} 
                                                @endif
                                                >Wishlist
                                            </a>
                                        </li>
                                        <li>
                                            <a 
                                                @if(Auth::check()) 
                                                href="" 
                                                @else 
                                                {!! $guestAttr !!} 
                                                @endif
                                                >Coupons
                                            </a>
                                        </li>
                                        <li>
                                            <a class="{{ request()->routeIs('account.cards') ? 'active' : '' }}"
                                                @if(Auth::check()) 
                                                href="" 
                                                @else 
                                                {!! $guestAttr !!} 
                                                @endif
                                                >Saved Cards
                                            </a>
                                        </li>
                                        <li>
                                            <a class="{{ request()->routeIs('account.address') ? 'active' : '' }}" 
                                                @if(Auth::check()) 
                                                href="{{ route('account.address') }}" 
                                                @else 
                                                {!! $guestAttr !!} 
                                                @endif
                                                >Saved Address
                                            </a>
                                        </li> 
                                        @if (Auth::check())
                                            <hr />
                                            <li><a href="{{ route('account.profile') }}" class="{{ request()->routeIs(['account.profile', 'account.profile.edit', 'account.changePassword']) ? 'active' : '' }}">Edit Profile</a></li>
                                            <li><a href="{{ route('account.logout') }}">Logout</a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="item">
                            <a href="{{ route('account.wishlist') }}" class="link">
                                <span class="sprites wishlist-icon"></span>
                                <span class="label d-none d-md-block">Wishlist</span>	                                        
                            </a>
                        </li>
                        <li class="item">
                            <a href="{{ route('front.cart') }}" class="link">
                                <span class="sprites bag-icon"></span> 
                                <span class="label d-none d-md-block">Bag</span>

                                <span id="cartCount" class="card-count">
                                    {{ Cart::count() }}
                                </span>					                                                                                   
                            </a>
                        </li>
                    </ul>
                </div> 
            </div>        
        </nav>
    </div>							    

    <form class="search-form bottom-form d-none" action="{{ route('front.shop') }}">
        <div class="search-control">
            <span class="sprites search-icon"></span> 
            <input value="{{ Request::get('search') }}" type="text" placeholder="Search for products, brands and more" class="form-control" name="search" id="search">            
            <a href="javascript:0" class="close-search-icon d-none">
                <span class="sprites"></span> 
            </a>
        </div>
    </form>
</header>

<div class="menu-overlay"></div>