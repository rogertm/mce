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
	// Make slider items the same high
	function mceItemHight(){
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
	mceItemHight();

	// Hide header on scroll down, show on scroll up
	// http://jsfiddle.net/mariusc23/s6mLJ/31/
	function mceMenuScroll( target, height ){
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
	mceMenuScroll( $('#top-menu'), $('#header').outerHeight() );

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

	// Navbar Search
/*	$('#site-top-menu .menu-item-search').click(function(event){
		event.preventDefault();
		var item 		= $(this)
			site_title 	= $('#site-title .navbar-brand')
			site_menu 	= $('#site-top-menu')
			menu 		= $('#menu-top-menu')
			form 		= $('#nav-searchform');
			input 		= $('#nav-searchform #nbs');
		$(site_menu).removeClass('navbar-collapse').addClass('w-100').css('display','block');
		$(menu).addClass('d-none');
		$(site_title).addClass('d-none');
		$(form).removeClass('d-none d-xl-none d-lg-none d-md-block d-sm-block').addClass('d-block');
		$(input).focus();
	});
	$('#nav-searchform .close-search').click(function(event){
		event.preventDefault();
		var item 		= $(this)
			site_title 	= $('#site-title .navbar-brand')
			site_menu 	= $('#site-top-menu')
			menu 		= $('#menu-top-menu')
			form 		= $('#nav-searchform');
		$(site_menu).addClass('navbar-collapse').removeClass('w-100').css('display','none');
		$(menu).removeClass('d-none');
		$(site_title).removeClass('d-none');
		$(form).removeClass('d-block').addClass('d-none d-xl-none d-lg-none d-md-block d-sm-block');
	});*/

	// Run function on resize
	$(window).resize(function(){
		mceItemHight();
		mceMenuScroll( $('#top-menu'), $('#header').outerHeight() );
	});
});
