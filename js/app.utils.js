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

	// Make slider items the same high
	function mce_item_hight(){
		var values	= []
			item 	= $('#testimonials-carousel .carousel-item');
		item.each(function(index){
			var item_hight = $(this).height();
			values.push(item_hight);
		});
		values.sort();
		var value = values.pop() + 25;
		item.css( 'min-height', value );
	};
	mce_item_hight();

	// Parallax-Scroll
	$('.bg-holder').parallaxScroll({
		friction: 0.2
	});

	// Run function on resize
	$(window).resize(function(){
		mce_fullscreen_hero();
		mce_item_hight();
	});
});
