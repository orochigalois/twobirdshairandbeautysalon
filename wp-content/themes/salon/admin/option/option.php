<?php
$floating_button_labels_array =	array(
									array(
										'type' => 'toggle',
										'name' => 'ozy_salon_section_floating_buttons_is_active',
										'label' => esc_attr__('Display Book Now Button?', 'salon'),
										'description' => esc_attr__('Enables Book Now Button.', 'salon'),
										'default' => '1',
									), array(
										'type' => 'textbox',
										'name' => 'ozy_salon_section_floating_buttons_short_label',
										'label' => esc_attr__('Short Label', 'salon'),
										'dependency' => array(
											'field' => 'ozy_salon_section_floating_buttons_is_active',
											'function' => 'vp_dep_boolean',
										),									
										'description' => esc_attr__('Enter one character long label to display on Book Now button.', 'salon'),
										'validation' => 'maxlength[1]',
										'default' => esc_attr('B', 'salon')
									), array(
										'type' => 'textbox',
										'name' => 'ozy_salon_section_floating_buttons_long_label',
										'label' => esc_attr__('Label', 'salon'),
										'description' => esc_attr__('Enter label to display as a tooltip on the button.', 'salon'),
										'dependency' => array(
											'field' => 'ozy_salon_section_floating_buttons_is_active',
											'function' => 'vp_dep_boolean',
										),									
										'validation' => 'maxlength[20]',
										'default' => esc_attr('Book Now', 'salon')
									), array(
										'type' => 'select',
										'name' => 'ozy_salon_section_floating_buttons_booking_page',
										'label' => esc_attr__('Booking Page', 'salon'),
										'dependency' => array(
											'field' => 'ozy_salon_section_floating_buttons_is_active',
											'function' => 'vp_dep_boolean',
										),									
										'description' => esc_attr__('Select a page to use target Book Now page. Leave blank to hide related button.', 'salon'),
										'items' => array(
											'data' => array(
												array(
													'source' => 'function',
													'value' => 'vp_bind_ozy_salon_pages',
												),
											),
										),
									),									
								);
					
$footer_copyright_array =		array(
									array(
										'type' => 'textbox',
										'name' => 'ozy_salon_section_footer_copyright_text',
										'label' => esc_attr__('Footer Copyright Text Field', 'salon'),
										'default' => esc_attr__('&copy; 2017 A Professional Hair Salon WordPress Theme', 'salon')
									),
									array(
										'type' => 'toggle',
										'name' => 'ozy_salon_section_footer_social_icons',
										'label' => esc_attr__('Show Social Icons', 'salon'),
										'description' => esc_attr__('To manage social icon accounts visit Social tab.', 'salon'),
										'default' => '1',
									),
									array(
										'type' => 'toggle',
										'name' => 'ozy_salon_section_footer_info_bar',
										'label' => esc_attr__('Show Sticky Info Bar', 'salon'),
										'description' => wp_kses(__('This option also could be managed individually for each page on Page Options panel. To fill the bar, visit <a href="widgets.php">Appearance > Widgets</a>', 'salon'), array('a' => array('href' => array()))),
										'default' => '0',
									),																							
								);
								
