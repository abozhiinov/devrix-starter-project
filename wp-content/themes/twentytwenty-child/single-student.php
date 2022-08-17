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

            echo '<header style="font-weight: bold; font-size: 60px;" class="archive-header has-text-align-center">'; 
            the_title(); 
            echo '</header>';

            echo '<center><div>';
            the_post_thumbnail();
            echo '</div></center>';

            echo '<div style="margin-top: 1%;" class="has-text-align-center">';
            the_excerpt();
            echo '</div>';
            
			//get_template_part( 'template-parts/content', get_post_type() );
		}
	}

	?>

</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>