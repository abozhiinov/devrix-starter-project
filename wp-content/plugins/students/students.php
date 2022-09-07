<?php
/**
 * Plugin Name:  Students
 *  * Plugin URI:
 * Description:  School managment system
 * Version:      1.0
 * Author:       Alexander Bozhinov
 * Author URI:
 * License:
 * License URI:
 * Text Domain:
 * Domain Path:
 *
 * @package WordPress
 */

/**
 * Requirements
 */
require 'functions.php';

/**
 * Create posttype student
 */
function create_posttype() {
	$labels = array(
		'name'          => 'Students',
		'singular_name' => 'Student',
	);

	$supports = array(
		'thumbnail',
		'excerpt',
		'title',
		'category',
		'content',
		'custom-fields',
	);

	$args = array(
		'labels'              => $labels,
		'description'         => 'Post type student',
		'supports'            => $supports,
		'taxonomies'          => array( 'category', 'post_tag' ), // Allowed taxonomies.
		'hierarchical'        => false, // Allows hierarchical categorization, if set to false, the Custom Post Type will behave like Post, else it will behave like Page.
		'public'              => true,  // Makes the post type public.
		'show_ui'             => true,  // Displays an interface for this post type.
		'show_in_menu'        => true,  // Displays in the Admin Menu (the left panel).
		'show_in_nav_menus'   => true,  // Displays in Appearance -> Menus.
		'show_in_admin_bar'   => true,  // Displays in the black admin bar.
		'menu_position'       => 4,     // The position number in the left menu.
		'menu_icon'           => true,  // The URL for the icon used for this post type.
		'can_export'          => true,  // Allows content export using Tools -> Export.
		'has_archive'         => true,  // Enables post type archive (by month, date, or year).
		'exclude_from_search' => false, // Excludes posts of this type in the front-end search result page if set to true, include them if set to false.
		'publicly_queryable'  => true,  // Allows queries to be performed on the front-end part if set to true.
		'capability_type'     => 'post', // Allows read, edit, delete like “Post”.
		'show_in_rest'        => true,
	);

	register_post_type( 'student', $args );
}

add_action( 'init', 'create_posttype' );

