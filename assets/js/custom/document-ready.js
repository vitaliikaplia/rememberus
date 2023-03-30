/**
 * document ready
 */
(function ($) {
    $(document).ready(function () {

        /** Cookie Pop-Up */
        if(!$.cookie("user-cookies-accepted") && $('.cookiePopupBg').length && $('.cookiePopupWrapper').length){
            setTimeout(function(){
                $('.cookiePopupWrapper').addClass('show');
                $('.cookiePopupBg').addClass('show');
            }, 3000);
            $('.cookiePopupWrapper a.close').click(function(){
                $.cookie("user-cookies-accepted", true);
                $('.cookiePopupWrapper').removeClass('show');
                $('.cookiePopupBg').removeClass('show');
                return false;
            });
        }

        /** Subpages header */
        $("body").headroom({
            tolerance : {
                up : 14,
                down : 16
            }
        });

        /** Form name field */
        if($('input[name="form_name"]').length){
            $('input[name="form_name"]').val(document.title);
        }

        /** testimonials */
        if($('.main-slider .slider').length){
            $('.main-slider .slider').each(function(){

                var thisEl = $(this),
                    autoplay = false,
                    autoplaySpeed = false;

                if(thisEl.attr('data-autoplay')){
                    autoplay = true;
                    autoplaySpeed = parseInt(thisEl.attr('data-autoplay'))*1000;
                }

                thisEl.slick({
                    dots: true,
                    infinite: true,
                    speed: 300,
                    slidesToShow: 1,
                    fade: true,
                    adaptiveHeight: false,
                    autoplay: autoplay,
                    autoplaySpeed: autoplaySpeed
                });

                thisEl.parents('.customBlock').find('.slick-dots').css('bottom', thisEl.find('.bottom').outerHeight());

            });
        }

        /** textarea autogrow */
        if($('.customBlock form textarea').length){
            $('.customBlock form textarea').each(function(){
                var thisEl = $(this),
                    thisTextAreaHeight = thisEl.outerHeight();
                thisEl.autogrow();
                thisEl.css("height",thisTextAreaHeight);
            });
        }

        /** random images */
        if($('.customBlockWrapper .randomImages').length){
            $('.customBlockWrapper .randomImages').each(function(){
                var thisEl = $(this),
                    images = thisEl.find('img'),
                    count = images.length;
                images.eq((getRandomInt(count)-1)).show();
            });
        }

        /** faq */
        if($('.customBlock .faq').length){
            $('.customBlock .faq').each(function(){
                var thisEl = $(this),
                    faqItems =  thisEl.find('.line');

                faqItems.click(function(){
                    var faqItem = $(this),
                        answer = faqItem.find('.answer');
                    if(!faqItem.hasClass('opened')){
                        faqItems.not(faqItem).removeClass('opened');
                        faqItems.not(faqItem).find('.answer').slideUp();
                        faqItem.addClass('opened');
                        answer.slideDown();
                    } else {
                        faqItem.removeClass('opened');
                        answer.slideUp();
                    }
                });
            });
        }

        /** header menu */
        $('.overallHeaderWrapper .overallHeader .menu li a').click(function(){
            if($(this).attr('href') == "#"){
                return false;
            }
        });

        /** person popup */
        $('.customBlock .team .person').click(function(){
            var thisEl = $(this),
                thisContent = thisEl.html(),
                popupWEl = $('<div />'),
                popupEl = $('<div />');

            popupEl.addClass('personPopup').html(thisContent).prepend('<span class="cross" />');
            popupWEl.addClass('personPopupWrapper').html(popupEl);

            $('body').addClass('popup').append(popupWEl);

            $('.personPopupWrapper').unbind();
            $('.personPopupWrapper').click(function(e){
                if($(e.target).attr('class') == 'personPopupWrapper' || $(e.target).attr('class') == 'cross'){
                    $('.personPopup').html('');
                    $('.personPopupWrapper').html('');
                    $('.personPopup').remove();
                    $('.personPopupWrapper').remove();
                    $('body').removeClass('popup');
                }
            });

            return false;
        });

        /** form */
        if($('.customBlock form').length){
            $('.customBlock form').each(function(){

                var thisFormEl = $(this);

                thisFormEl.find("button").click(function(){
                    thisFormEl.submit();
                    return false;
                });

                thisFormEl.find(".required").bind('click keyup', function(){
                    setTimeout(function () {
                        thisFormEl.find(".required").parent().removeClass("red");
                    }, 400);
                });

                thisFormEl.submit(function(e){

                    e.preventDefault();

                    var readyToSend;

                    if(!thisFormEl.hasClass("busy")){

                        readyToSend = true;

                        if(thisFormEl.find("input.required").length){
                            thisFormEl.find("input.required").each(function(){
                                if($(this).val().trim() == ""){
                                    readyToSend = false;
                                    $(this).addClass("red");
                                    thisFormEl.find(".red").first().focus();
                                    var thisEl = $(this).parent();
                                    thisEl.addClass('shake');
                                    setTimeout(function(){
                                        thisEl.removeClass('shake');
                                    }, 500);
                                } else {
                                    $(this).removeClass("red");
                                }
                            });
                        }

                        if(thisFormEl.find("textarea.required").length){
                            thisFormEl.find("textarea.required").each(function(){
                                if($(this).val().trim() == ""){
                                    readyToSend = false;
                                    $(this).addClass("red");
                                    var thisEl = $(this).parent();
                                    thisEl.addClass('shake');
                                    setTimeout(function(){
                                        thisEl.removeClass('shake');
                                    }, 500);
                                    thisFormEl.find(".red").first().focus();
                                } else {
                                    $(this).removeClass("red");
                                }
                            });
                        }

                        if(thisFormEl.find("select.required").length){
                            thisFormEl.find("select.required").each(function(){
                                if($(this).val() == null){
                                    readyToSend = false;
                                    $(this).addClass("red");
                                    var thisEl = $(this).parent();
                                    thisEl.addClass('shake');
                                    setTimeout(function(){
                                        thisEl.removeClass('shake');
                                    }, 500);
                                    thisFormEl.find(".red").first().focus();
                                } else {
                                    $(this).removeClass("red");
                                }
                            });
                        }

                        if(thisFormEl.find("input.email").length){
                            thisFormEl.find("input.email").each(function(){
                                if(!isValidEmailAddress($(this).val().trim())){
                                    readyToSend = false;
                                    $(this).addClass("red");
                                    var thisEl = $(this).parent();
                                    thisEl.addClass('shake');
                                    setTimeout(function(){
                                        thisEl.removeClass('shake');
                                    }, 500);
                                    thisFormEl.find(".red").first().focus();
                                } else {
                                    $(this).removeClass("red");
                                }
                            });
                        }

                        if(readyToSend == true){

                            thisFormEl.addClass("busy");

                            thisFormEl.find('input, button').each(function(){
                                $(this).blur();
                            });

                            $.ajax({
                                type: "POST",
                                url: ajaxUrl,
                                dataType: 'json',
                                data: new FormData(thisFormEl[0]),
                                contentType: false,
                                cache: false,
                                processData: false,
                                success : function (out) {
                                    if(out.status == "ok"){
                                        thisFormEl.removeClass("busy");
                                        thisFormEl.trigger("reset");
                                        if(out.thanks_url){
                                            window.location.href = out.thanks_url;
                                        }
                                    }
                                }
                            });

                        }

                    }

                });
            });
        }

        /** mobile menu */
        $('.mobileMenuButton').click(function(){
            if(!$('body').hasClass('mobile-menu-opened')){
                $('body').addClass('mobile-menu-opened');
            } else {
                $('body').removeClass('mobile-menu-opened');
            }
        });

        /** prevent back top on lang change */
        $('#flags a').each(function(){
            $(this).attr('href', '#' + $(this).attr('title'));
        });

    });
})(jQuery);
