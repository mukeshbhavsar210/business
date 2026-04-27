<ul class="navbar-nav mb-auto w-100">    
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.dashboard') }}" >
            <i class="iconoir-home-simple menu-icon"></i>
            <span>Dashboards</span>
        </a>   
    </li>
    <li class="nav-item">
        <a href="{{ route('categories.index') }}" class="nav-link">
            <i class="iconoir-view-grid menu-icon"></i>
            <span>Category</span>
        </a>
    </li>         
    <li class="nav-item">
        <a href="{{ route('products.index') }}" class="nav-link">
            <i class="iconoir-compact-disc menu-icon"></i>
            <span>Products</span>
        </a>
    </li>     
    <li class="nav-item">
        <a href="{{ route('orders.index') }}" class="nav-link">
            <i class="iconoir-journal-page menu-icon"></i>
            <span>Orders</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('brands.index') }}" class="nav-link">
            <i class="iconoir-compact-disc menu-icon"></i>
            <span>Brands</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('review.index') }}" class="nav-link">
            <i class="iconoir-journal-page menu-icon"></i>
            <span>Ratings</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('affiliate_products.index') }}" class="nav-link">
            <i class="iconoir-compact-disc menu-icon"></i>
            <span>Affiliate Marketing</span>
        </a>
    </li> 
    <li class="nav-item">
        <a class="nav-link" href="#extra" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApplications">
            <i class="iconoir-page-star menu-icon"></i>
            <span>Settings</span>
        </a>
        <div class="collapse " id="extra">
            <ul class="nav flex-column">
                                 
                <li class="nav-item">
                    <a href="{{ route('shipping.index') }}" class="nav-link">                        
                        <span>Shipping</span>
                    </a>
                </li> 
                <li class="nav-item">
                    <a href="{{ route('colors.index') }}" class="nav-link">                        
                        <span>Colors</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('coupons.index') }}" class="nav-link">                        
                        <span>Discount</span>
                    </a>
                </li> 
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <span>Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pages.index') }}" class="nav-link">
                        <span>Pages</span>
                    </a>
                </li>                               
            </ul>
        </div>
    </li>
</ul>