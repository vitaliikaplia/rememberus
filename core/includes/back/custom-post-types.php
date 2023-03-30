<?php

if(!defined('ABSPATH')){exit;}

/**
 * Projects
 */
register_post_type('projects', array(
        'label' => __('Projects', TEXTDOMAIN),
        'description' => '',
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'hierarchical' => false,
        'rewrite' => array('slug' => '', 'with_front' => 1),
        'query_var' => true,
        'has_archive' => false,
        'menu_position' => 24,
        'menu_icon' => 'dashicons-heart',
        'supports' => array('title','revisions','author','thumbnail'),
        'show_in_rest' => false,
        'labels' => array (
            'name' => __('Projects', TEXTDOMAIN),
            'singular_name' => __('Project', TEXTDOMAIN),
            'menu_name' => __('Projects', TEXTDOMAIN),
            'add_new' => __('Add project', TEXTDOMAIN),
            'add_new_item' => __('Add a new project', TEXTDOMAIN),
            'edit' => __('Edit', TEXTDOMAIN),
            'edit_item' => __('Edit project', TEXTDOMAIN),
            'new_item' => __('New project', TEXTDOMAIN),
            'view' => __('View', TEXTDOMAIN),
            'view_item' => __('View project', TEXTDOMAIN),
            'search_items' => __('Search projects', TEXTDOMAIN),
            'not_found' => __('No projects found', TEXTDOMAIN),
            'not_found_in_trash' => __('No projects found', TEXTDOMAIN),
            'parent' => __('Parent project', TEXTDOMAIN),
        )
    )
);

/**
 * Overall blocks
 */
register_post_type('overall_blocks', array(
        'label' => __('Overall blocks', TEXTDOMAIN),
        'description' => '',
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'hierarchical' => false,
        'rewrite' => array('slug' => false, 'with_front' => false),
        'query_var' => true,
        'has_archive' => false,
        'menu_position' => 24,
        'menu_icon' => 'dashicons-editor-kitchensink',
        'supports' => array('title','editor','revisions','author'),
        'show_in_rest' => true,
        'labels' => array (
            'name' => __('Overall blocks', TEXTDOMAIN),
            'singular_name' => __('Overall block', TEXTDOMAIN),
            'menu_name' => __('Overall blocks', TEXTDOMAIN),
            'add_new' => __('Add item', TEXTDOMAIN),
            'add_new_item' => __('Add new item', TEXTDOMAIN),
            'edit' => __('Edit', TEXTDOMAIN),
            'edit_item' => __('Edit item', TEXTDOMAIN),
            'new_item' => __('New item', TEXTDOMAIN),
            'view' => __('View', TEXTDOMAIN),
            'view_item' => __('View item', TEXTDOMAIN),
            'search_items' => __('Search for items', TEXTDOMAIN),
            'not_found' => __('No items found', TEXTDOMAIN),
            'not_found_in_trash' => __('No items found in trash', TEXTDOMAIN),
            'parent' => __('Parent item', TEXTDOMAIN)
        )
    )
);

/**
 * Custom post type for mail logging
 */
register_post_type('mail-log', array(
        'label' => __('Mail log', TEXTDOMAIN),
        'description' => '',
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => false,
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'hierarchical' => false,
        'rewrite' => array('slug' => '', 'with_front' => false),
        'query_var' => true,
        'has_archive' => false,
        'exclude_from_search' => true,
        'menu_position' => 88,
        'menu_icon' => 'dashicons-email-alt',
        'supports' => array('title'),
        'capabilities' => array(
            'create_posts' => false
        ),
        'labels' => array (
            'name' => __('Mail log', TEXTDOMAIN),
            'singular_name' => __('Mail log', TEXTDOMAIN),
            'menu_name' => __('Mail log', TEXTDOMAIN),
            'add_new' => __('Add', TEXTDOMAIN),
            'add_new_item' => __('Add', TEXTDOMAIN),
            'edit' => __('Edit', TEXTDOMAIN),
            'edit_item' => __('Edit', TEXTDOMAIN),
            'new_item' => __('New', TEXTDOMAIN),
            'view' => __('View', TEXTDOMAIN),
            'view_item' => __('View', TEXTDOMAIN),
            'search_items' => __('Search for mail logs', TEXTDOMAIN),
            'not_found' => __('No mail logs found', TEXTDOMAIN),
            'not_found_in_trash' => __('No mail logs found in trash', TEXTDOMAIN),
            'parent' => __('Parent', TEXTDOMAIN),
        )
    )
);
