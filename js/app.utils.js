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
		$('.hero-header.bg-full').css({
			'width': $(window).width(),
			'min-height': $(window).height() / 1.5,
			'height': 'auto',
		});
		$('.hero-header.bg-empty').css({
			'width': $(window).width(),
			'min-height': $(window).height() / 2,
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

	// Hide header on scroll down, show on scroll up
	// http://jsfiddle.net/mariusc23/s6mLJ/31/
	function mce_menu_scroll( target, height ){
		var didScroll;
		var lastScrollTop = 0;
		var delta = 5;
		var targetHeight = height;

		$(window).scroll(function(event){
		    didScroll = true;
		});

		setInterval(function() {
		    if (didScroll) {
		        hasScrolled();
		        didScroll = false;
		    }
		}, 250);

		function hasScrolled() {
		    var st = $(this).scrollTop();

		    // Make sure they scroll more than delta
		    if(Math.abs(lastScrollTop - st) <= delta)
		        return;

		    // If they scrolled down and are past the target. Do stuff.
		    // This is necessary so you never see what is "behind" the target.
		    if (st > lastScrollTop && st > targetHeight){
		        // Scroll Down
		        $(target).fadeOut();
		    } else {
		        // Scroll Up
		        if(st + $(window).height() < $(document).height()) {
		            $(target).fadeIn();
		        }
		    }

		    lastScrollTop = st;
		}
	}
	mce_menu_scroll( $('#top-menu'), $('#header').outerHeight() );

	// Fancybox
	$().fancybox({
		selector: '.gallery .gallery-item',
		infobar: false,
		smallBtn: false,
		closeExisting: true,
		loop: true,
		toolbar: true,
		buttons: [
			"zoom",
			"share",
			"slideShow",
			"fullScreen",
			"download",
			"thumbs",
			"close"
		],
	});

	/** Go to top */
	var gotoTop = $('#gototop');
	$(window).scroll(function(){
		if ($('body,html').scrollTop() > Number( $('#header').outerHeight() ) ){
			$(gotoTop).fadeIn();
		}else{
			$(gotoTop).fadeOut();
		}
	});

	/** ScrollTo */
	$('.scroll-to').click(function(e){
		e.preventDefault();
		var element = $(this),
			target = element.attr('data-target');
		$(window).scrollTo(target,{
			duration: 500,
		});
	});

	// Run function on resize
	$(window).resize(function(){
		mce_fullscreen_hero();
		mce_item_hight();
		mce_menu_scroll( $('#top-menu'), $('#header').outerHeight() );
	});
});
