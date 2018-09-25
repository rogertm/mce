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
 * Latests post at front page
 *
 * @since MCE 1.0
 */
function mce_latests_post(){
	global $template;
	if ( ! is_front_page() )
		return;

	$chronicle = t_em( 'term_cat_chronicles' );
	$args = array(
		'post_type'			=> 'post',
		'posts_per_page'	=> 3,
		'cat'				=> - $chronicle,
		'meta_query'		=> array(
			array(
				'key'		=> '_thumbnail_id',
			),
		)
	);
	$wp_query = new WP_Query( $args );
?>
	<section id="latest-posts" class="my-10">
		<div class="<?php t_em_container() ?>">
			<h2 class="text-center h1 mb-6"><?php _e( 'Latests Blog Entries', 'mce' ) ?></h2>
<?php
		if ( $wp_query->have_posts() ) :
			while ( $wp_query->have_posts() ) :
				$wp_query->the_post();
				$thumbnail_cols	= 6;
				$content_cols	= 12 - $thumbnail_cols;
				$thumbnail_grid	= ( has_post_thumbnail() ) ? t_em_grid( $thumbnail_cols ) : null;
				$content_grid	= ( $thumbnail_grid ) ? t_em_grid( $content_cols ) : t_em_grid( '12' );
?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="row">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php $align = 'align-'. t_em( 'excerpt_set' ); ?>
						<div class="<?php echo $thumbnail_grid .' '. $align; ?>">
							<?php t_em_featured_post_thumbnail( t_em( 'excerpt_thumbnail_width' ), t_em( 'excerpt_thumbnail_height' ), true ); ?>
						</div>
					<?php endif; ?>
					<div class="<?php echo $content_grid; ?>">
						<header>
							<h2 class="entry-title mt-0"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 't_em' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						</header>
						<?php the_excerpt(); ?>
					</div>
				</div>
			</article><!-- #post-## -->
			<?php
			endwhile;
			wp_reset_postdata();
		endif;
?>
		</div>
	</section>
<?php
}
add_action( 't_em_action_main_after', 'mce_latests_post' );

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
				<a href="#respond">
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
 * Related entries in post type post
 *
 * @since MCE 1.0
 */
function mce_related_post(){
	if ( ! is_single() )
		return;

	global $post;
	$post_id 	= $post->ID;
	$post__in	= mce_get_post_data( $post_id );
	$post__in	= array_slice( $post__in, 0, 6 );

	if ( ! $post__in )
		return;
?>
	<section id="related-posts" class="py-5">
		<h5 class="mb-3"><?php _e( 'You may also read:', 'mce' ) ?></h5><hr>
		<div class="row">
<?php
	foreach ( $post__in as $id ) :
		$post_type	= get_post_type( $id );
		$obj 		= get_post_type_object( $post_type );
		$label 		= ( $post_type != 'post' ) ? $obj->labels->singular_name .': ' : null;
?>
			<div class="<?php echo t_em_grid( 4 ) .' '. t_em_grid( 6, 'md' ) ?>">
				<div class="card mb-5">
					<?php echo t_em_featured_post_thumbnail( 700, 350, true, 'card-img-top', $id ) ?>
					<div class="card-body">
						<h4 class="h5"><a href="<?php echo get_permalink( $id ) ?>"><?php echo $label . get_the_title( $id ) ?></a></h4>
					</div>
				</div>
			</div>
<?php
	endforeach;
?>
		</div>
	</section>
<?php
}
add_action( 't_em_action_post_after', 'mce_related_post' );
?>
