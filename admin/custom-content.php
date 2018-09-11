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
 * Array of pages object
 *
 * @since MCE 1.0
 */
function mce_list_pages( $type ){
	$args = array(
		'post_type'			=> $type,
		'posts_per_page'	=> -1,
		'orderby'			=> 'title',
		'post_status'		=> array( 'publish', 'private' ),
		'order'				=> 'ASC',
		'post_parent'		=> 0,
	);
	$sort = get_posts( $args );
	sort( $sort );
	return apply_filters( 'mce_admin_filter_list_pages', get_posts( $args ) );
}

/**
 * Custom Pages
 *
 * @since MCE 1.0
 */
function mce_custom_pages(){
	$pages = array(
		'page_blog'	=> array(
			'value'			=> 'page_blog',
			'label'			=> __( 'Page Blog', 'mce' ),
			'public_label'	=> __( 'Blog', 'mce' ),
			'user_menu'		=> '',
			'type'			=> 'page',
		),
		'page_history'	=> array(
			'value'			=> 'page_history',
			'label'			=> __( 'Page History', 'mce' ),
			'public_label'	=> __( 'History', 'mce' ),
			'user_menu'		=> '',
			'type'			=> 'page',
		),
		'page_chronicles'	=> array(
			'value'			=> 'page_chronicles',
			'label'			=> __( 'Page Chronicles', 'mce' ),
			'public_label'	=> __( 'Chronicles', 'mce' ),
			'user_menu'		=> '',
			'type'			=> 'page',
		),
		'page_groups'	=> array(
			'value'			=> 'page_groups',
			'label'			=> __( 'Page Groups', 'mce' ),
			'public_label'	=> __( 'Groups', 'mce' ),
			'user_menu'		=> '',
			'type'			=> 'page',
		),
		'page_galleries'	=> array(
			'value'			=> 'page_galleries',
			'label'			=> __( 'Page Galleries', 'mce' ),
			'public_label'	=> __( 'Galleries', 'mce' ),
			'user_menu'		=> '',
			'type'			=> 'page',
		),
		'page_routes'	=> array(
			'value'			=> 'page_routes',
			'label'			=> __( 'Page Routes', 'mce' ),
			'public_label'	=> __( 'Routes', 'mce' ),
			'user_menu'		=> '',
			'type'			=> 'page',
		),
		'page_contact'	=> array(
			'value'			=> 'page_contact',
			'label'			=> __( 'Page Contact', 'mce' ),
			'public_label'	=> __( 'Contact', 'mce' ),
			'user_menu'		=> '',
			'type'			=> 'page',
		),
		'page_faq'	=> array(
			'value'			=> 'page_faq',
			'label'			=> __( 'Page FAQ', 'mce' ),
			'public_label'	=> __( 'FAQ', 'mce' ),
			'user_menu'		=> '',
			'type'			=> 'page',
		),
	);
	return apply_filters( 'mce_admin_filter_custom_pages', $pages );
}

/**
 * Array of terms object
 * @param $tax  	string|array. Taxonomy
 *
 * @since MCE 1.1
 */
function mce_list_terms( $tax ){
	$args = array(
		'orderby'		=> 'name',
		'order'			=> 'DESC',
		'hide_empty'	=> false,
	);
	$sort = get_terms( $tax, $args );
	sort( $sort );
	return apply_filters( 'mce_admin_filter_list_terms', $sort );
}

/**
 * Custom Terms
 *
 * @since MCE 1.1
 */
