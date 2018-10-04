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
 * Custom Loop
 */
?>
<?php
	$pages	= mce_custom_pages();
	$tax	= array();
	$type	= array();
	foreach ( $pages as $key => $value ) :
		if ( is_page( t_em( $value['value'] ) ) ) :
			array_push( $type, $value['post_type'] );
			if ( $value['tax'] ) :
				array_push( $tax, t_em( $value['tax'] ) );
			endif;
		endif;
	endforeach;

	// Query for Custom Loop
	$args = array(
		'post_type'			=> $type,
		'posts_per_page'	=> get_option( 'posts_per_page' ),
		'paged'				=> get_query_var( 'paged' ),
	);

	if ( $tax ) :
		$term = get_term( $tax[0] );
		$tax_args = array(
			'tax_query'	=> array(
				array(
					'taxonomy'	=> $term->taxonomy,
					'field'		=> 'id',
					'terms'		=> $term->term_id,
				),
			),
		);
		$args = array_merge( $args, array_slice( $tax_args, -1 ) );
	endif;

	$the_query 	= new WP_Query ( $args );
	$content 	= ( t_em( 'archive_in_columns' ) == 1 && t_em( 'excerpt_set' ) != 'thumbnail-center' ) ? 'excerpt' : 'columns';
	$cols 		= ( t_em( 'archive_in_columns' ) > 1 || t_em( 'excerpt_set' ) == 'thumbnail-center' ) ? true : null;

	if ( $the_query->have_posts() ) :
		if ( $cols ) :
			echo '<div class="row">';
			$i = 0;
		endif;

		while ( $the_query->have_posts() ) :
			$the_query->the_post();
			if ( $cols && 0 == $i % t_em( 'archive_in_columns' ) ) :
				echo '</div>';
				echo '<div class="row">';
			endif;
			get_template_part( '/template-parts/content', $content );
			if ( $cols ) :
				$i++;
			endif;
		endwhile;

		if ( $cols ) :
			echo '</div>';
		endif;
	else :
		get_template_part( '/template-parts/content', 'none' );
	endif;
	wp_reset_postdata();
	t_em_page_navi( $the_query );
?>
