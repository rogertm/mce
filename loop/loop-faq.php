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
 * Custom Loop for FAQ post type
 */
?>
<?php
// Custom query for post type FAQ
$args = array(
'post_type'			=> 'faq',
'posts_per_page'	=> -1,
'order'				=> 'ASC',
'orderby'			=> 'menu_order',
);

$faqs = get_posts( $args );
?>
<div id="faq-archive">
	<h2 id="faq-index"><?php _e( 'Table of Content', 'mce' ) ?></h2>
	<ol class="list-unstyled">
	<?php foreach ( $faqs as $faq ) : ?>
		<li class="h5"><a href="<?php echo get_permalink( t_em( 'page_faq' ) ) .'#faq-'. $faq->ID ?>" class="scroll-to" data-target="<?php echo '#faq-'. $faq->ID ?>"><?php echo $faq->post_title ?></a></li>
	<?php endforeach; wp_reset_postdata(); ?>
	</ol>

	<?php foreach ( $faqs as $faq ) : ?>
	<div id="faq-<?php echo $faq->ID ?>" class="faq mb-3 border-bottom">
		<div class="faq-body">
			<h2 class="faq-title pt-5"><?php echo $faq->post_title ?></h2>
			<div class="faq-text">
				<?php echo t_em_wrap_paragraph( $faq->post_content ) ?>
				<p class="text-right"><a href="#faq-index" class="btn btn-sm btn-link scroll-to" data-target="#faq-index"><?php _e( 'Back to top', 'mce' ) ?></a></p>
			</div>
		</div>
	</div>
	<?php endforeach; wp_reset_postdata(); ?>
</div>
