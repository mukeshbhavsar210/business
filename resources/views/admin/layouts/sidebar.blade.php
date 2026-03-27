<ul class="navbar-nav mb-auto w-100">
    <li class="menu-label pt-0 mt-0">
        <span>Main Menu</span>
    </li>
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
            <i class="iconoir-journal-page menu-icon"></i>
            <span>Brands</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('ratings.index') }}" class="nav-link">
            <i class="iconoir-journal-page menu-icon"></i>
            <span>Ratings</span>
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

    {{-- <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="dashboard.html" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" data-bs-target="#categoryMenu">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p class="dropdown">Category Group
                        <span class="carat"></span>
                    </p>                    
                </a>    

                <div id="categoryMenu" class="accordion-collapse collapse" data-bs-parent="#categoryMenu">
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="{{ route('categories.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Category</p>
                            </a>
                        </li>            
                        <li class="nav-item">
                            <a href="{{ route('sub-categories.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Sub Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sub2-categories.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Sub2 Category</p>
                            </a>
                        </li>
                    </ul>                    
                </div>                                    
            </li>
            
            <li class="nav-item">
                <a href="{{ route('brands.index') }}" class="nav-link">
                    <svg class="h-6 nav-icon w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    <p>Brands</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('products.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-tag"></i>
                    <p>Products</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('shipping.create') }}" class="nav-link">
                    <!-- <i class="nav-icon fas fa-tag"></i> -->
                    <i class="fas fa-truck nav-icon"></i>
                    <p>Shipping</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('orders.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-shopping-bag"></i>
                    <p>Orders</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('coupons.index') }}" class="nav-link">
                    <i class="nav-icon  fa fa-percent" aria-hidden="true"></i>
                    <p>Discount</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link">
                    <i class="nav-icon  fas fa-users"></i>
                    <p>Users</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pages.index') }}" class="nav-link">
                    <i class="nav-icon  far fa-file-alt"></i>
                    <p>Pages</p>
                </a>
            </li>
        </ul>
    </nav> --}}
