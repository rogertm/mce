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

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

			<?php do_action( 't_em_action_post_before' ); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php do_action( 't_em_action_post_inside_before' ); ?>
				<header>
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header>

			<?php do_action( 't_em_action_post_content_before' ); ?>

				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->

			<?php do_action( 't_em_action_post_content_after' ); ?>

				<footer class="entry-meta entry-meta-footer mb-3">
					<?php t_em_edit_post_link(); ?>
				</footer>
				<?php do_action( 't_em_action_post_inside_after' ); ?>
			</article><!-- #post-## -->

			<?php do_action( 't_em_action_post_after' ) ?>

<?php endwhile; ?>

				<?php t_em_comments_template(); ?>
				<?php do_action( 't_em_action_content_after' ); ?>
			</section><!-- #content -->
		</section><!-- #main-content .rwo-fluid -->

<?php get_footer(); ?>
