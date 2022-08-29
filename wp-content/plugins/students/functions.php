<?php
/**
 * Functions used by the students plugin
 *
 * @package WordPress
 */

/**
 * Function to request a student
 *
 * @param object $data student's data.
 */
function rest_api_student( $data ) {
	$args = array(
		'post_type'      => 'student',
		'post_status'    => 'publish',
		'posts_per_page' => 50,
	);

	if ( $data->has_param( 'id' ) ) {
		$args += array( 'p' => $data['id'] );
	}

	$query = new WP_Query( $args );

	$student_data = array();
	$count        = 0;
	$posts        = $query->get_posts();

	foreach ( $posts as $post ) {
		$meta = get_post_meta( $post->ID );
		$obj  = new WP_Post( $post );
		$post = $obj->to_array();

		$student_data[ $count++ ] = array_merge( $post, $meta );
	}

	if ( empty( $student_data ) ) {
		return new WP_Error( 'no_student_available', 'There is no student to display', array( 'status' => 404 ) );
	}
	$response = new WP_REST_Response( $student_data );

	return $response;
}

add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'/v1',
			'/student(?:/(?P<id>\d+))?',
			array(
				'methods'  => 'GET',
				'callback' => 'rest_api_student',
			)
		);
	}
);

/**
 * Register adding student route
 */
add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'/v1',
			'/add-student',
			array(
				'methods'  => 'POST',
				'callback' => 'add_student_callback',
			)
		);
	}
);

/**
 * Add student through REST API
 *
 * @param object $request_data requested student data.
 */
function add_student_callback( $request_data ) {
	$data = array();

	$parameters  = $request_data->get_params();
	$post_title  = sanitize_text_field( $parameters['post_title'] );
	$the_content = sanitize_text_field( $parameters['the_content'] );
	$the_excerpt = sanitize_text_field( $parameters['the_excerpt'] );

	$lives_in  = sanitize_text_field( $parameters['lives_in'] );
	$address   = sanitize_text_field( $parameters['address'] );
	$birthdate = sanitize_text_field( $parameters['birthdate'] );
	$class     = sanitize_text_field( $parameters['class'] );
	$status    = sanitize_text_field( $parameters['status'] );

	if ( ! empty( $post_title ) ) {

		$my_post     = array(
			'post_title'   => $post_title,
			'post_content' => $the_content,
			'post_author'  => '',
			'post_excerpt' => $the_excerpt,
			'post_status'  => 'publish',
			'post_type'    => 'student',
		);
		$new_post_id = wp_insert_post( $my_post );

		update_post_meta( $new_post_id, 'lives_in', $lives_in );
		update_post_meta( $new_post_id, 'address', $address );
		update_post_meta( $new_post_id, 'birthdate', $birthdate );
		update_post_meta( $new_post_id, 'class', $class );
		update_post_meta( $new_post_id, 'status', $status );

		if ( $new_post_id ) {
			$data['status'] = 'Post added Successfully.';
		} else {
			return new WP_Error( 'post_failed', 'Post failed.', array( 'status' => 404 ) );
		}
	} else {
		return new WP_Error( 'incorrect_student_details', 'Please provide correct student details', array( 'status' => 404 ) );
	}

	return new WP_REST_Response( $data );
}

/**
 * Register editing student route
 */
add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'/v1',
			'/edit-student/(?P<id>\d+)',
			array(
				'methods'  => 'POST',
				'callback' => 'edit_student_callback',
			)
		);
	}
);

/**
 * Edit student through REST API
 *
 * @param object $request_data requested data.
 */
