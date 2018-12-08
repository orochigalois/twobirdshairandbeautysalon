jQuery(document).ready(function($) {	
	"use strict";
	/* Admin notice AJAX handler */
	jQuery(document).on( 'click', '.ozy-data-privacy-notice .notice-dismiss', function() {
		jQuery.ajax({
			url: ajaxurl,
			data: {
				action: 'salon_data_policy_notice_dismiss'
			}
		});
	});
	
	$('#ozy_import_revo_slider').click(function(){
		
		var $selected_sliders = $('input[name=ozy_import_revo]:checked'), selected_sliders_data = '', comma = '';
		$selected_sliders.each(function(){selected_sliders_data += comma + $(this).val();comma=',';});
		
		$('#ozy_import_revo_info').html('<pre>Process started! Please wait...</pre>');
		
		$('#ozy_import_revo_slider').attr('disabled', true).removeClass('button-primary');
		
		jQuery.ajax({
			url: ajaxurl,
			data: { action: 'salon_ajax_auto_install_revo_slider', selected_sliders: selected_sliders_data},
			cache: false,
			success: function(data) {
				$('#ozy_import_revo_info').html('<pre>' + data + '</pre>');
				$('#ozy_import_revo_slider').attr('disabled', false).addClass('button-primary');
			},
			error: function(MLHttpRequest, textStatus, errorThrown){  
				alert("MLHttpRequest: " + MLHttpRequest + "\ntextStatus: " + textStatus + "\nerrorThrown: " + errorThrown); 
				$('#ozy_import_revo_slider').attr('disabled', false).addClass('button-primary');
			}  
		});		
	});

	var icons = [], myIconPicker = jQuery('input.select_an_icon_field').fontIconPicker({iconsPerPage:2000});
	
	$('div[id*="ozy_salon_meta_post"]').css('overflow', 'inherit');
	
	jQuery.ajax({
		url:         ozyAdminParams.ozy_theme_path + 'font/ozy/config.json',
		dataType:    'JSON'
	}).done(function (r) {
		jQuery.each(r.glyphs, function (i,v) {
			icons.push(r.css_prefix_text + v.css);
		});
		myIconPicker.setIcons(icons);
	});	
	

	var ozy_current_target_icon_box = null;
	$(document).on('click', '.edit-menu-item-classes', function() {		
		ozy_current_target_icon_box = $(this);
		tb_show('Menu Options', '#TB_inline?height=815&max-height=815&width=750&inlineId=ozyIconSelectorWindow', false);
		$('#TB_ajaxContent').css('height', '90%');
	});

	$(document).on('click', '#ozy-form-iconselect-icons i', function() {
		if(ozy_current_target_icon_box != null) {
			ozy_current_target_icon_box.val($(this).attr('class').replace('icon ', ''));
			ozy_current_target_icon_box = null;
			tb_remove();
		}
	});

	function fixHelpIFrame() {
		if(jQuery("#ozy-help-iframe").length > 0) {
			var helpFrame = jQuery("#ozy-help-iframe");
			var innerDoc = (helpFrame.get(0).contentDocument) 
			? helpFrame.get(0).contentDocument 
			: helpFrame.get(0).contentWindow.document;
			helpFrame.height(innerDoc.body.scrollHeight + 35);
		}
	}

	jQuery(function(){
		fixHelpIFrame();
	});
	
	jQuery(window).resize(function(){
		fixHelpIFrame();
	});
	
	/**
	* Custom Menu Styling
	*/
	var ozy_current_target_menu_style_box = null;
	$(document).on('click', '.edit-menu-item-edit-style', function() {		
		ozy_current_target_menu_style_box = $(this);
		
		//load settings
		var get_params = jQuery.parseJSON( ozy_current_target_menu_style_box.siblings('textarea').val() );
		
		//set loaded values
		if (get_params !== undefined && get_params !== null) {
			if(get_params.is_form !== undefined) { $('#custom-menu-request-a-rate').prop('checked', (get_params.is_form === '1' ? true : false)); }
			if(get_params.html_content !== undefined) { $('#custom-menu-html-content').val($.base64.decode(get_params.html_content)); }
			if(get_params.bg_color !== undefined) { $('#custom-menu-bg-color').val(get_params.bg_color).minicolors('destroy').minicolors({defaultValue:get_params.bg_color}); }
			if(get_params.bg_color_end !== undefined) { $('#custom-menu-bg-color-end').val(get_params.bg_color_end).minicolors('destroy').minicolors({defaultValue:get_params.bg_color_end}); }
			if(get_params.fn_color !== undefined) { $('#custom-menu-fn-color').val(get_params.fn_color).minicolors('destroy').minicolors({defaultValue:get_params.fn_color}); }
			if(get_params.border_color !== undefined) { $('#custom-menu-border-color').val(get_params.border_color).minicolors('destroy').minicolors({defaultValue:get_params.border_color}); }
			if(get_params.border_width !== undefined) { $('#custom-menu-border-width').val(get_params.border_width); }
		}else{
			$('#custom-menu-request-a-rate').prop('checked', false);
			$('#custom-menu-html-content').val('');
			$('#custom-menu-border-color').val('').minicolors('destroy').minicolors();
			$('#custom-menu-fn-color').val('#ffffff').minicolors('destroy').minicolors();
			$('#custom-menu-bg-color').val('#fed201').minicolors('destroy').minicolors();
			$('#custom-menu-bg-color-end').val('#ff6801').minicolors('destroy').minicolors();
			$('#custom-menu-border-width').val('0');
		}
		
		tb_show('Custom Menu Style', '#TB_inline?height=315&max-height=315&width=750&inlineId=ozyMegaMenuStyleWindow', false);
		$('#TB_ajaxContent').css('height', '90%');
	});
	
	/*media window*/
    var custom_uploader;
 
    $(document).on('click', '.upload-image-button', function(e) {
		$this = $(this);
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
			$this.parent().find('input[type="text"]').val( attachment.url ).change();
			$this.parent().find('a>img').attr('src', attachment.url );
        });
 
        //Open the uploader dialog
        custom_uploader.open();
 
    });	
	/*end media window*/
	
	$(document).on('click', '#custom-menu-bg-apply', function(){
		if(ozy_current_target_menu_style_box != null) {
			var pass_params =  '{';
			pass_params += '"is_form":"'+ ($('#custom-menu-request-a-rate').is(':checked') ? '1' : '0') +'",';
			pass_params += '"html_content":"'+ $.base64.encode($('#custom-menu-html-content').val()) +'",';
			pass_params += '"bg_color":"'+ $('#custom-menu-bg-color').val() +'",';
			pass_params += '"bg_color_end":"'+ $('#custom-menu-bg-color-end').val() +'",';
			pass_params += '"fn_color":"'+ $('#custom-menu-fn-color').val() +'",';
			pass_params += '"border_color":"'+ $('#custom-menu-border-color').val() +'",';
			pass_params += '"border_width":"'+ $('#custom-menu-border-width').val() +'"';
			
			pass_params += '}';console.log(pass_params);
			ozy_current_target_menu_style_box.siblings('textarea').val( pass_params );//.css('display','block');
			ozy_current_target_menu_style_box = null;
			tb_remove();
		}
	});
});

