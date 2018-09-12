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
 * Latests post at front page
 *
 * @since MCE 1.0
 */
function mce_latests_post(){
	global $template;
	if ( ! is_front_page() )
		return;

	$chronicle = t_em( 'term_cat_chronicles' );
	$args = array(
		'post_type'			=> 'post',
		'posts_per_page'	=> 3,
		'cat'				=> - $chronicle,
		'meta_query'		=> array(
			array(
				'key'		=> '_thumbnail_id',
			),
		)
	);
	$wp_query = new WP_Query( $args );
?>
	<section id="latest-posts" class="my-10">
		<div class="<?php t_em_container() ?>">
			<h2 class="text-center h1 mb-6"><?php _e( 'Latests Blog Entries', 'mce' ) ?></h2>
<?php
		if ( $wp_query->have_posts() ) :
			while ( $wp_query->have_posts() ) :
				$wp_query->the_post();
				$thumbnail_cols	= 6;
				$content_cols	= 12 - $thumbnail_cols;
				$thumbnail_grid	= ( has_post_thumbnail() ) ? t_em_grid( $thumbnail_cols ) : null;
				$content_grid	= ( $thumbnail_grid ) ? t_em_grid( $content_cols ) : t_em_grid( '12' );
?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="row">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php $align = 'align-'. t_em( 'excerpt_set' ); ?>
						<div class="<?php echo $thumbnail_grid .' '. $align; ?>">
							<?php t_em_featured_post_thumbnail( 700, 350, true ); ?>
						</div>
					<?php endif; ?>
					<div class="<?php echo $content_grid; ?>">
						<header>
							<h2 class="entry-title mt-0"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 't_em' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						</header>
						<?php the_excerpt(); ?>
					</div>
				</div>
			</article><!-- #post-## -->
			<?php
			endwhile;
			wp_reset_postdata();
		endif;
?>
		</div>
	</section>
<?php
}
add_action( 't_em_action_main_after', 'mce_latests_post' );
?>
