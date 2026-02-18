<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Laravel Shop :: Administrative Panel</title>
		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="{{ asset('admin-assets/plugins/fontawesome-free/css/all.min.css') }}">
		<!-- Theme style -->

		<link href="{{ asset('admin-assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('admin-assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('admin-assets/css/app.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('admin-assets/css/custom.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('admin-assets/plugins/summernote/summernote-bs4.min.css') }}" rel="stylesheet" type="text/css" >
		<link href="{{ asset('admin-assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" >

        <meta name="csrf-token" content="{{ csrf_token() }}">
	</head>

	<body data-sidebar-size="collapsed">
        <div class="topbar d-print-none">
            <div class="container-xxl">
                <nav class="topbar-custom d-flex justify-content-between nav-sticky" id="topbar-custom">    
                    <ul class="topbar-item list-unstyled d-inline-flex align-items-center">                        
                        <li>
                            <button class="nav-link mobile-menu-btn nav-icon" id="togglemenu">
                                <i class="iconoir-menu-scale"></i>
                            </button>
                        </li> 
                        <li class="mx-1 welcome-text">
                            <h3 class="mb-0 fw-bold text-truncate">Good Morning, Admin!</h3>
                            <h6 class="mb-0 fw-normal text-muted text-truncate fs-14">Here's your overview this week.</h6>
                        </li>                   
                    </ul>
                    <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                        <li class="hide-phone app-search">
                            <form role="search" action="#" method="get">
                                <input type="search" name="search" class="form-control top-search mb-0" placeholder="Search here...">
                                <button type="submit"><i class="iconoir-search"></i></button>
                            </form>
                        </li>     
                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="{{ asset('admin-assets/img/us_flag.jpg') }}" alt="" class="thumb-sm rounded-circle">
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#"><img src="{{ asset('admin-assets/img/us_flag.jpg') }}" alt="" height="15" class="me-2">English</a>
                                <a class="dropdown-item" href="#"><img src="{{ asset('admin-assets/img/spain_flag.jpg') }}" alt="" height="15" class="me-2">Spanish</a>                                
                            </div>
                        </li>
                        <li class="topbar-item">
                            <a class="nav-link nav-icon" href="javascript:void(0);" id="light-dark-mode">
                                <i class="icofont-moon dark-mode"></i>
                                <i class="icofont-sun light-mode"></i>
                            </a>                    
                        </li>
                        <li class="dropdown topbar-item">
                            <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="{{ asset('admin-assets/img/avatar-1.jpg') }}" alt="" class="thumb-lg rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end py-0" style="">
                                <div class="d-flex align-items-center dropdown-item py-2 bg-secondary-subtle">                                    
                                    <div class="flex-grow-1 text-truncate align-self-center">
                                        <h6 class="my-0 fw-medium text-dark fs-13">{{ Auth::guard('admin')->user()->name }}</h6>
                                        <small class="text-muted">{{ Auth::guard('admin')->user()->email }}</small>
                                    </div>
                                </div>
                                
                                <a class="dropdown-item" href="{{ route('admin.showChangePasswordForm') }}">
                                    <i class="las la-user fs-18 me-1 align-text-bottom"></i>
                                    Change Password
                                </a>
                                
                                <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}">
                                    <i class="las la-power-off fs-18 me-1 align-text-bottom"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="startbar d-print-none">
            <div class="brand">
                <a href="" class="logo" title=""><span><img class="logo-sm" src="{{ asset('admin-assets/img/Heaven.jpg') }}" alt="" /></span></a>
            </div>
            <div class="startbar-menu">
                <div class="startbar-collapse simplebar-scrollable-y" id="startbarCollapse" data-simplebar="init">
                    <div class="simplebar-wrapper" style="margin: 0px -16px -16px;">
                        <div class="simplebar-height-auto-observer-wrapper">
                            <div class="simplebar-height-auto-observer"></div>
                        </div>
                        <div class="simplebar-mask">
                            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;">
                                    <div class="simplebar-content" style="padding: 0px 16px 16px;">
                                        <div class="d-flex align-items-start flex-column w-100">
                                            @include('admin/layouts/sidebar')

                                            <div class="update-msg text-center"> 
                                                <div class="d-flex justify-content-center align-items-center thumb-lg update-icon-box  rounded-circle mx-auto">
                                                    <i class="iconoir-peace-hand h3 align-self-center mb-0 text-primary"></i>
                                                </div>                   
                                                <h5 class="mt-3">Online Shopping</h5>                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="simplebar-placeholder" style="width: 70px; height: 657px;"></div>
                    </div>
                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                        <div class="simplebar-scrollbar" style="width: 0px; transform: translate3d(0px, 0px, 0px); display: none;"></div>
                    </div>
                    <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                        <div class="simplebar-scrollbar" style="height: 413px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="startbar-overlay d-print-none"></div>

<div class="page-wrapper">
    <div class="page-content">
        <div class="container-xxl">
            @yield('content')
        </div>                
        
        <footer class="footer text-center text-sm-start d-print-none">
            <div class="container-xxl">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-0 rounded-bottom-0">
                            <div class="card-body">
                                <p class="text-muted mb-0"> © <script> document.write(new Date().getFullYear()) </script> Online Shopping </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

		 
<script src="{{ asset('admin-assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin-assets/js/bootstrap.bundle.min.js.download') }}"></script>
<script src="{{ asset('admin-assets/js/simplebar.min.js.download') }}"></script>
<script src="{{ asset('admin-assets/js/app.js.download') }}"></script>

<script src="{{ asset('admin-assets/plugins/dropzone/min/dropzone.min.js') }}"></script>
<script src="{{ asset('admin-assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('admin-assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('admin-assets/js/datetimepicker.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function(){
        $(".summernote").summernote({
            //height:250;
        });
    })

    //Alert timeout
    setTimeout(function () {
        $('.alert').fadeOut(300);
    }, 1500);

    window.addEventListener("scroll", function() {
        let header = document.getElementById("adminHeader");
        if (window.scrollY > 100) {
            header.classList.add("sticky-header");
        } else {
            header.classList.remove("sticky-header");
        }
    });

</script>


		
        @yield('customJs')
	</body>
</html>
