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
	$style			= array(
		'background-image:url('. $thumbnail_url .');',
		'background-repeat:no-repeat;',
		'background-size:cover;',
	);
	$style			= join( $style );
?>
	<section id="postcard-<?php echo $id ?>" class="postcard bg-holder d-flex align-items-center" data-width="<?php echo $meta['width'] ?>" data-height="<?php echo $meta['height'] ?>" style="<?php echo $style ?>">
		<div class="postcard-body <?php t_em_container() ?>">
			<blockquote class="blockquote"><h3 class="h1"><?php echo $postcard->post_content ?></h3></blockquote>
		</div>
	</section>
<?php
}
add_action( 't_em_action_main_after', 'mce_front_page_postcard' );
?>
