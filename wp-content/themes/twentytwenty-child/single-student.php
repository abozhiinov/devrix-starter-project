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

            echo '<header class="student-name archive-header has-text-align-center">' . get_the_title() . '</header>';

            echo '<div class="student-thumbnail">' . get_the_post_thumbnail() . '</div>';

            echo '<div class="has-text-align-center">' . get_the_excerpt() . '</div>';
            
			//get_template_part( 'template-parts/content', get_post_type() );
		}
	}

	?>

</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>