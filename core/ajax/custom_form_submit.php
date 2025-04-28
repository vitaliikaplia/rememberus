<?php

if(!defined('ABSPATH')){exit;}

function custom_form_submit_action() {
    if( !empty($_POST['secret']) && isset($_POST['secret']) ){

        $form_options_arr = json_decode(custom_encrypt_decrypt('decrypt', trim(stripslashes($_POST['secret']))), true);
        $form_options = array();
        $form_fields = array();
        $form_text = "<p>";

        write_log($form_options_arr);

        foreach($form_options_arr as $value){
            foreach ($value as $key => $value){
                $form_options[$key] = str_replace(PHP_EOL,"<br />",$value);
            }
        }

        foreach($_POST as $key => $value){
            if($key != 'action' && $key != 'secret'){
                if($value){
                    $form_fields[$key] = str_replace(PHP_EOL,"<br />",$value);
                    $form_text .= str_replace('_', ' ', $key ) . ": <b>".str_replace(PHP_EOL,"<br />",$value)."</b><br/>";
//                    $form_fields[$key] = $value;
                    if($key == 'form_name'){
                        $form_name = str_replace(PHP_EOL,"<br />",$value);
//                        $form_name = $value;
                    }
                }
            }
        }

        $form_text .= "</p>";

        $subject = stripslashes($form_name);
        $subject_coded = "=?utf-8?B?" . base64_encode( stripslashes($subject) ) . "?=";
        $noReplyMail = "no-reply@".BLOGINFO_JUST_DOMAIN;
        $mail  = "<!DOCTYPE html><html><head><meta charset='utf-8' /></head><body>";
        $mail .= "<h1>".$subject."</h1>";
        $mail .= $form_text;
        $mail .= "</body></html>";
        $headers  = "Content-type: text/html; charset=utf-8 \r\n";
        $headers .= "From: ".BLOGINFO_NAME." <".$noReplyMail.">\r\n";

        if(is_array($form_options['email_recipients'])){
            foreach($form_options['email_recipients'] as $emailToSend){
                wp_mail($emailToSend['email'], $subject_coded, $mail, $headers);
            }
        }

        $mail_post = array(
            'post_type' => 'mail-log',
            'post_title' => $form_name,
            'post_content' => '',
            'post_status' => 'publish'
        );
        $new_id = wp_insert_post( $mail_post );
        update_field( 'field_629a43559e3e4', json_encode($form_fields), $new_id);


        if($form_options['thanks_page']){
            $toJson['thanks_url'] = get_the_permalink($form_options['thanks_page']);
        }
        $toJson['form_options'] = $form_options['thanks_page'];
        $toJson['status'] = "ok";
    }

    echo json_encode($toJson);
    exit;
}
add_action( 'wp_ajax_custom_form_submit', 'custom_form_submit_action' );
add_action( 'wp_ajax_nopriv_custom_form_submit', 'custom_form_submit_action' );
