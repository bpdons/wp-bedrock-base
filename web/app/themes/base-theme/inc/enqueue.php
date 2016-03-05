<?php

if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
function my_jquery_enqueue()
{
    wp_deregister_script('jquery');
    // IF IE 2-8 (if you start at 1, it includes 10 in this bad bad bad)
    if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/(?i)msie [2-8]/', $_SERVER['HTTP_USER_AGENT'])) {
        wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://code.jquery.com/jquery-1.12.0.min.js", FALSE, 'v1.12.0', FALSE);
    } else {
        wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://code.jquery.com/jquery-2.2.1.min.js", FALSE, 'v2.2.1', FALSE);
//			wp_register_script('jquery', get_bloginfo('template_url') . '/node_modeules/foundation-sites/node_modufles/jquery/dist/jquery/dist/jquery.min.js', FALSE, 'v2.2.1', FALSE);
    }
    wp_enqueue_script('jquery');
}

/*
*	Add all scripts in here, including their dependencies
*	The final true/false parameter determines whether to put the script in the header or footer. Nothing or false = header, true = footer.
*	Modernizr must run in the header. jQuery and the other scripts will be in the footer.
*/
function enqueue_scripts($pagename)
{

    wp_enqueue_script('modernizr', get_bloginfo('template_url') . '/assets/js/modernizr-2.8.3.min.js');
    wp_enqueue_script('vendors', get_bloginfo('template_url') . '/assets/js/vendors.min.js', ['jquery'], null, true);
    wp_enqueue_script('custom-js', get_bloginfo('template_url') . '/assets/js/custom.min.js', ['jquery'], null, true);
//		wp_enqueue_script( 'reveal', get_bloginfo('template_url') . '/bower_components/foundation/js/foundation/foundation.reveal.js', array( 'jquery' ), '', true);

    // Ajax scripts
    wp_localize_script('foundation-custom', 'customAjax', ['ajaxurl' => admin_url('admin-ajax.php')]);

}

add_action('wp_enqueue_scripts', 'enqueue_scripts');
