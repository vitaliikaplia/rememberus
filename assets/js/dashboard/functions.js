/**
 * Store options by ajax
 *
 * @param this_option_label
 * @param this_option_value
 * @param type
 */
function store_all_widget_options_by_ajax(this_option_label, this_option_value, type){

    jQuery.ajax({
        type: "POST",
        url: ajaxurl,
        dataType: "json",
        cache: false,
        data: {
            action: "change_widget_option",
            type: type,
            label: this_option_label,
            val: this_option_value
        },
        beforeSend: function() {
            // console.log(this_option_label);
            // console.log(this_option_value);
        },
        success : function (out) {
            // console.log(out);
            jQuery(".widget-options-inner").removeClass('wait');
        }
    });

}

/**
 * JS inside blocks
 */
if( window.acf ) {

    window.acf.addAction( 'render_block_preview', function( $elem, blockDetails ) {

        $elem.find('a,button').click(function(){
            return false;
        });

    } );
}
