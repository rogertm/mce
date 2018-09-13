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
 * Testimonials
 *
 * @since MCE 1.0
 */
function mce_testimonials(){
	$args = array(
		'post_type'			=> 'jetpack-testimonial',
		'orderby'			=> 'rand',
		'posts_per_page'	=> 3,
	);
	$testimonials = get_posts( $args );
	if ( ! $testimonials || ! is_front_page() )
		return;

	$count = count( $testimonials );
?>
	<section id="testimonials" class="testimonial mt-7 mb-0 py-7 text-center">
		<div class="<?php t_em_container() ?>">
			<h2 class="testimonial-headline mb-4"><?php _e( 'Testimonials', 'mce' ) ?></h2>
			<div id="testimonials-carousel" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
				<?php $i = 0; while ( $i < $count ) : ?>
					<li data-target="#testimonials-carousel" data-slide-to="<?php echo $i ?>"></li>
				<?php $i++; endwhile; ?>
				</ol>
				<div class="carousel-inner">
				<?php foreach ( $testimonials as $testimonial ) : ?>
					<div class="carousel-item testimonial-item">
						<div class="testimonial-body lead mx-lg-10">
							<?php echo $testimonial->post_content ?>
						</div>
						<div class="testimonial-footer d-flex justify-content-center">
							<?php echo get_the_post_thumbnail( $testimonial->ID, 'thumbnail', array( 'class' => 'd-block rounded-circle' ) ) ?>
							<h3 class="testimonial-name mt-5 ml-3"><?php echo $testimonial->post_title ?></h3>
						</div>
					</div>
				<?php endforeach; ?>
				</div>
				<a class="carousel-control-prev" href="#testimonials-carousel" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only"><?php _e( 'Previous', 'mce' ) ?></span>
				</a>
				<a class="carousel-control-next" href="#testimonials-carousel" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only"><?php _e( 'Next', 'mce' ) ?></span>
				</a>
			</div>
		</div>
	</section>
<?php
}
add_action( 't_em_action_main_after', 'mce_testimonials' );
?>
