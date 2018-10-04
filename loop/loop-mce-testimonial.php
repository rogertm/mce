<?php
/**
 * MCE
 *
 * @package			WordPress
 * @subpackage		MCE
 * @author			RogerTM
 * @license			license.txt
 * @link			https://excursionismocuba.com
 * @since 			MCE 1.0
 */

/**
 * Custom Loop for Testimonial post type
 */
?>
<?php
// Custom query for post type Testimonial
$args = array(
	'post_type'			=> 'mce-testimonial',
	'posts_per_page'	=> -1,
	'meta_key'			=> '_thumbnail_id',
);

$testimonials = get_posts( $args );
?>
	<div id="testimonial-archive" class="row">
	<?php foreach ( $testimonials as $testimonial ) : ?>
		<div id="testimonial-<?php echo $testimonial->ID ?>" class="<?php echo t_em_grid( 4 ) .' '. t_em_grid( 6, 'md' ) ?>">
		<div class="card text-center mb-5 testimonial">
			<?php echo get_the_post_thumbnail( $testimonial->ID, 'thumbnail', array( 'class' => 'avatar testimonial-image', 'alt' => $testimonial->post_title ) ) ?>
			<div class="card-body">
				<h5 class="card-title"><?php echo $testimonial->post_title ?></h5>
				<div class="card-text"><?php echo $testimonial->post_content ?></div>
			</div>
		</div>
		</div>
	<?php endforeach; wp_reset_postdata(); ?>
	</div>
