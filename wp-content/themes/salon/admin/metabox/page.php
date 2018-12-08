<?php

return array(
	'id'          => 'ozy_salon_meta_page',
	'types'       => array('page'),
	'title'       => esc_attr__('Page Options', 'salon'),
	'priority'    => 'high',
	'template'    => array(
		array(
			'type' => 'toggle',
			'name' => 'ozy_salon_meta_page_use_transparent_menu',
			'label' => esc_attr__('Transparent Menu', 'salon'),
			'description' => esc_attr__('Check this option to use transparent menu layout even on scroll event.', 'salon'),
		),
		array(
			'type' => 'toggle',
			'name' => 'ozy_salon_meta_page_footer_info_bar',
			'label' => esc_attr__('Show Footer Sticky Info Bar', 'salon'),
			'description' => wp_kses(__('Turn this option to hide footer sticky info bar for this page. Please visit <a href="themes.php?page=vpt_option#_ozy_salon_footer">Theme Options > Layout > Footer</a> section to manage it globally. To fill the bar, visit <a href="widgets.php">Appearance > Widgets</a>', 'salon'), array('a' => array('href' => array()))),
			'default' => 0
		),			
		array(
			'type' => 'select',
			'name' => 'ozy_salon_meta_page_custom_menu',
			'label' => esc_attr__('Custom Menu', 'salon'),
			'description' => esc_attr__('You can select a custom menu for this page.', 'salon'),
			'items' => array(
				'data' => array(
					array(
						'source' => 'function',
						'value' => 'vp_bind_ozy_salon_list_wp_menus',
					),
				),
			),
			'default' => '-1',
		),
		array(
			'type' => 'select',
			'name' => 'ozy_salon_meta_page_revolution_slider',
			'label' => esc_attr__('Revolution Header Slider', 'salon'),
			'description' => esc_attr__('You can select a header slider if you have installed and activated Revolution Slider which comes bundled with your theme.', 'salon'),
			'items' => array(
				'data' => array(
					array(
						'source' => 'function',
						'value' => 'vp_bind_ozy_salon_revolution_slider',
					),
				),
			),
			'default' => '{{first}}',
		),
		array(
			'type' => 'select',
			'name' => 'ozy_salon_meta_page_master_slider',
			'label' => esc_attr__('Master Header Slider', 'salon'),
			'description' => esc_attr__('You can select a header slider if you have installed and activated Master Slider which comes bundled with your theme.', 'salon'),
			'items' => array(
				'data' => array(
					array(
						'source' => 'function',
						'value' => 'vp_bind_ozy_salon_master_slider',
					),
				),
			),
			'default' => '{{first}}',
		),		


		array(
			'type' => 'toggle',
			'name' => 'ozy_salon_meta_page_use_footer_slider',
			'label' => esc_attr__('Use Footer Slider', 'salon'),
			'description' => esc_attr__('You can use footer slider with header slider too.', 'salon'),
		),
		array(
			'type'      => 'group',
			'repeating' => false,
			'length'    => 1,
			'name'      => 'ozy_salon_meta_page_use_footer_slider_group',
			'title'     => esc_attr__('Footer Slider', 'salon'),
			'dependency' => array(
				'field'    => 'ozy_salon_meta_page_use_footer_slider',
				'function' => 'vp_dep_boolean',
			),
			'fields'    => array(
				array(
					'type' => 'select',
					'name' => 'ozy_salon_meta_page_revolution_footer_slider',
					'label' => esc_attr__('Revolution Footer Slider', 'salon'),
					'description' => esc_attr__('You can select a footer slider if you have installed and activated Revolution Slider which comes bundled with your theme.', 'salon'),
					'items' => array(
						'data' => array(
							array(
								'source' => 'function',
								'value' => 'vp_bind_ozy_salon_revolution_slider',
							),
						),
					),
					'default' => '{{first}}',
				),
				array(
					'type' => 'select',
					'name' => 'ozy_salon_meta_page_master_footer_slider',
					'label' => esc_attr__('Master Footer Slider', 'salon'),
					'description' => esc_attr__('You can select a footer slider if you have installed and activated Master Slider which comes bundled with your theme.', 'salon'),
					'items' => array(
						'data' => array(
							array(
								'source' => 'function',
								'value' => 'vp_bind_ozy_salon_master_slider',
							),
						),
					),
					'default' => '{{first}}',
				),				
			),
		),

		array(
			'type' => 'toggle',
			'name' => 'ozy_salon_meta_page_no_menu_space',
			'label' => esc_attr__('No Menu Space', 'salon'),
			'description' => esc_attr__('If this option checked, your page content top will set to "0", not the bottom point of primary menu.', 'salon'),
		),

		array(
			'type' => 'toggle',
			'name' => 'ozy_salon_meta_page_disable_loader',
			'label' => esc_attr__('Disable Loading Screen', 'salon'),
			'description' => esc_attr__('Loading screen and page transition on this page will be disable.', 'salon'),
		),
		array(
			'type' => 'radiobutton',
			'name' => 'ozy_salon_meta_page_hide_footer_widget_bar',
			'label' => esc_attr__('Footer Bars Visiblity', 'salon'),
			'description' => esc_attr__('By this option you can hide footer bars as you wish.', 'salon'),
			'items' => array(
				array(
					'value' => '-1',
					'label' => esc_attr__('All Visible', 'salon'),
				),
				array(
					'value' => '1',
					'label' => esc_attr__('Hide Widget Bar', 'salon'),
				),
				array(
					'value' => '2',
					'label' => esc_attr__('Hide Widget Bar and Footer', 'salon'),
				),
			),
			'default' => array(
				'-1',
			),
		),
		


		array(
			'type' => 'toggle',
			'name' => 'ozy_salon_meta_page_hide_title',
			'label' => esc_attr__('Hide Page Title', 'salon'),
			'description' => esc_attr__('Page title will not be shown on the page.', 'salon'),
		),
		
		array(
			'type' => 'toggle',
			'name' => 'ozy_salon_meta_page_use_no_content_padding',
			'label' => esc_attr__('No content top padding', 'salon'),
			'description' => esc_attr__('Check this option to disable the padding top of your content (after page title).', 'salon'),
		),		
		array(
			'type' => 'toggle',
			'name' => 'ozy_salon_meta_page_use_custom_title',
			'label' => esc_attr__('Custom Header/Title', 'salon'),
			'description' => esc_attr__('There are several options to help you customize your page header.', 'salon'),
		),
		array(
			'type'      => 'group',
			'repeating' => false,
			'length'    => 1,
			'name'      => 'ozy_salon_meta_page_use_custom_title_group',
			'title'     => esc_attr__('Custom Header/Title Options', 'salon'),
			'dependency' => array(
				'field'    => 'ozy_salon_meta_page_use_custom_title',
				'function' => 'vp_dep_boolean',
			),
			'fields'    => array(	
				array(
					'type' => 'radiobutton',
					'name' => 'ozy_salon_meta_page_custom_title_position',
					'label' => esc_attr__('Title Position', 'salon'),
					'items' => array(
						array(
							'value' => 'left',
							'label' => esc_attr__('Left', 'salon'),
						),
						array(
							'value' => 'right',
							'label' => esc_attr__('Right', 'salon'),
						),
						array(
							'value' => 'center',
							'label' => esc_attr__('Center', 'salon'),
						),
					),
					'default' => array(
						'center',
					),
				),			
				array(
					'type'      => 'textbox',
					'name'      => 'ozy_salon_meta_page_custom_title',
					'label'     => esc_attr__('Page Title', 'salon'),
				),
				array(
					'type'      => 'color',
					'name'      => 'ozy_salon_meta_page_custom_title_color',
					'label'     => esc_attr__('Title Color', 'salon'),
					'default' => '',
					'format' => 'rgba'
				),				
				array(
					'type'      => 'textbox',
					'name'      => 'ozy_salon_meta_page_custom_sub_title',
					'label'     => esc_attr__('Sub Title', 'salon'),
				),
				array(
					'type'      => 'color',
					'name'      => 'ozy_salon_meta_page_custom_sub_title_color',
					'label'     => esc_attr__('Sub Title Color', 'salon'),
					'default' => '',
					'format' => 'rgba'
				),				
				array(
					'type'      => 'color',
					'name'      => 'ozy_salon_meta_page_custom_title_bgcolor',
					'label'     => esc_attr__('Header Background Color', 'salon'),
					'default' => '',
					'format' => 'rgba'
				),				
				array(
					'type'      => 'upload',
					'name'      => 'ozy_salon_meta_page_custom_title_bg',
					'label'     => esc_attr__('Header Image', 'salon'),
					'description'=> esc_attr__('Please use images like 1600px, 2000px wide and have a minimum height like 475px for good results.', 'salon'),
				),
				array(
					'type' => 'radiobutton',
					'name' => 'ozy_salon_meta_page_custom_title_bg_x_position',
					'label' => esc_attr__('Background X-Position', 'salon'),
					'items' => array(
						array(
							'value' => 'left',
							'label' => esc_attr__('Left', 'salon'),
						),
						array(
							'value' => 'right',
							'label' => esc_attr__('Right', 'salon'),
						),
						array(
							'value' => 'center',
							'label' => esc_attr__('Center', 'salon'),
						),
						array(
							'value' => 'top',
							'label' => esc_attr__('Top', 'salon'),
						),
						array(
							'value' => 'bottom',
							'label' => esc_attr__('Bottom', 'salon'),
						),
					),
					'default' => array(
						'left',
					),
				),
				array(
					'type' => 'radiobutton',
					'name' => 'ozy_salon_meta_page_custom_title_bg_y_position',
					'label' => esc_attr__('Background Y-Position', 'salon'),
					'items' => array(
						array(
							'value' => 'left',
							'label' => esc_attr__('Left', 'salon'),
						),
						array(
							'value' => 'right',
							'label' => esc_attr__('Right', 'salon'),
						),
						array(
							'value' => 'center',
							'label' => esc_attr__('Center', 'salon'),
						),
						array(
							'value' => 'top',
							'label' => esc_attr__('Top', 'salon'),
						),
						array(
							'value' => 'bottom',
							'label' => esc_attr__('Bottom', 'salon'),
						),
					),
					'default' => array(
						'top',
					),
				),				
				array(
					'type'      => 'textbox',
					'name'      => 'ozy_salon_meta_page_custom_title_height',
					'label'     => esc_attr__('Header Height', 'salon'),
					'description'=> esc_attr__('Height of your header in pixels? Don\'t include "px" in the string. e.g. 400', 'salon'),
					'default'	=> 170,
					'validation' => 'numeric'
				),				
			),
		),
		array(
			'type' => 'toggle',
			'name' => 'ozy_salon_meta_page_hide_content',
			'label' => esc_attr__('Hide Page Content', 'salon'),
			'description' => esc_attr__('Page content will not be shown. Supposed to use with Video backgrounds or Fullscreen sliders.', 'salon'),
		),		
		array(
			'type' => 'toggle',
			'name' => 'ozy_salon_meta_page_use_sidebar',
			'label' => esc_attr__('Use Custom Sidebar', 'salon'),
			'description' => esc_attr__('You can use custom sidebar individually.', 'salon'),
		),
		array(
			'type'      => 'group',
			'repeating' => false,
			'length'    => 1,
			'name'      => 'ozy_salon_meta_page_sidebar_group',
			'title'     => esc_attr__('Custom Sidebar', 'salon'),
			'dependency' => array(
				'field'    => 'ozy_salon_meta_page_use_sidebar',
				'function' => 'vp_dep_boolean',
			),
			'fields'    => array(
				array(
					'type' => 'radioimage',
					'name' => 'ozy_salon_meta_page_sidebar_position',
					'label' => esc_attr__('Sidebar Position', 'salon'),
					'description' => esc_attr__('Select one of available header type.', 'salon'),
					'item_max_width' => '86',
					'items' => array(
						array(
							'value' => 'full',
							'label' => esc_attr__('No Sidebar', 'salon'),
							'img' => SALON_BASE_URL . 'admin/images/full-width.png',
						),
						array(
							'value' => 'left',
							'label' => esc_attr__('Left Sidebar', 'salon'),
							'img' => SALON_BASE_URL . 'admin/images/left-sidebar.png',
						),
						array(
							'value' => 'right',
							'label' => esc_attr__('Right Sidebar', 'salon'),
							'img' => SALON_BASE_URL . 'admin/images/right-sidebar.png',
						)
					),
					'default' => '{{first}}',
				),			
				array(
					'type' => 'select',
					'name' => 'ozy_salon_meta_page_sidebar',
					'label' => esc_attr__('Sidebar', 'salon'),
					'items' => array(
						'data' => array(
							array(
								'source' => 'function',
								'value' => 'vp_bind_ozy_salon_sidebars',
							),
						),
					),
				),											
			),
		),
		array(
			'type' => 'toggle',
			'name' => 'ozy_salon_meta_page_use_custom_style',
			'label' => esc_attr__('Use Custom Style', 'salon'),
			'description' => esc_attr__('Options to customize your page individually.', 'salon'),
		),
		array(
			'type'      => 'group',
			'repeating' => false,
			'length'    => 1,
			'name'      => 'ozy_salon_meta_page_layout_group',
			'title'     => esc_attr__('Layout Styling', 'salon'),
			'dependency' => array(
				'field'    => 'ozy_salon_meta_page_use_custom_style',
				'function' => 'vp_dep_boolean',
			),
			'fields'    => array(					
				array(
					'type' => 'color',
					'name' => 'ozy_salon_meta_page_layout_ascend_background',
					'label' => esc_attr__('Background Color', 'salon'),
					'description' => esc_attr__('This option will affect, main wrapper\'s background color.', 'salon'),
					'default' => 'rgba(255,255,255,1)',
					'format' => 'rgba',
				),
				array(
					'type' => 'toggle',
					'name' => 'ozy_salon_meta_page_layout_transparent_background',
					'label' => esc_attr__('Transparent Content Background', 'salon'),
					'description' => esc_attr__('If you want, you can use transparent background for your content.', 'salon'),
					'default' => '0',
				)														
			),
		),
		array(
			'type' => 'toggle',
			'name' => 'ozy_salon_meta_page_use_custom_background',
			'label' => esc_attr__('Use Custom Background', 'salon'),
			'description' => esc_attr__('Lots of options to customize your page background individually.', 'salon'),
		),		
		array(
			'type'      => 'group',
			'repeating' => false,
			'name'      => 'ozy_salon_meta_page_background_group',
			'title'     => esc_attr__('Background Styling', 'salon'),
			'dependency' => array(
				'field'    => 'ozy_salon_meta_page_use_custom_background',
				'function' => 'vp_dep_boolean',
			),
			'fields'    => array(					
				array(
					'type' => 'upload',
					'name' => 'ozy_salon_meta_page_background_image',
					'label' => esc_attr__('Custom Background Image', 'salon'),
					'description' => esc_attr__('Upload or choose custom page background image.', 'salon'),
				),
				array(
					'type' => 'radiobutton',
					'name' => 'ozy_salon_meta_page_background_image_size',
					'label' => esc_attr__('Background Image Size', 'salon'),
					'description' => esc_attr__('Only available on browsers which supports CSS3.', 'salon'),
					'items' => array(
						array(
							'value' => '',
							'label' => esc_attr__('-not set-', 'salon'),
						),			
						array(
							'value' => 'cover',
							'label' => esc_attr__('cover', 'salon'),
						),
						array(
							'value' => 'contain',
							'label' => esc_attr__('contain', 'salon'),
						)
					),
					'default' => '{{first}}',
				),

				array(
					'type' => 'radiobutton',
					'name' => 'ozy_salon_meta_page_background_image_pos_x',
					'label' => esc_attr__('Background Position X', 'salon'),
					'items' => array(
						array(
							'value' => 'left',
							'label' => esc_attr__('left', 'salon'),
						),			
						array(
							'value' => 'center',
							'label' => esc_attr__('center', 'salon'),
						),
						array(
							'value' => 'right',
							'label' => esc_attr__('right', 'salon'),
						)
					),
					'default' => 'left',
				),
				array(
					'type' => 'radiobutton',
					'name' => 'ozy_salon_meta_page_background_image_pos_y',
					'label' => esc_attr__('Background Position Y', 'salon'),
					'items' => array(
						array(
							'value' => 'top',
							'label' => esc_attr__('top', 'salon'),
						),			
						array(
							'value' => 'center',
							'label' => esc_attr__('center', 'salon'),
						),
						array(
							'value' => 'bottom',
							'label' => esc_attr__('bottom', 'salon'),
						)
					),
					'default' => 'top',
				),				
				
				array(
					'type' => 'radiobutton',
					'name' => 'ozy_salon_meta_page_background_image_repeat',
					'label' => esc_attr__('Background Image Repeat', 'salon'),
					'items' => array(
						array(
							'value' => 'inherit',
							'label' => esc_attr__('inherit', 'salon'),
						),			
						array(
							'value' => 'no-repeat',
							'label' => esc_attr__('no-repeat', 'salon'),
						),
						array(
							'value' => 'repeat',
							'label' => esc_attr__('repeat', 'salon'),
						),
						array(
							'value' => 'repeat-x',
							'label' => esc_attr__('repeat-x', 'salon'),
						),
						array(
							'value' => 'repeat-y',
							'label' => esc_attr__('repeat-y', 'salon'),
						)
					),
					'default' => '{{first}}',
				),
				array(
					'type' => 'radiobutton',
					'name' => 'ozy_salon_meta_page_background_image_attachment',
					'label' => esc_attr__('Background Image Attachment', 'salon'),
					'items' => array(
						array(
							'value' => '',
							'label' => esc_attr__('-not set-', 'salon'),
						),			
						array(
							'value' => 'fixed',
							'label' => esc_attr__('fixed', 'salon'),
						),
						array(
							'value' => 'scroll',
							'label' => esc_attr__('scroll', 'salon'),
						),
						array(
							'value' => 'local',
							'label' => esc_attr__('local', 'salon')
						)
					),
					'default' => '{{first}}',
				),										
				array(
					'type' => 'color',
					'name' => 'ozy_salon_meta_page_background_color',
					'label' => esc_attr__('Background Color', 'salon'),
					'description' => esc_attr__('This option will affect only page background.', 'salon'),
					'default' => '#ffffff',
					'format' => 'hex',
				),
				array(
					'type' => 'toggle',
					'name' => 'ozy_salon_meta_page_background_use_gmap',
					'label' => esc_attr__('Use Google Map', 'salon'),
					'description' => esc_attr__('Instead of using a static background, you can use a Google Map as background.', 'salon'),
				),					
				array(
					'type'      => 'group',
					'repeating' => false,
					'name'      => 'ozy_salon_meta_page_background_gmap_group',
					'title'     => esc_attr__('Google Map', 'salon'),
					'dependency' => array(
						'field'    => 'ozy_salon_meta_page_background_use_gmap',
						'function' => 'vp_dep_boolean',
					),
					'fields'    => array(					
						array(
							'type' => 'textbox',
							'name' => 'ozy_salon_meta_page_background_gmap_address',
							'label' => esc_attr__('iFrame Src', 'salon'),
							'description' => esc_attr__('Enter src attribute of your Google Map iFrame.', 'salon'),
						)												
					),
				),
				array(
					'type' => 'toggle',
					'name' => 'ozy_salon_meta_page_background_use_slider',
					'label' => esc_attr__('Use Background Slider', 'salon'),
					'description' => esc_attr__('Instead of using a static background, you can use background image slider.', 'salon'),
				),					
				array(
					'type'      => 'group',
					'repeating' => true,
					'sortable' => true,
					'name'      => 'ozy_salon_meta_page_background_slider_group',
					'title'     => esc_attr__('Slider Image', 'salon'),
					'dependency' => array(
						'field'    => 'ozy_salon_meta_page_background_use_slider',
						'function' => 'vp_dep_boolean',
					),
					'fields'    => array(					
						array(
							'type' => 'upload',
							'name' => 'ozy_salon_meta_page_background_slider_image',
							'label' => esc_attr__('Slider Image', 'salon'),
							'description' => esc_attr__('Upload or choose custom background image.', 'salon'),
						)												
					),
				),
				array(
					'type' => 'toggle',
					'name' => 'ozy_salon_meta_page_background_use_video_self',
					'label' => esc_attr__('Use Self Hosted Video', 'salon'),
					'description' => esc_attr__('Instead of using a static background, you can use self hosted video.', 'salon'),
				),					
				array(
					'type'      => 'group',
					'repeating' => false,
					'sortable' => false,
					'name'      => 'ozy_salon_meta_page_background_video_self_group',
					'title'     => esc_attr__('Self Hosted Video', 'salon'),
					'dependency' => array(
						'field'    => 'ozy_salon_meta_page_background_use_video_self',
						'function' => 'vp_dep_boolean',
					),
					'fields'    => array(					
						array(
							'type' => 'upload',
							'name' => 'ozy_salon_meta_page_background_video_self_image',
							'label' => esc_attr__('Poster Image', 'salon'),
							'description' => esc_attr__('Upload or choose a poster image.', 'salon'),
						),
						array(
							'type' => 'upload',
							'name' => 'ozy_salon_meta_page_background_video_self_mp4',
							'label' => esc_attr__('MP4 File', 'salon'),
							'description' => esc_attr__('Upload or choose a MP4 file.', 'salon'),
						),
						array(
							'type' => 'upload',
							'name' => 'ozy_salon_meta_page_background_video_self_webm',
							'label' => esc_attr__('WEBM File', 'salon'),
							'description' => esc_attr__('Upload or choose a WEBM file.', 'salon'),
						),
						array(
							'type' => 'upload',
							'name' => 'ozy_salon_meta_page_background_video_self_ogv',
							'label' => esc_attr__('OGV File', 'salon'),
							'description' => esc_attr__('Upload or choose an OGV file.', 'salon'),
						)
					),
				),
				array(
					'type' => 'toggle',
					'name' => 'ozy_salon_meta_page_background_use_video_youtube',
					'label' => esc_attr__('Use YouTube Video', 'salon'),
					'description' => esc_attr__('Instead of using a static background, you can use YouTube video.', 'salon'),
				),					
				array(
					'type'      => 'group',
					'repeating' => false,
					'sortable' => false,
					'name'      => 'ozy_salon_meta_page_background_video_youtube_group',
					'title'     => esc_attr__('YouTube Video', 'salon'),
					'dependency' => array(
						'field'    => 'ozy_salon_meta_page_background_use_video_youtube',
						'function' => 'vp_dep_boolean',
					),
					'fields'    => array(					
						array(
							'type' => 'upload',
							'name' => 'ozy_salon_meta_page_background_video_youtube_image',
							'label' => esc_attr__('Poster Image', 'salon'),
							'description' => esc_attr__('Upload or choose a poster image.', 'salon'),
						),
						array(
							'type' => 'textbox',
							'name' => 'ozy_salon_meta_page_background_video_youtube_id',
							'label' => esc_attr__('YouTube Video ID', 'salon'),
							'description' => esc_attr__('Enter YouTube video ID. http://www.youtube.com/watch?v=<span style="color:red;">mYKA-VokOtA</span> text marked with red is the ID you have to be looking for.', 'salon'),
						)
					),
				),
				array(
					'type' => 'toggle',
					'name' => 'ozy_salon_meta_page_background_use_video_vimeo',
					'label' => esc_attr__('Use Vimeo Video', 'salon'),
					'description' => esc_attr__('Instead of using a static background, you can use Vimeo video.', 'salon'),
				),					
				array(
					'type'      => 'group',
					'repeating' => false,
					'sortable' => false,
					'name'      => 'ozy_salon_meta_page_background_video_vimeo_group',
					'title'     => esc_attr__('Vimeo Video', 'salon'),
					'dependency' => array(
						'field'    => 'ozy_salon_meta_page_background_use_video_vimeo',
						'function' => 'vp_dep_boolean',
					),
					'fields'    => array(					
						array(
							'type' => 'upload',
							'name' => 'ozy_salon_meta_page_background_video_vimeo_image',
							'label' => esc_attr__('Poster Image', 'salon'),
							'description' => esc_attr__('Upload or choose a poster image.', 'salon'),
						),
						array(
							'type' => 'textbox',
							'name' => 'ozy_salon_meta_page_background_video_vimeo_id',
							'label' => esc_attr__('Vimeo Video ID', 'salon'),
							'description' => esc_attr__('Enter Vimeo video ID. http://vimeo.com/<span style="color:red;">71964690</span> text marked with red is the ID you have to be looking for.', 'salon'),
						)
					),
				)
			),
		),
		array(
			'type' => 'radiobutton',
			'name' => 'ozy_salon_meta_page_layout_width',
			'label' => esc_attr__('Layout Width', 'salon'),
			'items' => array(
				array(
					'value' => 'global',
					'label' => esc_attr__('Use Global Options', 'salon'),
				),			
				array(
					'value' => '1212',
					'label' => esc_attr__('Normal (1212px)', 'salon'),
				),
				array(
					'value' => '1672',
					'label' => esc_attr__('Wider (1600px)', 'salon'),
				)
			),
			'default' => array(
				'global',
			),
		)					
	),	
);

/**
 * EOF
 */