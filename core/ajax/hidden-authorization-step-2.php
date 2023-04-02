<?php

if(!defined('ABSPATH')){exit;}

function hidden_login_step_2_action() {

    $user_id = intval($_POST['user_id']);
    $user_tmp_pin = intval($_POST['user_tmp_pin']);
    $secret_code = intval(str_replace(' ','', $_POST['secret_code']));
    $user_obj = get_user_by('id', $user_id);

    if(intval(get_user_meta($user_id, 'user_tmp_code', true)) == $secret_code && intval(get_user_meta($user_id, 'user_tmp_pin', true)) == $user_tmp_pin){
        wp_set_current_user( $user_id, $user_obj->user_login );
        wp_set_auth_cookie( $user_id, true );
        do_action( 'wp_login', $user_obj->user_login );
        delete_user_meta($user_id, 'user_tmp_code');
        delete_user_meta($user_id, 'user_tmp_pin');
        $toJson['redirect'] = BLOGINFO_URL . '/wp-admin/';
        $toJson['status'] = "ok";
    } else {
        $toJson['status'] = "error";
    }

    echo json_encode($toJson);

    exit;
}
add_action( 'wp_ajax_hidden_login_step_2', 'hidden_login_step_2_action' );
add_action( 'wp_ajax_nopriv_hidden_login_step_2', 'hidden_login_step_2_action' );
