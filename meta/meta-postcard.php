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
 * Postcard Data Fields
 * @return array 	Array of fields
 *
 * @since MCE 1.0
 */
function mce_postcard_data_fields(){
	$fields = array(
		'source'	=> array(
			'label'	=> __( 'Source or author', 'mce' ),
			'meta'	=> 'postcard_source',
			'type'	=> 'text',
		),
		'photo_by'	=> array(
			'label'	=> __( 'Photo by', 'mce' ),
			'meta'	=> 'postcard_photo_by',
			'type'	=> 'text',
		),
	);
	return apply_filters( 'mce_filter_postcard_data_fields', $fields );
}

/**
 * Postcard Data Callback
 *
 * @since MCE 1.0
 */
function mce_postcard_data_callback( $post ){
	wp_nonce_field( 'mce_postcard_attr', 'mce_postcard_field' );
	$fields = mce_postcard_data_fields();
	foreach ( $fields as $key => $value ) :
		echo '<label for="'. $value['meta'] .'"><h4>'. $value['label'] .'</h4></label>';
		$content = get_post_meta( $post->ID, $value['meta'], true );
		echo '<input id="'. $value['meta'] .'" type="'. $value['type'] .'" name="'. $value['meta'] .'" size="100" value="'. $content .'">';
	endforeach;
}

/**
 * Save the Postcard data
 *
 * @since MCE 1.0
 */
function mce_save_postcard_data( $post_id ){
	// Check if the current user is authorized to do this action.
	if ( ! current_user_can( 'edit_posts' ) )
		return;
	// Check if the user intended to change this value.
	if ( ! isset( $_POST['mce_postcard_field'] ) || ! wp_verify_nonce( $_POST['mce_postcard_field'], 'mce_postcard_attr' ) )
		return;
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;

	// Save the data
	$fields = mce_postcard_data_fields();
	foreach ( $fields as $key => $value ) :
		if ( isset( $_POST[$value['meta']] ) && ! empty( $_POST[$value['meta']] ) ) :
			$data = trim( $_POST[$value['meta']] );
			update_post_meta( $post_id, $value['meta'], $data );
		else :
			delete_post_meta( $post_id, $value['meta'] );
		endif;
	endforeach;

	// Avoiding infinite loop
	if ( ! wp_is_post_revision() ) :
		// unhook this function so it doesn't loop infinitely
		remove_action( 'save_post', 'mce_save_postcard_data' );
		// Set the Postcard Title
		$args = array(
			'ID'			=> $post_id,
			'post_title'	=> sprintf( _x( 'Postcard %s', 'Postcard title', 'mce' ), $post_id ),
			'post_name'		=> sanitize_title( sprintf( _x( 'Postcard %s', 'Postcard title', 'mce' ), $post_id ) ),
			'post_content'	=> trim( get_post_field( 'post_excerpt', $post_id ) ),
			'post_excerpt'	=> trim( get_post_field( 'post_excerpt', $post_id ) ),
		);
		wp_update_post( $args );

		// re-hook this function
		add_action( 'save_post', 'mce_save_postcard_data' );

	endif;
}
add_action( 'save_post', 'mce_save_postcard_data' );

/**
 * Add custom columns to Postcard screen
 *
 * @since MCE 1.0
 */
function mce_postcard_custom_columns( $custom_columns ){
	$custom_columns['content']		= __( 'Content', 'mce' );
	$custom_columns['thumbnail']	= __( 'Thumbnail', 'mce' );
	return $custom_columns;
}
add_action( 'manage_postcard_posts_columns', 'mce_postcard_custom_columns' );

/**
 * Add the content to Postcard custom columns
 *
 * @since MCE 1.0
 */
function mce_postcard_content_columns( $columns_name, $id ){
	if ( $columns_name == 'content' ) :
		echo t_em_wrap_paragraph( get_post_field( 'post_excerpt', $id ) );
	endif;
	if ( $columns_name == 'thumbnail' ) :
		if ( has_post_thumbnail( $id ) ) :
			echo get_the_post_thumbnail( $id, array( 75, 75 ) );
		endif;
	endif;
}
add_action( 'manage_postcard_posts_custom_column', 'mce_postcard_content_columns', 10, 2 );
?>
