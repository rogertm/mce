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
	if ( ! is_front_page() )
		return;

	$routes 	= mce_custom_terms();
	$degrees	= array();
	$zones		= array();
	foreach ( $routes as $key => $value ) :
		if ( $value['tax'] == 'degree' && t_em( $value['value'] ) ) :
			array_push( $degrees, t_em( $value['value'] ) );
		endif;
		if ( $value['tax'] == 'zone' && t_em( $value['value'] ) ) :
			array_push( $zones, t_em( $value['value'] ) );
		endif;
	endforeach;
	$cols_degree = 12 / count( $degrees );
	$cols_zone = 12 / count( $zones );
	$page = t_em( 'page_routes' );
?>
	<section id="rountes" class="route text-center mt-7 mb-0 py-7">
		<div class="<?php t_em_container() ?>">
			<h2 class="h1"><?php echo get_the_title( $page ) ?></h2>
			<div class="lead mx-10"><?php echo t_em_wrap_paragraph( t_em_get_post_excerpt( $page, false ) ) ?></div>
			<div class="row">
				<div class="<?php echo t_em_grid( 12 ) ?> mt-5"><h3 class="display-4"><?php _e( 'Difficult Degree', 'mce' ) ?></h3></div>
			<?php
			foreach ( $degrees as $term ) :
				$data = get_term( $term, 'degree' );
			?>
				<div class="<?php echo t_em_grid( $cols_degree ) ?> mt-5">
					<h4 class="h5"><?php echo $data->name ?></h4>
					<?php echo t_em_wrap_paragraph( $data->description ) ?>
					<p><a href="<?php echo get_term_link( $data->term_id ) ?>" class="btn btn-sm btn-secondary"><?php _e( 'Read more', 'mce' ) ?></a></p>
				</div>
			<?php
			endforeach;
			?>
				<div class="<?php echo t_em_grid( 12 ) ?> mt-5"><h3 class="display-4"><?php _e( 'Geographic Zone', 'mce' ) ?></h3></div>
			<?php
			foreach ( $zones as $term ) :
				$data = get_term( $term, 'zone' );
			?>
				<div class="<?php echo t_em_grid( $cols_zone ) ?> mt-5">
					<h4 class="h5"><?php echo $data->name ?></h4>
					<?php echo t_em_wrap_paragraph( $data->description ) ?>
					<p><a href="<?php echo get_term_link( $data->term_id ) ?>" class="btn btn-sm btn-secondary"><?php _e( 'Read more', 'mce' ) ?></a></p>
				</div>
			<?php
			endforeach;
			?>
			</div>
		</div>
	</section>
<?php
}
add_action( 't_em_action_main_after', 'mce_front_page_routes' );
?>
