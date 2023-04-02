/**
 * Hidden authorization
 */
(function ($) {
    $(document).ready(function () {

        if($('.wrapper-hidden-authorization input').length){
            $('.wrapper-hidden-authorization input').focus(function() {
                $(this).addClass('hasText');
            });
            $('.wrapper-hidden-authorization input').blur(function() {
                if ($(this).val().trim() == '') {
                    $(this).removeClass('hasText');
                }
            });
            $('.wrapper-hidden-authorization input').each(function(){
                if ($(this).val() != '') {
                    $(this).addClass('hasText');
                }
            });
            $('.wrapper-hidden-authorization form').find("button").click(function(){
                $(this).parents('form').submit();
                return false;
            });
            $('.wrapper-hidden-authorization form').submit(function(e){

                e.preventDefault();

                let readyToSend = true,
                    thisForm = $(this);

                if(!thisForm.hasClass("busy")){

                    if(thisForm.find(".email").length){
                        thisForm.find(".email").each(function(){
                            if(!isValidEmailAddress($(this).val().trim())){
                                readyToSend = false;
                                $(this).addClass("red");
                                thisForm.find(".email.red")[0].focus();
                            } else {
                                $(this).removeClass("red");
                            }
                        });
                    }

                    if(thisForm.find(".required").length){
                        thisForm.find(".required").each(function(){
                            if($(this).val().trim() == ""){
                                readyToSend = false;
                                $(this).addClass("red");
                                thisForm.find(".red")[0].focus();
                            } else {
                                $(this).removeClass("red");
                            }
                        });
                    }

                    if(readyToSend == true){

                        thisForm.addClass('busy');
                        thisForm.find('*').blur();

                        $.ajax({
                            type: "POST",
                            url: ajaxUrl,
                            dataType: "json",
                            cache: false,
                            data: {
                                "action": "hidden_login_step_1",
                                "formData": thisForm.serializeArray(),
                                "currentPageUrl": document.URL
                            },
                            success : function (out) {
                                if(out.status == "ok"){

                                    thisForm.trigger("reset");

                                    thisForm.find(".hasText").removeClass("hasText");

                                    var pinBox = $('.hidden-authorization .box');

                                    pinBox.html(out.html);

                                    pinBox.find('.codeInput input:first-child').focus();

                                    pinBox.find('.codeInput input').each(function(){
                                        $(this).mask('0', {placeholder: "_"});
                                        $(this).unbind('keyup');
                                    });

                                    pinBox.find('.codeInput input').on('focus', function(){
                                        if(!$(this).hasClass('input_1') && $(this).prev().val().trim() == ""){
                                            $(this).prev().focus();
                                        }
                                    });

                                    pinBox.find('.codeInput input').on('keyup', function(){

                                        $(this).removeClass('red');

                                        if($(this).val().trim() != ""){
                                            $(this).next().focus();
                                        } else {
                                            $(this).prev().focus();
                                        }

                                        if($(this).hasClass('input_8') && $(this).val().trim() != ""){
                                            let allValues = '';
                                            pinBox.find('.codeInput input').each(function(){
                                                allValues = allValues + $(this).val().trim();
                                            });
                                            pinBox.find('.codeInput input').addClass('disabled');
                                            pinBox.find('.codeInput input').blur();
                                            $.ajax({
                                                type: "POST",
                                                url: ajaxUrl,
                                                dataType: "json",
                                                cache: false,
                                                data: {
                                                    "action": "hidden_login_step_2",
                                                    "secret_code": allValues,
                                                    "user_id": pinBox.find('.codeInput').data().userId,
                                                    "user_tmp_pin": pinBox.find('.codeInput').data().userTmpPin,
                                                    "currentPageUrl": document.URL
                                                },
                                                success : function (out) {
                                                    if(out.status == 'ok' && out.redirect){
                                                        pinBox.find('.codeInput input').addClass('green');
                                                        window.location.href = out.redirect;
                                                    } else {
                                                        pinBox.find('.codeInput input').addClass('red');
                                                        pinBox.find('.codeInput input').removeClass('disabled');
                                                        pinBox.find('.codeInput input:last-child').focus();
                                                    }
                                                }
                                            });
                                        }
                                    });

                                } else if(out.status == "redirect") {

                                    thisForm.trigger("reset");
                                    thisForm.find(".hasText").removeClass("hasText");
                                    window.location.href = out.redirect;

                                } else {

                                    thisForm.removeClass('busy');
                                    thisForm.find("input").addClass("red");

                                }
                            }
                        });

                    }

                }

            });
        }

    });
})(jQuery);
