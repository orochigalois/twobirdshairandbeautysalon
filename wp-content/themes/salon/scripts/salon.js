/*jslint browser: true*/
/*jslint white: true */
/*global $,jQuery,ozy_headerType,headerMenuFixed,alert,$OZY_WP_AJAX_URL,$OZY_WP_IS_HOME,$OZY_WP_HOME_URL,addthis*/

/* Salon WordPress Theme Main JS File */

/**
* Call Close Fancybox
*/
function close_fancybox(){
	"use strict";
	jQuery.fancybox.close();
}

/* 
Some of dynamic elements like essential grid are not
sizing correctly when you refresh the page and jump to
another tab and back. Following handlers will fix it.
*/
window.onblur = function(){ jQuery(window).resize(); }  
window.onfocus = function(){ jQuery(window).resize(); }

/**
* Read cookie
*
* @key - Cookie key
*/
function getCookieValue(key) {
	"use strict";
    var currentcookie = document.cookie, firstidx, lastidx;
    if (currentcookie.length > 0)
    {
        firstidx = currentcookie.indexOf(key + "=");
        if (firstidx !== -1)
        {
            firstidx = firstidx + key.length + 1;
            lastidx = currentcookie.indexOf(";", firstidx);
            if (lastidx === -1)
            {
                lastidx = currentcookie.length;
            }
            return decodeURIComponent(currentcookie.substring(firstidx, lastidx));
        }
    }
    return "";
}

/**
* Cookie checker for like system
*
* @post_id - WordPress post ID
*/
function check_favorite_like_cookie(post_id) {
	"use strict";	
	var str = getCookieValue( "post_id" );
	if(str.indexOf("[" + post_id + "]") > -1) {
		return true;
	}
	
	return false;
}

/**
* Cokie writer for like system
*
* @post_id - WordPress post ID
*/
function write_favorite_like_cookie(post_id) {
	"use strict";	
	var now = new Date();
	now.setMonth( now.getYear() + 1 ); 
	post_id = "[" + post_id + "]," + getCookieValue("post_id");
	document.cookie="post_id=" + post_id + "; expires=" + now.toGMTString() + "; path=/; ";
}

/**
* Like buttons handler
*
* @post_id - WordPress post ID
* @p_post_type
* @p_vote_type
* @$obj
*/
function ajax_favorite_like(post_id, p_post_type, p_vote_type, $obj) {
	"use strict";	
	if( !check_favorite_like_cookie( post_id ) ) { //check, if there is no id in cookie
		jQuery.ajax({
			url: ozy_headerType.$OZY_WP_AJAX_URL,
			data: { action: 'salon_ajax_like', vote_post_id: post_id, vote_post_type: p_post_type, vote_type: p_vote_type },
			cache: false,
			success: function(data) {
				//not integer returned, so error message
				if( parseInt(data,0) > 0 ){
					write_favorite_like_cookie(post_id);
					jQuery('span', $obj).text(data);
				} else {
					alert(data);
				}
			},
			error: function(MLHttpRequest, textStatus, errorThrown){  
				alert("MLHttpRequest: " + MLHttpRequest + "\ntextStatus: " + textStatus + "\nerrorThrown: " + errorThrown); 
			}  
		});
	}
}

/**
* Load more button handler
*
* @order
* @orderby
* @item_count
* @category_name
* @offset
* @found
* @e
* @layout_type
*/
function ozy_ajax_load_more_blog(order, orderby, item_count, category_name, offset, found, e, layout_type, fitRows) {
	
	jQuery.ajax({
		url: ozy_headerType.$OZY_WP_AJAX_URL,
		data: { action: 'salon_ajax_load_more', p_order : order, p_orderby : orderby, p_item_count : item_count, p_category_name : category_name, p_offset : offset, p_layout_type : layout_type},
		cache: false,
		success: function(data) {
			
			jQuery('.wpb_wrapper.isotope').append(data);
			
			if(layout_type === 'portfolio') {
				ozy_page_template_page_portfolio_init();
			}else{
				ozy_page_template_page_isotope_blog_init(fitRows);
			}
			
			jQuery(e).find('a.button').html( jQuery(e).data('loadmorecaption') + '<span></span><span></span>');
			
			if((item_count + offset) >= found) {
				jQuery(e).hide();
			}
			
			var load_more_button_top_pos = e.position();
			jQuery('html, body').animate({scrollTop: load_more_button_top_pos.top }, 'slow');
			
		},
		error: function(MLHttpRequest, textStatus, errorThrown){  
			alert(errorThrown); 
		}  
	});	

}