/* https://github.com/carlo/jquery-base64 */
"use strict";jQuery.base64=(function($){var _PADCHAR="=",_ALPHA="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",_VERSION="1.0";function _getbyte64(s,i){var idx=_ALPHA.indexOf(s.charAt(i));if(idx===-1){throw"Cannot decode base64"}return idx}function _decode(s){var pads=0,i,b10,imax=s.length,x=[];s=String(s);if(imax===0){return s}if(imax%4!==0){throw"Cannot decode base64"}if(s.charAt(imax-1)===_PADCHAR){pads=1;if(s.charAt(imax-2)===_PADCHAR){pads=2}imax-=4}for(i=0;i<imax;i+=4){b10=(_getbyte64(s,i)<<18)|(_getbyte64(s,i+1)<<12)|(_getbyte64(s,i+2)<<6)|_getbyte64(s,i+3);x.push(String.fromCharCode(b10>>16,(b10>>8)&255,b10&255))}switch(pads){case 1:b10=(_getbyte64(s,i)<<18)|(_getbyte64(s,i+1)<<12)|(_getbyte64(s,i+2)<<6);x.push(String.fromCharCode(b10>>16,(b10>>8)&255));break;case 2:b10=(_getbyte64(s,i)<<18)|(_getbyte64(s,i+1)<<12);x.push(String.fromCharCode(b10>>16));break}return x.join("")}function _getbyte(s,i){var x=s.charCodeAt(i);if(x>255){throw"INVALID_CHARACTER_ERR: DOM Exception 5"}return x}function _encode(s){if(arguments.length!==1){throw"SyntaxError: exactly one argument required"}s=String(s);var i,b10,x=[],imax=s.length-s.length%3;if(s.length===0){return s}for(i=0;i<imax;i+=3){b10=(_getbyte(s,i)<<16)|(_getbyte(s,i+1)<<8)|_getbyte(s,i+2);x.push(_ALPHA.charAt(b10>>18));x.push(_ALPHA.charAt((b10>>12)&63));x.push(_ALPHA.charAt((b10>>6)&63));x.push(_ALPHA.charAt(b10&63))}switch(s.length-imax){case 1:b10=_getbyte(s,i)<<16;x.push(_ALPHA.charAt(b10>>18)+_ALPHA.charAt((b10>>12)&63)+_PADCHAR+_PADCHAR);break;case 2:b10=(_getbyte(s,i)<<16)|(_getbyte(s,i+1)<<8);x.push(_ALPHA.charAt(b10>>18)+_ALPHA.charAt((b10>>12)&63)+_ALPHA.charAt((b10>>6)&63)+_PADCHAR);break}return x.join("")}return{decode:_decode,encode:_encode,VERSION:_VERSION}}(jQuery));

