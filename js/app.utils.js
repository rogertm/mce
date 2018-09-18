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
		$('.home #static-header-inner, .hero').css({
			'width': $(window).width(),
			'height': $(window).height(),
		});
		$('.singular-hero.bg-full').css({
			'width': $(window).width(),
			'min-height': $(window).height() / 1.5,
			'height': 'auto',
		});
		$('.singular-hero.bg-empty').css({
			'width': $(window).width(),
			'height': 'auto',
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

	// Run function on resize
	$(window).resize(function(){
		mce_fullscreen_hero();
		mce_item_hight();
	});
});
