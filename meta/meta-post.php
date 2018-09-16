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
 * Post Data Fields
 * @return array 	Array of fields
 *
 * @since MCE 1.0
 */
function mce_post_data_fields(){
	$fields = array(
		'groups'		=> array(
			'label'		=> __( 'Groups', 'mce' ),
			'meta'		=> 'post_groups',
			'post-type'	=> 'group',
			'type'		=> 'select',
		),
		'routes'		=> array(
			'label'		=> __( 'Routes', 'mce' ),
			'meta'		=> 'post_routes',
			'post-type'	=> 'route',
			'type'		=> 'select',
		),
		'galleries'		=> array(
			'label'		=> __( 'Galleries', 'mce' ),
			'meta'		=> 'post_galleries',
			'post-type'	=> 'gallery',
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
		<option value="<?php echo $entry->ID ?>" <?php echo $selected ?>><?php echo $entry->post_title ?> <?php echo $entry->ID ?></option>
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
			/*@TODO: Make this to work
			$meta = get_post_meta( $post_id, $value['meta'], true );
			foreach ( $meta as $data ) :
				if ( ! in_array( $data, $_POST[$value['meta']] ) ) :
					$links = get_post_meta( $data, $value['post-type'].'_posts', true );
					$linked = array();
					foreach ( $links as $link ) :
						if ( $link != $post_id ) :
							array_push( $linked, $link );
						endif;
					endforeach;
					update_post_meta( $data, $value['post-type'].'_posts', $linked );
					if ( empty( get_post_meta( $data, $value['post-type'].'_posts', true ) ) ) :
						delete_post_meta( $data, $value['post-type'].'_posts' );
					endif;
				endif;
			endforeach;*/

			$new_data = array();
			foreach( $_POST[$value['meta']] as $data ) :
				array_push( $new_data, $data );
				$new_meta = ( get_post_meta( $data, $value['post-type'].'_posts', true ) ) ? get_post_meta( $data, $value['post-type'].'_posts', true ) : array();
				if ( ! in_array( $post_id, $new_meta ) ) :
					array_push( $new_meta, $post_id );
					update_post_meta( $data, $value['post-type'].'_posts', $new_meta );
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
