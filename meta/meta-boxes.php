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
 * Register meta boxes for post types
 *
 * @since MCE 1.0
 */
function mce_meta_boxes(){
	// Postcard
	add_meta_box( 'mce-postcard-data', __( 'Postcard Data' ), 'mce_postcard_data_callback', 'postcard', 'advanced', 'high' );
}
add_action( 'add_meta_boxes', 'mce_meta_boxes' );

/**
 * Includes
 */
require( get_stylesheet_directory() . '/meta/meta-postcard.php' );
?>
