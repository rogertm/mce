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
 * Register Setting
 * @link http://codex.wordpress.org/Settings_API
 *
 * @since MCE 1.0
 */
function mce_register_setting_init(){
	add_settings_field( 'mce_custom_pages', __( 'Custom Content', 'mce' ), 'mce_setting_fields_custom_pages', 'twenty-em-options', 'twenty-em-section' );
}
add_action( 't_em_admin_action_add_settings_field', 'mce_register_setting_init' );

/**
 * Enqueue styles and scripts
 *
 * @since MCE 1.0
 */
function mce_admin_enqueue(){
	$screen = get_current_screen();
	if ( $screen->id == 'toplevel_page_twenty-em-options' ):
		wp_register_style( 'style-admin', T_EM_CHILD_THEME_DIR_URL.'/admin/admin.css', false, t_em_theme( 'Version' ), 'all' );
		wp_enqueue_style( 'style-admin' );
	endif;
}
add_action( 'admin_enqueue_scripts', 'mce_admin_enqueue' );

/**
 * Merge into default theme options
 * This function is attached to the "t_em_admin_filter_default_theme_options" filter hook
 * @return array 	Array of options
 *
 * @since MCE 1.0
 */
function mce_default_theme_options( $default_theme_options ){
	$mce_default_options = array();

	// Get custom pages from the original function
	foreach ( mce_custom_pages() as $pages => $value ) :
		$key = array( $value['value'] => '' );
		$mce_default_options = array_merge( $mce_default_options, array_slice( $key, -1 ) );
	endforeach;

	// Get custom terms from the original function
	foreach ( mce_custom_terms() as $terms => $value ) :
		$key = array( $value['value'] => '' );
		$mce_default_options = array_merge( $mce_default_options, array_slice( $key, -1 ) );
	endforeach;

	$default_options = array_merge( $default_theme_options, $mce_default_options );

	return $default_options;
}
add_filter( 't_em_admin_filter_default_theme_options', 'mce_default_theme_options' );

/**
 * Sanitize and validate the input.
 * This function is attached to the "t_em_admin_filter_theme_options_validate" filter hook
 * @param $input array  Array of options to validate
 * @return array
 *
 * @since MCE 1.0
 */
function mce_theme_options_validate( $input ){
	if ( ! $input )
		return;

	// Let's go for pages
	$pages = mce_custom_pages();
	foreach ( $pages as $key => $value ) :
		if ( array_key_exists( $input[$key['value']], $pages ) ) :
			$input[$key] = $input[$key['value']];
		endif;
	endforeach;

	// Let's go for terms
	$terms = mce_custom_terms();
	foreach ( $terms as $key => $value ) :
		if ( array_key_exists( $input[$key['value']], $terms ) ) :
			$input[$key] = $input[$key['value']];
		endif;
	endforeach;

	return $input;
}
add_filter( 't_em_admin_filter_theme_options_validate', 'mce_theme_options_validate' );
?>