/* jQuery fontIconPicker - v1.0.0 - Made by Alessandro Benoit  - http://codeb.it/fontIconPicker - Under MIT License */
;(function(a){function d(b,c){this.element=a(b);this.settings=a.extend({},e,c);this.settings.emptyIcon&&this.settings.iconsPerPage--;this.iconPicker=a("<div/>",{"class":"icons-selector",style:"position: relative",html:'<div class="selector"><span class="selected-icon"><i class="fip-icon-block"></i></span><span class="selector-button"><i class="fip-icon-down-dir"></i></span></div><div class="selector-popup" style="display: none;">'+(this.settings.hasSearch?'<div class="selector-search"><input type="text" name="" value="" placeholder="Search icon" class="icons-search-input"/><i class="fip-icon-search"></i></div>': "")+'<div class="fip-icons-container"></div><div class="selector-footer" style="display:none;"><span class="selector-pages">1/2</span><span class="selector-arrows"><span class="selector-arrow-left" style="display:none;"><i class="fip-icon-left-dir"></i></span><span class="selector-arrow-right"><i class="fip-icon-right-dir"></i></span></span></div></div>'});this.iconContainer=this.iconPicker.find(".fip-icons-container");this.searchIcon=this.iconPicker.find(".selector-search i");this.iconsSearched= [];this.isSearch=!1;this.currentPage=this.totalPage=1;this.currentIcon=!1;this.iconsCount=0;this.open=!1;this.init()}var e={source:!1,emptyIcon:!0,iconsPerPage:20,hasSearch:!0};d.prototype={init:function(){this.element.hide();this.element.before(this.iconPicker);!this.settings.source&&this.element.is("select")&&(this.settings.source=[],this.element.find("option").each(a.proxy(function(b,c){a(c).val()&&this.settings.source.push(a(c).val())},this)));this.loadIcons();this.iconPicker.find(".selector-button").click(a.proxy(function(){this.toggleIconSelector()}, this));this.iconPicker.find(".selector-arrow-right").click(a.proxy(function(b){this.currentPage<this.totalPage&&(this.iconPicker.find(".selector-arrow-left").show(),this.currentPage+=1,this.renderIconContainer());this.currentPage===this.totalPage&&a(b.currentTarget).hide()},this));this.iconPicker.find(".selector-arrow-left").click(a.proxy(function(b){1<this.currentPage&&(this.iconPicker.find(".selector-arrow-right").show(),this.currentPage-=1,this.renderIconContainer());1===this.currentPage&&a(b.currentTarget).hide()}, this));this.iconPicker.find(".icons-search-input").keyup(a.proxy(function(b){var c=a(b.currentTarget).val();""===c?this.resetSearch():(this.searchIcon.removeClass("fip-icon-search"),this.searchIcon.addClass("fip-icon-cancel"),this.isSearch=!0,this.currentPage=1,this.iconsSearched=a.grep(this.settings.source,function(a){if(0<=a.search(c.toLowerCase()))return a}),this.renderIconContainer())},this));this.iconPicker.find(".selector-search").on("click",".fip-icon-cancel",a.proxy(function(){this.iconPicker.find(".icons-search-input").focus(); this.resetSearch()},this));this.iconContainer.on("click",".fip-box",a.proxy(function(b){this.setSelectedIcon(a(b.currentTarget).find("i").attr("class"));this.toggleIconSelector()},this));this.iconPicker.click(function(a){a.stopPropagation();return!1});a("html").click(a.proxy(function(){this.open&&this.toggleIconSelector()},this))},loadIcons:function(){this.iconContainer.html('<i class="fip-icon-spin3 animate-spin loading"></i>');this.settings.source instanceof Array&&this.renderIconContainer()},renderIconContainer:function(){var b, c=[],c=this.isSearch?this.iconsSearched:this.settings.source;this.iconsCount=c.length;this.totalPage=Math.ceil(this.iconsCount/this.settings.iconsPerPage);1<this.totalPage?this.iconPicker.find(".selector-footer").show():this.iconPicker.find(".selector-footer").hide();this.iconPicker.find(".selector-pages").text(this.currentPage+"/"+this.totalPage);b=(this.currentPage-1)*this.settings.iconsPerPage;if(this.settings.emptyIcon)this.iconContainer.html('<span class="fip-box"><i class="fip-icon-block"></i></span>'); else{if(1>c.length){this.iconContainer.html('<span class="icons-picker-error"><i class="fip-icon-block"></i></span>');return}this.iconContainer.html("")}c=c.slice(b,b+this.settings.iconsPerPage);b=0;for(var d;d=c[b++];)a("<span/>",{html:'<i class="'+d+'"></i>',"class":"fip-box"}).appendTo(this.iconContainer);this.settings.emptyIcon||this.element.val()&&-1!==a.inArray(this.element.val(),this.settings.source)?-1===a.inArray(this.element.val(),this.settings.source)?this.setSelectedIcon():this.setSelectedIcon(this.element.val()): this.setSelectedIcon(c[0])},setHighlightedIcon:function(){this.iconContainer.find(".current-icon").removeClass("current-icon");this.currentIcon&&this.iconContainer.find("."+this.currentIcon).parent("span").addClass("current-icon")},setSelectedIcon:function(a){"fip-icon-block"===a&&(a="");this.iconPicker.find(".selected-icon").html('<i class="'+(a||"fip-icon-block")+'"></i>');this.element.val(a).triggerHandler("change");this.currentIcon=a;this.setHighlightedIcon()},toggleIconSelector:function(){this.open= this.open?0:1;this.iconPicker.find(".selector-popup").slideToggle(300);this.iconPicker.find(".selector-button i").toggleClass("fip-icon-down-dir");this.iconPicker.find(".selector-button i").toggleClass("fip-icon-up-dir");this.open&&this.iconPicker.find(".icons-search-input").focus().select()},resetSearch:function(){this.iconPicker.find(".icons-search-input").val("");this.searchIcon.removeClass("fip-icon-cancel");this.searchIcon.addClass("fip-icon-search");this.iconPicker.find(".selector-arrow-left").hide(); this.currentPage=1;this.isSearch=!1;this.renderIconContainer();1<this.totalPage&&this.iconPicker.find(".selector-arrow-right").show()}};a.fn.fontIconPicker=function(b){this.each(function(){a.data(this,"fontIconPicker")||a.data(this,"fontIconPicker",new d(this,b))});this.setIcons=a.proxy(function(b){this.each(function(){a.data(this,"fontIconPicker").settings.source=b;a.data(this,"fontIconPicker").resetSearch();a.data(this,"fontIconPicker").loadIcons()})},this);return this}})(jQuery);