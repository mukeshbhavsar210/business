$(document).ready(function(){
    
    $('.nav-item.dropdown').hover(
        function(){
            $('body').addClass('active');
            $(this).addClass('active_menu');
        },
        function(){
            $('body').removeClass('active');
            $(this).removeClass('active_menu');
        }
    );

     $(window).on("scroll", function(){
        if($(window).scrollTop() > 100){
            $(".header").addClass("sticky");
        }else{
            $(".header").removeClass("sticky");
        }
    });

    function checkValue(element){
        if($(element).val() !== ''){
            $(element).closest('.form-group').addClass('active');
        } else {
            $(element).closest('.form-group').removeClass('active');
        }
    }

    // On Focus
    $(document).on('focus', '.form-control', function(){        
        $(this).closest('.form-group').addClass('active');
    });

    // On Blur
    $(document).on('blur', '.form-control', function(){
        checkValue(this);
    });

    // On Page Load (Edit Mode / Prefilled)
    $('.form-control').each(function(){
        checkValue(this);
    });

    function updateActive() {
        $('.default-card').removeClass('delivery-address');

        $('.address-radio:checked')
            .closest('.default-card')
            .addClass('delivery-address');
    }

    $(document).on('change', '.address-radio', function(){
        updateActive();
    });

    // Run on page load
    updateActive();


     $('.menu-toggle').on('click', function (e) {
        e.preventDefault();

        var parent = $(this).parent('.menu-item');

        parent.toggleClass('active');

        // Optional: Close other open menus
        parent.siblings().removeClass('active');
    });

     // all filters left
    $('.form-check-input:checked').each(function () {
        $(this).closest('.form-check .link').addClass('active-check');
    });
    
    $('.form-check-input').on('change', function () {
        $(this).closest('.form-check .link').toggleClass('active-check', this.checked);
    });

    //Discount coupon radio button
    $(document).on('change', 'input[name="coupon_id"]', function () {
        $('.coupon-box').removeClass('active');
        $(this).closest('.coupon-box').addClass('active');
    });
    

    var lazyLoadInstance = new LazyLoad({elements_selector:"img.lazy, video.lazy, div.lazy, section.lazy, header.lazy, footer.lazy,iframe.lazy"});
    let bannerHeight = $(window).height();

    $("#menuLink").mouseenter(function(){
        $("#megaDiv").stop(true, true).slideDown(200);
    });

    $("#menuLink, #megaDiv").mouseleave(function(){
        $("#megaDiv").stop(true, true).slideUp(200);
    });

    $('.product-slider').each(function(){
        var $slider = $(this);

        $slider.slick({
            dots: true,
            arrows: false,
            infinite: true,
            speed: 400,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: false,      // ❌ disabled by default
            autoplaySpeed: 2000   // 2 seconds
        });

        // Start autoplay on hover
        $slider.closest('.product-card').on('mouseenter', function () {
            $slider.slick('slickPlay');
        });

        // Stop autoplay on leave
        $slider.closest('.product-card').on('mouseleave', function () {
            $slider.slick('slickPause');
            $slider.slick('slickGoTo', 0); // optional → reset to first image
        });
    });

    
    $("#related-products").not('.slick-initialized').slick({
        centerMode: false,
        slidesToShow: 4,
        slidesToScroll: 1,
        arrows: true,
        prevArrow:'<i class="icon-left-arrow right-arrow arrow"></i>',
        nextArrow:'<i class="icon-right-arrow left-arrow arrow"></i>',
        responsive: [{
            breakpoint: 1200,
            settings: {
                centerMode: false,
                centerPadding: '0px',
                slidesToShow: 5,
                slidesToScroll: 1,
                
            }
        },{
            breakpoint: 1300,
            settings: {
                 centerMode: false,
                slidesToShow: 3,
                slidesToScroll: 1,
            }
        },{
            breakpoint: 1200,
            settings: {
                 centerMode: false,
                slidesToShow: 3,
                slidesToScroll: 1,
            }
        },{
            breakpoint: 1024,
            settings: {
                 centerMode: false,
                slidesToShow: 2,
                slidesToScroll: 1,
            }
        },{
            breakpoint: 992,
            settings: {
                 centerMode: false,
                slidesToShow: 2,
                slidesToScroll: 1,
            }
        },{
            breakpoint: 576,
            settings: {
                 centerMode: false,
                slidesToShow: 1,
                slidesToScroll: 1,      
            }
        }] 
    
    });
});

$("#isShippingDiffernt").click(function(){
    if ($(this).is(':checked') == true) {
        $("#shippingForm").removeClass('d-none');
    } else {
        $("#shippingForm").addClass('d-none');
    }
});