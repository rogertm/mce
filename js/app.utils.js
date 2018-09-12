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
jQuery(document).ready(function($) {
	// Hero Full Screen
	function mce_fullscreen_hero(){
		$('.home #static-header-inner, .bg-holder').css({
			width: $(window).width(),
			height: $(window).height(),
		});
	}
	mce_fullscreen_hero();

	// Parallax-Scroll
	$('.bg-holder').parallaxScroll({
		friction: 0.2
	});

	// Run function on resize
	$(window).resize(function(){
		mce_fullscreen_hero();
	});
});
