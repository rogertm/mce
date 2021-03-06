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
 * The template for displaying all single posts.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 */

get_header(); ?>

		<section id="main-content" <?php t_em_breakpoint( 'main-content' ); ?>>
			<section id="content" role="main" <?php t_em_breakpoint( 'content' ); ?>>
			<?php do_action( 't_em_action_content_before' ); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		<?php do_action( 't_em_action_post_before' ); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php do_action( 't_em_action_post_inside_before' ); ?>
			<div class="entry-meta entry-meta-header mb-3">
				<?php do_action( 't_em_action_entry_meta_header' ) ?>
			</div><!-- .entry-meta -->

			<?php do_action( 't_em_action_post_content_before' ); ?>

			<div class="entry-content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->

			<?php do_action( 't_em_action_post_content_after' ); ?>

			<footer class="entry-meta entry-meta-footer mb-3">
				<?php do_action( 't_em_action_entry_meta_footer' ) ?>
			</footer><!-- .entry-meta .entry-meta-footer -->

			<?php do_action( 't_em_action_post_inside_after' ); ?>
		</article><!-- #post-## -->
		<?php do_action( 't_em_action_post_after' ); ?>

<?php endwhile; // end of the loop. ?>

				<?php t_em_comments_template(); ?>
				<?php do_action( 't_em_action_content_after' ); ?>
			</section><!-- #content -->
			<?php get_sidebar(); ?>
			<?php get_sidebar( 'alt' ); ?>
		</section><!-- #main-content -->

<?php get_footer(); ?>
