<?php

if(!defined('ABSPATH')){exit;}

function get_gclid_for_form(){

    if(isset($_COOKIE['keep-your-third-secret']) && $_COOKIE['keep-your-third-secret']){
        $gclid_string = custom_encrypt_decrypt('decrypt', $_COOKIE['keep-your-third-secret']);
        $gclid_out = array();
        parse_str($gclid_string, $gclid_out);
        return $gclid_out;
    }

}
