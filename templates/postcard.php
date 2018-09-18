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
 * Postcard section at front page
 *
 * @since MCE 1.0
 */
function mce_front_page_postcard(){
	$args = array(
		'post_type'			=> 'postcard',
		'posts_per_page'	=> 1,
		'orderby'			=> 'rand',
		'meta_query'		=> array(
			array(
				'key'		=> '_thumbnail_id',
			),
		),
	);
	$postcards 		= get_posts( $args );

	if ( ! $postcards )
		return;

	$postcard 		= $postcards[0];
	$id				= $postcard->ID;
	$thumbnail_id	= get_post_meta( $id, '_thumbnail_id', true );
	$thumbnail_url	= wp_get_attachment_url( $thumbnail_id );
	$meta 			= wp_get_attachment_metadata( $thumbnail_id );
	$style			= 'background-image:url('. $thumbnail_url .');';
	$source			= ( get_post_meta( $id, 'postcard_source', true ) ) ? '<footer class="blockquote-footer font-italic text-light">'. get_post_meta( $id, 'postcard_source', true ) .'</footer>' : null;
	$photo_by		= ( get_post_meta( $id, 'postcard_photo_by', true ) ) ? '<div class="mb-5">'. sprintf( __( 'Photo by: %s', 'mce' ), get_post_meta( $id, 'postcard_photo_by', true ) ) .'</div>' : null;
?>
	<section id="postcard-<?php echo $id ?>" class="postcard hero text-light d-flex align-items-end justify-content-end" style="<?php echo $style ?>">
		<div class="postcard-body <?php t_em_container() ?>">
			<div class="<?php echo t_em_grid( 8 ) .' '. t_em_grid( 4, '', true ) ?> mb-7">
				<blockquote class="blockquote text-right">
					<p class="h1"><?php echo $postcard->post_content ?></p>
					<?php echo $source ?>
				</blockquote>
			</div>
			<?php echo $photo_by ?>
		</div>
	</section>
<?php
}
add_action( 't_em_action_main_after', 'mce_front_page_postcard' );
?>
