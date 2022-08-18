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
            
            $data = get_student_info(get_the_ID());
            foreach($data as $d) : 
                esc_html($d);
            endforeach;
            if($data['status'] == 1) $activity = "Active";
            else                     $activity = "Inactive";
            
            if( get_option('show_country') ) echo '<div class="student-info has-text-align-center">Lives in '            . $data['lives_in'];
            if( get_option('show_address') ) echo '<div class="student-info has-text-align-center">Current address is  ' . $data['address'];
            if( get_option('show_birthdate') ) echo '<div class="student-info has-text-align-center">Born on '           . $data['birthdate'] . '</div>';
            if( get_option('show_class') ) echo '<div class="student-info has-text-align-center">'                       . $data['class'] . 'th class</div>';
            if( get_option('show_status') ) echo '<div class="student-info has-text-align-center">Profile status: '      .  $activity . '</div>';

		}
	}

	?>

</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>