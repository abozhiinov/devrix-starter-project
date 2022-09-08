<?php
/**
 * Block Name: ACF Student
 *
 * This is the template that displays the acf student block.
 *
 * @package WordPress
 */

$args = array(
	'post_type'      => 'student',
	'posts_per_page' => get_field( 'number_of_students' ),
	'meta_key'       => 'status',
	'meta_value'     => (int) get_field( 'show_by_status' ),
	'_embed'         => true,
);

if ( get_field( 'student_id' ) ) {
	$args += array( 'p' => get_field( 'student_id' ) );
}

$students = get_posts( $args );

?>

<div class="acf-students">

<?php
foreach ( $students as $student ) {
	$student       = (array) $student;
	$student_title = str_replace( ' ', '-', strtolower( $student['post_title'] ) );
	?>
	<div class="acf-student-box">
		<div class="student-name"> <a href=<?php echo esc_url( home_url( 'student/' . $student_title ) ); ?>> <?php echo esc_html( $student['post_title'] ); ?></a> </div>
		<div class="acf-thumbnail"> <a href=<?php echo esc_url( home_url( 'student/' . $student_title ) ); ?>> <?php echo get_the_post_thumbnail( $student['ID'] ); ?> </a> </div>
	</div>
	<?php
}

?>

</div>
