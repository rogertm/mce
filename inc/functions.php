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

	// Removed Hooks
	remove_action( 't_em_action_post_inside_before', 't_em_single_post_thumbnail' );
	remove_action( 't_em_action_content_before', 't_em_custom_template_content', 15 );
}
add_action( 'after_setup_theme', 'mce_setup' );

/**
 * Init
 *
 * @since MCE 1.0
 */
function mce_init(){
	// Give page excerpt's support
	add_post_type_support( 'page', array( 'excerpt' ) );
}
add_action( 'init', 'mce_init' );

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
