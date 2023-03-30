<?php

if(!defined('ABSPATH')){exit;}

function get_projects($arr){

    $args = array(
        'post_type' => 'projects',
        'post__in' => $arr,
        'orderby' => 'post__in',
        'posts_per_page' => -1
    );
    return Timber::get_posts( $args );

}
