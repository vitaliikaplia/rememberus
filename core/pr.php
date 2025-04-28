<?php

if(!defined('ABSPATH')){exit;}

/** custom pr function */
function pr($var){
	echo "<textarea style='position: fixed; border: none; padding: 10px; opacity: 1; bottom:0; left:0; z-index:999999999; display: block; width: 100%;height: 20%;overflow: auto; resize: none; background-color:#4b4b4b; color: #fff; border-top: solid 2px black;' onclick='$(this).select(); console.clear(); console.log($(this).val())'>";
	print_r($var);
	echo "</textarea>";
}

function write_log( $data ) {
    if ( true === WP_DEBUG ) {
        if ( is_array( $data ) || is_object( $data ) ) {
            error_log( print_r( $data, true ) );
        } else {
            error_log( $data );
        }
    }
}
