<header class="header">    
    <div class="row">
        <nav class="navbar navbar-expand-lg">							
            <div class="col-md-7 col-12">
                <div class="logo-controls">
                    <a href="{{ route('front.home') }}" class="logo" >
                        <img src="{{ asset('front-assets/images/logo.svg') }}" alt="Business">
                    </a>					

                    <div class="d-block d-md-none">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                            Menu
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>						
                                
                    <div class="collapse navbar-collapse" id="mainNavbar">
                        <ul class="navbar-nav">
                            @if (getCategories()->isNotEmpty())
                                @foreach (getCategories() as $item1)
                                    <li class="nav-item dropdown position-static">
                                        <a href="{{ route('front.category', [$item1->category_slug]) }}" class="nav-link dropdown-toggle" >
                                            {{ $item1->category_name }}
                                        </a>

                                        @if ($item1->subCategories->isNotEmpty())														
                                            <ul class="dropdown-menu">
                                                <div class="container">
                                                    <div class="row">
                                                        @foreach ($item1->subCategories as $item2)
                                                            @if ($item2->subSubCategories->isNotEmpty())																	
                                                                <div class="col-md-2 col-12">
                                                                    <ul>
                                                                        <li class="dropdown-header">
                                                                            <a href="{{ route('front.shop', [$item1->category_slug, $item2->sub_category_slug]) }}">
                                                                                {{ $item2->sub_category_name }}
                                                                            </a>
                                                                        </li>                                                                
                                                                        @foreach ($item2->subSubCategories as $item3)
                                                                            <li>                                                                            
                                                                                <a class="dropdown-item" href="{{ route('front.shop', [$item1->category_slug, $item2->sub_category_slug, $item3->sub_sub_category_slug]) }}">
                                                                                    {{ $item3->sub_sub_category_name }}
                                                                                </a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @else
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ route('front.shop', [$item1->slug, $item2->slug]) }}" title="{{ $item2->slug }}">
                                                                        {{ $item2->name }}
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-12">
                <div class="search-controls">
                    <form class="search-form" action="{{ route('front.shop') }}">
                        <div class="search-control">
                            <span class="sprites search-icon"></span> 
                            <input value="{{ Request::get('search') }}" type="text" placeholder="Search for products, brands and more" class="form-control" name="search" id="search">
                        </div>
                    </form>

                    <ul class="icon-controls">
                        <li class="item">
                            <div class="hover-parent">
                                <a href="{{ route('account.profile') }}" class="link">
                                    <span class="sprites user-icon"></span>     
                                    @if (Auth::check())
                                        <span>Account</span>
                                    @else
                                        <span>Profile</span>
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
                                        <li><a class="{{ request()->routeIs(['account.orders', 'account.orderDetail', 'account.order.view', 'account.orders.cancelled']) ? 'active' : '' }}"
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
                                <span class="label">Wishlist</span>	                                        
                            </a>
                        </li>
                        <li class="item">
                            <a href="{{ route('front.cart') }}" class="link">
                                <span class="sprites bag-icon"></span> 
                                <span class="label">Bag</span>

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
</header>

<div class="menu-overlay"></div>