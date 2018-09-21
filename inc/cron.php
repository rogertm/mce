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
 * Chronicle schedule action hook
 *
 * @since MCE 1.0
 */
function mce_action_chronicle_schedule(){
	if ( ! wp_next_scheduled( 'mce_action_chronicle_schedule' ) ) :
		wp_schedule_event( current_time( 'timestamp' ), 'daily', 'mce_action_chronicle_schedule' );
	endif;
}
add_action( 'wp', 'mce_action_chronicle_schedule' );

/**
 * Set daily Chronicle
 *
 * @since MCE 1.0
 */
function mce_set_daily_chronicle(){
	$args = array(
		'post_type'			=> 'post',
		'cat'				=> t_em( 'term_cat_chronicles' ),
		'posts_per_page'	=> 1,
		'orderby'			=> 'rand',
		'meta_query'		=> array(
			array(
				'key'		=> '_thumbnail_id',
			),
		),
	);
	$chronicle = get_posts( $args );
	$chronicle = $chronicle[0]->ID;
	update_option( 'mce_daily_chronicle', $chronicle );
}
add_action( 'mce_action_chronicle_schedule', 'mce_set_daily_chronicle' );
?>
