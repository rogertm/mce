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
?>
	<section id="postcard-<?php echo $id ?>" class="postcard card">
		<img src="<?php echo $thumbnail_url ?>" class="card-img" alt="<?php echo $postcard->post_content ?>">
		<div class="postcard-body card-img-overlay d-flex align-items-center <?php t_em_container() ?>">
			<blockquote class="blockquote card-body"><h3 class="h1"><?php echo $postcard->post_content ?></h3></blockquote>
		</div>
	</section>
<?php
}
add_action( 't_em_action_main_after', 'mce_front_page_postcard' );
?>