function ozy_ajax_load_more_blog_action() {
	jQuery(".load_more_blog").click(function(e) {		

		e.preventDefault();
		
		jQuery(this).find('a.button').html( jQuery(this).data('loadingcaption') + '<span></span><span></span>');
		
		var order 			= jQuery(this).data("order");
		var orderby 		= jQuery(this).data("orderby");
		var item_count 		= jQuery(this).data("item_count");
		var excerpt_length 	= jQuery(this).data("excerpt_length");
		var category_name 	= jQuery(this).data("category_name");
		var offset 			= jQuery(this).data("offset");
		var found 			= jQuery(this).data("found");
		var layout_type 	= jQuery(this).data("layout_type");
		var	fitRows		 	= jQuery(this).data("fitrows");

		offset = offset + item_count;
		ozy_ajax_load_more_blog(order, orderby, item_count, category_name, offset, found, jQuery(this), layout_type, fitRows);
		jQuery(this).data("offset", offset);		

		return false;
		
	});	
}

function ozy_page_template_page_portfolio_init() {
	var $container_portfolio, visible_item_count = 8;
	jQuery('.isotope').each(function() {			
		var $that = jQuery(this);
		$that.imagesLoaded( function() {
			var conf_arr = {
				filter:  '',
				itemSelector: '.ozy_portfolio',
				layoutMode: 'masonry',
				masonry: {}
			};				
			if($that.hasClass('custom-gutter')) {
				visible_item_count = parseInt($that.data('visible_item_count')) + 2;
				conf_arr['masonry'] = {
					columnWidth: '.grid-sizer',
					gutter: '.gutter-sizer'
				};
			}else{
				visible_item_count = $that.data('visible_item_count');					
				conf_arr['masonry'] = {
					gutter:0
				};
			}
			conf_arr['filter'] = jQuery('.ozy-portfolio-listing').length>0 ? ':nth-child(-n+'+ visible_item_count +')' : '';
			jQuery('.isotope.loaded-already').isotope('destroy');
			$container_portfolio = $that.addClass('loaded-already').isotope(conf_arr);
			
			jQuery('.load_more_blog').animate({opacity:1}, 300, 'easeInOutExpo');
			
			if(jQuery('.ozy-portfolio-listing').length<=0) {
				jQuery('#portfolio-filter a').each(function() {
					if(!jQuery('.isotope>div' + jQuery(this).data('filter')).length) {
						jQuery(this).addClass('disabled').parent('li').animate({opacity:'.3'}, 300, 'easeInOutExpo');
					}else{
						jQuery(this).removeClass('disabled').parent('li').animate({opacity:'1'}, 300, 'easeInOutExpo');
					}
				});
			}
		});    
	});
	
	// bind filter button click
	jQuery('#portfolio-filter a').on( 'click', function(e) {
		e.preventDefault();
		if(jQuery(this).hasClass('disabled')) {return false;}
		var filterValue = jQuery(this ).attr('data-filter');
		$container_portfolio.isotope({ filter: filterValue });
		jQuery(this).parents('ul').find('li').removeClass('active');jQuery(this).parent('li').addClass('active');
		return false;
	});	
}

/**
* Popup window launcher
*
* @url - Url address for the popup window
* @title - Popup window title
* @w - Width of the window
* @h - Height of the window
*/
function ozyPopupWindow(url, title, w, h) {
	"use strict";
	var left = (screen.width/2)-(w/2), top = (screen.height/2)-(h/2);
	return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}

/**
* To check iOS devices and versions
*/
function ozyCheckIsMobile() {
	"use strict";
	return (/Mobi/.test(navigator.userAgent));
}

function ozyCheckIs768el() {
	"use strict";
	return jQuery(window).width()<=768 ? true : false;
}

function ozyCheckMac(){
	"use strict";
	var isMac = /(mac)/.exec( window.navigator.userAgent.toLowerCase() );
	return ( isMac != null && isMac.length );
}

