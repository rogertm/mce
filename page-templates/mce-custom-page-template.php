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
 * Template Name: MCE Custom Page
 */

get_header(); ?>

		<section id="main-content" <?php t_em_breakpoint( 'main-content' ); ?>>
			<section id="content" role="main" <?php t_em_breakpoint( 'content-one-column' ); ?>>
			<?php do_action( 't_em_action_content_before' ); ?>

			<?php
			$pages	= mce_custom_pages();
			$type	= array();
			foreach ( $pages as $key => $value ) :
				if ( is_page( t_em( $value['value'] ) ) ) :
					array_push( $type, $value['post_type'] );
				endif;
			endforeach;
			$loop 	= $type[0];
			get_template_part( '/loop/loop', $loop );
			?>

			<?php do_action( 't_em_action_content_after' ); ?>
			</section><!-- #content -->
		</section><!-- #main-content .rwo-fluid -->

<?php get_footer(); ?>
