<?php
// Output option-based style
if( !function_exists( 'salon_salon_style') ) :
	function salon_salon_style() {
		ob_start();
		global $ozySalonHelper, $post;

		// is page based styling enabled?
		$body_style = $content_background_color = $transparent_content_background = '';
		$page_id = get_the_ID();
				
		if(vp_metabox('ozy_salon_meta_page.ozy_salon_meta_page_use_custom_style', null, $page_id) == '1') {
			$_var = 'ozy_salon_meta_page.ozy_salon_meta_page_layout_group.0.ozy_salon_meta_page_layout_';
			$content_background_color 		= vp_metabox($_var . 'ascend_background', null, $page_id);
			$transparent_content_background = vp_metabox($_var . 'transparent_background', null, $page_id);
		}else{
			$content_background_color 		= salon_get_option('content_background_color', null, $page_id);
		}
		
		if(vp_metabox('ozy_salon_meta_page.ozy_salon_meta_page_use_custom_background', null, $page_id) == '1' && !is_search()) {
			$_var = 'background_group.0.ozy_salon_meta_page_background_';
			$body_style = $ozySalonHelper->background_style_render(
				salon_get_metabox($_var . 'color', null, $page_id),
				salon_get_metabox($_var . 'image', null, $page_id),
				salon_get_metabox($_var . 'image_size', null, $page_id),
				salon_get_metabox($_var . 'image_repeat', null, $page_id),
				salon_get_metabox($_var . 'image_attachment', null, $page_id),
				false,
				salon_get_metabox($_var . 'image_pos_x', null, $page_id),
				salon_get_metabox($_var . 'image_pos_y', null, $page_id)				
			);
		}else{
			if(is_singular('ozy_portfolio') || is_page_template('page-portfolio.php')) {
				// Custom background for portfolio post				
				$body_style = $ozySalonHelper->background_style_render(salon_get_option('portfolio_body_background_color', null, $page_id), '', '', '', '');
			}else{
				$_var = 'body_background_';
				$body_style = $ozySalonHelper->background_style_render(
					salon_get_option($_var . 'color', null, $page_id), 
					salon_get_option($_var . 'image', null, $page_id), 
					salon_get_option($_var . 'image_size', null, $page_id), 
					salon_get_option($_var . 'image_repeat', null, $page_id), 
					salon_get_option($_var . 'image_attachment', null, $page_id)
				);
			}
		}
	
	?>
		<style type="text/css">
			@media only screen and (min-width: 1212px) {
				.container{padding:0;width:<?php echo salon_gd('container_width'); ?>px;}
				#content{width:<?php echo salon_gd('content_width'); ?>px;}
				#sidebar{width:<?php echo salon_gd('sidebar_width'); ?>px;}
			}
	
			/* Body Background Styling */
			#main{<?php echo $body_style; ?>}
		
			/* Layout and Layout Styling */
			#main.header-slider-active>.container,
			#main.footer-slider-active>.container{padding-top:0px;}
			#footer,#footer-widget-bar,#footer-widget-bar-sticky,.top,.salon-btt:before {
				font-family:<?php echo salon_get_option('footer_typography_font_face', 'Playfair Display')?>;
				background-color:<?php echo salon_get_option('footer_color_1', 'rgba(0,0,0,1)');?>;
			}
			#footer-widget-bar h1,#footer-widget-bar h2,#footer-widget-bar h3,#footer-widget-bar h4,#footer-widget-bar h5,#footer-widget-bar h6,#back-to-top-wrapper a,#back-to-top-wrapper a span,.ozy-twitter-widget-icon>span,#footer-widget-bar #social-icons>a>span,#footer-widget-bar-sticky * {color:<?php echo salon_get_option('footer_color_5', '#ffffff');?> !important;}			
			#footer *,#footer-widget-bar *,#footer-widget-bar-sticky #close-footer-info-bar {color:<?php echo salon_get_option('footer_color_2', '#ffffff');?>;}			
			#footer a,
			#footer-widget-bar a,
			.ozy-twitter-widget div>span {color:<?php echo salon_get_option('footer_color_2', '#04c1ff');?> !important;}
			#footer-widget-bar{border-top-color:<?php echo salon_get_option('footer_color_4', 'rgba(255,255,255,.10)');?> !important;}
			#footer-widget-bar-sticky>.container.info-bar,
			#footer-widget-bar-sticky #close-footer-info-bar {background-color:<?php echo salon_get_option('footer_info_bg', 'rgba(29,27,27,1)');?>;}
			#footer-widget-bar form input:not([type=checkbox]):not([type=radio]) {
				background-color:<?php echo salon_get_option('footer_color_1', '#000000');?> !important;
				color:<?php echo salon_get_option('footer_color_2', '#ffffff');?> !important;
				border-color:<?php echo salon_get_option('footer_color_2', '#ffffff');?> !important;
			}
			#footer>footer>.container hr {
				background-color:<?php echo salon_get_option('footer_color_4', '#ffffff');?> !important;
			}
		<?php
			$menu_logo_height = salon_get_option('primary_menu_height', '100') . 'px';
		
			echo $transparent_content_background == '1' ? '	#main{background-color:transparent !important;}' . PHP_EOL : '';

			$footer_background_image = salon_get_option('footer_background_image');
			if($footer_background_image) { echo '#footer{background:url('. $footer_background_image .') repeat center center;}'; }

			?>
			/* Header Over Primary Menu Styling */
			.logo h1>a{color:<?php echo salon_get_option('primary_menu_font_color_hover'); ?>;}

			.salon-navigation-wrapper, .salon-nav-trigger, body{background-color:<?php echo salon_get_option('primary_menu_background_color'); ?>;}
			.salon-nav .salon-primary-nav,
			.salon-nav .salon-primary-nav a {
				<?php
				echo $ozySalonHelper->font_style_render(
					salon_get_option('primary_menu_typography_font_face'), 
					salon_get_option('primary_menu_typography_font_weight'), 
					salon_get_option('primary_menu_typography_font_style'), 
					salon_get_option('primary_menu_typography_font_size') . 'px', 
					salon_get_option('primary_menu_typography_line_height') . 'em', 
					salon_get_option('primary_menu_font_color')
				);
				?>				
			}
			.salon-nav .salon-primary-nav>li li,
			.salon-nav .salon-primary-nav>li li a {
				font-size: <?php echo ((int)(salon_get_option('primary_menu_typography_font_size') / 2.4)) . 'px';  ?>;
				line-height: 1.8em;
			}
			.salon-nav .salon-primary-nav>li li:after {
				top: <?php echo (salon_get_option('primary_menu_typography_font_size') / 3) . 'px';  ?>;
			}
			.salon-navigation-wrapper .salon-half-block {
				<?php
				echo $ozySalonHelper->font_style_render(
					salon_get_option('primary_menu_typography_font_face'), 
					salon_get_option('primary_menu_typography_font_weight'), 
					salon_get_option('primary_menu_typography_font_style'), 
					'',
					'',
					salon_get_option('primary_menu_font_color')
				);
				?>					
			}
			.salon-nav-trigger .salon-nav-icon{background-color:<?php echo salon_get_option('primary_menu_font_color_hover') ?>;}
			.salon-nav-trigger svg>circle{stroke:<?php echo salon_get_option('primary_menu_font_color') ?>;}
			
			.salon-nav h2,
			.salon-nav .salon-primary-nav a.selected,
			.no-touch .salon-nav .salon-primary-nav a:hover,
			.salon-nav .salon-contact-info a,
			li.menu-item.current-menu-item>a,
			li.menu-item.current_page_ancestor>a {color:<?php echo $ozySalonHelper->rgba2rgb(salon_get_option('primary_menu_font_color_hover')) ?>;}
			
			.primary-menu-bar-wrapper ul.menu li{
				<?php
				echo $ozySalonHelper->font_style_render(
					salon_get_option('primary_menu_typography_font_face'), 
					salon_get_option('primary_menu_typography_font_weight'), 
					salon_get_option('primary_menu_typography_font_style'), 
					salon_get_option('primary_menu_typography_font_size') . 'px', 
					salon_get_option('primary_menu_typography_line_height') . 'em', 
					salon_get_option('primary_menu_font_color')
				);
				
				$menu_normal_color = salon_get_option('primary_menu_font_color'); //used for alternate sandwich menu color
				$menu_hover_color = salon_get_option('primary_menu_font_color_hover'); //used for alternate sandwich menu color
				?>
			}
			.primary-menu-bar-wrapper #menu-social-icons>div{background-color:<?php echo salon_get_option('primary_menu_font_color'); ?>;}
			.primary-menu-bar-wrapper #menu-social-icons>a>span,
			.primary-menu-bar-wrapper ul.menu li a{color:<?php echo salon_get_option('primary_menu_font_color'); ?>;}
			.primary-menu-bar-wrapper #menu-social-icons>a:hover>span,
			.primary-menu-bar-wrapper ul.menu li:not(.dropdown):hover a{color:<?php echo salon_get_option('primary_menu_font_color_hover'); ?>;}
			.primary-menu-bar-wrapper nav:before{background-color:<?php echo salon_get_option('primary_menu_background_color'); ?>;}
			.primary-menu-bar-wrapper button:before {background:<?php echo $menu_hover_color; ?>;box-shadow: 0 0.25em 0 0 <?php echo $menu_hover_color; ?>, 0 0.5em 0 0 <?php echo $menu_hover_color; ?>;}
			body.ozy-logo-alternate .primary-menu-bar-wrapper button:before {background:<?php echo $menu_normal_color; ?>;box-shadow: 0 0.25em 0 0 <?php echo $menu_normal_color; ?>, 0 0.5em 0 0 <?php echo $menu_normal_color; ?>;}

			<?php
				$menu_normal_color = $ozySalonHelper->change_opacity($menu_normal_color, '.4');
				$menu_hover_color = $ozySalonHelper->change_opacity($menu_hover_color, '.4');
			?>
			.primary-menu-bar-wrapper button.two:before {background:<?php echo $menu_normal_color; ?>;box-shadow: 0 0.25em 0 0 <?php echo $menu_normal_color; ?>, 0 0.5em 0 0 <?php echo $menu_normal_color; ?>;}
			body.ozy-logo-alternate .primary-menu-bar-wrapper button.two:before {background:<?php echo $menu_hover_color; ?>;box-shadow: 0 0.25em 0 0 <?php echo $menu_hover_color; ?>, 0 0.5em 0 0 <?php echo $menu_hover_color; ?>;}
			/* Language Switcher */
			.lang-switcher-booking-button-wrapper{background-color:<?php echo salon_get_option('primary_menu_font_color_hover') ?>;border-color:<?php echo salon_get_option('primary_menu_font_color_hover') ?>;}
			.lang-switcher-booking-button-wrapper>div>a,.lang-switcher-booking-button-wrapper>div>span{color:<?php echo salon_get_option('primary_menu_background_color') ?>;}
			
			/* Widgets */
			.widget li>a{color:<?php echo salon_get_option('content_color'); ?> !important;}
			.widget li>a:hover{color:<?php echo salon_get_option('content_color_alternate'); ?> !important;}
			.ozy-latest-posts>a>span,.lSSlideOuter .lSPager.lSpg>li.active a, .lSSlideOuter .lSPager.lSpg>li:hover a{
				background-color:<?php echo salon_get_option('content_color_alternate') ?>;
				color:<?php echo salon_get_option('content_color') ?>;
			}
						
			/* Page Styling and Typography */
			.content-color-alternate, .content-color-alternate a, .content-color-alternate p{color:<?php echo salon_get_option('content_color_alternate'); ?> !important;}			
			.content-color-alternate2, .content-color-alternate2 a, .content-color-alternate2 p{color:<?php echo salon_get_option('content_color_alternate2'); ?> !important;}
			.content-color-alternate3, .content-color-alternate3 a, .content-color-alternate3 p{color:<?php echo salon_get_option('content_color_alternate3'); ?> !important;}
			.content-color-alternate4,.nav-box>h4,.nav-box>a>span,h4.ozy-related-posts-title {color:<?php echo salon_get_option('content_color_alternate4'); ?> !important;}
			.heading-color, .heading-color a,h1.content-color>a,h2.content-color>a,h3.content-color>a,
			h4.content-color>a,h5.content-color>a,h6.content-color>a,blockquote,.a-page-title {color:<?php echo salon_get_option('heading_color'); ?> !important;}
			.ozy-footer-slider,.content-font,.ozy-header-slider,#content, #sidebar,#footer,.tooltipsy{
				<?php echo $ozySalonHelper->font_style_render(salon_get_option('typography_font_face'), 
				salon_get_option('typography_font_weight'), 
				salon_get_option('typography_font_style'), 
				salon_get_option('typography_font_size') . 'px', 
				salon_get_option('typography_font_line_height') . 'em', 
				salon_get_option('content_color'));?>
			}
			.content-font-family{font-family:<?php echo salon_get_option('typography_font_face'); ?>}
			.lg-sub-html{font-family:<?php echo salon_get_option('typography_font_face') ?>}/*light gallery caption*/
			#content a:not(.ms-btn):not(.vc_btn3),#sidebar a,#footer a,.alternate-text-color,#footer-widget-bar>.container>.widget-area a:hover,.fancybox-inner a,.item__details ul li:first-child {			color:<?php echo salon_get_option('content_color_alternate');?>;}
			#ozy-share-div>a>span,.page-pagination a {
				background-color:<?php echo salon_get_option('content_background_color_alternate');?> !important;
				color:<?php echo salon_get_option('content_color');?> !important;
			}
			.page-pagination a.current{
				background-color:<?php echo salon_get_option('content_color_alternate');?> !important;
				color:<?php echo salon_get_option('content_color_alternate2');?> !important;
			}			
			.fancybox-inner{color:<?php echo salon_get_option('content_color');?> !important;}
			.header-line{background-color:<?php echo salon_get_option('primary_menu_separator_color') ?>;}
			.a-page-title:hover{border-color:<?php echo salon_get_option('heading_color');?> !important;}
			.nav-box a, .ozy-related-posts a,#page-title-wrapper h1,#page-title-wrapper h4,
			#side-nav-bar a,#side-nav-bar h3,#content h1,
			#sidebar .widget h1,#content h2,#sidebar .widget h2,
			#content h3,#sidebar .widget h3,#content h4,
			#sidebar .widget h4,#content h5,#sidebar .widget h5,
			#content h6,#sidebar .widget h6,.heading-font,
			#logo,#tagline,.fancybox-inner{<?php echo $ozySalonHelper->font_style_render(salon_get_option('typography_heading_font_face'), '', '', '', '', salon_get_option('heading_color'));?>}
			#page-title-wrapper h1,#content h1,#footer-widget-bar h1,
			#sidebar h1,#footer h1,#sidr h1{
					<?php echo $ozySalonHelper->font_style_render('', 
				salon_get_option('typography_heading_font_weight_h1'), 
				salon_get_option('typography_heading_h1_font_style'), 
				salon_get_option('typography_heading_h1_font_size') . 'px', 
				salon_get_option('typography_heading_line_height_h1', '1.5') . 'em', '', '', 
				salon_get_option('typography_heading_font_ls_h1'));?>
			}
			#footer-widget-bar .widget-area h4,
			#sidebar .widget>h4,
			h4.heading-h4 {
				<?php echo $ozySalonHelper->font_style_render('', 
				salon_get_option('typography_heading_font_weight_h4'), 
				salon_get_option('typography_heading_h4_font_style'), 
				salon_get_option('typography_heading_h4_font_size') . 'px', 
				salon_get_option('typography_heading_line_height_h4', '1.5') . 'em', '', '',
				salon_get_option('typography_heading_font_ls_h4'));?>
			}
			#content h2,#footer-widget-bar h2,#sidebar h2,
			#footer h2,#sidr h2{
				<?php echo $ozySalonHelper->font_style_render('', 
				salon_get_option('typography_heading_font_weight_h2'), 
				salon_get_option('typography_heading_h2_font_style'), 
				salon_get_option('typography_heading_h2_font_size') . 'px', 
				salon_get_option('typography_heading_line_height_h2', '1.5') . 'em', '', '',
				salon_get_option('typography_heading_font_ls_h2'));?>;
			}
			#content h3,#footer-widget-bar h3,#sidebar h3,#footer h3,#sidr h3{
				<?php echo $ozySalonHelper->font_style_render('', 
				salon_get_option('typography_heading_font_weight_h3'), 
				salon_get_option('typography_heading_h3_font_style'), 
				salon_get_option('typography_heading_h3_font_size') . 'px', 
				salon_get_option('typography_heading_line_height_h3', '1.5') . 'em', '', '',
				salon_get_option('typography_heading_font_ls_h3'));?>;
			}
			#content h4,#page-title-wrapper h4,#footer-widget-bar h4,
			#sidebar h4,#footer h4,#sidr h4{
				<?php echo $ozySalonHelper->font_style_render('', 
				salon_get_option('typography_heading_font_weight_h4'), 
				salon_get_option('typography_heading_h4_font_style'), 
				salon_get_option('typography_heading_h4_font_size') . 'px', 
				salon_get_option('typography_heading_line_height_h4', '1.5') . 'em', '', '',
				salon_get_option('typography_heading_font_ls_h4'));?>;
			}
			#content h5,#footer-widget-bar h5,#sidebar h5,#footer h5,#sidr h5 {
				<?php echo $ozySalonHelper->font_style_render('', 
				salon_get_option('typography_heading_font_weight_h5'), 
				salon_get_option('typography_heading_h5_font_style'), 
				salon_get_option('typography_heading_h5_font_size') . 'px', 
				salon_get_option('typography_heading_line_height_h5', '1.5') . 'em', '', '',
				salon_get_option('typography_heading_font_ls_h5'));?>;
			}
			#content h6,#footer-widget-bar h6,#sidebar h6,#footer h6,#sidr h6{
				<?php echo $ozySalonHelper->font_style_render('', 
				salon_get_option('typography_heading_font_weight_h6'), 
				salon_get_option('typography_heading_h6_font_style'), 
				salon_get_option('typography_heading_h6_font_size') . 'px', 
				salon_get_option('typography_heading_line_height_h6', '1.5') . 'em', '', '',
				salon_get_option('typography_heading_font_ls_h6'));?>;
			}
			body.single h2.post-title,.post-single h2.post-title {
				<?php echo $ozySalonHelper->font_style_render('', 
				salon_get_option('typography_heading_font_weight_h1'), 
				salon_get_option('typography_heading_h1_font_style'), 
				salon_get_option('typography_heading_h1_font_size') . 'px', 
				'1.1em', '', '!important', 
				salon_get_option('typography_heading_font_ls_h1'));?>
			}			
			#footer-widget-bar .widget a:hover,
			#sidebar .widget a:hover{color:<?php echo salon_get_option('content_color')?>;}
			span.plus-icon>span{background-color:<?php echo salon_get_option('content_color')?>;}
			.content-color,#single-blog-tags>a{color:<?php echo salon_get_option('content_color'); ?> !important;}		
			
			/* Forms */
			input,select,textarea{
				<?php echo $ozySalonHelper->font_style_render(salon_get_option('typography_font_face'), 
				salon_get_option('typography_font_weight'), 
				salon_get_option('typography_font_style'), 
				salon_get_option('typography_font_size') . 'px', 
				salon_get_option('typography_font_line_height') . 'em', 
				salon_get_option('form_font_color'));?>
			}
			.lightbox-book-me-now {
				color:<?php echo salon_get_option('form_button_font_color_hover')?> !important;
			}
			.wp-search-form i.oic-zoom{color:<?php echo salon_get_option('form_font_color') ?>;}
			input:not([type=submit]):not([type=radio]):not([type=checkbox]):not([type=file]),select,textarea{
				background-color:<?php echo salon_get_option('form_background_color')?>;
				border-color:<?php echo salon_get_option('form_background_color')?> !important;
			}
			#content input:not([type=submit]):not([type=radio]):not([type=checkbox]):not([type=file]):hover,#content textarea:hover,
			#content input:not([type=submit]):not([type=radio]):not([type=checkbox]):not([type=file]):focus,#content textarea:focus{border-color:<?php echo salon_get_option('content_color_alternate')?> !important;}
			.generic-button,input[type=button],input[type=submit],button[type=submit],.tagcloud>a{
				color:<?php echo $ozySalonHelper->rgba2rgb(salon_get_option('form_button_font_color'))?> !important;
				background-color:<?php echo salon_get_option('form_button_background_color')?>;
				border:1px solid <?php echo salon_get_option('form_button_background_color')?>;
			}
			input[type=button]:hover,input[type=submit]:hover,button[type=submit]:hover,.tagcloud>a:hover{
				background-color:<?php echo $ozySalonHelper->rgba2rgb(salon_get_option('form_button_background_color_hover'))?>;
				color:<?php echo $ozySalonHelper->rgba2rgb(salon_get_option('form_button_font_color_hover'))?> !important;
				border:1px solid <?php echo salon_get_option('form_button_background_color_hover')?>;
			}			
			
			/* Blog Comments & Blog Stuff */
			.post.regular-blog{background-color:<?php echo salon_get_option('content_background_color_alternate') ?> !important;}
			#comments>h3>span{background-color:<?php echo salon_get_option('content_color_alternate') ?>;}
			.comment-body>.comment-meta.commentmetadata>a,.comment-body .reply>a,#commentform .form-submit .submit{color:<?php echo salon_get_option('content_color') ?> !important}
			#commentform .form-submit .submit{border-color:<?php echo salon_get_option('content_color') ?> !important;}
			#commentform .form-submit .submit:hover{border-color:<?php echo salon_get_option('content_color_alternate') ?> !important;}
			.post-meta p.g{color:<?php echo salon_get_option('content_color_alternate2')?>;}	
			.ozy-related-posts .caption,
			.ozy-related-posts .caption>h4>a{
				color:<?php echo salon_get_option('content_background_color') ?> !important;
				background-color:<?php echo salon_get_option('content_color') ?>;
			}
			.super-header-share-buttons>a{
				background-color:<?php echo salon_get_option('content_color_alternate2') ?>;
				color:<?php echo salon_get_option('content_color_alternate3') ?>;
			}
			.super-header-share-buttons>a:hover,
			.super-header-share-buttons>a:active{
				background-color:<?php echo salon_get_option('content_color_alternate') ?>;
			}			
			/*post formats*/
			.simple-post-format>div>span,.simple-post-format>div>h2,.simple-post-format>div>p,
			.simple-post-format>div>p>a,.simple-post-format>div>blockquote,.post-excerpt-audio>div>div{color:<?php echo $ozySalonHelper->rgba2rgb(salon_get_option('content_background_color'))?> !important;}
			div.sticky.post-single {
				background-color:<?php echo salon_get_option('primary_menu_separator_color') ?>;
				border-color:<?php echo salon_get_option('content_color_alternate') ?>;
			}
			#content .post .post-meta {
				position:absolute;left:20px;top:20px;width:65px;padding:8px 0 0 0;
				background-color: <?php echo salon_get_option('content_color_alternate')?>;
				text-align:center;
				z-index:1;
			}
			#content .post .post-meta span {display:block;font-weight:400;padding-bottom:4px !important;}
			#content .post .post-meta span.d,
			#content .post .post-meta span.c>span.n {font-size:24px !important;line-height:24px !important;font-weight:700;}
			#content .post .post-meta span.c>span.t {font-size:8px !important;line-height:10px !important;}
			#content .post .post-meta span.m,
			#content .post .post-meta span.y,
			#content .post .share-box>span {
				font-size:10px !important;line-height:12px !important;
				color: <?php echo salon_get_option('content_color_alternate4')?> !important;
				text-transform:uppercase;
			}
			#content .post .post-meta span.d{font-weight:700 !important;color: <?php echo salon_get_option('content_color_alternate4')?> !important;}
			#content .post .post-meta span.c {
				padding-top:8px;background-color: <?php echo salon_get_option('content_color_alternate4')?>;
				color: <?php echo salon_get_option('content_color_alternate3')?>;
			}
			
			/* Shortcodes */
			.flickity-page-dots .dot{background-color:<?php echo salon_get_option('content_color') ?>;}
			.flickity-page-dots .dot.is-selected{background-color:<?php echo salon_get_option('content_color_alternate') ?>;}
			
			.ozy-button.auto,.wpb_button.wpb_ozy_auto{
				background-color:<?php echo salon_get_option('form_button_background_color') ?>;
				color:<?php echo salon_get_option('form_button_font_color')?>;
			}
			.ozy-button.auto:hover,
			.wpb_button.wpb_ozy_auto:hover{
				border-color:<?php echo salon_get_option('form_button_background_color_hover') ?>;
				color:<?php echo salon_get_option('form_button_font_color_hover') ?> !important;
				background-color:<?php echo salon_get_option('form_button_background_color_hover')?>;
			}			
			.ozy-call-to-action-box>div.overlay-wrapper>a:hover{
				background-color:<?php echo salon_get_option('content_color_alternate') ?> !important;
				border-color:<?php echo salon_get_option('content_color_alternate') ?> !important;
			}
			.ozy-call-to-action-box>div.overlay-wrapper>a {border-color:<?php echo salon_get_option('content_color_alternate3') ?> !important;}
			.ozy-call-to-action-box>div.overlay-wrapper>a,
			.ozy-call-to-action-box>div.overlay-wrapper>h2{color:<?php echo salon_get_option('content_color_alternate3') ?> !important;}
			.ozy-canvas-slider-wrapper nav.btns button:hover{
				background-color:<?php echo salon_get_option('content_color_alternate') ?> !important;
				color:<?php echo salon_get_option('content_color_alternate3') ?> !important;
			}
			
			/* Fancy Post Accordion */
			.ozy-fancyaccordion-feed tr.title td:last-child h3,
			.ozy-fancyaccordion-feed tr.excerpt td:last-child p>a {
				color:<?php echo salon_get_option('content_color') ?> !important;
			}
			.ozy-fancyaccordion-feed tr.excerpt td:last-child p>a {
				border-color:<?php echo salon_get_option('content_color') ?> !important;
			}
			.ozy-fancyaccordion-feed tr.title:hover td:last-child h3,
			.ozy-fancyaccordion-feed tr.title.open td:last-child h3 {
				color:<?php echo salon_get_option('content_color_alternate') ?> !important;
			}
			.ozy-fancyaccordion-feed tr.title td:first-child span {
				background-color:<?php echo salon_get_option('content_color') ?> !important;
				color:<?php echo salon_get_option('content_color_alternate3') ?> !important;
			}
			.ozy-fancyaccordion-feed tr.title:hover td:first-child span,
			.ozy-fancyaccordion-feed tr.title.open td:first-child span {
				background-color:<?php echo salon_get_option('content_color_alternate') ?> !important;
				color:<?php echo salon_get_option('content_color_alternate3') ?> !important;
			}	
			
			/* Shared Border Color */			
			.ozy-fancyaccordion-feed td, .post .pagination>a,.ozy-border-color,#ozy-share-div.ozy-share-div-blog,.page-content table td,#content table tr,.post-content table td,.ozy-toggle .ozy-toggle-title, .ozy-toggle-inner,.ozy-tabs .ozy-nav li a,.ozy-accordion>h6.ui-accordion-header,.ozy-accordion>div.ui-accordion-content,.chat-row .chat-text,#sidebar .widget>h4,
			#sidebar .widget li,.ozy-content-divider,#post-author,.single-post .post-submeta>.blog-like-link,.widget ul ul,blockquote,.page-pagination>a,.page-pagination>span,#content select,body.search article.result,div.rssSummary,#content table tr td,#content table tr th,.widget .testimonial-box,
			.facts-bar,.facts-bar>.heading,.ozy-tabs-menu li,.ozy-tab,#ozy-tickerwrapper,#ozy-tickerwrapper>strong,#single-blog-tags>a,.comment-body,#comments-form h3#reply-title,.ozy-news-box-ticker-wrapper .news-item, .shared-border-color {border-color:<?php echo salon_get_option('primary_menu_separator_color') ?>!important;}
			#content table tr.featured {border:2px solid <?php echo salon_get_option('content_color_alternate') ?> !important;}
			#ozy-tickerwrapper div.pagination>a.active>span,
			.header-line>span{background-color:<?php echo salon_get_option('content_color_alternate') ?>;}
			
			/* Specific heading styling */	
		<?php
			$use_no_page_title_margin = $custom_header = false;
			if(!is_search() && !is_404() && isset($post->ID)) {
				/*to get custom post*/
				$post_id = $post->ID;		
				if (is_single() && isset($post->post_type) && $post->post_type === 'post' && (int)salon_get_option('page_blog_page_id')>0) { $post_id = salon_get_option('page_blog_page_id'); }
				
				if(salon_get_metabox('use_custom_title', 0, $post_id) == '1') {
					$_var = 'use_custom_title_group.0.ozy_salon_meta_page_custom_title_';
					$h_height 	= salon_get_metabox($_var . 'height', '90', $post_id);
					$h_bgcolor 	= salon_get_metabox($_var . 'bgcolor', '', $post_id);
					$h_bgimage 	= salon_get_metabox($_var . 'bg', '', $post_id);
					$h_bg_xpos	= salon_get_metabox($_var . 'bg_x_position', '', $post_id);
					$h_bg_ypos	= salon_get_metabox($_var . 'bg_y_position', '', $post_id);
					
					$h_css = (int)$h_height > 0 ? 'height:'. $h_height .'px;' : '';
					$h_css.= (int)$h_height > 0 ? $ozySalonHelper->background_style_render($h_bgcolor, $h_bgimage, 'cover', 'repeat', 'inherit', true, $h_bg_xpos, $h_bg_ypos) : '';
					echo '#page-title-wrapper{'. $h_css .'}';					
					$h_title_color = salon_get_metabox($_var . 'color', 0, $post_id);
					if($h_title_color) {
						echo '#page-title-wrapper>div>h1{
							color:'. $h_title_color .';
						}';
					}
					$h_sub_title_color = salon_get_metabox('use_custom_title_group.0.ozy_salon_meta_page_custom_sub_title_color', 0, $post_id);
					if($h_sub_title_color) {
						echo '#page-title-wrapper>div>h4{
							color:'. $h_sub_title_color .';
							font-weight:300;
						}';
					}
					
					$h_title_position = salon_get_metabox($_var . 'position', 0, $post_id);
					if($h_title_position) {
						echo '#page-title-wrapper>div>h1,
						#page-title-wrapper>div>h4{
							text-align:'. $h_title_position .';
							font-weight:300;
						}';
					}
					$custom_header = true;
				}else{
					echo '#page-title-wrapper{
						height:90px;
					}';
				}
			}else{				
				echo '#page-title-wrapper{
					height:90px;
				}';
			}
			
			$use_no_menu_space = vp_metabox('ozy_salon_meta_page.ozy_salon_meta_page_no_menu_space', null, $page_id);
			if($use_no_menu_space === '1') {
				echo '#main{padding-top:0!important}';
			}else{
				echo '@media only screen and (min-width: 479px) { body:not(.full-page-template) #main{padding-top:'. $menu_logo_height .';} }';
				echo '@media only screen and (max-width: 479px) { body:not(.full-page-template) #main{padding-top:'. ((int)$menu_logo_height/2) .'px;} }';
			}
			if(salon_get_metabox('use_no_content_padding') === '1') {
				echo '#main>.container{
					padding-top:0!important;
				}';
			}
			echo 'body.full-page-template{#main{padding-top:0!important}}';
		?>		
			
			/* Conditional Page Template Styles */
			<?php
			if(is_home() || is_category() || is_archive() || is_tag() || is_author()) {
				echo '#main{background-color:'. salon_get_option('content_background_color_alternate') .' !important}';
			}
			if(is_page_template('page-big-blog.php')) {
				echo '.big-blog-post-submeta>a.button{color:'. salon_get_option('content_color') .' !important}';
				echo '.big-blog-post-submeta>a.button>i,.big-blog-category{color:'. salon_get_option('heading_color') .'}';
				echo 'body.page-template-page-big-blog .big-blog-date-category-seperator{background-color:'. salon_get_option('heading_color') .'}';
				echo 'body.page-template-page-big-blog .post.regular-blog{border-color:'. salon_get_option('heading_color') .'}';
			}
			if(is_page_template('page-full-blog.php')) {
				echo '.page-template-page-full-blog-php .share-buttons a:hover{background-color:'. salon_get_option('content_color_alternate') .';}';				
			}
			if (is_single() && isset($post->post_type) && $post->post_type === 'ozy_portfolio') {
				echo '#main {padding-top:'. $menu_logo_height .';}';
				echo '.portfolio-single-title{color:'. salon_get_option('heading_color', '#000') .';}';
			}
			if(is_page_template('page-portfolio.php')) {
			?>			
			.button-container .button {
				color:<?php echo salon_get_option('content_color', '#fff') ?>!important;
			}
			.button-container .button:hover {
				color:<?php echo salon_get_option('content_color_alternate', '#30303c') ?>!important;
			}			
			#portfolio-filter>li>a {
				color:<?php echo salon_get_option('content_color', '#fff') ?>!important;
			}
			#portfolio-filter>li.active>a {
				color:<?php echo salon_get_option('content_color_alternate', '#fff') ?>!important;
			}
			#portfolio-filter>li.active {
				border-color:currentColor;
			}
			body.page-template-page-portfolio .lightgallery.plus-icon {
				color:<?php echo salon_get_option('content_color', '#fff') ?>!important;
				background-color:<?php echo salon_get_option('content_color_alternate3', '#30303c') ?>!important;
			}
			.wpb_wrapper.isotope>.ozy_portfolio>.featured-thumbnail>.caption>.heading>a{color:<?php echo salon_get_option('content_color_alternate3', '#30303c') ?>!important;}
			.wpb_wrapper.isotope>.ozy_portfolio>.featured-thumbnail>.caption>p{color:<?php echo salon_get_option('content_color_alternate', '#30303c') ?>!important;}
			<?php
			}
			
			if(is_page_template('page-big-blog.php')) {
				echo '.big-blog-post-submeta>a.button{color:'. salon_get_option('content_color') .' !important}';
				echo '.big-blog-post-submeta>a.button>i,.big-blog-category{color:'. salon_get_option('heading_color') .'}';
				echo 'body.page-template-page-big-blog .big-blog-date-category-seperator{background-color:'. salon_get_option('heading_color') .'}';
				echo 'body.page-template-page-big-blog .post.regular-blog{border-color:'. salon_get_option('heading_color') .'}';
			}						
			$ozySalonHelper->render_custom_fonts();
			?>					
			.nav-box-wrapper>div,
			.ozy-related-posts-wrapper>div,
			#content.no-vc,
			body.single-post #content,
			.ozy-page-model-full #page-title-wrapper>div,
			.featured-thumbnail-header>div>div>div,
			.ozy-page-model-boxed #main {max-width:<?php echo salon_gd('container_width'); ?>px !important;} /*1212*/			
			body:not(.single):not(.single-ozy_portfolio) #content.no-sidebar {width:<?php echo (int)salon_gd('container_width')-72; ?>px;} /*1140*/
			#footer-widget-bar-sticky>.container.info-bar>section {max-width:<?php echo (int)salon_gd('container_width')-32; ?>px;} /*1180*/
			body.page-template-page-regular-blog .ozy-header-slider,
			body.single #content.no-vc {max-width:<?php echo (int)salon_gd('container_width')-72; ?>px;} /*1140*/
			@media only screen and (max-width: 768px) {
				.nav-box-wrapper>div,
				.ozy-related-posts-wrapper>div,
				#content.no-vc,
				body.single-post #content,
				.ozy-page-model-full #page-title-wrapper>div,
				.ozy-page-model-boxed #main {width:<?php echo salon_gd('container_width'); ?>px !important;width:100% !important;}
			}

		</style>
		<?php
		echo $ozySalonHelper->salon_trim_all(ob_get_clean());		
	}
	add_action( 'wp_head', 'salon_salon_style', 99 );
endif;
?>