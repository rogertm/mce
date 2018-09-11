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

	$term = t_em( 'term_cat_chronicles' );
	$args = array(
		'post_type'			=> 'post',
		'posts_per_page'	=> 1,
		'cat'				=> $term,
		'orderby'			=> 'rand',
		'meta_query'		=> array(
			array(
				'key'		=> '_thumbnail_id',
			),
		),
	);
	$chronicles				= get_posts( $args );

	if ( ! $chronicles )
		return;

	$chronicle 		= $chronicles[0];
	$id				= $chronicle->ID;
	$thumbnail_id	= get_post_meta( $id, '_thumbnail_id', true );
	$thumbnail_url	= wp_get_attachment_url( $thumbnail_id );
?>
	<section id="chronicle-<?php echo $id ?>" class="chronicle card">
		<img src="<?php echo $thumbnail_url ?>" class="card-img" alt="<?php echo $chronicle->post_title ?>">
		<div class="chronicle-body card-img-overlay d-flex align-items-center <?php t_em_container() ?>">
			<blockquote class="blockquote card-body"><h3 class="h1"><?php echo $chronicle->post_title ?></h3></blockquote>
		</div>
	</section>
<?php
}
add_action( 't_em_action_main_after', 'mce_front_page_chronicle' );
?>
