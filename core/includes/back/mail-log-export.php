<?php

if(!defined('ABSPATH')){exit;}

/**
 * Mail log export menu item
 */
function add_mail_log_export_page(){
    add_submenu_page('edit.php?post_type=mail-log', __('Export mail log', TEXTDOMAIN), __('Export', TEXTDOMAIN), 'activate_plugins', 'mail_logs_export', 'mail_log_export_page');
}
add_action('admin_menu', 'add_mail_log_export_page');

/**
 * Mail log export page
 */
function mail_log_export_page() {

    $args = array(
        'posts_per_page'   => 1,
        'orderby'          => 'date',
        'order'            => 'ASC',
        'post_type'        => 'mail-log',
        'post_status'      => 'publish'
    );
    $posts_array = get_posts( $args );
    $fromDate = get_the_date( "Y-m-d", $posts_array[0]->ID );

    echo Timber::compile( 'dashboard/mail-log-export.twig', array(
        'site' => new BlankSite(),
        'fromDate' => $fromDate,
        'maxDate' => date('Y-m-d', strtotime(get_option('gmt_offset').' hour')),
    ));

}

if(is_admin() && isset($_GET['post_type']) && $_GET['post_type'] == "mail-log" && isset($_GET['page']) && $_GET['page'] == "mail_logs_export" && isset($_GET['export_process']) && $_GET['export_process'] == "ok" && isset($_POST['export_date_from']) && $_POST['export_date_from'] && isset($_POST['export_date_to']) && $_POST['export_date_to']){

    $dateFrom = date_parse($_POST['export_date_from']);
    $dateTo = date_parse($_POST['export_date_to']);

    $args = array(
        "post_type" => "mail-log",
        "post_status" => "publish",
        "posts_per_page" => -1,
        'date_query'    => array(
            'inclusive' => true,
            'after'   => array(
                'year' => $dateFrom['year'],
                'month' => $dateFrom['month'],
                'day' => $dateFrom['day']
            ),
            'before' => array(
                'year' => $dateTo['year'],
                'month' => $dateTo['month'],
                'day' => $dateTo['day']
            ),
        )
    );

    $the_query = new WP_Query($args);

    $columns = array();

    // The Loop
    if ( $the_query->have_posts() ) :

        $columns[0] = "title";
        $columns[1] = "date";

        $tableLines = array();
        $line = 1;

        $breaks = array("<br />","<br>","<br/>");

        while ( $the_query->have_posts() ) : $the_query->the_post();

            $postID = get_the_ID();

            $data = get_field('data', $postID);

            $tableLines[$line]["mail-title"] = get_the_title();
            $tableLines[$line]["mail-date"] = get_the_date( "Y-m-d", $postID );

            foreach(json_decode($data, true) as $key => $val){
                $tableLines[$line][$key] = str_ireplace($breaks, "\n", $val);
                $columns[] = strtolower($key);
            }

            $line++;

        endwhile;

        $columns = array_values(array_unique($columns));

    endif;
    wp_reset_postdata();

    $output = fopen("php://output",'w') or die("Can't open php://output");
    header("Content-Type:application/csv");
    header("Content-Disposition:attachment;filename=mail-export-from-".$_POST['export_date_from']."-to-".$_POST['export_date_to'].".csv");
    fputcsv($output, $columns);
    foreach($tableLines as $product) {
        fputcsv($output, $product);
    }
    fclose($output) or die("Can't close php://output");
    exit();

}
