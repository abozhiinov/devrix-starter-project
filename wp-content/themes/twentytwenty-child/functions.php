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

function get_student_info( $post_id ) {

    if( empty( $post_id ) ) return; // Check if it has an ID to work on

    $data = array(); // Create an empty array for needed data
    $info = get_post_meta( $post_id ); // Get needed data using the get_post_meta() function
    
    if( !empty($info) && is_array($info) ) { // Fill the data in the array
        $data['lives_in']  = !empty( $info['lives_in'] )  ? esc_html( $info['lives_in'][0] )  : '';
        $data['address']   = !empty( $info['address'] )   ? esc_html( $info['address'][0] )   : '';
        $data['birthdate'] = !empty( $info['birthdate'] ) ? esc_html( $info['birthdate'][0] ) : '';
        $data['class']     = !empty( $info['class'] )     ? esc_html( $info['class'][0] )     : '';
        $data['status']    = !empty( $info['status'] )    ? esc_html( $info['status'][0] )    : '';
    }
    
    return $data;
}

function student_custom_box_html( $post ) {
    $data = array(
        'lives_in'  => '',
        'address'   => '',
        'birthdate' => '',
        'class'     => '',
        'status'    => ''
    );
    if(!empty(get_the_ID())){
        $data = get_student_info(get_the_ID());
    }
    ?>
    <form method="post">
        <div>
            <label for="location_field">Lives In (Country, City)</label></br>
            <input name="lives_in" class="postbox" value="<?php echo $data['lives_in']; ?>"/>
        </div>
        <div>
            <label for="address_field">Address</label></br>
            <input name="address" class="postbox" value="<?php echo $data['address']; ?>"/>
        </div>
        <div>
            <label for="birthdate_field">Birthdate</label></br>
            <input type="date" name="birthdate" class="postbox" value="<?php echo $data['birthdate']; ?>"/>
        </div>
        <div>
            <label for="class_field">Class / Grade</label></br>
            <select name="class" class="postbox" value="<?php echo $data['class']; ?>">
                <option value="8"  <?php if($data['class'] == 8)  { ?> selected <?php } ?>>8th</option>
                <option value="9"  <?php if($data['class'] == 9)  { ?> selected <?php } ?>>9th</option>
                <option value="10" <?php if($data['class'] == 10) { ?> selected <?php } ?>>10th</option>
                <option value="11" <?php if($data['class'] == 11) { ?> selected <?php } ?>>11th</option>
                <option value="12" <?php if($data['class'] == 12) { ?> selected <?php } ?>>12th</option>
            </select>
        </div>
        <div>
            <label for="activity">Activity Status </label></br>
            <select name="status" class="postbox" value="<?php echo $data['status']; ?>">
                <option value="1" <?php if($data['status'] == 1) { ?> selected <?php } ?>>Active</option>
                <option value="0" <?php if($data['status'] == 0) { ?> selected <?php } ?>>Inactive</option>
            </select>
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

function save_meta_function( $post_id ) {
    $lives_in  = sanitize_text_field( $_POST['lives_in'] );
    $address   = sanitize_text_field( $_POST['address'] );
    $birthdate = sanitize_text_field( $_POST['birthdate'] );
    $class     = sanitize_text_field( $_POST['class'] );
    $status    = sanitize_text_field( $_POST['status'] );

    update_post_meta( $post_id, 'lives_in', $lives_in );
    update_post_meta( $post_id, 'address', $address );
    update_post_meta( $post_id, 'birthdate', $birthdate );
    update_post_meta( $post_id, 'class', $class);
    update_post_meta( $post_id, 'status', $status );
}
add_action( 'save_post', 'save_meta_function', 10 );

function pagination( $paged = '', $max_page = '' ) {
    $big = 999999999;
    if( ! $paged ) {
        $paged = get_query_var('paged');
    }

    if( ! $max_page ) {
        global $wp_query;
        $max_page = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
    }

    echo paginate_links( array(
        'base'       => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format'     => '?paged=%#%',
        'current'    => max( 1, $paged ),
        'total'      => $max_page,
        'mid_size'   => 1,
        'prev_text'  => __( '<' ),
        'next_text'  => __( '>' ),
    ) );
}

// END ENQUEUE PARENT ACTION
