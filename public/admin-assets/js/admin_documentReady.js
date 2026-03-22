$(document).ready(function(){
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

    $(".tooltip").hover(function(e) {
            var tip = $(this).attr("data-tip");
            $("<div class='tooltip-box'>" + tip + "</div>")
                .appendTo("body")
                .css({ top: e.pageY + 10, left: e.pageX + 10 })
                .fadeIn();
        }, function() {
            $(".tooltip-box").remove();
        }).mousemove(function(e) {
            $(".tooltip-box").css({ top: e.pageY + 10, left: e.pageX + 10 });
        });
        
        $(document).on("mouseenter", ".tooltip-item", function(e) {
            let tip = $(this).data("tip");

            let tooltip = $("<div class='tooltip-box'></div>")
                .text(tip)
                .appendTo("body");

            $(this).data("tooltipEl", tooltip);

            tooltip.css({
                top: e.pageY + 10,
                left: e.pageX + 10
            }).fadeIn();
        });

        $(document).on("mousemove", ".tooltip-item", function(e) {
            let tooltip = $(this).data("tooltipEl");
            if (tooltip) {
                tooltip.css({
                    top: e.pageY + 10,
                    left: e.pageX + 10
                });
            }
        });

        $(document).on("mouseleave", ".tooltip-item", function() {
            let tooltip = $(this).data("tooltipEl");
            if (tooltip) {
                tooltip.remove();
            }
        });    
});