function edit_student_callback( $request_data ) {
	$data      = array();
	$url_array = explode( '?', basename( cur_page_url() ) );
	$id        = $url_array[0];

	$parameters = $request_data->get_params();

	if ( ! empty( $parameters['post_title'] ) ) {
		$post_title = sanitize_text_field( $parameters['post_title'] );
	}
	if ( ! empty( $parameters['the_content'] ) ) {
		$the_content = sanitize_text_field( $parameters['the_content'] );
	}
	if ( ! empty( $parameters['the_excerpt'] ) ) {
		$the_excerpt = sanitize_text_field( $parameters['the_excerpt'] );
	}

	$meta      = get_post_meta( $id );
	$country   = ! empty( $parameters['country'] ) ? sanitize_text_field( $parameters['country'] ) : $meta['lives_in'][0];
	$address   = ! empty( $parameters['address'] ) ? sanitize_text_field( $parameters['address'] ) : $meta['address'][0];
	$birthdate = ! empty( $parameters['birthdate'] ) ? sanitize_text_field( $parameters['birthdate'] ) : $meta['birthdate'][0];
	$class     = ! empty( $parameters['class'] ) ? sanitize_text_field( $parameters['class'] ) : $meta['class'][0];
	$status    = ! empty( $parameters['status'] ) ? sanitize_text_field( $parameters['status'] ) : $meta['status'][0];

	if ( ! empty( $id ) ) {

		$my_post  = array();
		$my_post += array( 'ID' => $id );
		if ( ! empty( $post_title ) ) {
			$my_post += array( 'post_title' => $post_title );
		}
		if ( ! empty( $the_content ) ) {
			$my_post += array( 'post_content' => $the_content );
		}
		if ( ! empty( $the_excerpt ) ) {
			$my_post += array( 'post_excerpt' => $the_excerpt );
		}

		$post_id = wp_update_post( $my_post );
		update_post_meta( $post_id, 'lives_in', $country );
		update_post_meta( $post_id, 'address', $address );
		update_post_meta( $post_id, 'birthdate', $birthdate );
		update_post_meta( $post_id, 'class', $class );
		update_post_meta( $post_id, 'status', $status );

		if ( $post_id ) {
			$data['status'] = 'Post updated Successfully.';
		} else {
			return new WP_Error( 'post_failed', 'Post failed.', array( 'status' => 404 ) );
		}
	} else {
		return new WP_Error( 'incorrect_student_details', 'Please provide correct student details', array( 'status' => 404 ) );
	}

	return new WP_REST_Response( $data );
}

/**
 * Register deleting student route
 */
add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'/v1',
			'/delete-student/(?P<id>\d+)',
			array(
				'methods'  => 'POST',
				'callback' => 'delete_student_callback',
			)
		);
	}
);

/**
 * Delete student through REST API
 */
function delete_student_callback() {
	$data = array();
	$id   = basename( cur_page_url() );

	if ( ! empty( $id ) ) {
		$answer = wp_delete_post( $id );
		if ( 'false' !== $answer && null !== $answer ) {
			$data['status'] = 'Post deleted Successfully.';
		} else {
			return new WP_Error( 'incorrect_student_id', 'Please provide correct student ID', array( 'status' => 404 ) );
		}
	} else {
		return new WP_Error( 'incorrect_student_details', 'Please provide correct student details', array( 'status' => 404 ) );
	}

	return new WP_REST_Response( $data );
}

/**
 * Get current page URL
 */
function cur_page_url() {
	$page_url = 'http';
	wp_unslash( $_SERVER );
	if ( isset( $_SERVER['HTTPS'] ) && 'on' === $_SERVER['HTTPS'] ) {
		$page_url .= 's';
	}
	$page_url .= '://';
	if ( isset( $_SERVER['SERVER_PORT'] ) && '80' !== $_SERVER['SERVER_PORT'] ) {
		if ( isset( $_SERVER['SERVER_NAME'] ) && isset( $_SERVER['SERVER_PORT'] ) && isset( $_SERVER['REQUEST_URI'] ) ) {
			$page_url .= sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) . ':' . sanitize_text_field( wp_unslash( $_SERVER['SERVER_PORT'] ) ) . sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) );
		}
	} else {
		$page_url .= sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) . sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) );
	}

	return $page_url;
}

