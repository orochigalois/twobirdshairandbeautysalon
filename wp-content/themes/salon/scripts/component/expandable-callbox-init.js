var Expand = (function() {
  var tile = jQuery('.strips__strip');
  var tileLink = jQuery('.strips__strip > .strip__content');
  var tileText = tileLink.find('.strip__inner-text');
  var tileSubTitle = tileText.find('h2');
  var stripClose = jQuery('.strip__close');
  
  var expanded  = false;

  var open = function() {
      
    var tile = jQuery(this).parent();
		stripClose.css('color', tileSubTitle.data('color'));
      if (!expanded) {

		var to_scroll_position = jQuery('section.strips').offset().top;
		jQuery('html, body').animate({scrollTop: to_scroll_position }, 'slow');
		  
		  jQuery('body').addClass('fade-logo-menu-to-top');
        tile.addClass('strips__strip--expanded');
		setTimeout(function(){ tileText.animate({'opacity':1}, 200); }, 600);
        stripClose.addClass('strip__close--show');
        stripClose.css('transition', 'all .6s 1s cubic-bezier(0.23, 1, 0.32, 1)');
        expanded = true;
      } 
    };
  
  var close = function() {
    if (expanded) {
		jQuery('body').removeClass('fade-logo-menu-to-top');
	tileText.animate({'opacity':0}, 200, function() {
      tile.removeClass('strips__strip--expanded');
      stripClose.removeClass('strip__close--show');
      stripClose.css('transition', 'all 0.2s 0s cubic-bezier(0.23, 1, 0.32, 1)')
      expanded = false;
	});
    }
  }
  
    var bindActions = function() { tileLink.on('click', open);stripClose.on('click', close); };
    var init = function() { bindActions(); };
    return { init: init};

  }());

Expand.init();