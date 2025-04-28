<?php

if(!defined('ABSPATH')){exit;}

///** hidden authorization */
//function custom_login_page_redirect() {
//    global $pagenow;
//    if( 'wp-login.php' == $pagenow && !isset($_REQUEST['usewplogin']) ) {
//        wp_redirect(BLOGINFO_URL);
//        return;
//    }
//}
//add_action('login_head', 'custom_login_page_redirect');
//
//if(str_replace('/','',stripslashes($_SERVER['REQUEST_URI'])) == HIDDEN_AUTHORIZATION_SECRET_URL){
//
//    if( ! is_user_logged_in() ){
//
//        if (substr($_SERVER['REQUEST_URI'], -1) !== '/') {
//            wp_redirect(BLOGINFO_URL . '/' . str_replace('/','',stripslashes($_SERVER['REQUEST_URI'])) . '/');
//            exit();
//        }
//
//        add_action('wp', function(){ status_header( 200 ); });
//
//        echo Timber::compile( 'hidden-authorization/step-1.twig', array(
//            'site'=>new BlankSite(),
//            'general_fields'=>cache_general_fields(),
//            'localization'=>custom_localization(),
//            'theme_mods'=>get_theme_mods(),
//            'wp_content_url'=>BLOGINFO_URL . '/wp-content/',
//            'users'=>get_users()
//        ));
//
//        exit();
//
//    } else {
//
//        wp_redirect(BLOGINFO_URL . '/wp-admin/');
//        exit();
//
//    }
//
//}
