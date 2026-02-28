<!DOCTYPE html>
<html class="no-js" lang="en_AU" />
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Online Fashion Shopping for Men and Women</title>
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />

	<link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/slick.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/slick-theme.css') }}" />
	
	<link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/style.min.css') }}" />
	{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
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

@include(request()->routeIs(['front.cart','front.checkout']) ? 'front.layouts.cart_header' : 'front.layouts.header')

<main class="{{ request()->routeIs(['front.cart','front.checkout']) ? 'main' : 'default' }}">
    @yield('content')
</main>

@include(request()->routeIs(['front.cart','front.checkout']) ? 'front.layouts.cart_footer' : 'front.layouts.footer')

<script src="{{ asset('front-assets/js/jquery-3.6.0.min.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
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
        if(selectedSize == ''){
            alert('Please select size');
            return;
        }

        if(selectedColor == ''){
            alert('Please select color');
            return;
        }

        $.ajax({
            url: '{{ route("front.addToCart") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                size: selectedSize,
                color: selectedColor
            },
            dataType: 'json',
            success: function(response){
                if(response.status == true){

                    // ✅ Update cart count
                    $('#cartCount').text(response.cartCount);

                    // ✅ Show toast message
                    $('#cartToastMessage').text(response.message);

                    let toast = new bootstrap.Toast(
                        document.getElementById('cartToast')
                    );

                    toast.show();

                    // Optional: Reset selections
                    selectedSize = '';
                    selectedColor = '';                    

                } else {
                    alert(response.message);
                }
            },
            error: function(){
                alert('Something went wrong');
            }
        });
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
                    var toastEl = document.getElementById('wishlistToast');
                    var toast = new bootstrap.Toast(toastEl);
                    toast.show();
                } else {
                    window.location.href= "{{ route('front.home') }}";
                }
            },
            error: function(xhr){
                console.log(xhr.responseText); // So you can see real error
            }
        })
    }    
</script>

@yield('customJs')

</body>
</html>
