<?php
/**
 * Base Foundation functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 *
 * @package WordPress
 * @subpackage Base_Foundation
 * @since Base Foundation 1.0
 */

// WP does not automatically allow sessions
if (!session_id()) {
    add_action('init', 'session_start');
}

// set locale and timezone
setlocale(LC_ALL, 'en_AU');
date_default_timezone_set("Australia/Melbourne");

// remove unwanted functionality
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // index link
remove_action('wp_head', 'parent_post_rel_link', 10); // prev link
remove_action('wp_head', 'start_post_rel_link', 10); // start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'Comments'); // Display the XHTML generator that is generated on the wp_head hook, WP version

add_theme_support('menus');
// Enqueue the required JS files
require_once(dirname(__FILE__) . '/inc/enqueue.php');
// Custom post types
require_once(dirname(__FILE__) . '/inc/custom-post-types.php');
// Custom gravity form processing/features
require_once( dirname(__FILE__) . '/inc/gravity-forms-hooks.php' );
// Custom meta boxes & save function
require_once(dirname(__FILE__) . '/inc/custom-meta.php');
// Custom taxonomies
require(dirname(__FILE__) . '/inc/custom-taxonomies.php');
// Shortcodes
require(dirname(__FILE__) . '/inc/shortcodes.php');
// template tags
require(dirname(__FILE__) . '/inc/template-tags.php');
// Custom ajax stuff
require_once(dirname(__FILE__) . '/inc/ajax-process.php');

if (!function_exists('wp_base_setup')) :
    function wp_base_setup()
    {
        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(825, 510, TRUE);
        add_image_size('slideshow', 1400, 460, ['center', 'center']);

        register_nav_menus([
            'main_menu' => __('Main Menu'),
            'footer_menu' => __('Footer Menu'),
            'social_menu' => __('Social Media Menu'),
        ]);

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption'
        ]);

        /*
         * Enable support for Post Formats.
         *
         * See: https://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', [
            'aside',
            'image',
            'video',
            'quote',
            'link',
            'gallery',
            'status',
            'audio',
            'chat'
        ]);
    }
endif;
add_action('after_setup_theme', 'wp_base_setup');

/**
 * Remove Quick Drafts and News dashboard widgets on welcome CMS admin page
 */
function remove_dashboard_widgets()
{
    global $wp_meta_boxes;
//	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']); // at a glance
//    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']); // activity
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']); // quick draft
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']); // News

}

add_action('wp_dashboard_setup', 'remove_dashboard_widgets');

/**
 * Change permissions on gravity forms to allow basic access to editors.
 */
function add_grav_forms_permissions()
{
    $role = get_role('editor');
    $role->add_cap('gravityforms_view_entries');
    $role->add_cap('gravityforms_delete_entries');
    $role->add_cap('gravityforms_view_entry_notes');
    $role->add_cap('gravityforms_export_entries');
    $role->add_cap('gravityforms_create_form');
    $role->add_cap('gravityforms_edit_forms');
}

add_action('admin_init', 'add_grav_forms_permissions');

/**
 * Utilize Die and Dump from familiar PHP Frameworks.
 */
if (!function_exists('dd')) :
    function dd($vars)
    {
        echo '<pre>';
        print_r($vars);
        echo '</pre>';
        die();
    }
endif;

/**
 * Remote Emoji's from WP 4.2 onwards
 */
function pw_remove_emojicons()
{
    // Remove from comment feed and RSS
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    // Remove from emails
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    // Remove from head tag
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    // Remove from print related styling
    remove_action('wp_print_styles', 'print_emoji_styles');
    // Remove from admin area
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
}

add_action('init', 'pw_remove_emojicons');


/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Twenty Fifteen 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function twentyfifteen_search_form_modify($html)
{
    return str_replace('class="search-submit"', 'class="search-submit screen-reader-text"', $html);
}

add_filter('get_search_form', 'twentyfifteen_search_form_modify');

// Move the Yoast SEO box to below any advanced custom fields
add_filter( 'wpseo_metabox_prio', 'change_yoast_meta_priority_callback');
function change_yoast_meta_priority_callback() {
    return 'low';
}