function mce_custom_terms(){
	$custom_terms = array(
		'term_degree_easy'	=> array(
			'value'			=> 'term_degree_easy',
			'label'			=> __( 'Term Degree Easy', 'mce' ),
			'public_label'	=> __( 'Easy', 'mce' ),
			'tax'			=> 'degree',
		),
		'term_degree_middle'	=> array(
			'value'			=> 'term_degree_middle',
			'label'			=> __( 'Term Degree Middle', 'mce' ),
			'public_label'	=> __( 'Middle', 'mce' ),
			'tax'			=> 'degree',
		),
		'term_degree_difficult'	=> array(
			'value'			=> 'term_degree_difficult',
			'label'			=> __( 'Term Degree Difficult', 'mce' ),
			'public_label'	=> __( 'Difficult', 'mce' ),
			'tax'			=> 'degree',
		),
		'term_degree_extreme'	=> array(
			'value'			=> 'term_degree_extreme',
			'label'			=> __( 'Term Degree Extreme', 'mce' ),
			'public_label'	=> __( 'Extreme', 'mce' ),
			'tax'			=> 'degree',
		),
	);
	return apply_filters( 'mce_admin_filter_custom_terms', $custom_terms );
}

/**
 * Render custom content panel
 *
 * @since MCE 1.0
 */
function mce_setting_fields_custom_pages(){

?>
	<h2><?php _e( 'Custom Pages', 'mce' ) ?></h2>
<?php
	foreach ( mce_custom_pages() as $page ) :
?>
	<div class="text-option custom-pages">
		<label class="">
			<span><?php echo $page['label']; ?></span>
			<select name="t_em_theme_options[<?php echo $page['value'] ?>]">
				<option value="0"><?php _e( '&mdash; Select &mdash;', 'mce' ); ?></option>
				<?php foreach ( mce_list_pages( $page['type'] ) as $list ) : ?>
					<?php $selected = selected( t_em( $page['value'] ), $list->ID, false ); ?>
					<option value="<?php echo $list->ID ?>" <?php echo $selected; ?>><?php echo $list->post_title ?></option>
					<?php
						$args = array(
							'post_type'			=> $page['type'],
							'posts_per_page'	=> -1,
							'orderby'			=> 'title',
							'post_status'		=> array( 'publish', 'private' ),
							'order'				=> 'ASC',
							'post_parent'		=> $list->ID,
						);
						$sort_child = get_posts( $args );
						sort( $sort_child );
						foreach ( $sort_child as $child ) :
							$selected = selected( t_em( $page['value'] ), $child->ID, false );
					?>
						<option value="<?php echo $child->ID ?>" <?php echo $selected; ?>> &mdash; <?php echo $child->post_title ?></option>
					<?php
						endforeach;
					?>
				<?php endforeach; ?>
			</select>
		</label>
		<?php if ( t_em( $page['value'] ) ) : ?>
			<div class="row-action">
				<span class="edit"><a href="<?php echo get_edit_post_link( t_em( $page['value'] ) ) ?>"><?php _e( 'Edit', 'mce' ) ?></a> | </span>
				<span class="view"><a href="<?php echo get_permalink( t_em( $page['value'] ) ) ?>"><?php _e( 'View', 'mce' ) ?></a></span>
			</div>
		<?php endif; ?>
	</div>
<?php
	endforeach;
?>
	<h2><?php _e( 'Custom Terms', 'mce' ) ?></h2>
<?php
	foreach ( mce_custom_terms() as $term ) :
?>
	<div class="text-option custom-pages">
		<label class="">
			<span><?php echo $term['label']; ?></span>
			<select name="t_em_theme_options[<?php echo $term['value'] ?>]">
				<option value="0"><?php _e( '&mdash; Select &mdash;', 'mce' ); ?></option>
				<?php foreach ( mce_list_terms( $term['tax'] ) as $list ) :
				?>
					<?php $selected = selected( t_em( $term['value'] ), $list->term_id, false ); ?>
					<option value="<?php echo $list->term_id ?>" <?php echo $selected; ?>><?php echo $list->name ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<?php if ( t_em( $term['value'] ) ) : ?>
			<div class="row-action">
				<span class="edit"><a href="<?php echo get_edit_term_link( t_em( $term['value'] ) ) ?>"><?php _e( 'Edit', 'mce' ) ?></a> | </span>
				<span class="view"><a href="<?php echo get_term_link( intval( t_em( $term['value'] ) ) ) ?>"><?php _e( 'View', 'mce' ) ?></a></span>
			</div>
		<?php endif; ?>
	</div>
<?php
	endforeach;
}
?>
