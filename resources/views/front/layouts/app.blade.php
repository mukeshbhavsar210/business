<!DOCTYPE html>
<html class="no-js" lang="en_AU" />
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Online Fashion Shopping for Men and Women</title>
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />

	<link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/slick.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/slick-theme.css') }}" />
	
	{{-- <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/style.min.css') }}" /> --}}
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/ion.rangeSlider.min.css') }}" />

	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;500&family=Raleway:ital,wght@0,400;0,600;0,800;1,200&family=Roboto+Condensed:wght@400;700&family=Roboto:wght@300;400;700;900&display=swap" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">	
	<link rel="shortcut icon" type="image/x-icon" href="#" />
</head>
<body data-instant-intensity="mousedown">

<header>
	<div class="top-header">
		<div class="container">
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
										@foreach (getCategories() as $category)
											<li class="nav-item dropdown position-static">
												<a href="{{ route('front.category.shop', [$category->category_slug]) }}" class="nav-link dropdown-toggle" >
													{{ $category->category_name }}
												</a>

												@if ($category->subCategories->isNotEmpty())														
													<ul class="dropdown-menu">															
														<div class="row">
															@foreach ($category->subCategories as $subCategory)
																@if ($subCategory->subSubCategories->isNotEmpty())																	
																<div class="col-md-3 col-12">
																	<li class="dropdown-header">
																		<a href="{{ route('front.shop', [$category->category_slug, $subCategory->sub_category_slug]) }}">
																			{{ $subCategory->sub_category_name }}
																		</a>
																	</li>
																	@foreach ($subCategory->subSubCategories as $subSubCategory)
																		<li>
																			<a class="dropdown-item" href="{{ route('front.shop', [$category->category_slug, $subCategory->sub_category_slug, $subSubCategory->sub2_category_slug]) }}">
																				{{ $subSubCategory->sub2_category_name }}
																			</a>
																		</li>
																	@endforeach																	
																</div>
															{{-- @else
																<li>
																	<a class="dropdown-item"
																	href="{{ route('front.shop', [$category->slug, $subCategory->slug]) }}">
																		{{ $subCategory->name }}
																	</a>
																</li> --}}
															@endif
														@endforeach
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
									<i class="fa fa-search"></i>
									<input value="{{ Request::get('search') }}" type="text" placeholder="Search for products, brands and more" class="form-control" name="search" id="search">
								</div>
							</form>

							<ul class="icon-controls">
								@if (Auth::check())
									<li>
										<div class="hover-parent position-relative">
											<a href="" class="link">
												<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="none" viewBox="0 0 18 18" style="font-size: 20px;" class=" " stroke="none"><path stroke="#303030" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.25 5a4.25 4.25 0 1 1-8.5 0 4.25 4.25 0 0 1 8.5 0Z"></path><mask id="header_icon_account_svg__a" fill="#fff"><path d="M0 16.997c.844-2.406 2.131-4.427 3.72-5.838C5.308 9.747 7.136 9 9 9c1.864 0 3.691.747 5.28 2.159C15.87 12.57 17.156 14.594 18 17"></path></mask><path fill="#303030" d="M-1.415 16.5a1.5 1.5 0 0 0 2.83.993l-2.83-.993Zm18 .996a1.5 1.5 0 0 0 2.83-.992l-2.83.992Zm-15.17-.003c.777-2.213 1.938-4.002 3.301-5.213l-1.992-2.243C.91 11.65-.504 13.902-1.416 16.5l2.831.993Zm3.301-5.213C6.071 11.076 7.555 10.5 9 10.5v-3c-2.283 0-4.454.918-6.276 2.537l1.992 2.243ZM9 10.5c1.445 0 2.929.576 4.284 1.78l1.992-2.243C13.454 8.418 11.283 7.5 9 7.5v3Zm4.284 1.78c1.363 1.21 2.524 3.002 3.3 5.216l2.832-.992c-.912-2.598-2.325-4.855-4.14-6.467l-1.992 2.243Z" mask="url(#header_icon_account_svg__a)"></path><path stroke="#303030" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M.8 17h16.3"></path></svg>
												<span>Profile</span>
											</a>

											<div class="hover-content">												
												<p><b>Hello {{ Auth::user()->name }}</b></p>
												{{ Auth::user()->phone }}
												<hr />												
												<ul class="navbar-listings" >													
													<li><a href="{{ route('account.orders') }}">Orders</a></li>
													<li><a href="{{ route('account.wishlist') }}">Wishlist</a></li>
													<li><a href="{{ route('account.changePassword') }}">Coupons</a></li>
													<li><a href="{{ route('account.changePassword') }}">Saved Cards</a></li>
													<li><a href="{{ route('account.changePassword') }}">Saved Address</a></li>
													<hr />													
													<li><a href="{{ route('account.profile') }}">Edit Profile</a></li>													
													<li><a href="{{ route('account.logout') }}">Logout</a></li>													
												</ul>
											</div>
										</div>
									</li>
								@else
									<li>
										<div class="hover-parent position-relative">
											<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="none" viewBox="0 0 24 24" style="font-size: 24px;" class=" " stroke="none"><g clip-path="url(#header_icon_wishlist_svg__a)"><path stroke="#303030" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 20S3 14.91 3 8.727c0-1.093.375-2.152 1.06-2.997a4.672 4.672 0 0 1 2.702-1.638 4.639 4.639 0 0 1 3.118.463A4.71 4.71 0 0 1 12 6.909a4.71 4.71 0 0 1 2.12-2.354 4.639 4.639 0 0 1 3.118-.463 4.672 4.672 0 0 1 2.701 1.638A4.756 4.756 0 0 1 21 8.727C21 14.91 12 20 12 20Z"></path></g><defs><clipPath id="header_icon_wishlist_svg__a"><path fill="#fff" d="M0 0h24v24H0z"></path></clipPath></defs></svg>
											<span>Profile</span>

											<div class="hover-content">
												<p><b>Welcome</b></p>
												<p>To access account and manage orders</p>
												<a class="btn btn-primary mt-2" href="{{ route('account.login')}}">Login / Signup</a>
												<hr />
												<ul class="navbar-listings">
													<li><a href="{{ route('account.orders') }}">Orders</a></li>
													<li><a href="{{ route('account.wishlist') }}">Wishlist</a></li>
													<li><a href="{{ route('account.wishlist') }}">Contact us</a></li>
													<hr />
													<li><a href="{{ route('account.changePassword') }}">Coupons</a></li>
													<li><a href="{{ route('account.changePassword') }}">Saved Cards</a></li>
													<li><a href="{{ route('account.changePassword') }}">Saved Address</a></li>																										
												</ul>
											</div>
										</div>
									</li>
								@endif						
								<li>
									<a href="{{ route('front.cart') }}" class="link">
										<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="none" viewBox="0 0 24 24" style="font-size: 24px;" class=" " stroke="none"><g clip-path="url(#header_icon_wishlist_svg__a)"><path stroke="#303030" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 20S3 14.91 3 8.727c0-1.093.375-2.152 1.06-2.997a4.672 4.672 0 0 1 2.702-1.638 4.639 4.639 0 0 1 3.118.463A4.71 4.71 0 0 1 12 6.909a4.71 4.71 0 0 1 2.12-2.354 4.639 4.639 0 0 1 3.118-.463 4.672 4.672 0 0 1 2.701 1.638A4.756 4.756 0 0 1 21 8.727C21 14.91 12 20 12 20Z"></path></g><defs><clipPath id="header_icon_wishlist_svg__a"><path fill="#fff" d="M0 0h24v24H0z"></path></clipPath></defs></svg>
										<span>Wishlist</span>						
									</a>
								</li>
								<li>
									<a href="{{ route('front.cart') }}" class="link">
										<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="none" viewBox="0 0 16 20" style="font-size: 20px;">
											<path stroke="#303030" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M.75 4.8c0-.02.003-.037.006-.05h14.488c.003.013.006.03.006.05v14.4c0 .02-.003.037-.006.05H.756a.196.196 0 0 1-.006-.05V4.8ZM4.5 3.75c0-.73.395-1.429 1.098-1.945C6.302 1.29 7.255 1 8.25 1c.995 0 1.948.29 2.652.805C11.605 2.321 12 3.021 12 3.75"></path>
										</svg>
										<span>Bag</span>						
									</a>
								</li>
							</ul>
						</div>				
					</div>											
				</nav>
			</div>							
		</div>
	</div>
</header>

<main>
    @yield('content')
</main>

<footer class="bg-dark mt-5">
	<div class="container pb-5 pt-3">
		<div class="row">
			<div class="col-md-4">
				<div class="footer-card">
					<h3>Get In Touch</h3>
					<p>No dolore ipsum accusam no lorem. <br>
					123 Street, New York, USA <br>
					exampl@example.com <br>
					000 000 0000</p>
				</div>
			</div>

			<div class="col-md-4">
				<div class="footer-card">
					<h3>Important Links</h3>
					<ul>
                        @if(staticPages()->isNotEmpty())
                            @foreach (staticPages() as $page)
                                <li><a href="{{ route('front.page',$page->slug) }}" title="Contact Us">{{ $page->name }}</a></li>
                            @endforeach
                        @endif

					</ul>
				</div>
			</div>

			<div class="col-md-4">
				<div class="footer-card">
					<h3>My Account</h3>
					<ul>
						<li><a href="#" title="Sell">Login</a></li>
						<li><a href="#" title="Advertise">Register</a></li>
						<li><a href="#" title="Contact Us">My Orders</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="copyright-area">
		<div class="container">
			<div class="row">
				<div class="col-12 mt-3">
					<div class="copy-right text-center">
						<p>© Copyright 2022 Amazing Shop. All Rights Reserved</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>

<!-- Wishlist Modal -->
<div class="modal fade" id="wishlistModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Success</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<script src="{{ asset('front-assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('front-assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
<script src="{{ asset('front-assets/js/instantpages.5.1.0.min.js') }}"></script>
<script src="{{ asset('front-assets/js/lazyload.17.6.0.min.js') }}"></script>
<script src="{{ asset('front-assets/js/slick.min.js') }}"></script>
<script src="{{ asset('front-assets/js/ion.rangeSlider.min.js') }}"></script>
<script src="{{ asset('front-assets/js/documentReady.js') }}"></script>
<script>
	window.onscroll = function() {myFunction()};
	var navbar = document.getElementById("navbar");
	var sticky = navbar.offsetTop;

	function myFunction() {
		if (window.pageYOffset >= sticky) {
			navbar.classList.add("sticky")
		} else {
			navbar.classList.remove("sticky");
		}
	}

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function addToCart(id){
		let size = $("select[name='size']").val();
    	let color = $("select[name='color']").val();

        $.ajax({
            url: '{{ route("front.addToCart") }}',
            type: 'post',
            data: {
				_token: '{{ csrf_token() }}', // Include CSRF token
				id: id,
				size: size,
				color: color
			},
            dataType: 'json',
            success: function(response){
                if(response.status == true){
                    window.location.href= "{{ route('front.cart') }}";
                } else {
                    alert(response.message);
                }
            }
        })
    }

    function addToWishlist(id){
        $.ajax({
            url: '{{ route("front.addToWishlist",) }}',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success: function(response){
                if(response.status == true){
                    $("#wishlistModal .modal-body").html(response.message);
                    $("#wishlistModal").modal('show');
                } else {
                    window.location.href= "{{ route('account.login') }}";
                    //alert(response.message);
                }
            }
        })
    }

    //Alert timeout
    //setTimeout(function () {
        //$('.alert').fadeOut(300);
    //}, 2000);
</script>

@yield('customJs')

</body>
</html>
