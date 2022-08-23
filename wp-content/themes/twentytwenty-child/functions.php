<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

$master_modified_time = filemtime( get_theme_file_path());
define( 'DX_ASSETS_VERSION', $master_modified_time . '-0000' );

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
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array( ) );
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );

function ajax_scripts_method() {
    wp_enqueue_script( 'student-ajax', get_stylesheet_directory_uri() . '/settings-student.js', array( 'jquery' ), DX_ASSETS_VERSION);
    wp_localize_script( 'student-ajax', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'admin_enqueue_scripts', 'ajax_scripts_method' );

function add_my_filter( $content ) {
    $content = __( apply_filters( 'custom_filter_change', "This is my filter" )) . $content;
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

/** 
 * Adds 'Students Archive' page to the menu 
 * */
function add_students_archive( $items ) {
    $items .= '<li><a href=' . get_post_type_archive_link('student') . '>Students Archive</a></li>';
    return $items;
}
add_filter( 'menu_items', 'add_students_archive' );

/**
 * Adds 'Students Administration' panel to the menu 
 * */
function add_student_admin( $items ) {
    $items .= '<li><a href=' . admin_url('admin.php?page=student-administration') . '>Administration</a></li>';
    return $items;
}
add_filter( 'menu_items', 'add_student_admin');

/**
 * Adds 'Profile Settings' panel to the menu 
 * */
function add_profile_settings( $items ) {
    $items .= '<li><a href=' . admin_url('profile.php') . '>Profile Settings</a></li>';
    return $items;
}
add_filter( 'menu_items', 'add_profile_settings' );

/** 
 * Sends email every time a profile update is made 
 * */
function email_on_update( $user_id, $old_user_data ) {
    $to = get_bloginfo( 'admin_email' );
    $subject = 'Update';
    $body = 'There was an update';
    $headers = array( 'Content-Type: text/html; charset=UTF-8' );

    wp_mail( $to, $subject, $body, $headers );
}
add_action( 'profile_update', 'email_on_update', 10, 2 );

/** 
 * Get custom settings info from the DB 
 * */
function get_student_info( $post_id ) {

    if( empty( $post_id ) ) return;

    $data = array();
    $info = get_post_meta( $post_id );
    
    if( !empty($info) && is_array($info) ) { 
        $data['lives_in']  = !empty( $info['lives_in'] )  ? esc_html( $info['lives_in'][0] )  : '';
        $data['address']   = !empty( $info['address'] )   ? esc_html( $info['address'][0] )   : '';
        $data['birthdate'] = !empty( $info['birthdate'] ) ? esc_html( $info['birthdate'][0] ) : '';
        $data['class']     = !empty( $info['class'] )     ? esc_html( $info['class'][0] )     : '';
        $data['status']    = !empty( $info['status'] )    ? esc_html( $info['status'][0] )    : '';
    }
    
    return $data;
}

/** 
 * Callback function with the HTML box for the custom settings 
 * */
function student_custom_box_html() {
    $id   = get_the_ID();
    $data =  !empty( $id ) ? get_student_info( $id ) : array() ;
    ?>
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
            <option value="8"  <?php if( $data['class'] == 8 )  { ?> selected <?php } ?>>8th</option>
            <option value="9"  <?php if( $data['class'] == 9 )  { ?> selected <?php } ?>>9th</option>
            <option value="10" <?php if( $data['class'] == 10 ) { ?> selected <?php } ?>>10th</option>
            <option value="11" <?php if( $data['class'] == 11 ) { ?> selected <?php } ?>>11th</option>
            <option value="12" <?php if( $data['class'] == 12 ) { ?> selected <?php } ?>>12th</option>
        </select>
    </div>
    <div>
        <label for="activity">Activity Status </label></br>
        <select name="status" class="postbox" value="<?php echo $data['status']; ?>">
            <option value="1" <?php if( $data['status'] == 1 ) { ?> selected <?php } ?>>Active</option>
            <option value="0" <?php if( $data['status'] == 0 ) { ?> selected <?php } ?>>Inactive</option>
        </select>
    </div>
    <?php 
}

/** 
 * Adds the meta box to the edit page of the post type 'student' 
 * */
function student_add_custom_box() {
        add_meta_box(
            'student_box_id',
            'Student Information',   
            'student_custom_box_html',
            'student'
        );
}
add_action( 'add_meta_boxes', 'student_add_custom_box' );

/** 
 * Sanitize and update personal data in the DB 
 * */
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

/** 
 * Pagination function 
 * */
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

/** 
 * Add custom top-level menu page 
 * */
function register_student_administration() {
    add_menu_page(
        'Students',
        'Students',
        'manage_options',
        'student-administration',
        'student_administration_callback' );
}
add_action( 'admin_menu', 'register_student_administration' );

/**
 * Callback func for the menu page
 * */
function student_administration_callback() {
    update_students_settings();
    echo '<div>' . '<h2>Students Administration</h2>' . '</div>' . ' <form method="post">';
    settings_fields( 'student-administration' );
    do_settings_sections( 'student-administration' );
}

/** 
 * Add custom settings to the new settings page 
 * */
function register_settings() {
    add_settings_section( 'students', 'Display Settings', null, 'student-administration' );

    add_settings_field( 'show_country'   , 'Show country:'        , 'show_checkbox_country'  , 'student-administration', 'students' );
    add_settings_field( 'show_address'   , 'Show address:'        , 'show_checkbox_address'  , 'student-administration', 'students' );
    add_settings_field( 'show_birthdate' , 'Show birthdate:'      , 'show_checkbox_birthdate', 'student-administration', 'students' );
    add_settings_field( 'show_class'     , 'Show class:'          , 'show_checkbox_class'    , 'student-administration', 'students' );
    add_settings_field( 'show_status'    , 'Show activity status:', 'show_checkbox_status'   , 'student-administration', 'students' );
    add_settings_field( 'submit_setts'   , ''                     , 'show_submit'            , 'student-administration', 'students' );

    register_setting( 'student-administration', 'show_country' );
    register_setting( 'student-administration', 'show_address' );
    register_setting( 'student-administration', 'show_birthdate' );
    register_setting( 'student-administration', 'show_class' );
    register_setting( 'student-administration', 'show_status' );
    register_setting( 'student-administration', 'submit_setts' );
}
add_action( 'admin_init', 'register_settings' );

/**
 *  Callback for a custom setting
 *  */
function show_checkbox_country() {
    $option  = get_option( 'show_settings' );
    $checked = ( $option[ "show_country" ] === 1 ) ? 'checked' : '';
    echo '<input type="checkbox" name="country_box" value="1"  ' . $checked . '  />';
}

/**
 *  Callback for a custom setting
 *  */
function show_checkbox_address() {
    $option  = get_option( 'show_settings' );
    $checked = ( $option[ "show_address" ] === 1 ) ? 'checked' : '';
    echo '<input type="checkbox" name="address_box" value="1"  ' . $checked . '  />';
}

/**
 *  Callback for a custom setting
 *  */
function show_checkbox_birthdate() {
    $option  = get_option( 'show_settings' );
    $checked = ( $option[ "show_birthdate" ] === 1 ) ? 'checked' : '';
    echo '<input type="checkbox" name="birthdate_box" value="1"  ' . $checked . '  />';
}

/**
 *  Callback for a custom setting
 *  */
function show_checkbox_class() {
    $option  = get_option( 'show_settings' );
    $checked = ( $option[ "show_class" ] === 1 ) ? 'checked' : '';
    echo '<input type="checkbox" name="class_box" value="1"  ' . $checked . '  />';
}

/**
 *  Callback for a custom setting
 *  */
function show_checkbox_status() {
    $option  = get_option( 'show_settings' );
    $checked = ( $option[ "show_status" ] === 1 ) ? 'checked' : '';
    echo '<input type="checkbox" name="status_box" value="1" ' . $checked . '  />';
}

function show_submit() {
    submit_button( 'Save Settings' );
}

/**
 *  Update showability of the student's personal information
 * */
function update_students_settings() { 
    if( isset( $_POST['submit'] ) ) {
        $options                   = get_option( 'show_settings' );
        $options['show_country']   = ! empty( $_POST['country_box'] )   ? 1 : 0;
        $options['show_address']   = ! empty( $_POST['address_box'] )   ? 1 : 0;
        $options['show_birthdate'] = ! empty( $_POST['birthdate_box'] ) ? 1 : 0;
        $options['show_class']     = ! empty( $_POST['class_box'] )     ? 1 : 0;
        $options['show_status']    = ! empty( $_POST['status_box'] )    ? 1 : 0;
        update_option( 'show_settings', $options );
    }
}

/** 
 *  Add custom sub menu page 
 */
function ajax_student_administration() {
    add_submenu_page(
        'student-administration',
        'AJAX Students',
        'AJAX Students',
        'manage_options',
        'ajax-student-administration',
        'ajax_admin_callback' );
}
add_action( 'admin_menu', 'ajax_student_administration' );

function ajax_admin_callback() {
    update_students_settings();
    echo '<div class="wrap">' . '<h2>AJAX Students Administration</h2>' . '</div>' . '<div class="ajax-wrap"> <form method="post">';
    settings_fields( 'ajax-student-administration' );
    do_settings_sections( 'ajax-student-administration' );
}

/**
 *  Add custom settings to the new settings page 
 * */
function ajax_register_settings() {
    add_settings_section( 'students', 'Display Settings', null, 'ajax-student-administration' );

    add_settings_field( 'show_country'   , 'Show country:'        , 'show_checkbox_country_ajax'  , 'ajax-student-administration', 'students' );
    add_settings_field( 'show_address'   , 'Show address:'        , 'show_checkbox_address_ajax'  , 'ajax-student-administration', 'students' );
    add_settings_field( 'show_birthdate' , 'Show birthdate:'      , 'show_checkbox_birthdate_ajax', 'ajax-student-administration', 'students' );
    add_settings_field( 'show_class'     , 'Show class:'          , 'show_checkbox_class_ajax'    , 'ajax-student-administration', 'students' );
    add_settings_field( 'show_status'    , 'Show activity status:', 'show_checkbox_status_ajax'   , 'ajax-student-administration', 'students' );

    register_setting( 'ajax-student-administration', 'show_country' );
    register_setting( 'ajax-student-administration', 'show_address' );
    register_setting( 'ajax-student-administration', 'show_birthdate' );
    register_setting( 'ajax-student-administration', 'show_class' );
    register_setting( 'ajax-student-administration', 'show_status' );
}
add_action( 'admin_init', 'ajax_register_settings' );

/**
 *  Callback for a custom setting
 *  */
function show_checkbox_country_ajax() {
    $options = get_option( 'show_ajax_settings' );
    echo '<input type="checkbox" id="show_country" name="country_box_ajax" value="1" ' . checked( $options["show_country"] , true, false )  . '  />';
}

/**
 *  Callback for a custom setting 
 * */
function show_checkbox_address_ajax() {
    $options = get_option( 'show_ajax_settings' );
    echo '<input type="checkbox" id="show_address" name="address_box_ajax" value="1" ' . checked( $options["show_address"], true, false ) . '  />';
}

/**
 *  Callback for a custom setting 
 * */
function show_checkbox_birthdate_ajax() {
    $options = get_option( 'show_ajax_settings' );
    echo '<input type="checkbox" id="show_birthdate" name="birthdate_box_ajax" value="1" ' . checked( $options["show_birthdate"] , true, false ) . '  />';
}

/**
 *  Callback for a custom setting 
 * */
function show_checkbox_class_ajax() {
    $options = get_option( 'show_ajax_settings' );
    echo '<input type="checkbox" id="show_class" name="class_box_ajax" value="1" ' . checked( $options["show_class"] , true, false ) . '  />';
}

/** 
 * Callback for a custom setting 
 * */
function show_checkbox_status_ajax() {
    $options = get_option( 'show_ajax_settings' );
    echo '<input type="checkbox" id="show_status" name="status_box_ajax" value="1" ' . checked( $options["show_status"] , true, false ) . '  /> </div> </form>';
}

/**
 *  Function executed by AJAX when a checkbox is un/checked on the settings page 
 * */
function ajax_func() {
    $options = get_option( 'show_ajax_settings' );
    $options[ $_POST['option'] ] = 0;
    if( $_POST['checked'] === 'true' ) {
        $options[ $_POST['option'] ] = 1;
    }
    update_option( 'show_ajax_settings', $options );
}
add_action( 'wp_ajax_ajax_func', 'ajax_func' );

/** 
 * Add a column for the activity status on the student dashboard 
 * */
function add_student_columns( $columns ) {
    $columns['Active'] = __( 'Active' );
    return $columns;
}
add_filter('manage_student_posts_columns' , 'add_student_columns');

/**
 * Print the activity checkboxes on the dashboard
 *  */ 
function print_extra_columns() { 
    $id   = get_the_ID();
    $meta = get_post_meta( $id );
    $checked = ( $meta["status"][0] == 1 ) ? 'checked' : '';
    echo '<form method="post"> <div > <input type="checkbox" class="student-status" id="' . get_the_ID() . '" name="status" value="1" ' . $checked . '  /> </div> </form>';
}
add_action( 'manage_student_posts_custom_column', 'print_extra_columns' );

/**
 * Make the custom column sortable
 */
function sort_student_status( $columns ) {
    $columns['Active'] = __('status');
    return $columns;
}
add_filter( 'manage_edit-student_sortable_columns', 'sort_student_status' );

/**
 * Define how to order our sortable custom column
 */
function student_status_orderby($query) {
    $post_type = $query->get( 'post_type' );

    if( !is_admin() || ( $post_type !== 'student' ) ){
         return;
    }
 
    $orderby = $query->get( 'orderby' );
 
    if( 'status' == $orderby ) {
        $query->set('meta_key','status');
        $query->set('orderby','meta_value');
    }
}
add_action( 'pre_get_posts', 'student_status_orderby' );

/**
 * Function executed by AJAX to update activity status
 */
function update_student_status(){
    $status = ( 'true' === esc_attr( $_POST['checked'] ) ) ?  1 : 0;
    update_post_meta( sanitize_text_field( $_POST['student-id'] ), 'status', $status );
}
add_action( 'wp_ajax_update_student_status', 'update_student_status' );

/** 
 * Add custom top-level menu page 
 * */
function register_dictionary_menu() {
    add_menu_page(
        'Dictionary',
        'Dictionary',
        'manage_options',
        'dictionary',
        'dictionary_callback' );
}
add_action( 'admin_menu', 'register_dictionary_menu' );

/**
 * Callback func for the menu page
 * */
function dictionary_callback() {
    echo '<div> <h2>Dictionary</h2> </div>';
    settings_fields( 'dictionary' );
    do_settings_sections( 'dictionary' );
}

/** 
 * Add custom settings to the new settings page 
 * */
function register_dictionary_settings() {
    add_settings_section( 'dictionary', '', null, 'dictionary' );

    add_settings_field( 'dictionary_search'   , 'Search up a word: ', 'show_dictionary_search'  , 'dictionary', 'dictionary' );

    register_setting( 'dictionary', 'dictionary_search' );
}
add_action( 'admin_init', 'register_dictionary_settings' );

/** 
 * Callback for a custom setting 
 * */
function show_dictionary_search() {
    $body = ! empty ( $result = get_transient( 'dictionary_transient' ) ) ? $result : '';
    $search = isset( $_POST[ 'dictionary-search' ] ) ? sanitize_text_field( $_POST[ 'dictionary-search' ] ) : '';
    echo 
    '<form method="post" action="' . admin_url( 'admin.php?page=dictionary' ) . '"> 
        <input type="search" class="dictionary-search" name="dictionary-search" placeholder="Search..." value="' . $search . '"> 
        <input type="submit" class="dictionary-submit"> 
        <div> 
            <label for="search">Keep search for:</label></br>
            <select class="dictionary-search-time" name="keep-search"> 
                <option value="10">10 seconds</option>
            </select> 
        </div>
    </form> <div class="result-data"> ' . $body . ' </div>'; 
}

/** 
 * Function executed by AJAX to remotely get data from Oxford Dictionary
 * */
function search_oxford_dictionary(){
    $result = wp_remote_get( esc_url( 'https://www.oxfordlearnersdictionaries.com/definition/english/' . sanitize_title_with_dashes( $_POST[ 'word' ]) ) );

    if( is_wp_error( $result ) ) {
        return;
    }

    $body = wp_remote_retrieve_body( $result );
    set_transient('dictionary_transient', $body, sanitize_text_field( $_POST[ 'keep-time' ] ) );

    echo $body;
}
add_action( 'wp_ajax_search_oxford_dictionary', 'search_oxford_dictionary' );

/** 
 * Creating shortcode for students
 * */
function students_shortcode( $attributes ) {
    $shortcode_args = shortcode_atts( array(
        'number_of_students' => '0',
    ), $attributes );

    ?>

    <div id="site-content" class="<?php echo is_page_template( 'templates/template-full-width.php' ) ? '' : 'thin'; ?>">
    <div id="content" role="main" class="archive-header-inner section-inner medium">
 
    <?php 
    $args = array(
        'post_type'      => 'student',
        'meta_key'       => 'status',
        'meta_value'     => '1',
        'posts_per_page' => $shortcode_args[ 'number_of_students' ]
    );
    $query = new WP_Query( $args );
    
    if( $query->have_posts() ) {
        while ( $query->have_posts() ) {
    ?>

    <div class="student-box"> 

        <?php
            $query->the_post();

            $title = str_replace( ' ','-', strtolower( get_the_title() ) );
            $data = get_student_info( get_the_ID() );

            echo '<div class="student-name"> <a href=' . home_url( $title ) . '>' . get_the_title() . ', ' . $data[ 'class' ] . ' Grade </a> </div>';

            echo '<div class="student-thumbnail">' . get_the_post_thumbnail() . '</div>';
        ?>

    </div>

    <?php   	
        }
    }
    wp_reset_postdata();
    ?>
    
        </div>
    </div>

<?php
}
add_shortcode('students', 'students_shortcode');

// END ENQUEUE PARENT ACTION
