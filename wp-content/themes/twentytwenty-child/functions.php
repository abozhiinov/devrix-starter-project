<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array(  ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );

function add_my_filter($content) {
    $content = "<div>This is my filter</div>".$content;
    return $content;
}
add_filter( 'the_content', 'add_my_filter', 10 );

function add_two($content) {
    $content .= "<div>Two</div>";
    return $content;
}
add_filter( 'the_content', 'add_two', 11 );

function add_one($content) {
    $content .= "<div>One</div>";
    return $content;
}
add_filter( 'the_content', 'add_one', 10 );

function add_three($content) {
    $content .= "<div>Three</div>";
    return $content;
}
add_filter( 'the_content', 'add_three', 11 );

function add_custom_menu_item ($items, $args) {
    if(is_user_logged_in()) {
        $items .= '<li><a href="/devrix-starter/wp-admin/profile.php">Profile Settings</a></li>';
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'add_custom_menu_item', 10, 2 );

// END ENQUEUE PARENT ACTION
