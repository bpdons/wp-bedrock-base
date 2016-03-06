<?php
add_action('init', 'custom_taxonomies');
function custom_taxonomies()
{
    /*register_taxonomy('taxonomy_name', array('custom_post_type'), array(
        'hierarchical' => TRUE,
        'show_ui'      => TRUE,
        'query_var'    => TRUE,
        'rewrite'      => array('slug' => 'example-slug'),
        'labels'       => array(
            'name'          => _x('Taxonomy Name', 'taxonomy general name'),
            'singular name' => _x('Taxonomy Name', 'taxonomy singular name'),
            'search_items'  => __('Search Taxonomy Names'),
            'all_items'     => __('All Taxonomy Names'),
        ),
    ));*/
}