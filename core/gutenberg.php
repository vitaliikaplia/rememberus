<?php

if(!defined('ABSPATH')){exit;}

if(!get_option('disable_gutenberg_everywhere')){

    /** custom blocks categories */
    function custom_block_categories( $categories, $post ) {
        return array_merge(
            $categories,
            array(
                array(
                    'slug' => 'main',
                    'title' => __( 'Main', TEXTDOMAIN ),
                ),
            )
        );
    }
    add_filter( 'block_categories_all', 'custom_block_categories', 10, 2);

    /** custom blocks array */
    function get_custom_acf_blocks(){
        return array(
            array(
                "name" => "slider",
                "label" => __( "Slider", TEXTDOMAIN ),
                "category" => "main",
                'icon' => 'block-default',
                'defaults' => ''
            ),
            array(
                "name" => "numbers",
                "label" => __( "Numbers", TEXTDOMAIN ),
                "category" => "main",
                'icon' => 'block-default',
                'defaults' => ''
            ),
            array(
                "name" => "zebra",
                "label" => __( "Zebra", TEXTDOMAIN ),
                "category" => "main",
                'icon' => 'block-default',
                'defaults' => ''
            ),
            array(
                "name" => "form",
                "label" => __( "Form", TEXTDOMAIN ),
                "category" => "main",
                'icon' => 'block-default',
                'defaults' => ''
            ),
            array(
                "name" => "before",
                "label" => __( "Before", TEXTDOMAIN ),
                "category" => "main",
                'icon' => 'block-default',
                'defaults' => ''
            ),
            array(
                "name" => "who-we-are",
                "label" => __( "Who we are", TEXTDOMAIN ),
                "category" => "main",
                'icon' => 'block-default',
                'defaults' => ''
            ),
            array(
                "name" => "projects",
                "label" => __( "Projects", TEXTDOMAIN ),
                "category" => "main",
                'icon' => 'block-default',
                'defaults' => ''
            ),
            array(
                "name" => "faq",
                "label" => __( "FAQ", TEXTDOMAIN ),
                "category" => "main",
                'icon' => 'block-default',
                'defaults' => ''
            ),
            array(
                "name" => "donate",
                "label" => __( "Donate", TEXTDOMAIN ),
                "category" => "main",
                'icon' => 'block-default',
                'defaults' => ''
            ),
            array(
                "name" => "footer",
                "label" => __( "Footer", TEXTDOMAIN ),
                "category" => "main",
                'icon' => 'block-default',
                'defaults' => ''
            ),
            array(
                "name" => "thanks",
                "label" => __( "Thanks", TEXTDOMAIN ),
                "category" => "main",
                'icon' => 'block-default',
                'defaults' => ''
            ),
            array(
                "name" => "awards",
                "label" => __( "Awards", TEXTDOMAIN ),
                "category" => "main",
                'icon' => 'block-default',
                'defaults' => ''
            ),
            array(
                "name" => "content",
                "label" => __( "Content", TEXTDOMAIN ),
                "category" => "main",
                'icon' => 'block-default',
                'defaults' => ''
            ),
            array(
                "name" => "gallery",
                "label" => __( "Gallery", TEXTDOMAIN ),
                "category" => "main",
                'icon' => 'block-default',
                'defaults' => ''
            )
        );
    }

    /** custom gutenberg blocks */
    $blocks = get_custom_acf_blocks();

    /** create arrays of custom blocks */
    $allowed_blocks = array();
    $custom_gutenberg_blocks = array();

    /** registering blocks styles */
    function add_custom_blocks_style_css_action() {
        $blocks_arr = get_custom_acf_blocks();
        foreach($blocks_arr as $block){
            $style_url = TEMPLATE_DIRECTORY_URL . 'assets/css/blocks/' . $block['category'] . '/' . $block['name'] . '.min.css';
            $style_name = $block['category'] . '-' . $block['name'];
            wp_register_style($style_name, $style_url, '', ASSETS_VERSION);
        }
    }
    add_action('init', 'add_custom_blocks_style_css_action');

    foreach($blocks as $block){

        $allowed_blocks[] = 'acf/' . $block['category'] . '-' . $block['name'];

        $style_name = $block['category'] . '-' . $block['name'];

        if($block['icon'] == 'URL'){
            $url = TEMPLATE_DIRECTORY_URL . 'assets/svg/blocks/'.$block['category'].'/'.$block['name'].'.svg';
            if(filter_var($url, FILTER_VALIDATE_URL)){
                $icon = cache_svg_icon(TEMPLATE_DIRECTORY_URL . 'assets/svg/blocks/'.$block['category'].'/'.$block['name'].'.svg');
            } else {
                $icon = $block['icon'];
            }
        } else {
            $icon = $block['icon'];
        }

        $custom_gutenberg_blocks[] = array(
            'name'            => $block['category'] . '-' . $block['name'],
            'title'           => $block['label'],
            'render_callback' => 'block_render_callback',
            'icon'            => $icon,
            'style'           => $style_name,
            'mode' 			  => 'preview',
            'category'        => $block['category'],
            'keywords'        => array( $block['label'] ),
            'data'            => $block['defaults'],
            'supports'        => array(
                'align' => false,
                'mode' => false,
                'customClassName' => false,
                'jsx' => true
            ),
            'example'  => [
                'attributes' => [
                    'mode' => 'preview',
                    'data' => array(
                        'is_example'   => true
                    )
                ]
            ]
        );

    }

    /** the callback that renders the blocks */
    function block_render_callback( $block, $content = '', $is_preview = false, $post_id = 0 ) {

        $context = Timber::get_context();

        // Store block values
        $context['block'] = $block;

        $context['block_name'] = str_replace('acf/','', $block['name']);
        $context['block_class'] = $context['block_name'];
        $no_category_block_name = str_replace('acf/' . $block['category'] . '-','', $block['name']);

        //Store $is_preview value.
        global $is_preview_global;
        if($is_preview_global){
            $context['is_preview'] = true;
        } else {
            $context['is_preview'] = $is_preview;
        }

        // Store field values
        $context['fields'] = get_fields();

        $context['site_theme_uri'] = TEMPLATE_DIRECTORY_URL;
        $context['is_admin'] = is_admin();
        $context['is_example'] = get_field('is_example');
        if($context['is_example']){
            $context['block_example'] = TEMPLATE_DIRECTORY_URL . 'assets/block-preview/' . $block['category'] . '/' . $no_category_block_name . '.png?ver=' . ASSETS_VERSION;
        }

        // Render the block
        Timber::render('blocks' . DS . $context['block']['category'] . DS . $no_category_block_name . '.twig', $context );
    }

    /** init custom blocks */
    function init_custom_gutenberg_blocks() {
        global $custom_gutenberg_blocks;
        foreach ($custom_gutenberg_blocks as $block) {
            acf_register_block_type( $block );
        }
    }
    add_action( 'acf/init', 'init_custom_gutenberg_blocks' );

    /** allow only custom blocks */
    add_filter( 'allowed_block_types_all', 'custom_allowed_block_types' );
    function custom_allowed_block_types( $allowed_blocks ) {
        global $allowed_blocks;
        return $allowed_blocks;
    }

    /** remove default block patterns from gutenberg editor */
    remove_theme_support( 'core-block-patterns' );

    /** remove custom gutenberg css */
//    add_filter( 'block_editor_settings_all' , 'remove_guten_wrapper_styles' );
//    function remove_guten_wrapper_styles( $settings ) {
//        unset($settings['styles'][0]);
//        unset($settings['styles'][1]);
//        return $settings;
//    }

    /**
     * Enqueue WordPress theme styles within Gutenberg.
     */
    function organic_origin_gutenberg_styles() {
        wp_enqueue_style( 'organic-origin-gutenberg', TEMPLATE_DIRECTORY_URL . 'assets/css/gutenberg.min.css', false, ASSETS_VERSION, 'all' );
    }
    add_action( 'enqueue_block_editor_assets', 'organic_origin_gutenberg_styles' );

    /**
     * Adding block styles as cached inlined css
     */
    function add_blocks_styles() {
        if(!is_404()){
            if(get_option('inline_scripts_and_styles')){
                if($blocks_css = get_transient( 'blocks_css' )){
                    echo $blocks_css;
                } else {
                    global $blocks;
                    if(!empty($blocks)){
                        $css = '';
                        foreach($blocks as $block){
                            $css .= file_get_contents( TEMPLATE_DIRECTORY_URL.'assets/css/blocks/' . $block['category'] . '/' . $block['name'] . '.min.css' );
                        }
                        $blocks_css = '<style type="text/css">'.$css.'</style>';
                        set_transient( 'blocks_css', $blocks_css, TRANSIENTS_TIME );
                        echo "\n";
                        echo $blocks_css;
                    }
                }
            }
        }
    }
    add_action( 'wp_head', 'add_blocks_styles' );

}
