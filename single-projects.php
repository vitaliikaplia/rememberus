<?php

if(!defined('ABSPATH')){exit;}

$context = Timber::get_context();
$post = Timber::query_post();
$context['post'] = $post;
$context['custom_fields'] = cache_fields($post->ID);
$context['custom_fields']['show_footer_spacer_line'] = true;

Timber::render( array( 'single-projects.twig' ), $context, TIMBER_CACHE_TIME );
