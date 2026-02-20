$(document).ready(function(){

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
