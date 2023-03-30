<?php

if(!defined('ABSPATH')){exit;}

function get_HTTP_REFERER_for_form(){

    if(isset($_COOKIE['keep-your-second-secret']) && $_COOKIE['keep-your-second-secret']){
        return custom_encrypt_decrypt('decrypt', $_COOKIE['keep-your-second-secret']);
    }

}