function ozyCheckChrome() {
	"use strict";
	var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
	var isSafari = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor);
	return isChrome || isSafari;
}

/**
* ozy_full_row_fix
* 
* Set sections to document height which matches with selector
*/
function ozy_full_row_fix() {
	"use strict";
	if(jQuery('body.page-template-page-masterslider-full').length) { ozy_full_row_fix_calc('height'); }
	
	/* Countdown Page */
	if(jQuery('body.page-template-page-countdown').length) {
		jQuery('#content').height(jQuery(window).height());
	}	
}

function ozy_full_row_fix_calc(height_param) {
	"use strict";
	var header_height = jQuery('#header').height();
	var window_height = (jQuery(window).innerHeight() - ((jQuery(this).outerHeight(true) - jQuery(this).height())));
	if(jQuery('#wpadminbar').length>0) {header_height = header_height + jQuery('#wpadminbar').height();}		
	jQuery('#main').css(height_param, (window_height - header_height) + 'px' );	
}

function ozy_share_button() {
	"use strict";
	jQuery(document).on('click', 'body.single .post-submeta>a:not(.blog-like-link)', function(e) {
		e.preventDefault();
		ozyPopupWindow(jQuery(this).attr('href'), 'Share', 640, 440);		
	});	
}

/**
* ozy_hash_scroll_fix
*
* Check if there is a hash and scrolls to there, onload
*/
function ozy_hash_scroll_fix() {
	"use strict";
	setTimeout(function(){
	if(window.location.hash) {
		var hash = window.location.hash;
		if(jQuery(hash).length) {
			jQuery('html,body').animate({scrollTop: jQuery(hash).offset().top}, 1600, 'easeInOutExpo');
		}
	}}, 200);	
}

function ozy_custom_map_mobile_full_height_fix() {
	/* Google Map */
	if ('undefined' !== typeof jQuery.fn.prettyMaps) {
		if(jQuery(window).width() <= 479) {
			jQuery('.ozy-google-map:not(.init-later)').each(function(index, element) {
				if(jQuery(this).data('height').toString().indexOf('%') !== -1) {
					jQuery(this).height('400px');
				}
			});
		}else{
			jQuery('.ozy-google-map:not(.init-later)').each(function(index, element) {
				if(jQuery(this).data('height').toString().indexOf('%') !== -1) {
					jQuery(this).height(jQuery(this).data('height'));
				}
			});			
		}
	}
}

var ozy_ticker_containerheight = 0, ozy_ticker_numbercount = 0, ozy_ticker_liheight, ozy_ticker_index = 1, ozy_ticker_timer;
function ozy_callticker() {
	"use strict";
	jQuery(".ozy-ticker ul").stop().animate({
		"margin-top": (-1) * (ozy_ticker_liheight * ozy_ticker_index)
	}, 1500);
	jQuery('#ozy-tickerwrapper .pagination>a').removeClass('active');jQuery('#ozy-tickerwrapper .pagination>a[data-slide="'+ (ozy_ticker_index) +'"]').addClass('active');//bullet active
	if (ozy_ticker_index != ozy_ticker_numbercount - 1) {
		ozy_ticker_index = ozy_ticker_index + 1;
	}else{
		ozy_ticker_index = 0;
	}
	ozy_ticker_timer = setTimeout("ozy_callticker()", 3600);
}

/* Resets windows scroll position if there is a hash to make it work smooth scroll*/
var windowScrollTop = jQuery(window).scrollTop();
window.scrollTo(0, 0);
setTimeout(function() {
	"use strict";
	window.scrollTo(0, windowScrollTop);
}, 1);

jQuery(window).resize(function() {
	"use strict";
	ozy_full_row_fix();
	ozy_custom_map_mobile_full_height_fix();
});

jQuery(window).load(function(){
	if (jQuery().masonry) {
		/* Search page */
		if(jQuery('body.search-results').length) {
			jQuery('body.search-results .post-content>div').imagesLoaded( function(){				
				jQuery('body.search-results .post-content>div').masonry({
					itemSelector : 'article.result',
					gutter : 20
				});
			});
		}
	}
	
	/* Row Kenburns Slider */
	jQuery('.smoothslides').each(function() {
		jQuery(jQuery(this)).smoothSlides({
			effectDuration:5000,
			navigation:false,
			pagination:false,
			matchImageSize:false
		});
    });
});

