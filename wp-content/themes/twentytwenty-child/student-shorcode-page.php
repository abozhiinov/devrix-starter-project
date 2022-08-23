<?php
/* 
 * Template Name: Student Shortcode Page
 * The archive page for students post-type.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
*/
get_header(); ?>

<header class="archive-header has-text-align-center header-footer-group">
    <div class="archive-header-inner section-inner medium">
        <a class="archive-title" href="<?php home_url('students-shortcode'); ?>" >Students Shortcode</a>
    </div>
</header>

<div class="section-inner small">
    <form method="post">
        <input type="number" placeholder="Type the number of students to show:" name="students_number"/> 
    </form>
</div>

<?php
    if( !empty( $_POST[ 'students_number' ] ) ) {
        $number = sanitize_text_field( $_POST[ 'students_number' ] );
        do_shortcode( '[students number_of_students=' . $number . ']' );
    } else {
        echo '<h1 class="has-text-align-center nothing-show">Nothing to show.</h1>';
    }
?>

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>