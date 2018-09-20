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
	remove_action( 't_em_action_content_before', 't_em_header_archive_author_meta', 15 );
	remove_action( 't_em_action_content_before', 't_em_header_archive_taxonomy', 15 );
	remove_action( 't_em_action_content_before', 't_em_header_archive_date', 15 );
	remove_action( 't_em_action_content_before', 't_em_header_archive_search', 15 );
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

/**
 * Redirect post type archive
 *
 * @since MCE 1.0
 */
function mce_redirect(){
	$pages = mce_custom_pages();
	$dogo = array();
	foreach ( $pages as $key => $value ) :
		if ( $value['post_type'] ) :
			$args = array(
				'value'	=> $value['value'],
				'type'	=> $value['post_type'],
				'go'	=> t_em( $value['value'] ),
				'tax'	=> ( $value['tax'] ) ? t_em( $value['tax'] ) : null,
			);
			$go = array( $value['post_type'] => $args );
			$dogo = array_merge( $dogo, array_slice( $go, -1 ) );
		endif;
	endforeach;

	foreach ( $dogo as $key => $value ) :
		if ( is_post_type_archive( $value['type'] ) ) :
			wp_safe_redirect( get_permalink( $value['go'] ) );
		elseif ( is_category( t_em( 'term_cat_chronicles' ) ) ) :
			wp_safe_redirect( get_permalink( t_em( 'page_chronicles' ) ) );
		endif;
	endforeach;
}
add_action( 'template_redirect', 'mce_redirect' );
?>