jQuery(document).ajaxComplete(function() {
	/*re init lighgallery for newly loaded items*/
	if(jQuery('.wpb_wrapper.isotope').length) {
		var $target_gallery = jQuery('.wpb_wrapper.isotope');
		if($target_gallery.data('lightGallery')) {
			$target_gallery.data('lightGallery').destroy(true);
		}
		$target_gallery.lightGallery({
			selector: '.lightgallery',
			thumbnail:true
		});
	}
});

if(jQuery('.wpb_row[data-alternate_logo="1"]').length) {
	jQuery(window).scroll(function() {
		"use strict";
		jQuery.doTimeout('scroll', 100, function(){			
			var scrollTop = jQuery(this).scrollTop();
			var anyRowVisible = false;
			jQuery('.wpb_row[data-alternate_logo="1"]').each(function() {
				var topDistance = jQuery(this).offset().top;
				var topHeight = jQuery(this).outerHeight();
				if ((topDistance-100) < scrollTop && (topHeight+topDistance)>scrollTop+100) {					
					anyRowVisible = true;
					if(jQuery('#logo-default').css('opacity') == '1') {
						jQuery('body').addClass('ozy-logo-alternate');
					}
				}
			});
			
			if(!anyRowVisible) {
				if(jQuery('#logo-alternate').css('opacity') == '1') {
					jQuery('body').removeClass('ozy-logo-alternate');
				}
			}			
		});
	});
}

