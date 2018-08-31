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
 * Register custom post types
 *
 * @since MCE 1.0
 */
function mce_post_types(){
	$post_types = array(
		'group'		=> array( 'post-type'		=> 'group',
							  'singular'		=> _x( 'Group', 'post type singular name', 'mce' ),
							  'plural'			=> _x( 'Groups', 'post type general name', 'mce' ),
							  'hierarchical'	=> false,
							  'supports'		=> array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'shortlinks' ),
							  'rewrite'			=> _x( 'group', 'post type slug', 'mce' ),
					),
		'route'		=> array( 'post-type'		=> 'route',
							  'singular'		=> _x( 'Route', 'post type singular name', 'mce' ),
							  'plural'			=> _x( 'Routes', 'post type general name', 'mce' ),
							  'hierarchical'	=> false,
							  'supports'		=> array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'shortlinks' ),
							  'rewrite'			=> _x( 'route', 'post type slug', 'mce' ),
					),
		'gallery'	=> array( 'post-type'		=> 'gallery',
						 	  'singular'		=> _x( 'Gallery', 'post type singular name', 'mce' ),
							  'plural'			=> _x( 'Galleries', 'post type general name', 'mce' ),
							  'hierarchical'	=> false,
							  'supports'		=> array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'shortlinks' ),
							  'rewrite'			=> _x( 'gallery', 'post type slug', 'mce' ),
					),
		'postcard'	=> array( 'post-type'		=> 'postcard',
						 	  'singular'		=> _x( 'Postcard', 'post type singular name', 'mce' ),
							  'plural'			=> _x( 'Postcards', 'post type general name', 'mce' ),
							  'hierarchical'	=> false,
							  'supports'		=> array( 'excerpt', 'thumbnail', 'revisions', 'shortlinks' ),
							  'rewrite'			=> _x( 'postcard', 'post type slug', 'mce' ),
					),
	);

	foreach ( $post_types as $post_type => $pt ) :
		$labels = array(
			'name'					=> $pt['plural'],
			'singular_name'			=> $pt['singular'],
			'manu_name'				=> $pt['plural'],
			'all_items'				=> sprintf( __( 'All %s', 'mce' ), $pt['plural'] ),
			'add_new'				=> __( 'Add new', 'mce' ),
			'add_new_item'			=> sprintf( __( 'Add new %s', 'mce' ), $pt['singular'] ),
			'edit_item'				=> sprintf( __( 'Edit %s', 'mce' ), $pt['singular'] ),
			'new_item'				=> sprintf( __( 'New %s', 'mce' ), $pt['singular'] ),
			'view_item'				=> sprintf( __( 'View %s', 'mce' ), $pt['singular'] ),
			'search_items'			=> sprintf( __( 'Search %s', 'mce' ), $pt['plural'] ),
			'not_found'				=> sprintf( __( 'No %s found', 'mce' ), $pt['singular'] ),
			'not_found_in_trash'	=> sprintf( __( 'No %s found in trash', 'mce' ), $pt['singular'] ),
			'parent_item_colon'		=> sprintf( __( 'Parent %s', 'mce' ), $pt['singular'] ),
		);

		$args = array(
			'labels'				=> $labels,
			'public'				=> true,
			'exclude_from_search'	=> ( $pt['post-type'] != 'postcard' ) ? false : true,
			'publicly_queryable'	=> ( $pt['post-type'] != 'postcard' ) ? true : false,
			'show_ui'				=> true,
			'show_in_nav_menus'		=> true,
			'show_in_menu'			=> true,
			'show_in_admin_bar'		=> true,
			'capability_type'		=> 'post',
			'hierarchical'			=> $pt['hierarchical'],
			'supports'				=> $pt['supports'],
			'has_archive'			=> ( $pt['post-type'] != 'postcard' ) ? true : false,
			'rewrite'				=> array( 'slug' => $pt['rewrite'] ),
			'query_var'				=> true,
			'can_export'			=> true,
		);

		register_post_type( $pt['post-type'], $args );
	endforeach;
}
add_action( 'init', 'mce_post_types' );

/**
 * Rewrite rules to get permalinks works when theme will be activated
 *
 * @since MCE 1.0
 */
function mce_rewrite_flush(){
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'mce_rewrite_flush' );
?>
