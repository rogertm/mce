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
 * Get post data and related posts
 * @param int 		$post_id. Post ID
 * @return array 	Array of related entries
 *
 * @since MCE 1.0
 */
function mce_get_post_data( $post_id ){
	// Data fields
	$fields 	= mce_post_data_fields();
	$data__in	= array();

	foreach ( $fields as $key => $value ) :
		$data = ( get_post_meta( $post_id, $value['meta'], true ) ) ? get_post_meta( $post_id, $value['meta'], true ) : array();
		$data__in = array_merge_recursive( $data__in, $data );
	endforeach;

	// Same CPT
	$post_type 	= get_post_type( $post_id );
	$link__in	= array();
	$type__in	= array();

	if ( $post_type != 'post' ) :
		$type_args = array(
			'post_type'			=> $post_type,
			'posts_per_page'	=> -1,
			'post__not_in'		=> array( $post_id ),
			'post_status'		=> 'publish',
			'meta_key'			=> '_thumbnail_id',
		);

		$types = get_posts( $type_args );

		// Same CPT
		foreach ( $types as $type ) :
			$type__in = array_merge( $type__in, array( $type->ID ) );
		endforeach;

		// Push the meta
		foreach ( $fields as $key => $value ) :
			$data = ( get_post_meta( $post_id, 'mce_'. $value['post-type'] .'_posts', true ) ) ? get_post_meta( $post_id, 'mce_'. $value['post-type'] .'_posts', true ) : array();
			$link__in = array_merge( $link__in, $data );
		endforeach;
	endif;

	// Related Post
	$taxed__in = array();
	$post_args = array(
		'post_type'			=> 'post',
		'posts_per_page'	=> -1,
		'post__not_in'		=> array( $post_id ),
		'post_status'		=> 'publish',
		'meta_key'			=> '_thumbnail_id',
		'tax_query'			=> array(
			'relation'		=> 'OR',
		),
	);

	$taxonomies = get_taxonomies( array( 'public' => true ), 'object' );
	$taxonomy = array();
	foreach ( $taxonomies as $key => $value ) :
		if ( in_array( $post_type, $value->object_type ) ) :
			array_push( $taxonomy, $key );
		endif;
	endforeach;
	if ( $taxonomy ) :
		foreach ( $taxonomy as $tax ) :
			$terms = get_the_terms( $post_id, $tax );
			if ( ! $terms ) continue;
			$terms_ids = array();
			foreach ( $terms as $term ) :
				array_push( $terms_ids, $term->term_id );
			endforeach;
			$key = array(
				'taxonomy'	=> $tax,
				'field'		=> 'id',
				'terms'		=> $terms_ids,
			);
			array_push( $post_args['tax_query'], $key );
		endforeach;
	endif;

	$taxed = get_posts( $post_args );
	foreach ( $taxed as $p ) :
		$taxed__in = array_merge( $taxed__in, array( $p->ID ) );
	endforeach;

	// Empty Posts
	$empty_args = array(
		'post_type'			=> 'post',
		'posts_per_page'	=> -1,
		'post__not_in'		=> array( $post_id ),
		'post_status'		=> 'publish',
		'meta_key'			=> '_thumbnail_id',
	);
	$empty_posts = get_posts( $empty_args );
	$empty__in = array();
	foreach ( $empty_posts as $p ) :
		$empty__in = array_merge( $empty__in, array( $p->ID ) );
	endforeach;

	$posts = array_merge( $data__in, $link__in, $type__in, $taxed__in, $empty__in );
	$posts = array_unique( $posts );

	// Return only six posts
	return array_slice( $posts, 0, 6 );
}

/**
 * Post Data Fields
 * @return array 	Array of fields
 *
 * @since MCE 1.0
 */
function mce_post_data_fields(){
	$fields = array(
		'groups'		=> array(
			'label'		=> __( 'Groups', 'mce' ),
			'meta'		=> 'mce_post_groups',
			'post-type'	=> 'mce-group',
			'type'		=> 'select',
		),
		'routes'		=> array(
			'label'		=> __( 'Routes', 'mce' ),
			'meta'		=> 'mce_post_routes',
			'post-type'	=> 'mce-route',
			'type'		=> 'select',
		),
		'galleries'		=> array(
			'label'		=> __( 'Galleries', 'mce' ),
			'meta'		=> 'mce_post_galleries',
			'post-type'	=> 'mce-gallery',
			'type'		=> 'select',
		),
	);
	return apply_filters( 'mce_filter_post_data_fields', $fields );
}