jQuery(document).ready(function($) {
	"use strict";
	
	jQuery(window).scroll(); //init logo switch for first time
	
	ozy_share_button();

	ozy_full_row_fix();
	
	ozy_ajax_load_more_blog_action();
	
	ozy_hash_scroll_fix();
	
	/* First close all menu items on initialization */
	$('.salon-nav .salon-primary-nav li a').each(function() {
		$(this).parent().children('ul:first').slideToggle();
    });
	
	/* Menu Item Handler */
	$('.salon-nav .salon-primary-nav li a').click(function (e) {
		if($(this).parent('li').hasClass('dropdown')) {			
			e.preventDefault();					
			var $that = $(this).parent('li');
			$('.salon-nav .salon-primary-nav li').each(function() { if(!$that.is($(this))) { $(this).removeClass('open'); }});
			var ullist = $(this).parent().toggleClass('open').children('ul:first');
			ullist.slideToggle();
			$(this).parent().siblings().children().next().slideUp();
			return false; //prevent to follow link if menu has child items and has href to go
		}else{
			if (/#/.test(this.href)) {
				e.preventDefault();
				if(ozy_headerType.$OZY_WP_IS_HOME != 'false') {
					if(ozy_click_hash_check(this) == false) {
						$('.salon-nav-trigger').click();
					}
				}else{
					if(ozy_Animsition.is_active) {
						$('.animsition').animsition('out', $(e.target), ozy_headerType.$OZY_WP_HOME_URL + $(this).attr('href'));
					}else{
						window.location = ozy_headerType.$OZY_WP_HOME_URL + $(this).attr('href');
					}
				}
			}else{
				if(ozy_Animsition.is_active) {
					e.preventDefault();
					$('.animsition').animsition('out', $(e.target), $(this).attr('href'));
				}
			}
			$('body').toggleClass('open');
		}
	});
	
	var isLateralNavAnimating = false;
	$('.salon-nav-trigger').on('click', function(event){
		event.preventDefault();
		//stop if nav animation is running 
		if( !isLateralNavAnimating ) {
			if($(this).parents('.csstransitions').length > 0 ) isLateralNavAnimating = true; 
			
			$('body').toggleClass('navigation-is-open');
			$('.salon-navigation-wrapper').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
				//animation is over
				isLateralNavAnimating = false;
				//switching tabs when menu open may cause white page issues
				setTimeout(function(){ $(window).resize(); }, 200);
			});
		}
	});
	
	/* Language Switcher & Book Now*/
	if($('.lang-switcher-booking-button-wrapper:not(.book-now)').length) {
		var lang_switcher_height = 0;
		$('.lang-switcher-booking-button-wrapper:not(.book-now)>div>a').each(function(index, element) {
			lang_switcher_height = lang_switcher_height + $(this).height();
		});
		$('<style type="text/css">.lang-switcher-booking-button-wrapper:not(.book-now):hover,.lang-switcher-booking-button-wrapper.hover:not(.book-now){height:'+ parseInt(lang_switcher_height+81) +'px}</style>').appendTo('head');
	}
	if($('.lang-switcher-booking-button-wrapper.book-now').length) {
		$('<style type="text/css">.lang-switcher-booking-button-wrapper.book-now:hover{width:'+ parseInt($('.lang-switcher-booking-button-wrapper.book-now>a>span:last-child').width()+60) +'px}</style>').appendTo('head');
	}
	
	/* Content Button Smooth Scroll Handler */	
	$('#content a.vc_btn3[href*="#"], .widget ul.menu>li>a[href*="#"]').click(function(e) {
		var pattern = /^((http|https|ftp):\/\/)/;
		if(pattern.test(this.href)) {
			e.preventDefault();
			if(ozy_headerType.$OZY_WP_IS_HOME != 'false') {
				ozy_click_hash_check(this);					
			}else{
				if(ozy_Animsition.is_active) {
					$('.animsition').animsition('out', $(e.target), ozy_headerType.$OZY_WP_HOME_URL + this.hash);//$(this).attr('href'));
				}else{
					window.location = ozy_headerType.$OZY_WP_HOME_URL + this.hash;//$(this).attr('href');
				}
			}		
		}else if (/#/.test(this.href)) {		
			e.preventDefault();			
			if(ozy_headerType.$OZY_WP_IS_HOME != 'false') {
				ozy_click_hash_check(this);					
			}else{
				if(ozy_Animsition.is_active) {
					$('.animsition').animsition('out', $(e.target), ozy_headerType.$OZY_WP_HOME_URL + $(this).attr('href'));
				}else{
					window.location = ozy_headerType.$OZY_WP_HOME_URL + $(this).attr('href');
				}
			}
		}else{
			if(ozy_Animsition.is_active) {
				e.preventDefault();
				$('.animsition').animsition('out', $(e.target), $(this).attr('href'));
			}
		}
	});		
	//}

	/* Smooth Scroll */
	if(ozy_headerType.smooth_scroll == '1') {
		if(!ozyCheckIsMobile() && !ozyCheckMac() && ozyCheckChrome()) {
			var $window = $(window); //Window object
			var scrollTime = 0.6; //Scroll time
			var scrollDistance = 300; //Distance. Use smaller value for shorter scroll and greater value for longer scroll			
			$window.on("mousewheel DOMMouseScroll", function(event){
				
				event.preventDefault();	
												
				var delta = event.originalEvent.wheelDelta/120 || -event.originalEvent.detail/3;
				var scrollTop = $window.scrollTop();
				var finalScroll = scrollTop - parseInt(delta*scrollDistance);
					
				TweenMax.to($window, scrollTime, {
					scrollTo : { y: finalScroll, autoKill:true },
						ease: Power1.easeOut, //For more easing functions see http://api.greensock.com/js/com/greensock/easing/package-detail.html
						autoKill: true,
						overwrite: 5							
					});
			});			
		}		
	}	

	/* Animsition */
	if(ozy_Animsition.is_active) {
		$(".animsition").animsition({
			inClass: 'fade-in',
			outClass: 'fade-out',
			inDuration: 1500,
			outDuration: 800,
			linkElement: '.salon-primary-nav li>a:not([target="_blank"]):not([href^="#"])', // e.g. linkElement: 'a:not([target="_blank"]):not([href^=#])'
			loading: true,
			loadingParentElement: 'body', //animsition wrapper element
			loadingClass: 'square-loader',//'uil-ring-css',//'animsition-loading',
			loadingInner: "<div><div></div></div>", // e.g '<img src="loading.svg" />'
			timeout: false,
			timeoutCountdown: 5000,
			onLoadEvent: true,
			browser: [ 'animation-duration', '-webkit-animation-duration'],
			overlay : false,
			overlayClass : 'animsition-overlay-slide',
			overlayParentElement : 'body',
			transition: function(url){ window.location.href = url; }
		});
	}	
	
	/* Search Button & Stuff */
	var main_margin_top = $('#main').css('margin-top');
	$(document).on('touchstart, click', '#ozy-close-search,.menu-item-search>a', function(e) {
		if($('#top-search').hasClass('open')){
			$('#top-search').removeClass('open').delay(200);
			$('#top-search').animate({height:'0px'}, 200, 'easeInOutExpo');
			$('#info-bar,.logo-bar-wrapper').animate({opacity:1}, 400, 'easeInOutExpo');
		}else{
			$('html,body').animate({
				 scrollTop: 0
			}, 100, 'easeInOutExpo', function(){				
				$('#top-search').animate({height:'90px', opacity:1}, 200, 'easeInOutExpo',function(){$('#top-search>form>input').focus();$('#top-search').addClass('open');});
				$('#info-bar,.logo-bar-wrapper').animate({opacity:0}, 400, 'easeInOutExpo');
			});
			
		}
		e.preventDefault();
	});
	
	/* Close search box when clicked somewhere on the document, if opened already */
	$(document).on("touchstart, click", function(e) {
		if(ozyCheckIsMobile()) {
			var searchbox_div = $("#top-search");
			if (!searchbox_div.is(e.target) && !searchbox_div.has(e.target).length) {
				if($(searchbox_div).hasClass('open')){				
					$(searchbox_div).removeClass('open').delay(200);
					$(searchbox_div).animate({height:'0px'}, 200, 'easeInOutExpo');
					$('#info-bar,.logo-bar-wrapper').animate({opacity:1}, 400, 'easeInOutExpo');
				}
			}
		}
	});	

	function ozy_visual_stuff() {	
		/* Blog Share Button*/
		$(document).on('click', '.post-submeta>a.post-share, .big-blog-post-submeta>a.post-share', function(e) {
			if($(this).data('open') !== '1') {
				$(this).data('open', '1').next('div').stop().animate({'margin-left': '0', opacity: 'show'}, 300, 'easeInOutExpo');
			}else{
				$(this).data('open', '0').next('div').stop().animate({'margin-left': '30px', opacity: 'hide'}, 300, 'easeInOutExpo');
			}
			e.preventDefault();
		});
		$(document).on("click", function(e) {
			var post_share_button = $(".post-submeta>a.post-share, .big-blog-post-submeta>a.post-share");
			if (!post_share_button.is(e.target) && !post_share_button.has(e.target).length) {
				post_share_button.data('open', '0').next('div').stop().animate({'margin-left': '30px', opacity: 'hide'}, 300, 'easeInOutExpo');
			}
		});
		
		/* Tooltip plugin init */	
		$(function(){
			$('.tooltip-top').tooltipsy({className:'tooltipsy white', offset: [0, 20]});
			$('.tooltip').tooltipsy();
		});
		
		/* YouTube Embed */
		$('.oytb-videoWrapper').each(function(index, element) {
			var $poster = $(this);
			var $wrapper = $poster.closest(this);

			$(this).click(function(ev){
				ev.preventDefault();
				videoPlay($wrapper);
			});
			
			function videoPlay($wrapper) {
				var $iframe = $wrapper.find('.oytb-js-videoIframe');
				var src = $iframe.data('src');
				$wrapper.addClass('oytb-videoWrapperActive');
				$poster.parent('div').find('.oytb-video-StopButton').show(100, 'easeInOutExpo');
				$iframe.attr('src',src);
			}
			
			$('.oytb-video-StopButton').click(function(){
				videoStop($wrapper);
			});
			
			function videoStop($wrapper) {
				if (!$wrapper) {
					var $wrapper = $('.oytb-js-videoWrapper');
					var $iframe = $('.oytb-js-videoIframe');
				} else {
					var $iframe = $wrapper.find('.oytb-js-videoIframe');
				}
				$wrapper.removeClass('oytb-videoWrapperActive');
				$poster.parent('div').find('.oytb-video-StopButton').hide(100, 'easeInOutExpo');
				$iframe.attr('src','');
			}		
        });

		/* Flickity See All switch button */
		$('.flickity-carousel-wrapper>.flickity-carousel.carousel').each(function(index, element) {	
			var $carousel = $(this);		
			var isFlickity = true;
			// toggle Flickity on/off
			$('.flickity-see-all').on( 'click', function() {
				//switch button label
				var button_label = $(this).toggleClass('grid-open').data('label');$(this).data('label', $(this).html());$(this).html(button_label);
				
				if ( isFlickity ) {										
					//setup isotope
					var conf_arr = {
						layoutMode: 'packery',
						itemSelector: '.carousel-cell'
					};				
					$carousel.toggleClass('flickity-carousel-grid').flickity('destroy').isotope(conf_arr);
					
					//isotope animation
					var anim_timing = 0.25;
					$carousel.find('.carousel-cell').each(function(index, element) {
						$(this).css({'-webkit-transform' : 'translateX(200%)', 'transform' : 'translateX(200%)', '-webkit-animation' : 'comeFromRight '+anim_timing+'s ease-in-out forwards', 'animation' : 'comeFromRight '+anim_timing+'s ease-in-out forwards'});
						anim_timing = anim_timing + 0.10;
                    });

				} else {
					//init new Flickity
					var data_flickity_str = $carousel.attr('data-flickity');
					$carousel.isotope('destroy').toggleClass('flickity-carousel-grid').flickity(JSON.parse(data_flickity_str));
				}
				isFlickity = !isFlickity;
				return false;
			});	
		});		
	}
	
	ozy_visual_stuff();
	
	function ozy_vc_components() {			
		/* Google Map */
		if ('undefined' !== typeof jQuery.fn.prettyMaps) {
			$('div.ozy-google-map').parents('div.wpb_column').css('overflow', 'hidden');
			$('.ozy-google-map:not(.init-later)').each(function(index, element) {
				if($(this).data('height').toString().indexOf('%') !== -1) {
					$(this).parent('div.wpb_wrapper').css('height', '100%');
				}				
				$(this).parent().append(
					$('<div class="gmaps-cover"></div>').click(function(){ $(this).remove(); })
				);
				$(this).prettyMaps({
					address: $(this).data('address'),
					zoom: $(this).data('zoom'),
					panControl: true,
					zoomControl: true,
					mapTypeControl: true,
					scaleControl: true,
					streetViewControl: true,
					overviewMapControl: true,
					scrollwheel: true,
					image: $(this).data('icon'),
					hue: $(this).data('hue'),
					saturation: $(this).data('saturation'),
					lightness: $(this).data('lightness')
				});
			});
			ozy_custom_map_mobile_full_height_fix();
		}

		/* Counter */
		if ('undefined' !== typeof jQuery.fn.waypoint) {
			jQuery('.ozy-counter>.timer').waypoint(function() {
				if(!$(this).hasClass('ran')) {
					$(this).addClass('ran').countTo({
						from: $(this).data('from'),
						to: $(this).data('to'),
						speed: 5000,
						refreshInterval: 25,
						sign: $(this).data('sign'),
						signpos: $(this).data('signpos')
					});
				}
			},{ 
				offset: '85%'
			});		
		}
		
		/* Sticky Footer Info Bar */
		if(!ozyCheckIsMobile()) {
			jQuery('#footer-widget-bar').waypoint(function(direction) {
				jQuery('#footer-widget-bar-sticky').css('position', (direction !== 'down' ? 'fixed' : 'inherit'));
			},{ 
				offset: '95%'
			});
		}
		$('#footer-widget-bar-sticky #close-footer-info-bar').click(function(e) {
			e.preventDefault();
			$('#footer-widget-bar-sticky').animate({height:0, opacity:0}, 200, 'easeInOutExpo');
		});
		
		/* Shuffle Slider */
		$(".vc_row.has-bg-slider").shuffleImages({
			//target: ".shuffle-me > .images > img",
			target: ".shuffle-me > .images > div",
		});		
		
		/* Typewriter */
		$(".typing-box").each(function() {
			var options = {
				typeSpeed : $(this).data('typespeed'),
				startDelay : $(this).data('startdelay'),
				backSpeed : $(this).data('backspeed'),
				backDelay : $(this).data('backdelay'),
				loop : $(this).data('loop'),
				strings : $.parseJSON(ozyTypeWriterData[$(this).data('path')])
			};
			$(this).typed(options);            
        });
		
		/* Instagram Feed */
		$('.ozy-instagram-gallery').each(function(index, element) {            
			var accesstoken = $(this).data('accesstoken'),
				num_photos = $(this).data('numitems');
			$.ajax({
				url: 'https://api.instagram.com/v1/users/self/media/recent/?access_token='+accesstoken+'&count='+num_photos+'&callback=?',
				dataType: 'jsonp',
				type: 'GET',
				data: {count: num_photos, access_token: accesstoken},
				success: function(data2){
					for(var i = 0; i < data2.data.length; i++) {
						$(element).append('<li><a href="'+ data2.data[i].link +'" target="_blank"><img src="'+data2.data[i].images.thumbnail.url+'"></a></li>');  
					}
				},
				error: function(data2){
					$(element).append('<li>'+ data2 +'</li>');
				}
			});
		});
				
		/* Team Member Extended Content (Lightbox) */
		if($('.ozy-team_member.has-extended-content').length) {
			$('.ozy-team_member.has-extended-content a').click(function(e) {
				e.preventDefault();
				var $this = $(this).parents('div.ozy-team_member');
				$this.find('figure>a').click(function(e){ e.preventDefault(); });
				var $source = $this.find('.extended-content');
				$.fancybox({
					maxWidth:940,
					maxHeight:640,
					padding:0,
					scrolling:'no',
					'content' : $source.html()
				});				
			});
		}
		
		/* Fancy Blog List */
		$('.ozy-fancyaccordion-feed tr.title').click(function(e){
			e.preventDefault();
			if($(this).hasClass('open')) {
				$(this).next('tr.excerpt').find('td>div').hide(200, function() {
					$(this).parent().slideUp(100);			
				});
			}else{
				$(this).next('tr.excerpt').find('td').show(200, function() {
					$(this).find('div').slideDown(100);					
				});
			}
			$(this).toggleClass('open');			
		});
	}
	
	ozy_vc_components();
	
	/* page-portfolio.php*/
	if($('body.page-template-page-portfolio-php').length>0) {
		$('.wpb_wrapper.isotope').lightGallery({
			selector: '.lightgallery',
			thumbnail:true
		}); 
		
		ozy_page_template_page_portfolio_init();
	}	
		
	function ozy_click_hash_check($this) {
		if (location.pathname.replace(/^\//,'') == $this.pathname.replace(/^\//,'') 
			|| location.hostname == $this.hostname) {
	
			var target = $($this.hash);
			target = target.length ? target : $('[name=' + $this.hash.slice(1) +']');
		   	if (target.length) {
				$('html,body').animate({
					 scrollTop: target.offset().top
				}, 1600, 'easeInOutExpo');
				return false;
			}
		}
	}
	
	/* Waypoint animations */
	if ('undefined' !== typeof jQuery.fn.waypoint) {
	    jQuery('.ozy-waypoint-animate').waypoint(function() {
			jQuery(this).addClass('ozy-start-animation');
		},{ 
			offset: '85%'
		});
	}
	
	/* Blog post like function */
	$(document).on('click', '.blog-like-link', function(e) {
		ajax_favorite_like($(this).data('post_id'), 'like', 'blog', this);
		e.preventDefault();
    });
	
	/* FancyBox initialization */
	$(".wp-caption>p").click(  function(){ jQuery(this).prev('a').attr('title', jQuery(this).text()).click(); } ); //WordPress captioned image fix
	$(".fancybox, .wp-caption>a, .single-image-fancybox a").fancybox({
		beforeLoad: function() {
		},
		padding : 0,
		helpers		: {
			title	: { type : 'inside' },
			buttons	: {}
		}
	});
	$('.fancybox-media').fancybox({openEffect  : 'none',closeEffect : 'none',helpers : {title	: { type : 'inside' }, media : {}}});
	
	/* Back to top button */
	var pxScrolled = 200;
	var duration = 500;
	
	$(window).scroll(function() {
		if ($(this).scrollTop() > pxScrolled) {
			$('.salon-btt-container').css({'bottom': (ozyCheckIs768el() ? '64':0)+'px', 'transition': '.3s'});
		} else {
			$('.salon-btt-container').css({'bottom': '-72px'});
		} 
	});
	
	$('.top').click(function() {
		$('body,html').animate({scrollTop: 0}, duration);
	})	
});