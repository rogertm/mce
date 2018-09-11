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
 * Routes section at front page
 *
 * @since MCE 1.0
 */
function mce_front_page_routes(){
	$routes = mce_custom_terms();
	$terms = array();
	foreach ( $routes as $key => $value ) :
		if ( $value['tax'] == 'degree' && t_em( $value['value'] ) ) :
			array_push( $terms, t_em( $value['value'] ) );
			$cols = 12 / count( $terms );
		endif;
	endforeach;
	$cols = 12 / count( $terms );
	$page = t_em( 'page_routes' );
?>
	<section id="rountes" class="routes my-5">
		<h3 class="text-center"><?php echo get_the_title( $page ) ?></h3>
		<div class="row">
		<?php
		foreach ( $terms as $term ) :
			$data = get_term( $term, 'degree' );
		?>
			<div class="<?php echo t_em_grid( $cols ) ?> text-center">
				<h4 class="h5"><?php echo $data->name ?></h4>
				<?php echo t_em_wrap_paragraph( $data->description ) ?>
				<p><a href="<?php echo get_term_link( $data->term_id ) ?>" class="btn btn-sm btn-secondary"><?php _e( 'Read more', 'mce' ) ?></a></p>
			</div>
		<?php
		endforeach;
		?>
		</div>
	</section>
<?php
}
add_action( 't_em_action_custom_front_page_after', 'mce_front_page_routes' );
?>
