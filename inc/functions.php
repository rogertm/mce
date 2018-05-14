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
 * MCE Setup
 *
 * @since MCE 1.0
 */
function mce_setup(){
	// Make MCE available for translation.
	load_child_theme_textdomain( 'mce', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'mce_setup' );

/**
 * Keep an eye on revisions 8)
 *
 * @since MCE 1.0
 */
function mce_posts_revisions( $num, $post ){
	return 1;
}
add_filter( 'wp_revisions_to_keep', 'mce_posts_revisions', 10, 2 );
?>
