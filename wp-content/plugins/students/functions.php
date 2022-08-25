<?php 

function rest_api_student( $data ) {
    if(!empty($data['id'])){
        $query = new WP_Query([
            'post_type' => 'student',
            'p'         => $data['id']   
        ]);
        
        $post = $query->get_posts();
        $meta = get_post_meta($data['id']);
        $posts = array_merge($post, $meta);
    } else {
        $query = new WP_Query([
            'post_type'   => 'student',
            'numberposts' => -1
        ]);

        $no_meta_posts = $query->get_posts();
        $posts = array( array() );
        $count = 0;

        foreach($no_meta_posts as $post) :
            $meta = get_post_meta($post->ID);
            $obj = new WP_Post($post);
            $post = $obj->to_array($post);
            $posts[$count++] = array_merge($post, $meta);
        endforeach;
    }
    
    if ( empty( $posts ) ) {
        return new WP_Error( 'empty_student', 'There are no posts to display', array('status' => 404) );
    }
    $response = new WP_REST_Response($posts);

    return $response;
}

add_action( 'rest_api_init', function () {
    register_rest_route( '/v1', '/student/(?P<id>\d+)', array(
      'methods' => 'GET',
      'callback' => 'rest_api_student',
    ) );
    register_rest_route( '/v1', '/student', array(
        'methods' => 'GET',
        'callback' => 'rest_api_student',
      ) );
} );

?>