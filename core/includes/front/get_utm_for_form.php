<?php

if(!defined('ABSPATH')){exit;}

function get_utm_for_form(){

    if(isset($_COOKIE['keep-your-first-secret']) && $_COOKIE['keep-your-first-secret']){
        $utm_string = custom_encrypt_decrypt('decrypt', $_COOKIE['keep-your-first-secret']);
        $utm_out = array();
        parse_str($utm_string, $utm_out);
        return $utm_out;
    }

}
