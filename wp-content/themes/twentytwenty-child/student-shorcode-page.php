<?php
/* 
 * Template Name: Student Shortcode Page
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

<div id="site-content">
    <div id="content" role="main" class="archive-header-inner section-inner medium">
    <?php
        the_content();
    ?>
    </div>
</div>

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>