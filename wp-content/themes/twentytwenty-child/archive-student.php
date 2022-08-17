<?php
/* 
 * Template Name: Student Archive
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
        <h1 class="archive-title"><a style="text-decoration: none;" href="/devrix-starter/student">Students Archive</a></h1>
    </div>
</header>

<div id="site-content" class="<?php echo is_page_template( 'templates/template-full-width.php' ) ? '' : 'thin'; ?>">
    <div id="content" role="main" class="archive-header-inner section-inner medium">
 
    <?php 

    if( have_posts() ) {
        while ( have_posts() ) {
    ?>
    <div style="margin-top:50px"> 
        <?php
            the_post();

            get_template_part( 'template-parts/content', get_post_type() );
            //the_post_thumbnail(); 
        ?>
    </div>
    <?php   	
        }
        echo '<div style="margin-top:50px">';
        the_posts_pagination( array(
            'mid_size'  => 2,
            'prev_text' => __( '< Previous Page', 'textdomain' ),
            'next_text' => __( 'Next Page >', 'textdomain' ),
            ) ); 
        echo '</div>';
    }
    ?>
 
    </div><!-- #content -->
</div><!-- #primary -->
 
<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>