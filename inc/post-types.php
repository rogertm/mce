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

	// Register Custom Taxonomies
	$taxonomies = array(
		'degree'	=> array(
			'post_type'				=> array( 'route' ),
			'singular'				=> _x( 'Degree of Difficulty', 'taxonomy singular name', 'mce' ),
			'plural'				=> _x( 'Degrees of Difficulty', 'taxonomy general name', 'mce' ),
			'hierarchical'			=> true,
			'show_ui'				=> true,
			'show_admin_column'		=> true,
			'update_count_callback'	=> '_update_post_term_count',
			'query_var'				=> true,
			'rewrite'				=> array( 'slug' => 'route-degree' ),
		),
	);

	foreach ( $taxonomies as $taxonomy => $tax ) :
		$labels = array(
			'name'					=> $tax['plural'],
			'singular_name'			=> $tax['singular'],
			'search_items'			=> sprintf( __( 'Search %s', 'mce' ), $tax['plural'] ),
			'popular_items'			=> sprintf( __( 'Popular %s', 'mce' ), $tax['plural'] ),
			'all_items'				=> sprintf( __( 'All %s', 'mce' ), $tax['plural'] ),
			'parent_item'			=> sprintf( __( 'Parent %s', 'mce' ), $tax['plural'] ),
			'parent_item_colon'		=> sprintf( __( 'Parent %s', 'mce' ), $tax['plural'] ),
			'edit_item'				=> sprintf( __( 'Edit %s', 'mce' ), $tax['plural'] ),
			'update_item'			=> sprintf( __( 'Update %s', 'mce' ), $tax['singular'] ),
			'view_item'				=> sprintf( __( 'View %s', 'mce' ), $tax['singular'] ),
			'add_new_item'			=> sprintf( __( 'Add New %s', 'mce' ), $tax['singular'] ),
			'new_item_name'			=> sprintf( __( 'New %s name', 'mce' ), $tax['singular'] ),
			'not_found'				=> sprintf( __( 'No %s found', 'mce' ), $tax['plural'] ),
			'menu_name'				=> $tax['plural'],
		);

		$args = array(
			'hierarchical'				=> $tax['hierarchical'],
			'labels'					=> $labels,
			'show_ui'					=> $tax['show_ui'],
			'show_admin_column'			=> $tax['show_admin_column'],
			'update_count_callback'		=> $tax['update_count_callback'],
			'query_var'					=> $tax['query_var'],
			'rewrite'					=> $tax['rewrite'],
		);

		register_taxonomy( $taxonomy, $tax['post_type'], $args );
	endforeach;;
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
