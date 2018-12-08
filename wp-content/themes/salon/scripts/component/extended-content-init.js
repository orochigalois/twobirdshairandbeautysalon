var is_nice_scroll_loaded = false;
jQuery(window).load(function(){
	if(!ozyCheckIsMobile()) {
		jQuery.getScript(ozy_headerType.theme_url + "scripts/vendor/nicescroll/nicescroll.min.js", function( data, textStatus, jqxhr ) {
			is_nice_scroll_loaded = true;
		});
	}
});
/**
* Original idea: https://codyhouse.co/gem/ink-transition-effect/
* Original Author: Claudia Romano
* This script is customized, please check official page as described above
*/
jQuery(document).ready(function($) {
	/* Extended Content */
	
	//add modal layout
	$('<div class="ozy-extended-modal"><div class="modal-content"><div class="content-font alternate-text-color"></div></div><!-- .modal-content --><a href="#0" class="modal-close">Close</a></div> <!-- .ozy-extended-modal --><div class="ozy-extended-transition-layer"><div class="bg-layer"></div></div> <!-- .ozy-extended-transition-layer -->').appendTo('body');
	
	//cache some jQuery objects
	var transitionLayer = $('.ozy-extended-transition-layer'),
		transitionBackground = transitionLayer.children(),
		modalWindow = $('.ozy-extended-modal');

	var frameProportion = 1.78, //png frame aspect ratio
		frames = 25, //number of png frames
		resize = false;

	//set transitionBackground dimentions
	setLayerDimensions();
	$(window).on('resize', function(){
		if( !resize ) {
			resize = true;
			(!window.requestAnimationFrame) ? setTimeout(setLayerDimensions, 300) : window.requestAnimationFrame(setLayerDimensions);
		}
	});

	//close modal window
	modalWindow.on('click', '.modal-close', function(event){
		event.preventDefault();
		transitionLayer.addClass('closing');
		modalWindow.removeClass('visible');
		transitionBackground.one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(){
			transitionLayer.removeClass('closing opening visible');
			transitionBackground.off('webkitAnimationEnd oanimationend msAnimationEnd animationend');
		});
	});

	function setLayerDimensions() {
		var windowWidth = $(window).width(),
			windowHeight = $(window).height(),
			layerHeight, layerWidth;

		if( windowWidth/windowHeight > frameProportion ) {
			layerWidth = windowWidth;
			layerHeight = layerWidth/frameProportion;
		} else {
			layerHeight = windowHeight*1.2;
			layerWidth = layerHeight*frameProportion;
		}

		transitionBackground.css({
			'width': layerWidth*frames+'px',
			'height': layerHeight+'px',
		});

		resize = false;
	}		
	
	//open modal window		
	$('.vc_btn3[data-extended-content]').each(function() {
		$(this).click(function(e){
			var $content_elm = $(this).data('extended-content');
			if($('#' + $content_elm).length) {
				e.preventDefault();
				$('.ozy-extended-modal>.modal-content>div').html($('#' + $content_elm).html());

				transitionLayer.addClass('visible opening');
				var delay = ( $('.no-cssanimations').length > 0 ) ? 0 : 600;
				setTimeout(function(){
					modalWindow.addClass('visible');
					if(is_nice_scroll_loaded && !ozyCheckIsMobile()) {
						$('.ozy-extended-modal>.modal-content').getNiceScroll().remove();
						$('.ozy-extended-modal>.modal-content').niceScroll({cursorcolor: "#FFFFFF",horizrailenabled:false, cursoropacitymin:.3, cursoropacitymax:.3, autohidemode:false, cursorwidth: "6px", cursorborder: "none"});
					}
				}, delay);
				
				return false;
			}
		});
	});	 
});