$primary_menu_address_array =	array(
									array(
										'type'    => 'slider',
										'name'    => 'ozy_salon_primary_menu_height',
										'label'   => esc_attr__('Top Padding', 'salon'),
										'description'   => esc_attr__('Set this value to fit at least same as your logo height for better results.', 'salon'),
										'min'     => '40',
										'max'     => '700',
										'default' => '180',
									),
									array(
										'type' => 'codeeditor',
										'name' => 'ozy_salon_primary_menu_address_text',
										'label' => esc_attr__('Address Content', 'salon'),
										'default' => 
esc_html__('Phone : 914-816-1182

info@salonwp.com

Salon Opening Hours:
08:00 - 20:00

3824 Deans Lane
New York, NY 10011', 'salon'),
										'mode' => 'html'
									)
								);								

if(salon_is_wpml_active()){
	$languages = icl_get_languages('skip_missing=0&orderby=code');
	if(!empty($languages)){
		foreach($languages as $l){
			if(ICL_LANGUAGE_CODE != $l['language_code']) {

				array_push($floating_button_labels_array, 
								array(
									'type' => 'toggle',
									'name' => 'ozy_salon_section_floating_buttons_is_active' . $l['language_code'],
									'label' => esc_attr__('Display Book Now Button?', 'salon') . '(' . strtoupper($l['native_name']) .')',
									'description' => esc_attr__('Enables Book Now Button.', 'salon'),
									'default' => '1',
								),array(
									'type' => 'textbox',
									'name' => 'ozy_salon_section_floating_buttons_short_label' . $l['language_code'],
									'label' => esc_attr__('Short Label', 'salon') . '(' . strtoupper($l['native_name']) .')',
									'dependency' => array(
										'field' => 'ozy_salon_section_floating_buttons_is_active',
										'function' => 'vp_dep_boolean',
									),									
									'description' => esc_attr__('Enter one character long label to display on Book Now button.', 'salon'),
									'validation' => 'maxlength[1]',
									'default' => esc_attr('B', 'salon')
								),array(
									'type' => 'textbox',
									'name' => 'ozy_salon_section_floating_buttons_long_label' . $l['language_code'],
									'label' => esc_attr__('Label', 'salon') . '(' . strtoupper($l['native_name']) .')',
									'description' => esc_attr__('Enter label to display as a tooltip on the button.', 'salon'),
									'dependency' => array(
										'field' => 'ozy_salon_section_floating_buttons_is_active',
										'function' => 'vp_dep_boolean',
									),									
									'validation' => 'maxlength[20]',
									'default' => esc_attr('Book Now', 'salon')
								),array(
									'type' => 'select',
									'name' => 'ozy_salon_section_floating_buttons_booking_page' . $l['language_code'],
									'label' => esc_attr__('Booking Page', 'salon') . '(' . strtoupper($l['native_name']) .')',
									'dependency' => array(
										'field' => 'ozy_salon_section_floating_buttons_is_active',
										'function' => 'vp_dep_boolean',
									),									
									'description' => esc_attr__('Select a page to use target Book Now page. Leave blank to hide related button.', 'salon'),
									'items' => array(
										'data' => array(
											array(
												'source' => 'function',
												'value' => 'vp_bind_ozy_salon_pages',
											),
										),
									),
								)								
							);
					
				array_push($footer_copyright_array, array(
														'type' => 'textbox',
														'name' => 'ozy_salon_section_footer_copyright_text' . $l['language_code'],
														'label' => esc_attr__('Footer Copyright Text Field', 'salon') . '(' . strtoupper($l['native_name']) .')',
													),
													array(
														'type' => 'toggle',
														'name' => 'ozy_salon_section_footer_social_icons' . $l['language_code'],
														'label' => esc_attr__('Show Social Icons', 'salon'),
														'description' => esc_attr__('To manage social icon accounts visit Social tab.', 'salon') . '(' . strtoupper($l['native_name']) .')',
														'default' => '1',
													),
													array(
														'type' => 'toggle',
														'name' => 'ozy_salon_section_footer_info_bar' . $l['language_code'],
														'label' => esc_attr__('Show Sticky Info Bar', 'salon') . '(' . strtoupper($l['native_name']) .')',
														'description' => wp_kses(__('This option also could be managed individually for each page on Page Options panel. To fill the bar, visit <a href="widgets.php">Appearance > Widgets</a>', 'salon'), array('a' => array('href' => array()))),
														'default' => '0',
													)																																				
												);
				array_push($primary_menu_address_array, array(
										'type' => 'codeeditor',
										'name' => 'ozy_salon_primary_menu_address_text' . $l['language_code'],
										'label' => esc_attr__('Address Content', 'salon') . '(' . strtoupper($l['native_name']) .')',
										'default' => 
esc_html__('Phone : 914-816-1182

info@salonwp.com

Salon Opening Hours:
08:00 - 20:00

3824 Deans Lane
New York, NY 10011', 'salon'),
										'mode' => 'html'
									)
								);
			}
		}
	}
}

//return 
$ozy_salon_option_arr = array(
	'title' => esc_attr__('SALON Option Panel', 'salon'),
	'logo' => SALON_BASE_URL . 'admin/images/logo.png',
	'menus' => array(
		array(
			'title' => esc_attr__('General Options', 'salon'),
			'name' => 'ozy_salon_general_options',
			'icon' => 'font-awesome:fa-gear',
			'controls' => array(
				array(
					'type' => 'section',
					'title' => esc_attr__('General', 'salon'),
					'fields' => array(					
						array(
							'type' => 'toggle',
							'name' => 'ozy_salon_back_to_top_button',
							'label' => esc_attr__('Back To Top Button', 'salon'),
							'description' => esc_attr__('Enable / Disable Back To Top Button globally.', 'salon'),
							'default' => '1',
						),
						array(
							'type' => 'toggle',
							'name' => 'ozy_salon_smooth_scroll',
							'label' => esc_attr__('Smooth Scrolling', 'salon'),
							'description' => esc_attr__('When enabled page will scrool smoothly when mousewheel used, on supported browsers.', 'salon'),
							'default' => '0',
						),
						array(
							'type' => 'toggle',
							'name' => 'ozy_salon_disable_animsition',
							'label' => esc_attr__('Disable Loading Screen', 'salon'),
							'description' => esc_attr__('Loading screen and page transition on this page will be disable.', 'salon'),
							'default' => '0',
						),
						array(
							'type' => 'codeeditor',
							'name' => 'ozy_salon_custom_css',
							'label' => esc_attr__('Custom CSS', 'salon'),
							'description' => esc_attr__('Write your custom css here. <strong>Please do not add "style" tags.</strong>', 'salon'),
							'theme' => 'eclipse',
							'mode' => 'css',
						),
						array(
							'type' => 'codeeditor',
							'name' => 'ozy_salon_custom_script',
							'label' => esc_attr__('Custom JS', 'salon'),
							'description' => esc_attr__('Write your custom js here. Please do not add script tags into this box. <strong>Please do not add "script" tags.</strong>', 'salon'),
							'theme' => 'mono_industrial',
							'mode' => 'javascript',
						),
					),
				),
				array(
					'type' => 'section',
					'title' => esc_attr__('Fallback Favicons', 'salon'),
					'description' => esc_attr__('Please use Appearance > Customize to choose a favicon. This panel being used just for fallback.', 'salon'),
					'fields' => array(
						array(
							'type' => 'notebox',
							'name' => 'ozy_salon_favicon_info',
							'label' => esc_attr__('About Favicons', 'salon'),
							'description' => esc_attr__('Please use Appearance > Customize to choose a favicon. This panel being used just for fallback.', 'salon'),
							'status' => 'normal',
						),					
						array(
							'type' => 'upload',
							'name' => 'ozy_salon_favicon',
							'label' => esc_attr__('Favicon', 'salon'),
							'description' => esc_attr__('Upload a 16px x 16px .png or .gif image, will be set as your favicon.', 'salon'),
							'default' => SALON_CSS_DIRECTORY_URL . '/favico.gif',
						),
						array(
							'type' => 'upload',
							'name' => 'ozy_salon_favicon_apple_small',
							'label' => esc_attr__('Apple Touch Icon (small)', 'salon'),
							'description' => esc_attr__('Upload a 57px x 57px .png image, will be set as your small Apple Touch Icon.', 'salon'),
							'default' => SALON_CSS_DIRECTORY_URL . '/images/favico_57.png',
						),array(
							'type' => 'upload',
							'name' => 'ozy_salon_favicon_apple_medium',
							'label' => esc_attr__('Apple Touch Icon (medium)', 'salon'),
							'description' => esc_attr__('Upload a 76px x 76px .png image, will be set as your large Apple Touch Icon (iPad).', 'salon'),
							'default' => SALON_CSS_DIRECTORY_URL . '/images/favico_76.png',
						),array(
							'type' => 'upload',
							'name' => 'ozy_salon_favicon_apple_large',
							'label' => esc_attr__('Apple Touch Icon (large)', 'salon'),
							'description' => esc_attr__('Upload a 120px x 120px .png image, will be set as your large Apple Touch Icon (iPhone Retina).', 'salon'),
							'default' => SALON_CSS_DIRECTORY_URL . '/images/favico_120.png',
						),array(
							'type' => 'upload',
							'name' => 'ozy_salon_favicon_apple_xlarge',
							'label' => esc_attr__('Apple Touch Icon (large)', 'salon'),
							'description' => esc_attr__('Upload a 152px x 152px .png image, will be set as your large Apple Touch Icon (iPad Retina).', 'salon'),
							'default' => SALON_CSS_DIRECTORY_URL . '/images/favico_152.png',
						),					
					),
				),				
			),
		),
		
		
		array(
			'title' => esc_attr__('Typography', 'salon'),
			'name' => 'ozy_salon_typography',
			'icon' => 'font-awesome:fa-pencil',
			'controls' => array(
				array(
					'type' => 'section',
					'title' => esc_attr__('Extended Parameters', 'salon'),
					'fields' => array(
						array(
							'type' => 'textbox',
							'name' => 'ozy_salon_typography_google_param',
							'description' => 'Add extra parameters here. By this option, you can load non-latin charset or more types byt available parameters. Use like ":400,100,300,700".',
							'default' => ':100,200,300,400,500,600,700,800,900'
						),
					)
				),			
				array(
					'type' => 'section',
					'title' => esc_attr__('Content Typography', 'salon'),
					'fields' => array(
						array(
							'type' => 'html',
							'name' => 'ozy_salon_typography_font_preview',
							'binding' => array(
								'field'    => 'ozy_salon_typography_font_face,ozy_salon_typography_font_style,ozy_salon_typography_font_weight,ozy_salon_typography_font_size, ozy_salon_typography_font_line_height',
								'function' => 'vp_font_preview',
							),
						),
						array(
							'type' => 'select',
							'name' => 'ozy_salon_typography_font_face',
							'label' => esc_attr__('Font Face', 'salon'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_gwf_family',
									),
								),
							),
							'default' => 'Poppins'
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_salon_typography_font_style',
							'label' => esc_attr__('Font Style', 'salon'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'binding',
										'field' => 'ozy_salon_typography_font_face',
										'value' => 'vp_get_gwf_style',
									),
								),
							),
							'default' => array(
								'normal',
							),
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_salon_typography_font_weight',
							'label' => esc_attr__('Font Weight', 'salon'),
							'default' => '300',
							'items' => array(
								'data' => array(
									array(
										'source' => 'binding',
										'field' => 'ozy_salon_typography_font_face',
										'value' => 'vp_get_gwf_weight',
									),
								),
							),
						),
						array(
							'type'    => 'slider',
							'name'    => 'ozy_salon_typography_font_size',
							'label'   => esc_attr__('Font Size (px)', 'salon'),
							'min'     => '5',
							'max'     => '86',
							'default' => '18',
						),
						array(
							'type'    => 'slider',
							'name'    => 'ozy_salon_typography_font_line_height',
							'label'   => esc_attr__('Line Height (em)', 'salon'),
							'min'     => '0',
							'max'     => '3',
							'default' => '1.5',
							'step'    => '0.1',
						),
					),
				),
				array(
					'type' => 'section',
					'title' => esc_attr__('Heading Typography', 'salon'),
					'fields' => array(
						array(
							'type' => 'html',
							'name' => 'ozy_salon_typography_heading_font_preview',
							'binding' => array(
								'field'    => 'ozy_salon_typography_heading_font_face,ozy_salon_typography_heading_font_style,ozy_salon_typography_heading_font_weight,ozy_salon_typography_heading_h1_font_size',
								'function' => 'vp_font_preview_simple',
							),
						),
						array(
							'type' => 'select',
							'name' => 'ozy_salon_typography_heading_font_face',
							'label' => esc_attr__('Font Face', 'salon'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_gwf_family',
									),
								),
							),
							'default' => 'Volkhov'
						)
					),
				),
				array(
					'type' => 'section',
					'title' => esc_attr__('H1 Options', 'salon'),
					'fields' => array(
						array(
							'type'    => 'slider',
							'name'    => 'ozy_salon_typography_heading_h1_font_size',
							'label'   => esc_attr__('H1 Size (px)', 'salon'),
							'min'     => '5',
							'max'     => '128',
							'default' => '40',
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_salon_typography_heading_h1_font_style',
							'label' => esc_attr__('H1 Font Style', 'salon'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'binding',
										'field' => 'ozy_salon_typography_heading_font_face',
										'value' => 'vp_get_gwf_style',
									),
								),
							),
							'default' => array(
								'normal',
							),
						),
						array(
							'type' => 'select',
							'name' => 'ozy_salon_typography_heading_font_weight_h1',
							'label' => esc_attr__('H1 Weight', 'salon'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_weight_list',
									),
								),
							),
							'default' => array(
								'400',
							),							
						),
						array(
							'type'    => 'slider',
							'name'    => 'ozy_salon_typography_heading_line_height_h1',
							'label'   => esc_attr__('H1 Line Height (em)', 'salon'),
							'min'     => '0',
							'max'     => '3',
							'default' => '1.3',
							'step'    => '0.1',
						),					
						array(
							'type' => 'select',
							'name' => 'ozy_salon_typography_heading_font_ls_h1',
							'label' => esc_attr__('H1 Letter Spacing', 'salon'),
							'default' => 'normal',							
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_letter_spacing_list',
									),
								),
							),
						),
					),
				),
				array(
					'type' => 'section',
					'title' => esc_attr__('H2 Options', 'salon'),
					'fields' => array(												
						array(
							'type'    => 'slider',
							'name'    => 'ozy_salon_typography_heading_h2_font_size',
							'label'   => esc_attr__('H2 Size (px)', 'salon'),
							'min'     => '5',
							'max'     => '128',
							'default' => '36',
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_salon_typography_heading_h2_font_style',
							'label' => esc_attr__('H2 Font Style', 'salon'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'binding',
										'field' => 'ozy_salon_typography_heading_font_face',
										'value' => 'vp_get_gwf_style',
									),
								),
							),
							'default' => array(
								'normal',
							),
						),						
						array(
							'type' => 'select',
							'name' => 'ozy_salon_typography_heading_font_weight_h2',
							'label' => esc_attr__('H2 Weight', 'salon'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_weight_list',
									),
								),
							),
							'default' => array(
								'400',
							),
						),
						array(
							'type'    => 'slider',
							'name'    => 'ozy_salon_typography_heading_line_height_h2',
							'label'   => esc_attr__('H2 Line Height (em)', 'salon'),
							'min'     => '0',
							'max'     => '3',
							'default' => '1.3',
							'step'    => '0.1',
						),						
						array(
							'type' => 'select',
							'name' => 'ozy_salon_typography_heading_font_ls_h2',
							'label' => esc_attr__('H2 Letter Spacing', 'salon'),
							'default' => 'normal',
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_letter_spacing_list',
									),
								),
							),
						),
					),
				),
				array(
					'type' => 'section',
					'title' => esc_attr__('H3 Options', 'salon'),
					'fields' => array(						
						array(
							'type'    => 'slider',
							'name'    => 'ozy_salon_typography_heading_h3_font_size',
							'label'   => esc_attr__('H3 Size (px)', 'salon'),
							'min'     => '5',
							'max'     => '128',
							'default' => '30',
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_salon_typography_heading_h3_font_style',
							'label' => esc_attr__('H3 Font Style', 'salon'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'binding',
										'field' => 'ozy_salon_typography_heading_font_face',
										'value' => 'vp_get_gwf_style',
									),
								),
							),
							'default' => array(
								'normal',
							),
						),						
						array(
							'type' => 'select',
							'name' => 'ozy_salon_typography_heading_font_weight_h3',
							'label' => esc_attr__('H3 Weight', 'salon'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_weight_list',
									),
								),
							),
							'default' => array(
								'400',
							),							
						),
						array(
							'type'    => 'slider',
							'name'    => 'ozy_salon_typography_heading_line_height_h3',
							'label'   => esc_attr__('H3 Line Height (em)', 'salon'),
							'min'     => '0',
							'max'     => '3',
							'default' => '1.3',
							'step'    => '0.1',
						),						
						array(
							'type' => 'select',
							'name' => 'ozy_salon_typography_heading_font_ls_h3',
							'label' => esc_attr__('H3 Letter Spacing', 'salon'),
							'default' => 'normal',							
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_letter_spacing_list',
									),
								),
							),
						),
					),
				),
				array(
					'type' => 'section',
					'title' => esc_attr__('H4 Options', 'salon'),
					'fields' => array(						
						array(
							'type'    => 'slider',
							'name'    => 'ozy_salon_typography_heading_h4_font_size',
							'label'   => esc_attr__('H4 Size (px)', 'salon'),
							'min'     => '5',
							'max'     => '128',
							'default' => '20',
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_salon_typography_heading_h4_font_style',
							'label' => esc_attr__('H4 Font Style', 'salon'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'binding',
										'field' => 'ozy_salon_typography_heading_font_face',
										'value' => 'vp_get_gwf_style',
									),
								),
							),
							'default' => array(
								'normal',
							),
						),						
						array(
							'type' => 'select',
							'name' => 'ozy_salon_typography_heading_font_weight_h4',
							'label' => esc_attr__('H4 Weight', 'salon'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_weight_list',
									),
								),
							),
							'default' => array(
								'400',
							),							
						),
						array(
							'type'    => 'slider',
							'name'    => 'ozy_salon_typography_heading_line_height_h4',
							'label'   => esc_attr__('H4 Line Height (em)', 'salon'),
							'min'     => '0',
							'max'     => '3',
							'default' => '1.5',
							'step'    => '0.1',
						),						
						array(
							'type' => 'select',
							'name' => 'ozy_salon_typography_heading_font_ls_h4',
							'label' => esc_attr__('H4 Letter Spacing', 'salon'),
							'default' => 'normal',							
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_letter_spacing_list',
									),
								),
							),
						),
					),
				),
				array(
					'type' => 'section',
					'title' => esc_attr__('H5 Options', 'salon'),
					'fields' => array(						
						array(
							'type'    => 'slider',
							'name'    => 'ozy_salon_typography_heading_h5_font_size',
							'label'   => esc_attr__('H5 Size (px)', 'salon'),
							'min'     => '5',
							'max'     => '128',
							'default' => '16',
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_salon_typography_heading_h5_font_style',
							'label' => esc_attr__('H5 Font Style', 'salon'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'binding',
										'field' => 'ozy_salon_typography_heading_font_face',
										'value' => 'vp_get_gwf_style',
									),
								),
							),
							'default' => array(
								'normal',
							),
						),						
						array(
							'type' => 'select',
							'name' => 'ozy_salon_typography_heading_font_weight_h5',
							'label' => esc_attr__('H5 Weight', 'salon'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_weight_list',
									),
								),
							),
							'default' => array(
								'400',
							),							
						),
						array(
							'type'    => 'slider',
							'name'    => 'ozy_salon_typography_heading_line_height_h5',
							'label'   => esc_attr__('H5 Line Height (em)', 'salon'),
							'min'     => '0',
							'max'     => '3',
							'default' => '1.5',
							'step'    => '0.1',
						),						
						array(
							'type' => 'select',
							'name' => 'ozy_salon_typography_heading_font_ls_h5',
							'label' => esc_attr__('H5 Letter Spacing', 'salon'),
							'default' => 'normal',							
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_letter_spacing_list',
									),
								),
							),
						),
					),
				),
				array(
					'type' => 'section',
					'title' => esc_attr__('H6 Options', 'salon'),
					'fields' => array(						
						array(
							'type'    => 'slider',
							'name'    => 'ozy_salon_typography_heading_h6_font_size',
							'label'   => esc_attr__('H6 Size (px)', 'salon'),
							'min'     => '5',
							'max'     => '128',
							'default' => '12',
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_salon_typography_heading_h6_font_style',
							'label' => esc_attr__('H6 Font Style', 'salon'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'binding',
										'field' => 'ozy_salon_typography_heading_font_face',
										'value' => 'vp_get_gwf_style',
									),
								),
							),
							'default' => array(
								'normal',
							),
						),						
						array(
							'type' => 'select',
							'name' => 'ozy_salon_typography_heading_font_weight_h6',
							'label' => esc_attr__('H6 Weight', 'salon'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_weight_list',
									),
								),
							),
							'default' => array(
								'400',
							),							
						),
						array(
							'type'    => 'slider',
							'name'    => 'ozy_salon_typography_heading_line_height_h6',
							'label'   => esc_attr__('H6 Line Height (em)', 'salon'),
							'min'     => '0',
							'max'     => '3',
							'default' => '1.5',
							'step'    => '0.1',
						),						
						array(
							'type' => 'select',
							'name' => 'ozy_salon_typography_heading_font_ls_h6',
							'label' => esc_attr__('H6 Letter Spacing', 'salon'),
							'default' => 'normal',
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_letter_spacing_list',
									),
								),
							),
						),						
					),
				),
				

				array(
					'type' => 'section',
					'title' => esc_attr__('Primary Menu Typography', 'salon'),
					'name' => 'ozy_salon_primary_menu_section_typography',
					'fields' => array(
						array(
							'type' => 'select',
							'name' => 'ozy_salon_primary_menu_typography_font_face',
							'label' => esc_attr__('Font Face', 'salon'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_gwf_family',
									),
								),
							),
							'default' => 'Volkhov'
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_salon_primary_menu_typography_font_style',
							'label' => esc_attr__('Font Style', 'salon'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'binding',
										'field' => 'ozy_salon_primary_menu_typography_font_face',
										'value' => 'vp_get_gwf_style',
									),
								),
							),
							'default' => array(
								'normal',
							),
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_salon_primary_menu_typography_font_weight',
							'label' => esc_attr__('Font Weight', 'salon'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'binding',
										'field' => 'ozy_salon_primary_menu_typography_font_face',
										'value' => 'vp_get_gwf_weight',
									),
								),
							),
							'default' => array(
								'normal',
							),
						),
						array(
							'type'    => 'slider',
							'name'    => 'ozy_salon_primary_menu_typography_font_size',
							'label'   => esc_attr__('Font Size (px)', 'salon'),
							'min'     => '5',
							'max'     => '128',
							'default' => '50',
						),
						array(
							'type'    => 'slider',
							'name'    => 'ozy_salon_primary_menu_typography_line_height',
							'label'   => esc_attr__('Line Height (em)', 'salon'),
							'min'     => '0',
							'max'     => '3',
							'default' => '1.3',

							'step'    => '0.1',
						),
					),
				),
				
				array(
					'type' => 'section',
					'title' => esc_attr__('Footer Typography', 'salon'),
					'name' => 'ozy_salon_footer_section_typography',
					'fields' => array(
						array(
							'type' => 'select',
							'name' => 'ozy_salon_footer_typography_font_face',
							'label' => esc_attr__('Font Face', 'salon'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_gwf_family',
									),
								),
							),
							'default' => 'Volkhov'
						)						
					),
				),				
								
			),
		),
		
				
		array(
			'title' => esc_attr__('Layout', 'salon'),
			'name' => 'ozy_salon_layout',
			'icon' => 'font-awesome:fa-magic',
			'menus' => array(
				array(
					'title' => esc_attr__('Primary Menu / Logo', 'salon'),
					'name' => 'ozy_salon_primary_menu',
					'icon' => 'font-awesome:fa-cogs',
					'controls' => array(
						array(
							'type' => 'section',
							'title' => esc_attr__('Primary Menu', 'salon'),
							'name' => 'ozy_salon_section_header_layout',
							'fields' => $primary_menu_address_array						
						),
						
						array(
							'type' => 'section',
							'title' => esc_attr__('Floating Buttons', 'salon'),
							'name' => 'ozy_salon_section_floating_buttons',
							'fields' => $floating_button_labels_array
						),
						
						array(
							'type' => 'section',
							'title' => esc_attr__('Logo', 'salon'),
							'name' => 'ozy_salon_section_image_logo',
							'description' => esc_attr__('Please upload custom logo images for your site, one for regular one for retina screens which mighy be 2x larger', 'salon'),
							'fields' => array(				
								array(
									'type' => 'toggle',
									'name' => 'ozy_salon_use_custom_logo',
									'label' => esc_attr__('Use Custom Logo', 'salon'),
									'default' => 1,
									'description' => esc_attr__('Use custom logo or text logo', 'salon'),
								),
								array(
									'type' => 'upload',
									'name' => 'ozy_salon_custom_logo',
									'label' => esc_attr__('Custom Logo', 'salon'),
									'default' => SALON_BASE_URL . 'images/logo.png',
									'dependency' => array(
										'field' => 'ozy_salon_use_custom_logo',
										'function' => 'vp_dep_boolean',
									),
									'description' => esc_attr__('Upload or choose custom logo', 'salon'),
								),								
								array(
									'type' => 'upload',
									'name' => 'ozy_salon_custom_logo_retina',
									'label' => esc_attr__('Custom Logo Retina', 'salon'),
									'default' => SALON_BASE_URL . 'images/logo@2x.png',
									'dependency' => array(
										'field' => 'ozy_salon_use_custom_logo',
										'function' => 'vp_dep_boolean',
									),
									'description' => esc_attr__('Upload or choose custom 2x bigger logo', 'salon'),
								),
								array(
									'type' => 'upload',
									'name' => 'ozy_salon_custom_logo_alternate',
									'label' => esc_attr__('Custom Logo Alternate', 'salon'),
									'default' => SALON_BASE_URL . 'images/logo_alternate.png',
									'dependency' => array(
										'field' => 'ozy_salon_use_custom_logo',
										'function' => 'vp_dep_boolean',
									),
									'description' => esc_attr__('Upload or choose custom alternate logo', 'salon'),
								),								
								array(
									'type' => 'upload',
									'name' => 'ozy_salon_custom_logo_retina_alternate',
									'label' => esc_attr__('Custom Logo Retina Alternate', 'salon'),
									'default' => SALON_BASE_URL . 'images/logo_alternate@2x.png',
									'dependency' => array(
										'field' => 'ozy_salon_use_custom_logo',
										'function' => 'vp_dep_boolean',
									),
									'description' => esc_attr__('Upload or choose custom 2x bigger alternate logo', 'salon'),
								)															
							),
						),																				
					),
				),
				
				
				array(
					'title' => esc_attr__('Footer', 'salon'),
					'name' => 'ozy_salon_footer',
					'icon' => 'font-awesome:fa-cog',
					'controls' => array(
						array(
							'type' => 'section',
							'title' => esc_attr__('Footer Layout', 'salon'),
							'name' => 'ozy_salon_section_footer_copyright',
							'fields' => $footer_copyright_array
						)												
					),
				),				
				

				array(
					'title' => esc_attr__('Content / Page / Post', 'salon'),
					'name' => 'ozy_salon_page',
					'icon' => 'font-awesome:fa-pencil',
					'controls' => array(
						array(
							'type' => 'section',
							'title' => esc_attr__('General Layout', 'salon'),
							'name' => 'ozy_salon_page_section_general_layout',
							'fields' => array(
								array(
									'type' => 'radiobutton',
									'name' => 'ozy_salon_page_layout_width',
									'label' => esc_attr__('Layout Width', 'salon'),
									'items' => array(
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
										'1212',
									),
								)								
							),
						),								
						array(
							'type' => 'section',
							'title' => esc_attr__('Custom Page Pointers', 'salon'),
							'name' => 'ozy_salon_page_section_custom_page_pointers',
							'description' => esc_attr__('Select a page to use as your custom pages for some available places.', 'salon'),
							'fields' => array(
								array(
									'type' => 'select',
									'name' => 'ozy_salon_page_404_page_id',
									'label' => esc_attr__('404 Page', 'salon'),
									'description' => esc_attr__('Select a page to use as custom 404 page.', 'salon'),
									'items' => array(
										'data' => array(
											array(
												'source' => 'function',
												'value' => 'vp_bind_ozy_salon_pages',
											),
										),
									),
								),
								array(
									'type' => 'select',
									'name' => 'ozy_salon_page_blog_page_id',
									'label' => esc_attr__('Blog Page', 'salon'),
									'description' => esc_attr__('Select a page to use as custom Blog page.', 'salon'),
									'items' => array(
										'data' => array(
											array(
												'source' => 'function',
												'value' => 'vp_bind_ozy_salon_pages',
											),
										),
									),
								)																										
							),
						),							
						array(
							'type' => 'section',
							'title' => esc_attr__('Page', 'salon'),
							'name' => 'ozy_salon_page_section_page_sidebar_position',
							'description' => esc_attr__('Select position for your page sidebar', 'salon'),
							'fields' => array(
								array(
									'type' => 'notebox',
									'name' => 'ozy_salon_page_page_sidebar_info',
									'label' => esc_attr__('About Sidebars', 'salon'),
									'description' => wp_kses(__('To create a dynamic sidebar, first make sure "Salon Theme Essentials" plugins installed and activated, then please open <a href="edit.php?post_type=ozy_sidebars">Sidebars</a> section.', 'salon'),array('a' => array('href' => array()))),
									'status' => 'normal',
								),								
								array(
									'type' => 'radioimage',
									'name' => 'ozy_salon_page_page_sidebar_position',
									'label' => esc_attr__('Default Sidebar Position', 'salon'),
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
									'default' => array(
										'{{first}}',
									),
								),
								array(
									'type' => 'select',
									'name' => 'ozy_salon_page_page_sidebar_id',
									'label' => esc_attr__('Default Sidebar', 'salon'),
									'description' => esc_attr__('This option could be overriden individually.', 'salon'),
									'items' => array(
										'data' => array(
											array(
												'source' => 'function',
												'value' => 'vp_bind_ozy_salon_sidebars',
											),
										),
									),
								),
								array(
									'type' => 'toggle',
									'name' => 'ozy_salon_page_page_comment',
									'label' => esc_attr__('Comments Section', 'salon'),
									'description' => esc_attr__('Enable / Disable comment section on the pages', 'salon'),
									'default' => '0',
								),
								array(
									'type' => 'toggle',
									'name' => 'ozy_salon_page_page_author',
									'label' => esc_attr__('Author Section', 'salon'),
									'description' => esc_attr__('Enable / Disable author section on the pages', 'salon'),
									'default' => '0',
								),												
							),
						),
						array(
							'type' => 'section',
							'title' => esc_attr__('Blog', 'salon'),
							'name' => 'ozy_salon_page_section_blog_sidebar_position',
							'description' => esc_attr__('Select position for your blog page sidebar', 'salon'),
							'fields' => array(
								array(
									'type' => 'notebox',
									'name' => 'ozy_salon_page_blog_sidebar_info',
									'label' => esc_attr__('About Sidebars', 'salon'),
									'description' => wp_kses(__('To create a dynamic sidebar, first make sure "Salon Theme Essentials" plugins installed and activated, then please open <a href="edit.php?post_type=ozy_sidebars">Sidebars</a> section.', 'salon'),array('a' => array('href' => array()))),
									'status' => 'normal',
								),								
								array(
									'type' => 'radioimage',
									'name' => 'ozy_salon_page_blog_sidebar_position',
									'label' => esc_attr__('Defaul Sidebar Position', 'salon'),
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
									'default' => array(
										'{{first}}',
									),
								),
								array(
									'type' => 'select',
									'name' => 'ozy_salon_page_blog_sidebar_id',
									'label' => esc_attr__('Default Sidebar', 'salon'),
									'description' => esc_attr__('This option could be overriden individually.', 'salon'),
									'items' => array(
										'data' => array(
											array(
												'source' => 'function',
												'value' => 'vp_bind_ozy_salon_sidebars',
											),
										),
									),
								),
								array(
									'type' => 'toggle',
									'name' => 'ozy_salon_page_blog_comment',
									'label' => esc_attr__('Comments Section', 'salon'),
									'description' => esc_attr__('Enable / Disable comment section on the blog posts', 'salon'),
									'default' => '1',
								),
								array(
									'type' => 'toggle',
									'name' => 'ozy_salon_page_blog_author',
									'label' => esc_attr__('Author Section', 'salon'),
									'description' => esc_attr__('Enable / Disable author section on the blog posts', 'salon'),
									'default' => '1',
								),
								array(
									'type' => 'toggle',
									'name' => 'ozy_salon_page_blog_share',
									'label' => esc_attr__('Share Buttons', 'salon'),
									'description' => esc_attr__('Enable / Disable share buttons for posts.', 'salon'),
									'default' => '1',
								),
								array(
									'type' => 'toggle',
									'name' => 'ozy_salon_page_blog_related_posts',
									'label' => esc_attr__('Related Posts', 'salon'),
									'description' => esc_attr__('Enable / Disable related posts.', 'salon'),
									'default' => '1',
								),
								array(
									'type' => 'select',
									'name' => 'ozy_salon_page_blog_list_page_id',
									'label' => esc_attr__('Default Listing Page', 'salon'),
									'description' => esc_attr__('Select a page to use as "Return to Blog" link.', 'salon'),
									'items' => array(
										'data' => array(
											array(
												'source' => 'function',
												'value' => 'vp_bind_ozy_salon_pages',
											),
										),
									),
								)											
							),
						),											
					),
				),	
				
				
				array(
					'title' => esc_attr__('Miscellaneous', 'salon'),
					'name' => 'ozy_salon_misc',
					'icon' => 'font-awesome:fa-puzzle-piece',
					'controls' => array(
						array(
							'type' => 'section',
							'title' => esc_attr__('Fancy Box (Lightbox)', 'salon'),
							'name' => 'ozy_salon_section_fancybox_layout',
							'fields' => array(
								array(
									'type' => 'toggle',
									'name' => 'ozy_salon_fancbox_media',
									'label' => esc_attr__('Video Support', 'salon'),
									'description' => esc_attr__('By enabling this option Fancybox will start to support popular media links.', 'salon'),
									'default' => '1',
								),
								array(
									'type' => 'toggle',
									'name' => 'ozy_salon_fancbox_thumbnail',
									'label' => esc_attr__('Thumbnail', 'salon'),
									'description' => esc_attr__('Enable this option to show thumnails under your Fancybox window.', 'salon'),
									'default' => '0',
								),								
							),
						),																
					),
				),
				array(
					'title' => esc_attr__('Countdown Page', 'salon'),
					'name' => 'ozy_salon_countdown',
					'icon' => 'font-awesome:fa-clock-o',
					'controls' => array(
						array(
							'type' => 'section',
							'title' => esc_attr__('Countdown Page Options', 'salon'),
							'name' => 'ozy_salon_section_countdown',
							'fields' => array(
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_countdown_year',
									'label' => esc_attr__('End Year', 'salon'),
									'description' => esc_attr__('Enter the Year of the date counter will count to.', 'salon'),
									'default' => date('Y', time())
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_countdown_month',
									'label' => esc_attr__('End Month', 'salon'),
									'description' => esc_attr__('Enter the Month of the date counter will count to.', 'salon'),
									'default' => date('m', time())
								),								
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_countdown_day',
									'label' => esc_attr__('End Day', 'salon'),
									'description' => esc_attr__('Enter the Day of the date counter will count to.', 'salon'),
									'default' => '15'
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_countdown_hour',
									'label' => esc_attr__('End Hour', 'salon'),
									'description' => esc_attr__('Enter the Hour of the date counter will count to. Use 24 hour format', 'salon'),
									'default' => '12'
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_countdown_minute',
									'label' => esc_attr__('End Minute', 'salon'),
									'description' => esc_attr__('Enter the Minute of the date counter will count to.', 'salon'),
									'default' => '12'
								)	
							),
						),
												
					),
				),			
			),
		),
		array(
			'name' => 'ozy_salon_color_options',
			'title' => esc_attr__('Color Options', 'salon'),
			'icon' => 'font-awesome:fa-eye',
			'controls' => array(
							
				array(
					'type' => 'section',
					'title' => esc_attr__('GENERIC', 'salon'),
					'fields' => array(
						array(
							'type' => 'color',
							'name' => 'ozy_salon_content_background_color',
							'label' => esc_attr__('Content Background', 'salon'),
							'format' => 'rgba',
							'default' => 'rgba(255,255,255,1)'
						),
						array(
							'type' => 'color',
							'name' => 'ozy_salon_heading_color',
							'label' => esc_attr__('Heading Color', 'salon'),
							'description' => esc_attr__('Default color for H1-H6 elements', 'salon'),
							'format' => 'hex',
							'default' => '#000000'
						),
						array(
							'type' => 'color',
							'name' => 'ozy_salon_content_color',
							'label' => esc_attr__('Content Color', 'salon'),
							'description' => esc_attr__('Font color of the content', 'salon'),
							'format' => 'hex',
							'default' => '#210c20'
						),
						array(
							'type' => 'color',
							'name' => 'ozy_salon_content_color_alternate',
							'label' => esc_attr__('Alternate Color #1', 'salon'),
							'description' => esc_attr__('Like link color, hover color and input elements active border', 'salon'),
							'format' => 'hex',
							'default' => '#c09e6f'
						),
						array(
							'type' => 'color',
							'name' => 'ozy_salon_content_color_alternate2',
							'label' => esc_attr__('Alternate Color #2', 'salon'),
							'description' => esc_attr__('Like footer, footer sidebar title color, text color and seperator color', 'salon'),
							'format' => 'hex',
							'default' => '#585558'
						),
						array(
							'type' => 'color',
							'name' => 'ozy_salon_content_color_alternate3',
							'label' => esc_attr__('Alternate Color #3', 'salon'),
							'description' => esc_attr__('Like footer sidebar link color', 'salon'),
							'format' => 'hex',
							'default' => '#ffffff'
						),
						array(
							'type' => 'color',
							'name' => 'ozy_salon_content_color_alternate4',
							'label' => esc_attr__('Alternate Color #4', 'salon'),
							'description' => esc_attr__('Like Blog meta info bar text', 'salon'),
							'format' => 'hex',
							'default' => '#000000'
						),											
						array(
							'type' => 'color',
							'name' => 'ozy_salon_content_background_color_alternate',
							'label' => esc_attr__('Alternate Background Color', 'salon'),
							'description' => esc_attr__('Like comments background color', 'salon'),
							'format' => 'rgba',
							'default' => 'rgba(255,255,255,1)'
						),						
						array(
							'type' => 'color',
							'name' => 'ozy_salon_primary_menu_separator_color',
							'label' => esc_attr__('Separator / Border Color', 'salon'),
							'description' => esc_attr__('Used for, Primary menu, in page Seperators and Comments bottom border', 'salon'),
							'default' => 'rgba(243,237,229,1)',
							'format' => 'rgba'
						),						
					),
				),				
				
				array(
					'type' => 'section',
					'title' => esc_attr__('Primary Menu', 'salon'),
					'name' => 'ozy_salon_primary_menu_section_colors',
					'fields' => array(			
						array(
							'type' => 'color',
							'name' => 'ozy_salon_primary_menu_font_color',
							'label' => esc_attr__('Font Color', 'salon'),
							'default' => 'rgba(255,255,255,0.70)',
							'format' => 'rgba',
						),
						array(
							'type' => 'color',
							'name' => 'ozy_salon_primary_menu_font_color_hover',
							'label' => esc_attr__('Font Color : Hover / Active', 'salon'),
							'default' => 'rgba(255,255,255,1)',
							'format' => 'rgba',
						),
						array(
							'type' => 'color',
							'name' => 'ozy_salon_primary_menu_background_color',
							'label' => esc_attr__('Background Color', 'salon'),
							'default' => 'rgba(0,0,0,1)',
							'format' => 'rgba',
						),											
					),					
				),				
				array(
					'type' => 'section',
					'title' => esc_attr__('Footer', 'salon'),
					'name' => 'ozy_salon_footer_section_colors',
					'fields' => array(
						array(
							'type' => 'color',
							'name' => 'ozy_salon_footer_color_1',
							'label' => esc_attr__('Background Color', 'salon'),
							'default' => 'rgba(0,0,0,1)',
							'format' => 'rgba',
						),
						array(
							'type' => 'color',
							'name' => 'ozy_salon_footer_info_bg',
							'label' => esc_attr__('Info Bar Background Color', 'salon'),
							'default' => 'rgba(29,27,27,1)',
							'format' => 'rgba',
						),					
						array(
							'type' => 'color',
							'name' => 'ozy_salon_footer_color_5',
							'label' => esc_attr__('Title Foreground Color', 'salon'),
							'default' => '#ffffff',
							'format' => 'hex',
						),
						array(
							'type' => 'color',
							'name' => 'ozy_salon_footer_color_2',
							'label' => esc_attr__('Foreground Color', 'salon'),
							'default' => '#ffffff',
							'format' => 'hex',
						),					
						array(
							'type' => 'color',
							'name' => 'ozy_salon_footer_color_3',
							'label' => esc_attr__('Alternate Color', 'salon'),
							'default' => '#c09e6f',
							'format' => 'hex',
						),					
						array(
							'type' => 'color',
							'name' => 'ozy_salon_footer_color_4',
							'label' => esc_attr__('Separator Color', 'salon'),
							'default' => 'rgba(255,255,255,0.10)',
							'format' => 'rgba',
						),
						array(
							'type' => 'upload',
							'name' => 'ozy_salon_footer_background_image',
							'label' => esc_attr__('Background Image', 'salon'),
							'description' => esc_attr__('Upload or choose custom page background image.', 'salon')
						),						
					),
				),
				array(
					'type' => 'section',
					'title' => esc_attr__('Form', 'salon'),
					'name' => 'ozy_salon_form_section_coloring',
					'fields' => array(
						array(
							'type' => 'color',
							'name' => 'ozy_salon_form_font_color',
							'label' => esc_attr__('Font Color', 'salon'),
							'default' => 'rgba(0,0,0,1)',
							'format' => 'rgba',
						),
						array(
							'type' => 'color',
							'name' => 'ozy_salon_form_background_color',
							'label' => esc_attr__('Background Color', 'salon'),
							'default' => 'rgba(243,243,243,1)',
							'format' => 'rgba',
						),
						array(
							'type' => 'color',
							'name' => 'ozy_salon_form_button_font_color',
							'label' => esc_attr__('Font Color (Button)', 'salon'),
							'default' => 'rgba(255,255,255,1)',
							'format' => 'rgba',
						),
						array(
							'type' => 'color',
							'name' => 'ozy_salon_form_button_font_color_hover',
							'label' => esc_attr__('Font Color : Hover / Active (Button)', 'salon'),
							'default' => 'rgba(255,255,255,1)',
							'format' => 'rgba',
						),
						array(
							'type' => 'color',
							'name' => 'ozy_salon_form_button_background_color',
							'label' => esc_attr__('Background Color (Button)', 'salon'),
							'default' => 'rgba(0,0,0,1)',
							'format' => 'rgba',
						),	
						array(
							'type' => 'color',
							'name' => 'ozy_salon_form_button_background_color_hover',
							'label' => esc_attr__('Background Color : Hover / Active (Button)', 'salon'),
							'default' => 'rgba(221,181,127,1)',
							'format' => 'rgba',
						),											
					),
				),
				array(
					'type' => 'section',
					'title' => esc_attr__('Background Styling', 'salon'),
					'fields' => array(
						array(
							'type' => 'color',
							'name' => 'ozy_salon_body_background_color',
							'label' => esc_attr__('Background Color', 'salon'),
							'description' => esc_attr__('This option will affect only page background.', 'salon'),
							'default' => '#ffffff',
							'format' => 'hex',
						),					
						array(
							'type' => 'upload',
							'name' => 'ozy_salon_body_background_image',
							'label' => esc_attr__('Custom Background Image', 'salon'),
							'description' => esc_attr__('Upload or choose custom page background image.', 'salon'),
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_salon_body_background_image_size',
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
							'name' => 'ozy_salon_body_background_image_repeat',
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
							'name' => 'ozy_salon_body_background_image_attachment',
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
					),
				),				
				array(
					'type' => 'section',
					'title' => esc_attr__('Portfolio Post Background Styling', 'salon'),
					'fields' => array(
						array(
							'type' => 'color',
							'name' => 'ozy_salon_portfolio_body_background_color',
							'label' => esc_attr__('Background Color', 'salon'),
							'description' => esc_attr__('This option will affect only portfolio post background.', 'salon'),
							'default' => '#ffffff',
							'format' => 'hex',
						),		
					),
				),				
				
			),
		),			
		
		array(
			'title' => esc_attr__('Social', 'salon'),
			'name' => 'ozy_salon_typography',
			'icon' => 'font-awesome:fa-group',
			'menus' => array(
				array(
					'title' => esc_attr__('Accounts', 'salon'),
					'name' => 'ozy_salon_social_accounts',
					'icon' => 'font-awesome:fa-heart-o',
					'controls' => array(
						array(
							'type' => 'section',
							'title' => esc_attr__('Social Accounts', 'salon'),
							'description' => esc_attr__('Enter social account names/IDs box below', 'salon'),
							'fields' => array(
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_fivehundredpx',
									'label' => esc_attr__('500px', 'salon')
								),							
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_behance',
									'label' => esc_attr__('Behance', 'salon')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_blogger',
									'label' => esc_attr__('Blogger', 'salon')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_delicious',
									'label' => esc_attr__('Delicious', 'salon')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_deviantart',
									'label' => esc_attr__('DeviantArt', 'salon')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_digg',
									'label' => esc_attr__('Digg', 'salon')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_dribble',
									'label' => esc_attr__('Dribble', 'salon')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_email',
									'label' => esc_attr__('Email', 'salon'),
									'default' => '#'
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_facebook',
									'label' => esc_attr__('Facebook', 'salon'),
									'default' => '#'
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_flickr',
									'label' => esc_attr__('Flickr', 'salon')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_forrst',
									'label' => esc_attr__('Forrst', 'salon')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_foursquare',
									'label' => esc_attr__('Foursquare', 'salon')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_github',
									'label' => esc_attr__('Github', 'salon')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_googleplus',
									'label' => esc_attr__('Google+', 'salon')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_instagram',
									'label' => esc_attr__('Instagram', 'salon'),
									'default' => '#'
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_lastfm',
									'label' => esc_attr__('Last.FM', 'salon')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_linkedin',
									'label' => esc_attr__('LinkedIn', 'salon')
								),

								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_myspace',
									'label' => esc_attr__('MySpace', 'salon')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_pinterest',
									'label' => esc_attr__('Pinterest', 'salon')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_rss',
									'label' => esc_attr__('RSS', 'salon')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_soundcloud',
									'label' => esc_attr__('SoundCloud', 'salon')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_stumbleupon',
									'label' => esc_attr__('StumbleUpon', 'salon')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_tumblr',
									'label' => esc_attr__('Tumblr', 'salon')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_twitter',
									'label' => esc_attr__('Twitter', 'salon'),
									'default' => '#'
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_vimeo',
									'label' => esc_attr__('Vimeo', 'salon')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_vk',
									'label' => __('VK', 'salon')
								),								
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_wordpress',
									'label' => esc_attr__('WordPress', 'salon')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_yahoo',
									'label' => esc_attr__('Yahoo!', 'salon')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_yelp',
									'label' => __('Yelp (Please use full URL)', 'salon')
								),									
								array(
									'type' => 'textbox',
									'name' => 'ozy_salon_social_accounts_youtube',
									'label' => esc_attr__('Youtube', 'salon')
								),																																																																																																																																																																																														
							),
						),
					),
				),			
				array(
					'title' => esc_attr__('General', 'salon'),
					'name' => 'ozy_salon_social_general',
					'icon' => 'font-awesome:fa-group',
					'controls' => array(
						array(
							'type' => 'section',
							'title' => esc_attr__('Social Icons', 'salon'),
							'fields' => array(
								array(
									'type' => 'toggle',
									'name' => 'ozy_salon_social_use',
									'label' => esc_attr__('Social Share Buttons', 'salon'),
									'description' => esc_attr__('Enable / Disable social share buttons.', 'salon'),
									'default' => '1',
								),
								array(
									'type' => 'sorter',
									'name' => 'ozy_salon_social_icon_order',
									'max_selection' => 20,
									'label' => esc_attr__('Icon List / Order', 'salon'),
									'description' => esc_attr__('Select visible icons and sort.', 'salon'),
									'items' => array(
										'data' => array(
											array(
												'source' => 'function',
												'value' => 'vp_get_social_medias',
											),
										),
									),
									'default' => array('email', 'facebook', 'instagram', 'twitter')
								),
								array(
									'type' => 'select',
									'name' => 'ozy_salon_social_icon_target',
									'label' => esc_attr__('Target Window', 'salon'),
									'description' => esc_attr__('Where links will be opened?', 'salon'),
									'items' => array(
										array(
											'value' => '_blank',
											'label' => esc_attr__('Blank Window / New Tab', 'salon'),
										),
										array(
											'value' => '_self',
											'label' => esc_attr__('Self Window', 'salon'),
										),
									),
									'default' => array(
										'_blank',
									),
								),								
							),
						),
					),
				),			
			),
		),
	)
);

return $ozy_salon_option_arr;

/**
 *EOF
 */