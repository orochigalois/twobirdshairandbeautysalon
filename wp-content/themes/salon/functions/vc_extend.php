<?php
vc_add_param("vc_row", array(
	"type" => 'checkbox',
	"heading" => esc_attr__("Use Alternate Logo", "salon"),
	"param_name" => "row_alternate_logo",
	"description" => esc_attr__("If selected, alternate logo will be displayed when this row appears.", "salon"),
	"value" => Array(esc_attr__("Yes, please", "salon") => '1'),
	"group" => esc_attr__("FreeVision Custom", "salon")
));

vc_add_param("vc_row", array(
	"type" => 'dropdown',
	"heading" => __("Background Effect", "salon"),
	"param_name" => "bg_slider",
	"description" => __("If selected, you can select background images for your row.", "salon"),
	"value" => array("off" => "", "Kenburns Slider" => "kenburns", "Shuffle Slider" => "shuffle", "Photo Sharr Slider" => "photo_sharr", "Animated Wawe  Effect" => "wave"),
	"group" => __("FreeVision Custom", "salon")	
));

vc_add_param("vc_row", array(
	"type" => 'colorpicker',
	"heading" => __("Bar Color", "salon"),
	"param_name" => "wave_bar_color",
	"value" => '#222222',
	"dependency" => Array('element' => "bg_slider", 'value' => 'wave'),
	"group" => __("FreeVision Custom", "salon")	,
));

vc_add_param("vc_row", array(
	"type" => 'colorpicker',
	"heading" => __("Gradient Color Start", "salon"),
	"param_name" => "sharr_color1",
	"value" => '#597b7e',
	"dependency" => Array('element' => "bg_slider", 'value' => 'photo_sharr'),
	"group" => __("FreeVision Custom", "salon")	,
));

vc_add_param("vc_row", array(
	"type" => 'colorpicker',
	"heading" => __("Gradient Color End", "salon"),
	"param_name" => "sharr_color2",
	"value" => '#294b4e',
	"dependency" => Array('element' => "bg_slider", 'value' => 'photo_sharr'),
	"group" => __("FreeVision Custom", "salon")	,
));

vc_add_param("vc_row", array(
	"type" => "attach_images",
	"heading" => __("Images", "salon"),
	"param_name" => "bg_slider_images",
	"description" => __("Select images for your slider", "salon"),
	"dependency" => Array('element' => "bg_slider", 'not_empty' => true),
	"group" => __("FreeVision Custom", "salon")	
));

vc_add_param("vc_row", array(
	"type" => "attach_image",
	"heading" => __("Fallback Image", "salon"),
	"param_name" => "bg_slider_fallback_image",
	"description" => __("Please select a fallback image to use on mobile devices and small screens.", "salon"),
	"dependency" => Array('element' => "bg_slider", 'not_empty' => true),
	"group" => __("FreeVision Custom", "salon")	
));

vc_add_param("vc_row", array(
	"type" => 'dropdown',
	"heading" => __("Self Hosted Background Video", "salon"),
	"param_name" => "bg_video",
	"description" => __("If selected, you can select background video for your row.", "salon"),
	"value" => array("off" => "off", "on" => "on"),
	"group" => __("FreeVision Custom", "salon")	
));

vc_add_param("vc_row", array(
	"type" => "textfield",
	"heading" => __("Video Path", "salon"),
	"param_name" => "bg_video_path",
	"description" => __("Please type path of your self hosted MP4 file here.", "salon"),
	"dependency" => Array('element' => "bg_video", 'value' => 'on'),
	"group" => __("FreeVision Custom", "salon")	
));

vc_add_param("vc_row", array(
	"type" => "attach_image",
	"heading" => __("Fallback Image", "salon"),
	"param_name" => "bg_video_fallback_image",
	"description" => __("Please select a fallback image to use on mobile devices and small screens.", "salon"),
	"dependency" => Array('element' => "bg_video", 'value' => 'on'),
	"group" => __("FreeVision Custom", "salon")	
));

vc_add_param("vc_row", array(
	"type" => 'dropdown',
	"heading" => __("Bottom Arrow?", "salon"),
	"param_name" => "bottom_arrow",
	"value" => array("off" => "off", "on" => "on"),
	"group" => __("FreeVision Custom", "salon")	
));

vc_add_param("vc_row", array(
	"type" => "textfield",
	"heading" => __("Caption", "salon"),
	"param_name" => "bottom_arrow_caption",
	"dependency" => Array('element' => "bottom_arrow", 'value' => 'on'),
	"value" => esc_attr("SCROLL DOWN", "salon"),
	"group" => __("FreeVision Custom", "salon")	
));

vc_add_param("vc_btn", array(
	"type" => 'checkbox',
	"heading" => esc_attr__("Use Extended Content", "salon"),
	"param_name" => "row_use_extended_content",
	"description" => esc_attr__("If selected, you can enter HTML content which will be shown on floating window when clicked.", "salon"),
	"value" => Array(esc_attr__("Yes, please", "salon") => 'on'),
	"group" => esc_attr__("FreeVision Custom", "salon")
));

vc_add_param("vc_btn", array(
	"type" => "textarea_html",
	"heading" => esc_attr__("Content", "salon"),
	"param_name" => "content",
	"dependency" => Array('element' => "row_use_extended_content", 'value' => 'on'),
	"group" => esc_attr__("FreeVision Custom", "salon")	
));

vc_add_param("vc_column", array(
	"type" => 'checkbox',
	"heading" => esc_attr__("Use Custom Typography Options", "salon"),
	"param_name" => "column_use_custom_typography",
	"description" => esc_attr__("If selected, few custom typography options will appear.", "salon"),
	"value" => Array(esc_attr__("Yes, please", "salon") => '1'),
	"group" => esc_attr__("FreeVision Custom", "salon")
));

vc_add_param("vc_column", array(
	"type" => "colorpicker",
	"heading" => esc_attr__("Color", "salon"),
	"param_name" => "column_use_custom_typography_color",
	"dependency" => Array('element' => "column_use_custom_typography", 'value' => '1'),
	"value" => salon_get_option('content_color'),
	"group" => esc_attr__("FreeVision Custom", "salon")
));

vc_add_param("vc_column", array(
	"type" => "textfield",
	"heading" => esc_attr__("Size (px)", "salon"),
	"param_name" => "column_use_custom_typography_size",
	"dependency" => Array('element' => "column_use_custom_typography", 'value' => '1'),
	"value" => salon_get_option('typography_font_size'),
	"group" => esc_attr__("FreeVision Custom", "salon")
));

vc_add_param("vc_column", array(
	"type" => "textfield",
	"heading" => esc_attr__("Line Height (em)", "salon"),
	"param_name" => "column_use_custom_typography_line_height",
	"dependency" => Array('element' => "column_use_custom_typography", 'value' => '1'),
	"value" => salon_get_option('typography_font_line_height'),
	"group" => esc_attr__("FreeVision Custom", "salon")
));

vc_add_param("vc_column", array(
	"type" => "dropdown",
	"heading" => esc_attr__('Text Align', 'salon'),
	"param_name" => "column_use_custom_typography_align",
	"value" => array(
			  esc_attr__("-leave as is-", 'salon') => '',
			  esc_attr__("Left", 'salon') => 'left',
			  esc_attr__("Right", 'salon') => 'right',
			  esc_attr__('Center', 'salon') => 'center'
			),
	"group" => esc_attr__("FreeVision Custom", "salon")	
));
?>