<?php

require_once(SALON_BASE_DIR . 'functions/classes/tgm-plugin-activation.php');

/**
* TGM Plugin activator
*/
function salon_register_required_plugins() {

	$plugins = array(
		array(
			'name'     	=> 'Salon Essentials',
			'slug'     	=> 'ozy-salon-essentials',
			'source'   	=> get_template_directory() . '/plugins/ozy-salon-essentials.zip',
			'required' 	=> true,
			'force_deactivation' => true,
			'version'	=> '1.1'
		),array(
			'name'     	=> 'Revolution Slider',
			'slug'     	=> 'revslider',
			'source'   	=> get_template_directory() . '/plugins/revslider.zip',
			'required' 	=> true,
			'force_deactivation' => true,
			'version'	=> '5.4.8'
		),array(
			'name'     	=> 'WPBakery Page Builder (formerly Visual Composer)',
			'slug'     	=> 'js_composer',
			'source'   	=> get_template_directory() . '/plugins/js_composer.zip',
			'required' 	=> true,
			'force_deactivation' => true,
			'version'	=> '5.5.2'
		),array(
			'name'     	=> 'Booked Appointments',
			'slug'     	=> 'booked',
			'source'   	=> get_template_directory() . '/plugins/booked.zip',
			'required' 	=> false,
			'force_deactivation' => true,
			'version'	=> '2.1'
		),array(
			'name'     	=> 'MailChimp Widget',
			'slug'     	=> 'mailchimp-widget',
			'source'   	=> get_template_directory() . '/plugins/mailchimp-widget.zip',
			'required' 	=> false,
			'force_deactivation' => true,
			'version'	=> '0.8.12'
		),array(
			'name'     	=> 'Envato Market',
			'slug'     	=> 'envato-market',
			'source'   	=> get_template_directory() . '/plugins/envato-market.zip',
			'required' 	=> false,
			'force_deactivation' => true,
			'version'	=> '2.0.0'
		),array(
			'name'     	=> 'Contact Form 7',
			'slug'     	=> 'contact-form-7',
			'required' 	=> true,
			'force_deactivation' => true,
			'version'	=> '5.0.2'
		)
	);

	$config = array(
		'id'           => 'salon',  				// Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      	// Default absolute path to bundled plugins.
		'menu'         => 'install-required-plugins', // Menu slug.
		'has_notices'  => true,                    	// Show admin notices or not.
		'dismissable'  => true,                    	// If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      	// If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   	// Automatically activate plugins after installation or not.
		'message'      => '',                      	// Message to output right before the plugins table.				
	);

	tgmpa( $plugins, $config );

}

add_action('tgmpa_register', 'salon_register_required_plugins');

?>