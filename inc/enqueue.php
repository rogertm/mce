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
 * Enqueue and register all css and js
 *
 * @since MCE 1.0
 */
function mce_enqueue(){
	wp_register_style( 'mce', t_em_get_css( 'theme', T_EM_CHILD_THEME_DIR_PATH .'/css', T_EM_CHILD_THEME_DIR_URL .'/css' ), '', t_em_theme( 'Version' ), 'all' );
	wp_enqueue_style( 'mce' );
}
add_action( 'wp_enqueue_scripts', 'mce_enqueue' );

/**
 * Dequeue styles form parent theme
 *
 * @since MCE 1.0
 */
function mce_dequeue(){
	wp_dequeue_style( 'twenty-em-style' );
	wp_deregister_style( 'twenty-em-style' );
}
add_action( 'wp_enqueue_scripts', 'mce_dequeue', 999 );
?>