/**
 * Post Data Callback
 *
 * @since MCE 1.0
 */
function mce_post_data_callback( $post ){
	wp_nonce_field( 'mce_post_attr', 'mce_post_field' );
	$fields = mce_post_data_fields();

	foreach( $fields as $key => $value ) :
		$meta = ( get_post_meta( $post->ID, $value['meta'], true ) ) ? get_post_meta( $post->ID, $value['meta'], true ) : array( 0 );
		$args = array(
			'post_type'			=> $value['post-type'],
			'posts_per_page'	=> -1,
			'post_status'		=> 'any',
		);
		$entries = get_posts( $args );
?>
	<h4><?php printf( __( 'Attach %s to this post', 'mce' ), $value['label'] ) ?></h4>
	<select name="<?php echo $value['meta'] ?>[]" class="select-box" multiple="multiple" style="width:100%">
		<optgroup label="<?php printf( __( '&mdash; Select %s &mdash;', 'mce' ), $value['label'] ) ?>"></optgroup>
<?php 	foreach( $entries as $entry ) :
			$selected = ( in_array( $entry->ID, $meta ) ) ? 'selected' : null;
?>
		<option value="<?php echo $entry->ID ?>" <?php echo $selected ?>><?php echo $entry->post_title ?></option>
<?php 	endforeach; ?>
	</select>
<?php
	endforeach;
}

/**
 * Save the Post Data
 *
 * @since MCE 1.0
 */
function mce_save_post_data( $post_id ){
	// Check if the current user is authorized to do this action.
	if ( ! current_user_can( 'edit_posts' ) )
		return;
	// Check if the user intended to change this value.
	if ( ! isset( $_POST['mce_post_field'] ) || ! wp_verify_nonce( $_POST['mce_post_field'], 'mce_post_attr' ) )
		return;
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;

	// Save the values to the DB
	$fields = mce_post_data_fields();
	foreach ( $fields as $key => $value ) :
		if ( isset( $_POST[$value['meta']] ) ) :
			/**
			 * @TODO: Make this to work properly
			 * When $meta result array ( [0] => 123 ) this does not work
			 */
			$meta = get_post_meta( $post_id, $value['meta'], true );
			foreach ( $meta as $data ) :
				if ( ! in_array( $data, $_POST[$value['meta']] ) ) :
					$links = get_post_meta( $data, 'mce_'. $value['post-type'] .'_posts', true );
					$linked = array();
					foreach ( $links as $link ) :
						if ( $link != $post_id ) :
							array_push( $linked, $link );
						endif;
					endforeach;
					update_post_meta( $data, 'mce_'. $value['post-type'] .'_posts', $linked );
					if ( empty( get_post_meta( $data, 'mce_'. $value['post-type'] .'_posts', true ) ) ) :
						delete_post_meta( $data, 'mce_'. $value['post-type'] .'_posts' );
					endif;
				endif;
			endforeach;
			/**
			 * @ENDTODO
			 */

			$new_data = array();
			foreach( $_POST[$value['meta']] as $data ) :
				array_push( $new_data, $data );
				$new_meta = ( get_post_meta( $data, 'mce_'. $value['post-type'] .'_posts', true ) ) ? get_post_meta( $data, 'mce_'. $value['post-type'] .'_posts', true ) : array();
				if ( ! in_array( $post_id, $new_meta ) ) :
					array_push( $new_meta, $post_id );
					update_post_meta( $data, 'mce_'. $value['post-type'] .'_posts', $new_meta );
				endif;
			endforeach;
			update_post_meta( $post_id, $value['meta'], $new_data );
		else :
			delete_post_meta( $post_id, $value['meta'] );
		endif;
	endforeach;
}
add_action( 'save_post', 'mce_save_post_data' );
?>
