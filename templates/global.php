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
 * Single post header
 *
 * @since MCE 1.0
 */
function mce_hero_header(){
	if ( is_home() || is_404() )
		return;

	if ( is_singular() ) :
		$id 			= get_the_ID();
		$thumbnail_id 	= get_post_meta( get_the_ID(), '_thumbnail_id', true );
		$thumbnail_url	= ( $thumbnail_id ) ? t_em_image_resize( 2048, 1152, $thumbnail_id, false ) : null;
		$title 			= get_the_title();
		$style			= ( $thumbnail_id ) ? 'background-image:url('. $thumbnail_url .');' : null;
		$classes		= ( $thumbnail_id ) ? 'bg-full hero-singular' : 'bg-empty hero-singular';
		$excerpt 		= ( get_post_field( 'post_excerpt' ) ) ? '<div class="lead px-7">'. t_em_wrap_paragraph( get_post_field( 'post_excerpt' ) ) .'</div>' : null;
	elseif ( is_category() || is_tag() || is_tax() ) :
		$obj			= get_queried_object();
		$id 			= $obj->term_id;
		$labels			= get_taxonomy( $obj->taxonomy );
		$title 			= '<small class="h3 d-block">'. $labels->labels->singular_name .'</small> '. single_term_title( '', false );
		$style			= null;
		$classes 		= 'bg-empty hero-tax';
		$excerpt 		= ( $obj->description ) ? '<div class="lead px-7">'. t_em_wrap_paragraph( $obj->description ) .'</div>' : null;
	elseif ( is_date() ) :
		if ( is_day() ) :
			$date 	= __( 'Day', 'mce' );
			$format	= null;
			$id 	= 'day';
		elseif ( is_month() ) :
			$date 	= __( 'Month', 'mce' );
			$format	= 'F Y';
			$id 	= 'month';
		elseif ( is_year() ) :
			$date 	= __( 'Year', 'mce' );
			$format	= 'Y';
			$id 	= 'year';
		endif;
		$title 			= '<small class="h3 d-block">'. $date .'</small> '. get_the_date( $format );
		$style			= null;
		$classes 		= 'bg-empty hero-date';
		$excerpt 		= null;
	elseif ( is_author() ) :
		$id 			= get_the_author_meta( 'user_login' );
		$title 			= '<small class="h3 d-block">'. __( 'Author', 'mce' ) .'</small> '. get_the_author();
		$style			= null;
		$classes 		= 'bg-empty hero-author';
		$excerpt 		= ( get_the_author_meta( 'description' ) ) ? '<div class="lead px-7">'. t_em_wrap_paragraph( get_the_author_meta( 'description' ) ) .'</div>' : null;
	elseif ( is_search() ) :
		$id 			= 'search';
		$title 			= '<small class="h3 d-block">'. __( 'Search Results for', 'mce' ) .'</small> '. get_search_query();
		$style			= null;
		$classes 		= 'bg-empty hero-search';
		$excerpt 		= null;
	endif;
?>
	<div id="header-<?php echo $id ?>" class="hero-header text-light d-flex align-items-center <?php echo $classes ?>" style="<?php echo $style ?>">
		<div class="<?php t_em_container() ?> text-center">
			<header class="py-7">
				<h1 class="display-3"><?php echo $title ?></h1>
				<?php echo $excerpt ?>
			</header>
			<?php if ( is_singular() && ! is_page() ) : ?>
			<div class="text-center h3">
				<a href="<?php echo wp_get_shortlink() ?>">
					<i class="icomoon-link ml-2"></i>
				</a>
				<a href="#respond" class="scroll-to" data-target="#respond">
					<i class="icomoon-chat ml-2"></i>
				</a>
				<a href="<?php echo $thumbnail_url ?>" data-fancybox data-caption="<?php the_title() ?>">
					<i class="icomoon-eye ml-2"></i>
				</a>
			</div>
		<?php endif; ?>
		</div>
	</div>
<?php
}
add_action( 't_em_action_header', 'mce_hero_header' );

/**
 * Go to top
 *
 * @since MCE 1.0
 */
function mce_go_top(){
	echo '<div id="gototop" class="btn scroll-to" data-target="html"><i class="icomoon-chevron-thin-up"></i><span class="text-hide">'. __( 'Go to top', 'mce' ) .'</span></div>';
}
add_action( 'wp_footer', 'mce_go_top' );
?>
