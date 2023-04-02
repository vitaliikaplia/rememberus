<?php

if(!defined('ABSPATH')){exit;}

/** header css */
if(!is_admin()){
    function add_style_css_action() {
        wp_register_style('main', TEMPLATE_DIRECTORY_URL . 'assets/css/style.min.css', '', ASSETS_VERSION);
        wp_enqueue_style('main');
    }
    add_action('init', 'add_style_css_action');
}
