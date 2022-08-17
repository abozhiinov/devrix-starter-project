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
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array(  ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );

function add_my_filter( $content ) {
    $content = _e( apply_filters( 'custom_filter_change', "This is my filter" )) . $content;
    return $content;
}
//add_filter( 'the_content', 'add_my_filter', 10 );

function change_my_filter() {
    return "<div>This is my extendable filter</div>";
}
//add_filter( 'custom_filter_change', 'change_my_filter', 10 );

function add_two( $content ) {
    $content .= "<div>Two</div>";
    return $content;
}
//add_filter( 'the_content', 'add_two', 11 );

function add_one( $content ) {
    $content .= "<div>One</div>";
    return $content;
}
//add_filter( 'the_content', 'add_one', 10 );

function add_three( $content ) {
    $content .= "<div>Three</div>";
    return $content;
}
//add_filter( 'the_content', 'add_three', 11 );

function add_custom_menu_item ( $items, $args ) {
    if(is_user_logged_in()) {
        $items .= apply_filters('menu_items', '');
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'add_custom_menu_item', 10, 2 );

function add_students_archive( $items ) {
    $items .= '<li><a href=' . home_url( '/student' ) . '>Students Archive</a></li>';
    return $items;
}
add_filter( 'menu_items', 'add_students_archive' );

function add_profile_settings( $items ) {
    $items .= '<li><a href=' . admin_url('profile.php') . '>Profile Settings</a></li>';
    return $items;
}
add_filter( 'menu_items', 'add_profile_settings' );


function email_on_update( $user_id, $old_user_data ) {
    $to = get_bloginfo( 'admin_email' );
    $subject = 'Update';
    $body = 'There was an update';
    $headers = array( 'Content-Type: text/html; charset=UTF-8' );

    wp_mail( $to, $subject, $body, $headers );
}
add_action( 'profile_update', 'email_on_update', 10, 2 );

function student_custom_box_html( $post ) {
    ?>
    <form method="post">
        <div style="display:inline-block;">
            <label for="location_field">Lives In (Country, City)</label>
            <input style="margin-top:3%;"name="lives_in" class="postbox" value=""/>
        </div>
        <div>
            <label for="address_field">Address</label>
            <input style="margin-top:1%;" name="address" class="postbox" value=""/>
        </div>
        <div>
            <label for="birthdate_field">Birthdate</label>
            <input type="date" style="margin-top:1%;" name="birthdate" class="postbox" value=""/>
        </div>
        <div>
            <label for="class_field">Class / Grade</label>
            <select style="margin-top:1%;" name="class" class="postbox">
                <option value="8">8th</option>
                <option value="9">9th</option>
                <option value="10">10th</option>
                <option value="11">11th</option>
                <option value="12">12th</option>
            </select>
        </div>
        <div>
            <label for="status">Active/Inactive </label></br>
            <input id="active" type="radio" name="active" class="postbox" value="1"/>
            <label for="active">Active</label><br>
            <input id="inactive" type="radio" name="inactive" class="postbox" value="0"/>
            <label for="inactive">Inactive</label><br>
        </div>
    </form>
    <?php
}

function student_add_custom_box() {
        add_meta_box(
            'student_box_id',
            'Student Information',   
            'student_custom_box_html',
            'student'
        );
}
add_action( 'add_meta_boxes', 'student_add_custom_box' );

function save_meta_function( $post_id, $post, $update ) {
    if ( get_post_type( $post_id ) !== 'event' ) return;
    update_post_meta( $post_id, 'lives_in', $post->lives_in );
    update_post_meta( $post_id, 'address', $post->address );
    update_post_meta( $post_id, 'birthdate', $post->birthdate );
    update_post_meta( $post_id, 'class', $post->class );
    update_post_meta( $post_id, 'status', $post->lives_in );
}
add_action( 'save_post', 'save_meta_function', 10, 3 );

// END ENQUEUE PARENT ACTION
