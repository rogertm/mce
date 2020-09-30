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
 * Enqueue and register all css and js
 *
 * @since MCE 1.0
 */
function mce_enqueue(){
	wp_register_style( 'mce', t_em_get_css( 'theme', T_EM_CHILD_THEME_DIR_PATH .'/assets/dist/css', T_EM_CHILD_THEME_DIR_URL .'/assets/dist/css' ), '', t_em_theme( 'Version' ), 'all' );
	wp_enqueue_style( 'mce' );
	wp_register_script( 'child-app-utils', t_em_get_js( 'app.utils', T_EM_CHILD_THEME_DIR_PATH .'/assets/dist/js', T_EM_CHILD_THEME_DIR_URL .'/assets/dist/js' ), array( 'jquery' ), t_em_theme( 'Version' ), true );
	wp_enqueue_script( 'child-app-utils' );

	// Fancybox
/*	wp_register_style( 'jquery.fancybox', t_em_get_css( 'jquery.fancybox', T_EM_CHILD_THEME_DIR_PATH .'/node_modules/@fancyapps/fancybox/dist', T_EM_CHILD_THEME_DIR_URL .'/node_modules/@fancyapps/fancybox/dist' ), '', t_em_theme( 'Version' ), 'all' );
	wp_enqueue_style( 'jquery.fancybox' );
	wp_register_script( 'jquery.fancybox', t_em_get_js( 'jquery.fancybox', T_EM_CHILD_THEME_DIR_PATH .'/node_modules/@fancyapps/fancybox/dist', T_EM_CHILD_THEME_DIR_URL .'/node_modules/@fancyapps/fancybox/dist' ), array( 'jquery' ), t_em_theme( 'Version' ), true );
	wp_enqueue_script( 'jquery.fancybox' );*/

	// Scrollto
	wp_register_script( 'jquery.scrollTo', t_em_get_js( 'jquery.scrollTo', T_EM_CHILD_THEME_DIR_PATH .'/node_modules/jquery.scrollto', T_EM_CHILD_THEME_DIR_URL .'/node_modules/jquery.scrollto' ), array( 'jquery' ), t_em_theme( 'Version' ), true );
	wp_enqueue_script( 'jquery.scrollTo' );
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
