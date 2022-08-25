<?php 

function rest_api_student( $data ) {
    $args = array(
        'post_type'      => 'student',
        'post_status'    => 'publish',
        'posts_per_page' => 50,
    );

    if( $data->has_param( 'id' ) ) {
       $args += [ 'p' => $data[ 'id' ] ];
    }

    $query = new WP_Query( $args );

    $student_data = [];
    $count        = 0;
    $posts        = $query->get_posts();

    foreach( $posts as $post ) {
        $meta = get_post_meta( $post->ID );
        $obj  = new WP_Post( $post );
        $post = $obj->to_array();

        $student_data[ $count++ ] = array_merge( $post, $meta );
    }

    if( empty( $student_data ) ) {
        return new WP_Error( 'no_student_available', 'There is no student to display', array( 'status' => 404 ) );
    }
    $response = new WP_REST_Response( $student_data );

    return $response;
}

add_action( 'rest_api_init', function () {
    register_rest_route( '/v1', '/student(?:/(?P<id>\d+))?', array(
        'methods'  => 'GET',
        'callback' => 'rest_api_student'
    ) );
} );

?>