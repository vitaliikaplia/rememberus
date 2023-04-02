<?php

if(!defined('ABSPATH')){exit;}

function hidden_login_step_1_action() {

    if( ($user_login = $_POST['formData'][0]['value']) && ($user_password = $_POST['formData'][1]['value']) ) {
        if (filter_var($user_login, FILTER_VALIDATE_EMAIL)) {

            $user = get_user_by('email', $user_login);

            if($user->ID && wp_check_password( $user_password, $user->data->user_pass )){

                $user_info = get_userdata($user->ID);
                $user_email = $user_info->user_email;

                $a = '';
                $b = '';

                for ($i = 0; $i<8; $i++)
                {
                    $a .= mt_rand(0,9);
                }
                for ($i = 0; $i<8; $i++)
                {
                    $b .= mt_rand(0,9);
                }

                update_user_meta($user->ID, 'user_tmp_code', $a);
                update_user_meta($user->ID, 'user_tmp_pin', $b);

                $message = __("Your secret code", TEXTDOMAIN) . ': ' . $a;

                $headers  = "Content-type: text/html; charset=utf-8 \r\n";
                $headers .= "From: " . BLOGINFO_NAME . " <" . get_option('smtp_username') . ">\r\n";
                $subject_coded = "=?utf-8?B?" . base64_encode( stripslashes(__("Secret authorization code", TEXTDOMAIN)) ) . "?=";
                wp_mail($user_email, $subject_coded, stripslashes($message), $headers);

                $toJson['html'] = Timber::compile( 'hidden-authorization/step-2.twig', array(
                    'localization'=>custom_localization(),
                    'user_id'=>$user->ID,
                    'user_tmp_pin'=>$b
                ));

                $toJson['status'] = "ok";

            } else {

                $toJson['status'] = "error";
            }

        } else {

            $toJson['status'] = "error";

        }

    } else {

        $toJson['status'] = "error";

    }

    echo json_encode($toJson);

    exit;
}
add_action( 'wp_ajax_hidden_login_step_1', 'hidden_login_step_1_action' );
add_action( 'wp_ajax_nopriv_hidden_login_step_1', 'hidden_login_step_1_action' );
