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
        <h1 class="archive-title"><a href=<?php get_post_type_archive_link( 'student' );?>>Students Archive</a></h1>
    </div>
</header>

<div id="site-content" class="<?php echo is_page_template( 'templates/template-full-width.php' ) ? '' : 'thin'; ?>">
    <div id="content" role="main" class="archive-header-inner section-inner medium">
 
    <?php 
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $args = array(
        'post_type'  => 'student',
        'post_status' => 'publish',
        'meta_key'   => 'status',
        'meta_value' => '1',
        'paged'      => $paged
    );
    $query = new WP_Query( $args );

    if( $query->have_posts() ) {
        while ( $query->have_posts() ) {
    ?>
    <div class="student-box"> 
        <?php
            $query->the_post();
            
            $title = str_replace( ' ','-', strtolower( get_the_title() ) );
            
            echo '<div class="student-name"> <a href=' . home_url( $title ) . '>' . get_the_title() . '</a> </div>';

            echo '<div class="student-thumbnail">' . get_the_post_thumbnail() . '</div>';
        ?>
    </div>
    <?php   	
        }
        pagination( $paged );
    }
    wp_reset_postdata();
    ?>
 
    </div><!-- #content -->
</div><!-- #primary -->
 
<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>