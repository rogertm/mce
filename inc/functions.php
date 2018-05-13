<?php
/**
 * MCE
 *
 * @package			WordPress
 * @subpackage		MCE
 * @author			RogerTM
 * @license			license.txt
 * @link			https://themingisprose.com/twenty-em
 * @since 			MCE 1.0
 */

/**
 * MCE Setup
 *
 * @since MCE 1.0
 */
function mce_setup(){
	// Make MCE available for translation.
	load_child_theme_textdomain( 'mce', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'mce_setup' );
?>
