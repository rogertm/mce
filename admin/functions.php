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

	wp_register_style( 'select2', t_em_get_css( 'select2', T_EM_CHILD_THEME_DIR_PATH .'/node_modules/select2/dist/css', T_EM_CHILD_THEME_DIR_URL .'/node_modules/select2/dist/css' ) );
	wp_enqueue_style( 'select2' );
	wp_register_script( 'select2', t_em_get_js( 'select2', T_EM_CHILD_THEME_DIR_PATH .'/node_modules/select2/dist/js', T_EM_CHILD_THEME_DIR_URL .'/node_modules/select2/dist/js' ), array( 'jquery' ), t_em_theme( 'Version' ), true );
	wp_enqueue_script( 'select2' );
	wp_register_script( 'admin', t_em_get_js( 'admin', T_EM_CHILD_THEME_DIR_PATH .'/admin', T_EM_CHILD_THEME_DIR_URL .'/admin' ), array( 'jquery' ), t_em_theme( 'Version' ), true );
	wp_enqueue_script( 'admin' );
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
// add_filter( 't_em_admin_filter_theme_options_validate', 'mce_theme_options_validate' );

/**
 * Add social networks options
 */
function mce_social_network_options(){
	$social = array(
		'twitter_set' => array(
			'name' => 'twitter_set',
			'label' => __( 'Twitter URL', 't_em' ),
			'item' => __( 'Twitter', 't_em' ),
			'svg' 	=> 'twitter.svg',
			'order' => '10',
		),
		'facebook_set' => array(
			'name' => 'facebook_set',
			'label' => __( 'Facebook URL', 't_em' ),
			'item' => __( 'Facebook', 't_em' ),
			'svg' 	=> 'facebook.svg',
			'order' => '20',
		),
		'whatsapp_set' => array(
			'name' => 'whatsapp_set',
			'label' => __( 'Whatsapp URL', 't_em' ),
			'item' => __( 'Whatsapp', 't_em' ),
			'svg' 	=> 'whatsapp.svg',
			'order' => '30',
		),
		'telegram_set' => array(
			'name' => 'telegram_set',
			'label' => __( 'Telegram URL', 't_em' ),
			'item' => __( 'Telegram', 't_em' ),
			'svg' 	=> 'telegram.svg',
			'order' => '40',
		),
		'youtube_set' => array(
			'name' => 'youtube_set',
			'label' => __( 'YouTube URL', 't_em' ),
			'item' => __( 'YouTube', 't_em' ),
			'svg' 	=> 'youtube.svg',
			'order' => '50',
		),
		'instagram_set' => array(
			'name' => 'instagram_set',
			'label' => __( 'Instagram URL', 't_em' ),
			'item' => __( 'Instagram', 't_em' ),
			'svg' 	=> 'instagram.svg',
			'order' => '60',
		),
	);

	return $social;
}
add_filter( 't_em_admin_filter_social_network_options', 'mce_social_network_options' );
?>
