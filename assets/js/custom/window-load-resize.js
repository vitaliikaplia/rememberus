/**
 * window load resize
 */
(function ($) {
    $(window).on("load resize", function () {

        if($('.main-slider .slider').length){
            $('.main-slider .slider').each(function(){
                var thisEl = $(this);
                thisEl.parents('.customBlock').find('.slick-dots').css('bottom','');
                thisEl.parents('.customBlock').find('.slick-dots').css('bottom', thisEl.find('.bottom').outerHeight());
            });
        }

    });
})(jQuery);
