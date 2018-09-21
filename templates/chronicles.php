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
 * Featured Chronicle section at front page
 *
 * @since MCE 1.0
 */
function mce_front_page_chronicle(){
	if ( ! is_front_page() || ! t_em( 'term_cat_chronicles' ) )
		return;

	$term		= t_em( 'term_cat_chronicles' );
	$term_data	= get_term( $term, 'category' );
	$args = array(
		'post_type'			=> 'post',
		'posts_per_page'	=> 1,
		'p'					=> get_option( 'mce_daily_chronicle' ),
	);
	$chronicles	= get_posts( $args );

	if ( ! $chronicles )
		return;

	$chronicle 		= $chronicles[0];
	$id				= $chronicle->ID;
	$thumbnail_id	= get_post_meta( $id, '_thumbnail_id', true );
	$thumbnail_url	= wp_get_attachment_url( $thumbnail_id );
	$style			= 'background-image:url('. $thumbnail_url .');';
?>
	<section id="chronicle-<?php echo $id ?>" class="chronicle hero text-light mb-7 d-flex align-items-end" style="<?php echo $style ?>">
		<div class="chronicle-body <?php t_em_container() ?>">
			<div class="<?php echo t_em_grid( 8 ) ?> mb-7">
				<span class="d-block h6"><?php echo $term_data->name ?><hr class="bg-light"></span>
				<h3 class="h1"><?php echo $chronicle->post_title ?></h3>
				<?php echo t_em_wrap_paragraph( t_em_get_post_excerpt( $chronicle->ID, false ) ) ?>
				<p><a href="<?php echo get_permalink( $chronicle->ID ) ?>"><?php _e( 'Read more', 'mce' ) ?></a></p>
			</div>
		</div>
	</section>
<?php
}
add_action( 't_em_action_main_after', 'mce_front_page_chronicle' );
?>
