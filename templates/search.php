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
 * Add search item in Nav Menu
 *
 * @since MCE 1.0
 */
function mce_top_menu_search_item( $nav, $args ){
	if ( $args->theme_location == 'top-menu' ) :
		$nav .= '<li class="menu-item nav-item menu-item-search d-lg-block d-none">';
		$nav .= 	'<a href="#search" class="nav-link menu-search-item"><span class="sr-only">'. __( 'Search', 'mce' ) .'</span><i class="icomoon-search"></i></a>';
		$nav .= '</li>';
	endif;
	return $nav;
}
// add_filter( 'wp_nav_menu_items', 'mce_top_menu_search_item', 10, 2 );

/**
 * Nav Search Form
 *
 * @since MCE 1.0
 */
function mce_nav_searchform(){
?>
	<form id="nav-searchform" class="simple-searchform navbar-form d-none d-xl-none d-lg-none d-md-block d-sm-block" action="<?php echo home_url( '/' ); ?>" method="get">
		<div class="input-group">
			<label class="sr-only" for="nbs"><?php _e( 'Search in', 'mce' ); ?> <?php echo bloginfo( 'name' ); ?></label>
			<input type="text" class="form-control" name="s" id="nbs" value="<?php the_search_query(); ?>" placeholder="<?php _e( 'Type something and hit enter...', 'mce' ) ?>" />
		</div>
		<div class="actions">
			<a href="#close" class="close-search"><span class="icomoon-cross"></span><span class="sr-only"><?php _e( 'Close', 'mce' ) ?></span></a>
		</div>
	</form>
<?php
}
// add_action( 't_em_action_top_menu_navbar_after', 'mce_nav_searchform' );
?>
