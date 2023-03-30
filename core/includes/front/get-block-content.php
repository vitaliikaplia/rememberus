<?php

if(!defined('ABSPATH')){exit;}

/**
 * Get content with formatting for overall block
 */
function get_block_content($id) {
    global $is_preview_global;
    $is_preview_global = true;
    $content_post = get_post($id);
    $content = $content_post->post_content;
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    return $content;
}
