<?php
/**
 * The template for displaying students.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>
<main id="site-content">

	<?php
	if ( have_posts() ) {

		while ( have_posts() ) {
			the_post();

			echo '<div class="student-box">';
			echo '<header class="student-name archive-header has-text-align-center">' . esc_html( get_the_title() ) . '</header>';

			echo '<div class="student-thumbnail">' . get_the_post_thumbnail() . '</div>';

			echo '<div class="student-info has-text-align-center">' . esc_html( get_the_excerpt() ) . '</div>';

			$data = get_student_info( get_the_ID() );

			foreach ( $data as $d ) :
				esc_html( $d );
			endforeach;

			$activity = 'Inactive';
			if ( 1 === $data['status'] ) {
				$activity = 'Active';
			}

			$options = get_option( 'show_ajax_settings' );
			if ( $options['show_country'] ) {
				echo '<div class="student-info has-text-align-center">Lives in ' . esc_html( $data['lives_in'] );
			}
			if ( $options['show_address'] ) {
				echo '<div class="student-info has-text-align-center">Current address is  ' . esc_html( $data['address'] );
			}
			if ( $options['show_birthdate'] ) {
				echo '<div class="student-info has-text-align-center">Born on ' . esc_html( $data['birthdate'] ) . '</div>';
			}
			if ( $options['show_class'] ) {
				echo '<div class="student-info has-text-align-center">' . esc_html( $data['class'] ) . 'th grade</div>';
			}
			if ( $options['show_status'] ) {
				echo '<div class="student-info has-text-align-center">Profile status: ' . esc_html( $activity ) . '</div>';
			}

			echo '</div>';

			echo '<section> <h2>Linked Students</h2> <div class="linked-students-box"> ';

			$links = get_field( 'links' );
			if ( $links ) {
				echo '<ul>';
				foreach ( $links as $student_link ) :
					$student_post = (array) $student_link;
					echo '<li class="linked-inner">';
					echo '<a class="linked-student-name" href=" ' . esc_url( $student_post['guid'] ) . ' ">' . esc_html( $student_post['post_title'] ) . '</a>';
					echo '<div class="linked-student-thumbnail">' . get_the_post_thumbnail( $student_post['ID'] ) . '</div>';
					echo '</li>';
				endforeach;
				echo '</ul>';
			}

			echo '</div> </section>';

		}
	}

	?>

</main><!-- #site-content -->

<?php

get_template_part( 'template-parts/footer-menus-widgets' );

get_footer();
