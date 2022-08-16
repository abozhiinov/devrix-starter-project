<?php
/**
 * Template Name: Custom Template
 * Template Post Type: page, post
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
			the_title();
            the_post_thumbnail();
            the_content(); 
            the_author();

			//get_template_part( 'template-parts/singular' );

            do_action('custom_action_hook');

		}
	} else {
        echo "No posts.";
    }

	?>

</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>