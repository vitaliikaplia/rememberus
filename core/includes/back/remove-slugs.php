<?php

if(!defined('ABSPATH')){exit;}

/**
 * Remove the slug from custom post type permalinks.
 */
function wpex_remove_cpt_slug( $post_link, $post, $leavename ) {

    if ( ! in_array( $post->post_type, array( 'projects' ) ) || 'publish' != $post->post_status ) {
        return $post_link;
    }

    $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );

    return $post_link;

}
add_filter( 'post_type_link', 'wpex_remove_cpt_slug', 10, 3 );

/**
 * Some hackery to have WordPress match postname to any of our public post types
 * All of our public post types can have /post-name/ as the slug, so they better be unique across all posts
 * Typically core only accounts for posts and pages where the slug is /post-name/
 */
function wpex_parse_request_tricksy( $query ) {

    // Only noop the main query
    if ( ! $query->is_main_query() ) {
        return;
    }

    // Only noop our very specific rewrite rule match
    if ( 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
        return;
    }

    // 'name' will be set if post permalinks are just post_name, otherwise the page rule will match
    if ( ! empty( $query->query['name'] ) ) {
        $query->set( 'post_type', array( 'post', 'projects', 'page' ) );
    }

}
add_action( 'pre_get_posts', 'wpex_parse_request_tricksy' );
