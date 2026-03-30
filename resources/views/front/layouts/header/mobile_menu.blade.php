<div class="d-block d-md-none">
    <a href="javascript:0" class="navbar-toggler mobile-menu-icon" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
        <span class="sprites"></span>
    </a>
</div>

<div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="mobileMenu">
    <div class="mobile-ad">
        
    </div>

    <div class="offcanvas-body">                            
        <ul class="navbar-nav">
            @if (getCategories()->isNotEmpty())
                @foreach (getCategories() as $item1)
                    <li class="nav-item">
                        <a href="javascript:void(0);" class="nav-link toggle-category" data-target="#cat-{{ $item1->id }}">
                            {{ $item1->category_name }}
                            <span class="sprites mobile-arrow-1 float-end"></span>
                        </a>                                            

                        @if ($item1->subCategories->isNotEmpty())														
                            <ul class="mobile-dropdown" id="cat-{{ $item1->id }}">                                                    
                                @foreach ($item1->subCategories as $item2)
                                    @if ($item2->subSubCategories->isNotEmpty())
                                        <li>    
                                            <a href="javascript:void(0);" class="dropdown-item toggle-subcategory"  data-target="#subcat-{{ $item2->id }}">
                                                {{ $item2->sub_category_title }}
                                                <span class="sprites mobile-arrow-1 float-end"></span>
                                            </a>
                                            {{-- <a href="{{ route('front.shop', [$item1->category_slug, $item2->sub_category_slug]) }}" data-target="#subcat-{{ $item2->id }}">
                                                {{ $item2->sub_category_title }}
                                                <span class="float-end">▶</span>
                                            </a>                                 --}}
                                            
                                            @if ($item2->subSubCategories->isNotEmpty())
                                                <ul class="sub-dropdown" id="subcat-{{ $item2->id }}">
                                                    @foreach ($item2->subSubCategories as $item3)
                                                        <li>
                                                            <a class="dropdown-item"  href="{{ route('front.shop', [$item1->category_slug, $item2->sub_category_slug, $item3->sub_sub_category_slug]) }}">
                                                                {{ $item3->sub_sub_category_name }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @else
                                        <li>
                                            <a class="dropdown-item" href="{{ route('front.shop', [$item1->slug, $item2->slug]) }}" title="{{ $item2->slug }}">
                                                {{ $item2->name }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach                                                        
                            </ul>
                        @endif
                    </li>
                @endforeach
            @endif
        </ul>

        <hr />

        @if (Auth::check())
            <p><b>Hello {{ Auth::user()->name }}</b></p>
            {{ Auth::user()->phone }}            
        @else
            <p><b>Welcome</b></p>
            <p class="text-muted tiny-font">To access account and manage orders</p>
            <a class="btn btn-primary mt-2 checkoutBtn" href="#" >Login / Signup</a>
        @endif

        <ul class="navbar-listings">
            @if (Auth::check())  
                <li><a href="{{ route('account.dashboard') }}" class="{{ request()->routeIs(['account.dashboard', 'account.orderDetail', 'account.order.view', 'account.orders.cancelled']) ? 'active' : '' }}">Account</a></li>
                <li><a href="{{ route('account.orders') }}" class="{{ request()->routeIs(['account.orders', 'account.orderDetail', 'account.order.view', 'account.orders.cancelled']) ? 'active' : '' }}">Orders</a></li>                 
                <li><a href="{{ route('account.profile') }}" class="{{ request()->routeIs(['account.profile', 'account.profile.edit', 'account.changePassword']) ? 'active' : '' }}">Edit Profile</a></li>
                <li><a href="{{ route('account.logout') }}">Logout</a></li>
            @endif
        </ul>
    </div>
</div>