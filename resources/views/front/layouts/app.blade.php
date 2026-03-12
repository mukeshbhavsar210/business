<!DOCTYPE html>
<html class="no-js" lang="en_AU" />
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
    <title>@yield('title', 'Default Title')</title>
    <meta name="description" content="@yield('meta_description')">
    <meta name="keywords" content="@yield('meta_keywords')">
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />

    {{-- <meta property="og:title" content="{{ $product->title }}">
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit($product->description,150) }}">
    <meta property="og:image" content="{{ asset('storage/'.$product->image) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="product"> --}}

    <link rel="canonical" href="{{ url()->current() }}">

	<link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/slick.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/slick-theme.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/style.min.css') }}" />
	{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
	<link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/ion.rangeSlider.min.css') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:ital,opsz,wght@0,17..18,400..700;1,17..18,400..700&family=Manrope:wght@200..800&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">	
	<link rel="shortcut icon" type="image/x-icon" href="#" />
</head>
<body data-instant-intensity="mousedown">

<div class="container">    
    @include('front.layouts.toast')
</div>

@include(request()->routeIs(['front.cart','front.checkout','front.checkout.thankyou']) ? 'front.layouts.cart_header' : 'front.layouts.header')

<main class="{{ request()->routeIs(['front.cart','front.checkout','front.checkout.thankyou']) ? 'main' : 'default' }}">
    @yield('content')
</main>

@include(request()->routeIs(['front.cart','front.checkout','front.checkout.thankyou']) ? 'front.layouts.cart_footer' : 'front.layouts.footer')

@include('front.layouts.login_register')

<script src="{{ asset('front-assets/js/jquery-3.6.0.min.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
<script src="{{ asset('front-assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
<script src="{{ asset('front-assets/js/instantpages.5.1.0.min.js') }}"></script>
<script src="{{ asset('front-assets/js/lazyload.17.6.0.min.js') }}"></script>
<script src="{{ asset('front-assets/js/slick.min.js') }}"></script>
<script src="{{ asset('front-assets/js/ion.rangeSlider.min.js') }}"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="{{ asset('front-assets/js/documentReady.js') }}"></script>
<script>
    $('.checkoutBtn').click(function () {            
        $.ajax({
            url: "/set-intended-url",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                url: window.location.href
            }
        });
        $('#login').modal('show');
    });

    function showAlert(message, type = 'success'){
        let toastEl = $('#commonToast');
        toastEl.removeClass('bg-success bg-danger bg-warning');

        if(type === 'error'){
            toastEl.addClass('bg-danger');
        }else{
            toastEl.addClass('bg-success');
        }

        $('#commonToastMessage').text(message);

        let toast = new bootstrap.Toast(document.getElementById('commonToast'));
        toast.show();
    }

    setTimeout(function(){
        $('.toast').fadeOut('slow');
    },3000);

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
        if(selectedSize == '' || selectedSize == null){
            $('.size-list li').addClass('shake');
            setTimeout(function(){
                $('.size-list li').removeClass('shake');
            },400);
            return false;
        }
        
        let urlParams = new URLSearchParams(window.location.search);
        let variantId = urlParams.get('variant'); // null if not selected

        $.ajax({
            url: '{{ route("front.addToCart") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: id,
                variant_id: variantId,
                size: selectedSize,
            },
            dataType: 'json',
            success: function(response){
                if(response.status == true){
                    $('#cartCount').text(response.cartCount);
                    showAlert(response.message,'success');
                    selectedSize = '';
                }else{
                    showAlert(response.message,'error');
                }
            },
            error: function(){
                alert('Something went wrong');
            }
        });
    }

    function addToWishlist(id){
        $.ajax({
            url: '{{ route("front.addToWishlist") }}',
            type: 'POST',
            data: {
                id: id,
                _token: '{{ csrf_token() }}' 
            },
            dataType: 'json',
            success: function(response){
                if(response.status == true){
                    $("#wishlistToastBody").html(response.message);
                    showAlert(response.message,'success');
                    // var toastEl = document.getElementById('wishlistToast');
                    // var toast = new bootstrap.Toast(toastEl);
                    // toast.show();
                } else {
                    window.location.href= "{{ route('front.home') }}";
                }
            },
            error: function(xhr){
                console.log(xhr.responseText); // So you can see real error
            }
        })
    } 

    $("#registrationForm").submit(function(event){
        event.preventDefault();
        $("button[type='submit']").prop('disabled', true);
        $.ajax({
            url: '{{ route("account.processRegister") }}',
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response){
                $("button[type='submit']").prop('disabled', false);

                var errors = response.errors;

                if(response.status == false){
                    if(errors.name){
                        $("#name").siblings("p").addClass('invalid-feedback').html(errors.name);
                        $("#name").addClass('is-invalid');
                    } else {
                        $("#name").siblings("p").removeClass('invalid-feedback').html();
                        $("#name").removeClass('is-invalid');
                    }

                    if(errors.email){
                        $("#email").siblings("p").addClass('invalid-feedback').html(errors.email);
                        $("#email").addClass('is-invalid');
                    } else {
                        $("#email").siblings("p").removeClass('invalid-feedback').html();
                        $("#email").removeClass('is-invalid');
                    }

                    if(errors.password){
                        $("#password").siblings("p").addClass('invalid-feedback').html(errors.password);
                        $("#password").addClass('is-invalid');
                    } else {
                        $("#password").siblings("p").removeClass('invalid-feedback').html();
                        $("#password").removeClass('is-invalid');
                    }
                } else {
                    $("#name").siblings("p").removeClass('invalid-feedback').html();
                    $("#name").removeClass('is-invalid');
                    $("#email").siblings("p").removeClass('invalid-feedback').html();
                    $("#email").removeClass('is-invalid');
                    $("#password").siblings("p").removeClass('invalid-feedback').html();
                    $("#password").removeClass('is-invalid');

                    window.location.href="{{ route('front.home') }}"
                }
            },
            error: function(JQXHR, exception){
                console.log("Something went wrong");
            }
        })
    });
</script>

@yield('customJs')

</body>
</html>