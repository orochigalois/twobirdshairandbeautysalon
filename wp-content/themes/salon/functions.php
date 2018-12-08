<?php
/**
* Constants
*/
define( 'SALON_BASE_DIR', get_template_directory() . '/' );
define( 'SALON_BASE_URL', get_template_directory_uri() . '/' );
define( 'SALON_CSS_DIRECTORY_URL', get_stylesheet_directory_uri() . '/');
define( 'SALON_HOME_URL', esc_url(home_url('/') . '/') );
define( 'SALON_THEME_VERSION', '1.9' );
define( 'SALON_THEMENAME', 'SALON' ); //used in TGM Plugin Activation
define( 'SALON_DATE_FORMAT', get_option('date_format'));

/**
* Globals
*/
include_once(SALON_BASE_DIR . 'functions/classes/helper.php');

/**
* WPML Plugin Check
*/	
salon_sd('wpml_current_language_', '');
if(defined("ICL_LANGUAGE_CODE") && ICL_LANGUAGE_CODE != 'en') {
	salon_sd('wpml_current_language_', '_' . ICL_LANGUAGE_CODE);
}
	
/**
* Sets up theme defaults and registers support for various WordPress features.
*/
add_action('after_setup_theme', 'salon_theme_setup');	
function salon_theme_setup() {
	// Load Languages
	load_theme_textdomain('salon', get_template_directory() . '/lang/');

	// Declare Automatic Feed Links support
	add_theme_support( 'automatic-feed-links' );
	
	// Post thumbnail support
	add_theme_support( 'post-thumbnails' );
	
	// Custom menu support
	if ( function_exists( 'register_nav_menus' ) ) {
		register_nav_menus(
			array(
			  'header-menu' => esc_attr__('Primary Menu', 'salon'),
			  'logged-in-menu' => esc_attr__('Logged In Primary Menu', 'salon'),
			)
		);
	}

	// Add custom thumbnail sizes
	if ( function_exists( 'add_image_size' ) ) { 
		add_image_size( 'sixteennine', 560, 380, true );
		add_image_size( 'salon_showbiz', 720, 720, true );
		add_image_size( 'salon_blog', 1144, 9999, false );
	}
	
	// WordPress 4.1+ title tag support
	add_theme_support("title-tag");	
}

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function salon_content_width() {
	$GLOBALS['content_width'] = apply_filters('salon_content_width', 1212); //1600
}
add_action('after_setup_theme', 'salon_content_width', 0);

/**
* TGM Plugin Activator
*/
require_once SALON_BASE_DIR . 'functions/plugins.php';

/**
* Include Vafpress Framework
*/
require_once SALON_BASE_DIR . 'framework/bootstrap.php';
	
/**
* Include Custom Data Sources
*/
require_once SALON_BASE_DIR . 'admin/data_sources.php';

/**
* Mobile Check Class
*/
require_once SALON_BASE_DIR . 'functions/classes/mobile-check.php';

/**
* Theme options initializing here
*/
$ozy_tmpl_opt = SALON_BASE_DIR . 'admin/option/option.php';

/*
* Chat Formatter
*/
include_once(SALON_BASE_DIR . 'functions/chat.formatter.php');

/**
* Main functions / actions / hooks
*/
include_once(SALON_BASE_DIR . 'functions/functions.php');

/**
* Include Dynamic Sidebars
*/
require_once SALON_BASE_DIR . 'functions/sidebars.php';

/**
* Include Inline Resource file that contain SVG and etc.
*/
include_once(SALON_BASE_DIR . 'include/inline-resource.php');		

/**
* Create instance of Theme Options
*/
$theme_options = new VP_Option(array(
	'is_dev_mode' 			=> false, // dev mode, default to false
	'option_key' 			=> 'vpt_ozy_salon_option', // options key in db, required
	'page_slug' 			=> 'vpt_option', // options page slug, required
	'template' 				=> $ozy_tmpl_opt, // template file path or array, required
	'menu_page' 			=> 'themes.php', // parent menu slug or supply `array` (can contains 'icon_url' & 'position') for top level menu
	'use_auto_group_naming' => true, // default to true
	'use_exim_menu' 		=> true, // default to true, shows export import menu
	'minimum_role' 			=> 'edit_theme_options', // default to 'edit_theme_options'
	'layout' 				=> 'fixed', // fluid or fixed, default to fixed
	'page_title' 			=> esc_attr__( 'Theme Options', 'salon' ), // page title
	'menu_label' 			=> esc_attr__( 'Theme Options', 'salon' ), // menu label
));

/**
* Load option based css
*/
include_once(SALON_BASE_DIR . 'functions/option-based-css.php');

/**
* Visual Composer Add-On visual shortcodes
*/
salon_sd('vc_active', false);

function salon_init_vc_shortcodes() {
	if ( ! function_exists( 'is_plugin_active' ) ) require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
	if(is_plugin_active("js_composer/js_composer.php") && 
		function_exists('vc_map') && 
		function_exists('vc_set_as_theme')) {

		/* Make visual composer part of the theme */
		vc_set_as_theme();
		
		salon_sd('vc_active', true);

		include_once(SALON_BASE_DIR . 'functions/vc_extend.php');
	}	
}
add_action( 'init', 'salon_init_vc_shortcodes', 99 );


/**
* Customize Tag Cloud widget
*/
function salon_tag_cloud_fix($tag_string){
   return preg_replace("/style='font-size:.+pt;'/", '', $tag_string);
}
add_filter('wp_generate_tag_cloud', 'salon_tag_cloud_fix',10,3);

/**
* Output and checks for wp_head
*/
function salon_wp_head() {
	// Compatiblity check for old style favicon
	if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {
		echo '<link rel="icon" href="'. esc_url(salon_get_option('favicon')) . '" type="image/x-icon" />
		<link rel="apple-touch-icon" href="' . esc_url(salon_get_option('favicon_apple_small')) . '">
		<link rel="apple-touch-icon" sizes="76x76" href="' . esc_url(salon_get_option('favicon_apple_medium')) . '">
		<link rel="apple-touch-icon" sizes="120x120" href="' . esc_url(salon_get_option('favicon_apple_large')) . '">
		<link rel="apple-touch-icon" sizes="152x152" href="' . esc_url(salon_get_option('favicon_apple_xlarge')) . '">';
	}
	
	// Header / Footer slider check
	salon_sd('header_slider', salon_check_header_slider()); 
	salon_sd('footer_slider', salon_check_footer_slider());	
	$temp_header_slider = salon_gd('header_slider'); $temp_footer_slider = salon_gd('footer_slider');
	salon_sd('header_slider_class', (is_array($temp_header_slider) && $temp_header_slider[0] != '') ? 'header-slider-active':'');
	salon_sd('footer_slider_class', (is_array($temp_footer_slider) && $temp_footer_slider[0] != '') ? 'footer-slider-active':'');
}
add_action('wp_head','salon_wp_head');

function salon_is_wpml_active() {
	if(function_exists("icl_get_languages") && defined("ICL_LANGUAGE_CODE") && defined("ICL_LANGUAGE_NAME")) {
		return true;
	}
	return false;
}

function salon_blog_more($v = 0) {
	global $more; $more = $v;
}
?>