<?php
/**
 * Plugin Name: Salon Theme Essentials
 * Plugin URI: http://themeforest.net/user/freevision/portfolio
 * Description: This plugin will enable Custom Post types like few other features for your SALON theme.
 * Version: 1.1
 * Author: freevision
 */

define( 'OZY_SALON_ESSENTIALS_ACTIVATED', 1 );

/**
 * Custom post types for portfolio and video gallery
 */
function ozy_plugin_create_post_types() {
	
	load_plugin_textdomain('ozy-salon-essentials', false, basename( dirname( __FILE__ ) ) . '/translate');
	
	$essentials_options = get_option('ozy_salon_essentials');
	if(is_array($essentials_options) && isset($essentials_options['image_gallery_slug'])) {
		$image_gallery_slug = $essentials_options['image_gallery_slug'];
	} else {
		$image_gallery_slug = 'gallery';
	}	
	
	if(is_array($essentials_options) && isset($essentials_options['portfolio_slug'])) {
		$portfolio_slug = $essentials_options['portfolio_slug'];
	} else {
		$portfolio_slug = 'portfolio';
	}	
	
	//User managaged sidebars
	register_post_type( 'ozy_sidebars',
		array(
			'labels' => array(
				'name' => esc_attr__( 'Sidebars', 'ozy-salon-essentials'),
				'singular_name' => esc_attr__( 'Sidebars', 'ozy-salon-essentials'),
				'add_new' => 'Add Sidebar',
				'add_new_item' => 'Add Sidebar',
				'edit_item' => 'Edit Sidebar',
				'new_item' => 'New Sidebar',
				'view_item' => 'View Sidebars',
				'search_items' => 'Search Sidebar',
				'not_found' => 'No Sidebar found',
				'not_found_in_trash' => 'No Sidebar found in Trash'				
			),
			'can_export' => true,
			'public' => true,
			'exclude_from_search' => true,
			'publicly_queryable' => false,
			'show_in_nav_menus' => false,
			'show_in_admin_bar' => false,
			'menu_position' => 60,
			'has_archive' => false,
			'hierarchical' => false,
			'show_in_rest' => false,
			'rewrite' => false,
			'supports' => array('title'),
			'taxonomies' => array(''),
			'menu_icon' => 'dashicons-align-left'
		)
	);
	
	//Portfolio
	register_post_type( 'ozy_portfolio',
		array(
			'labels' => array(
				'name' => esc_attr__( 'Portfolio', 'ozy-salon-essentials'),
				'singular_name' => esc_attr__( 'Portfolio', 'ozy-salon-essentials'),
				'add_new' => esc_attr__( 'Add Portfolio Item', 'ozy-salon-essentials'),
				'edit_item' => esc_attr__( 'Edit Portfolio Item', 'ozy-salon-essentials'),
				'new_item' => esc_attr__( 'New Portfolio Item', 'ozy-salon-essentials'),
				'view_item' => esc_attr__( 'View Portfolio Item', 'ozy-salon-essentials'),
				'search_items' => esc_attr__( 'Search Portfolio Items', 'ozy-salon-essentials'),
				'not_found' => esc_attr__( 'No Portfolio Items found', 'ozy-salon-essentials'),
				'not_found_in_trash' => esc_attr__( 'No Portfolio Items found in Trash', 'ozy-salon-essentials')				
			),
			'can_export' => true,
			'public' => true,
			'sort' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => $portfolio_slug, 'with_front' => true),
			'supports' => array('title','editor','thumbnail','excerpt','page-attributes'),
			'menu_icon' => 'dashicons-portfolio'
		)
	);	

}
add_action( 'init', 'ozy_plugin_create_post_types' );

/**
 * Custom taxonomy registration
 */
function ozy_plugin_create_custom_taxonomies() {

	//Portfolio Categories
	$labels = array(
		'name' => esc_attr__( 'Portfolio Categories', 'ozy-salon-essentials' ),
		'singular_name' => esc_attr__( 'Portfolio Category', 'ozy-salon-essentials' ),
		'search_items' =>  esc_attr__( 'Search Portfolio Categories', 'ozy-salon-essentials' ),
		'popular_items' => esc_attr__( 'Popular Portfolio Categories', 'ozy-salon-essentials' ),
		'all_items' => esc_attr__( 'All Portfolio Categories', 'ozy-salon-essentials' ),
		'parent_item' => esc_attr__( 'Parent Portfolio Categories', 'ozy-salon-essentials' ),
		'parent_item_colon' => esc_attr__( 'Parent Portfolio Category:', 'ozy-salon-essentials' ),
		'edit_item' => esc_attr__( 'Edit Portfolio Category', 'ozy-salon-essentials' ),
		'update_item' => esc_attr__( 'Update Portfolio Category', 'ozy-salon-essentials' ),
		'add_new_item' => esc_attr__( 'Add New Portfolio Category', 'ozy-salon-essentials' ),
		'new_item_name' => esc_attr__( 'New Portfolio Category', 'ozy-salon-essentials' ),
	);
	
	register_taxonomy('portfolio_category', array('ozy_portfolio'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'sort' => true,
		'rewrite' => array( 'slug' => 'portfolio_category' ),
	));
}
add_action( 'init', 'ozy_plugin_create_custom_taxonomies', 0 );

/**
 * Options panel for this plugin
 */
class OzyEssentialsOptionsPage_Salon
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'Salon Essentials', 
            'manage_options', 
            'ozy-salon-essentials-setting-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'ozy_salon_essentials' );
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>ozy Essentials Options</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'ozy_salon_essentials_option_group' );
                do_settings_sections( 'ozy-salon-essentials-setting-admin' );
				do_settings_sections( 'ozy-salon-essentials-setting-admin-twitter' );
			
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'ozy_salon_essentials_option_group', // Option group
            'ozy_salon_essentials', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'ozy-salon-essentials-setting-admin', // ID
            'Options', // Title
            array( $this, 'print_section_info' ), // Callback
            'ozy-salon-essentials-setting-admin' // Page
        );
		
        add_settings_field(
            'portfolio_slug', 
            'Portfolio Slug Name', 
            array( $this, 'field_callback' ), 
            'ozy-salon-essentials-setting-admin', 
            'ozy-salon-essentials-setting-admin'
        );			
		
        add_settings_section(
            'ozy-salon-essentials-setting-admin-twitter', 
            'Twitter Parameters', 
            array( $this, 'print_twitter_section_info' ),
            'ozy-salon-essentials-setting-admin-twitter'
        );		
		
        add_settings_field(
            'twitter_consumer_key', 
            'Consumer Key', 
            array( $this, 'field_callback_twitter_consumer_key' ), 
            'ozy-salon-essentials-setting-admin-twitter', 
            'ozy-salon-essentials-setting-admin-twitter'
        );

		add_settings_field(
            'twitter_secret_key', 
            'Secret Key', 
            array( $this, 'field_callback_twitter_secret_key' ), 
            'ozy-salon-essentials-setting-admin-twitter', 
            'ozy-salon-essentials-setting-admin-twitter'
        );
		
		add_settings_field(
            'twitter_token_key', 
            'Access Token Key', 
            array( $this, 'field_callback_twitter_token_key' ), 
            'ozy-salon-essentials-setting-admin-twitter', 
            'ozy-salon-essentials-setting-admin-twitter'
        );
		
		add_settings_field(
            'twitter_token_secret_key', 
            'Access Token Secret Key', 
            array( $this, 'field_callback_twitter_token_secret_key' ), 
            'ozy-salon-essentials-setting-admin-twitter', 
            'ozy-salon-essentials-setting-admin-twitter'
        );		

    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        if( !empty( $input['portfolio_slug'] ) )
            $input['portfolio_slug'] = sanitize_text_field( $input['portfolio_slug'] );

		if( !empty( $input['twitter_consumer_key'] ) )
            $input['twitter_consumer_key'] = sanitize_text_field( $input['twitter_consumer_key'] );

		if( !empty( $input['twitter_secret_key'] ) )
            $input['twitter_secret_key'] = sanitize_text_field( $input['twitter_secret_key'] );

        if( !empty( $input['twitter_token_key'] ) )
            $input['twitter_token_key'] = sanitize_text_field( $input['twitter_token_key'] );

        if( !empty( $input['twitter_token_secret_key'] ) )
            $input['twitter_token_secret_key'] = sanitize_text_field( $input['twitter_token_secret_key'] );
			
        if( !is_numeric( $input['ozy_shortcodes'] ) )
            $input['ozy_shortcodes'] = '1'; 			

        return $input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Set custom slug for Portfolio post types.
		<p><strong>You may have to refresh your permalinks after saving this!</strong></p>';
    }
	
    public function print_twitter_section_info()
    {
        print 'Enter required parameters of your Twitter Dev. account <a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a>';
    }	

    /** 
     * Get the settings option array and print one of its values : Portfolio Slug
     */
    public function field_callback()
    {
        printf(
            '<input type="text" id="portfolio_slug" name="ozy_salon_essentials[portfolio_slug]" value="%s" />',
            (!isset($this->options['portfolio_slug']) ? 'portfolio' : esc_attr( $this->options['portfolio_slug']))
        );
    }	
	
    /** 
     * Get the settings option array and print one of its values : Twitter Consumer Key
     */	
    public function field_callback_twitter_consumer_key()
    {
        printf(
            '<input type="text" id="twitter_consumer_key" name="ozy_salon_essentials[twitter_consumer_key]" value="%s" />',
            (!isset($this->options['twitter_consumer_key']) ? '' : esc_attr( $this->options['twitter_consumer_key']))
        );
    }

    /** 
     * Get the settings option array and print one of its values : Twitter Secret Key
     */	
    public function field_callback_twitter_secret_key()
    {
        printf(
            '<input type="text" id="twitter_secret_key" name="ozy_salon_essentials[twitter_secret_key]" value="%s" />',
            (!isset($this->options['twitter_secret_key']) ? '' : esc_attr( $this->options['twitter_secret_key']))
        );		
    }

    /** 
     * Get the settings option array and print one of its values : Twitter Token Key
     */	
    public function field_callback_twitter_token_key()
    {
        printf(
            '<input type="text" id="twitter_token_key" name="ozy_salon_essentials[twitter_token_key]" value="%s" />',
            (!isset($this->options['twitter_token_key']) ? '' : esc_attr( $this->options['twitter_token_key']))
        );		
    }

    /** 
     * Get the settings option array and print one of its values : Twitter Token Secret Key
     */
    public function field_callback_twitter_token_secret_key()
    {
        printf(
            '<input type="text" id="twitter_token_secret_key" name="ozy_salon_essentials[twitter_token_secret_key]" value="%s" />',
            (!isset($this->options['twitter_token_secret_key']) ? '' : esc_attr( $this->options['twitter_token_secret_key']))
        );		
    }

}

/** 
 * Register activation redirection
 */
register_activation_hook(__FILE__, 'ozy_essentials_plugin_activate');
add_action('admin_init', 'ozy_essentials_plugin_activate_redirect');

function ozy_essentials_plugin_activate() {
    add_option('ozy_essentials_plugin_activate_redirect', true);
}

function ozy_essentials_plugin_activate_redirect() {
    if (get_option('ozy_essentials_plugin_activate_redirect', false)) {
        delete_option('ozy_essentials_plugin_activate_redirect');
        wp_redirect('options-general.php?page=ozy-salon-essentials-setting-admin');
    }
}

/**
* Sets up theme defaults and registers support for various WordPress features.
*/
function salon_plugin_theme_setup() {
	// Adds Post Format support
	// learn more: http://codex.wordpress.org/Post_Formats
	add_theme_support( 'post-formats', array( 
		'aside', 
		'gallery',
		'link',
		'image',
		'quote',
		'status',
		'video',
		'audio',
		'chat' ) 
	);
	
	// Enable shortcodes in the widgets
	add_filter('widget_text', 'shortcode_unautop');
	add_filter('widget_text', 'do_shortcode');	
	
	// Removes detailed login error information for security	
	add_filter('login_errors',create_function('$a', "return null;"));
}
add_action('after_setup_theme', 'salon_plugin_theme_setup', 99);	

/**
 * We need this plugin to work only on admin side
 */

if( is_admin() ) {
    $ozy_essentials_options_page = new OzyEssentialsOptionsPage_Salon();
}

/*
* Widgets
*/
require_once plugin_dir_path( __FILE__ ) . 'ozy-salon-essentials-widgets.php';

/**
 *	Samples Importer
 */
require_once plugin_dir_path( __FILE__ ) .'ozy-salon-essentials-importer-init.php';

/**
* Update Notifier
*/
require(plugin_dir_path( __FILE__ ) . 'updater/update-notifier.php');
define( 'SALON_NOTIFIER_THEME_NAME', 'SALON' );
define( 'SALON_NOTIFIER_THEME_FOLDER_NAME', 'salon' );
define( 'SALON_NOTIFIER_XML_FILE', 'http://s3-eu-west-1.amazonaws.com/themeversion/salon.xml' );
define( 'SALON_NOTIFIER_CACHE_INTERVAL', 43200);

/**
* ozy_add_extra_page
*
* We are adding and extra page to include documentation into to the admin.
*/
function salon_ozy_add_extra_page() {
	add_menu_page(
		esc_attr__('Documentation','ozy-salon-essentials'), 
		esc_attr__('Documentation','ozy-salon-essentials'), 
		'read',
		'salon-ozy-salon-documentation', 
		'salon_ozy_salon_documentation', 
		'dashicons-editor-help' 
	);
}
add_action('admin_menu', 'salon_ozy_add_extra_page');

function salon_ozy_salon_documentation() {
	echo '<iframe src="http://doc.freevision.me/salon" id="ozy-help-iframe" width="100%" height="800px" frameborder="0"></iframe>';
}

/**
 * Shortcodes
 */

if ( ! function_exists( 'is_plugin_active' ) ) require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
if(is_plugin_active("js_composer/js_composer.php") && function_exists('vc_map') && function_exists('vc_set_as_theme')) {

	//Icon Selector Attribute Type
	function ozy_select_an_icon_settings_field($settings, $value) {
       return '<div class="select_an_icon">'
                 .'<input name="'.$settings['param_name']
                 .'" id="field_'.$settings['param_name']
                 .'_select" class="wpb_vc_param_value wpb-textinput '
                 .$settings['param_name'].' '.$settings['type'].'_field" type="text" value="'
                 .$value.'"/>'
             .'</div>';
	}

	vc_add_shortcode_param('select_an_icon', 'ozy_select_an_icon_settings_field', get_template_directory_uri() .'/scripts/admin/admin.js');

	$add_css_animation = 
	array(
		'type' => 'animation_style',
		'heading' => esc_attr( 'Initial loading animation', 'ozy-salon-essentials' ),
		'param_name' => 'css_animation',
		'value' => '',
		'settings' => array(
			'type' => array(
				'in',
				'other',
			),
		),
		'description' => esc_attr( 'Select initial loading animation for grid element.', 'ozy-salon-essentials' ),
	);
	
	/**
	* Image / Video Box
	*/
	if (!function_exists('ozy_vc_image_video_box')) {
		function ozy_vc_image_video_box( $atts, $content = null ) {
            $atts = vc_map_get_attributes('ozy_vc_image_video_box', $atts);
			extract(shortcode_atts(array(
				'title' => '',
				'excerpt' => '',
				'link' => '',
				'video_url' => '',
				'fg_color' => '',
				'bg_image' => '',
				'bg_color' => '',
				'use_hover' => '',
				'css_animation' => ''
			), $atts));
			
			if($css_animation) {
				wp_enqueue_script('waypoints');
				$css_animation = " wpb_animate_when_almost_visible wpb_" . esc_attr($css_animation) . " ";
			}	
			
			$rand_id = 'oivbx-' . rand(10, 100000); $style = '';
			
			$bg_image = wp_get_attachment_image_src($bg_image, 'full');
			if(isset($bg_image[0])) {
				$style = 'background-image:url('. esc_url($bg_image[0]) .');';
			}			
			$output = '<div id="'. esc_attr($rand_id) .'" class="ozy-image_video_box '. ($video_url ? 'video-box' : '') . ' ' . ($use_hover == 'no' ? 'no-hover' : '') .' '. $css_animation .'" style="'. $style .'">' . PHP_EOL;
			if(!$video_url) {
				$link = vc_build_link($link); $href = '';
				if(is_array($link) && isset($link['url']) && $link['url']) {
					$href = ' href="'. esc_url($link['url']) .'" '. (isset($link['target']) ? ' target="'. esc_attr($link['target']).'"':'').' ';
				}
				$output.= '<div class="overlay"></div>';
				$output.= '<a '. $href .' class="caption">';
				$output.= '<h2>'. esc_html($title) .'</h2>';
				$output.= '<p>'. esc_html($excerpt) .'</p>';
				$output.= '</a>';
				if($href) $output.= '<a '. $href .'><img src="' . plugins_url( 'ozy-salon-essentials/images/arrow_icon.svg', dirname(__FILE__) ) . '" class="svg"/></a>';
			}else{
				$output.= '<a href="'. esc_url($video_url) .'" class="fancybox-media"><img src="' . plugins_url( 'ozy-salon-essentials/images/play_icon.svg', dirname(__FILE__) ) . '" class="svg"/></a>';
			}
			$output.= '</div>' . PHP_EOL;
						
			global $ozySalonHelper;
			if(!function_exists('salon_get_option') || !is_object($ozySalonHelper)) return null;
			$ozySalonHelper->set_footer_style("#$rand_id, #$rand_id>div.overlay {background-color:". esc_attr($bg_color) ."!important}");
			$ozySalonHelper->set_footer_style("#$rand_id h2, #$rand_id p {color:". esc_attr($fg_color) ."!important}");
			$ozySalonHelper->set_footer_style("#$rand_id svg g path {fill:". esc_attr($fg_color) ." !important;}");
			
			return $output;
		}

		add_shortcode( 'ozy_vc_image_video_box', 'ozy_vc_image_video_box' );
		
		vc_map( array(
			"name" => esc_attr__("Image / Video Box", "ozy-salon-essentials"),
			"base" => "ozy_vc_image_video_box",
			"icon" => "icon-wpb-ozy-el",
			"class" => '',
			"controls" => "full",
			'category' => 'by OZY',
			"params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Title", "ozy-salon-essentials"),
					"param_name" => "title",
					"admin_label" => true,
					"value" => "",
					"description" => esc_attr__("Title of your box.", "ozy-salon-essentials")
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Excerpt", "ozy-salon-essentials"),
					"param_name" => "excerpt",
					"admin_label" => true,
					"value" => "",
					"description" => esc_attr__("Enter a short text to display under your title.", "ozy-salon-essentials")
				),array(
					"type" => "vc_link",
					"class" => "",
					"heading" => esc_attr__("Link", "ozy-salon-essentials"),
					"param_name" => "link",
					"admin_label" => false,
					"value" => ""
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Video URL", "ozy-salon-essentials"),
					"param_name" => "video_url",
					"admin_label" => false,
					"value" => "",
					"description" => esc_attr__("When used, Link entry will be ignored.", "ozy-salon-essentials")
				),array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => esc_attr__("Foregound Color", "ozy-salon-essentials"),
					"param_name" => "fg_color",
					"admin_label" => false,
					"value" => "#ffffff"
				),array(
					"type" => "attach_image",
					"class" => "",
					"heading" => esc_attr__("Background Image", "ozy-salon-essentials"),
					"param_name" => "bg_image",
					"admin_label" => false,
					"value" => "",
					"description" => esc_attr__("Select image for your team member.", "ozy-salon-essentials")
				),array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => esc_attr__("Overlay Background Color", "ozy-salon-essentials"),
					"param_name" => "bg_color",
					"admin_label" => false,
					"value" => "rgba(0,0,0,0.90)"
				),array(
					"type" => 'dropdown',
					"heading" => esc_attr__("Use Hover?", "ozy-salon-essentials"),
					"param_name" => "use_hover",
					"value" => array("default", "no"),
					"admin_label" => true,
				),$add_css_animation
		   )
		) );		
	}
	
	/**
	* YouTube Embed
	*/
	if (!function_exists('ozy_vc_youtube_embed')) {
		function ozy_vc_youtube_embed( $atts, $content = null ) {
            $atts = vc_map_get_attributes('ozy_vc_youtube_embed', $atts);
			extract(shortcode_atts(array(
				'video_size' => '169',
				'video_id' => '',
				'poster_image' => '',
				'css_animation' => ''
			), $atts));
			
			if($css_animation) {
				wp_enqueue_script('waypoints');
				$css_animation = " wpb_animate_when_almost_visible wpb_" . esc_attr($css_animation) . " ";
			}	
			
			$rand_id = 'oyoutubeembed-' . rand(10, 100000); $style = '';

			$poster_image = wp_get_attachment_image_src($poster_image, 'full');
			if(isset($poster_image[0])) {
				$style = 'background-image:url('. esc_url($poster_image[0]) .');';
			}			
			
			$output = '<div id="'. esc_attr($rand_id) .'"><div class="oytb-videoWrapper oytb-videoWrapper'. esc_attr($video_size) .' oytb-js-videoWrapper '. $css_animation .'">
    <iframe class="oytb-videoIframe oytb-js-videoIframe" src="" frameborder="0" allowTransparency="true" allowfullscreen data-src="https://www.youtube.com/embed/'. esc_attr($video_id) .'?autoplay=1& modestbranding=1&rel=0&hl=sv"></iframe>
    <button class="oytb-videoPoster oytb-js-videoPoster" style="'. $style .'"><img src="' . plugins_url( 'ozy-salon-essentials/images/play_button.svg', dirname(__FILE__) ) . '#play" class="svg" alt=""/></button>
  </div><button class="oytb-video-StopButton generic-button" title="'. esc_attr('close video', 'ozy-salon-essentials') .'">X</button></div>';
  
			return $output;
		}

		add_shortcode( 'ozy_vc_youtube_embed', 'ozy_vc_youtube_embed' );
		
		vc_map( array(
			"name" => esc_attr__("YouTube Embed", "ozy-salon-essentials"),
			"base" => "ozy_vc_youtube_embed",
			"icon" => "icon-wpb-ozy-el",
			"class" => '',
			"controls" => "full",
			'category' => 'by OZY',
			"params" => array(
				array(
					"type" => 'dropdown',
					"heading" => esc_attr__("Video Size", "ozy-salon-essentials"),
					"param_name" => "video_size",
					"value" => array(esc_attr__("16:9", "ozy-salon-essentials") => "169", esc_attr__("4:3", "ozy-salon-essentials") => "43"),
					"admin_label" => true,
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Embed Video ID", "ozy-salon-essentials"),
					"param_name" => "video_id",
					"admin_label" => true,
					"value" => "",
					"description" => wp_kses(__('YouTube Embed Video ID. eq. https://www.youtube.com/watch?v=<strong style="color:red">3sey-GFl1SQ</strong>, the bold - red part is your video ID.', 'ozy-salon-essentials'), array('strong' => array('style' => array()),))
				),array(
					"type" => "attach_image",
					"class" => "",
					"heading" => esc_attr__("Poster Image", "ozy-salon-essentials"),
					"param_name" => "poster_image",
					"admin_label" => false,
					"value" => "",
					"description" => esc_attr__("Set a poster image for your video player.", "ozy-salon-essentials")
				),$add_css_animation
		   )
		) );		
	}	

	/**
	* Multiscroll Container
	*/
	if (!function_exists('ozy_vc_multiscroll_container')) {
		function ozy_vc_multiscroll_container( $atts, $content = null ) {
			$atts = vc_map_get_attributes('ozy_vc_multiscroll_container', $atts);
			extract(shortcode_atts(array(
				'css_animation' => ''
			), $atts));
					
			if($css_animation) {
				wp_enqueue_style( 'animate-css' );
				$css_animation = ' wpb_animate_when_almost_visible wpb_'. esc_attr($css_animation) .' '. esc_attr($css_animation) .' wpb_start_animation animated ';
			}
			
			$output = '<div id="multiscroll-container" class="'. esc_attr($css_animation) .'">';
			$output.= do_shortcode( $content );			
			$output.= '</div>';
			
			return $output;
		}
		
		add_shortcode('ozy_vc_multiscroll_container', 'ozy_vc_multiscroll_container');
		
		vc_map( array(
			"name" => esc_attr("Multi Scroll Container", "ozy-salon-essentials"),
			"base" => "ozy_vc_multiscroll_container",
			"as_parent" => array('only' => 'ozy_vc_multiscroll_wrapper'),
			"content_element" => true,
			"show_settings_on_create" => true,
			"is_container" => true,
			"icon" => "icon-wpb-ozy-el",
			'category' => 'by OZY',
			"params" => array(						
				$add_css_animation
		   )
		   ,"js_view" => 'VcColumnView'
		) );
		
		class WPBakeryShortCode_Ozy_Vc_Multiscroll_container extends WPBakeryShortCodesContainer{}		
	}	
	
	/**
	* Multiscroll Wrapper
	*/
	if (!function_exists('ozy_vc_multiscroll_wrapper')) {
		function ozy_vc_multiscroll_wrapper( $atts, $content = null ) {
			$atts = vc_map_get_attributes('ozy_vc_multiscroll_wrapper', $atts);
			extract(shortcode_atts(array(
				'align' => 'left',
				'css_animation' => ''
			), $atts));
					
			if($css_animation) {
				wp_enqueue_style( 'animate-css' );
				$css_animation = ' wpb_animate_when_almost_visible wpb_'. esc_attr($css_animation) .' '. esc_attr($css_animation) .' wpb_start_animation animated ';
			}
			
			$GLOBALS['OZY_MULTISCROLL_PANEL_ID'] = 1;
			
			$output = '<div class="ms-'. esc_attr($align) .' '. esc_attr($css_animation) .'">';
			$output.= do_shortcode( $content );			
			$output.= '</div>';
			
			return $output;
		}
		
		add_shortcode('ozy_vc_multiscroll_wrapper', 'ozy_vc_multiscroll_wrapper');
		
		vc_map( array(
			"name" => esc_attr("Multi Scroll Wrapper", "ozy-salon-essentials"),
			"base" => "ozy_vc_multiscroll_wrapper",
			"as_child" => array('only' => 'ozy_vc_multiscroll_container'),
			"as_parent" => array('only' => 'ozy_vc_multiscroll_panel'),
			"content_element" => true,
			"show_settings_on_create" => true,
			"is_container" => true,
			"icon" => "icon-wpb-ozy-el",
			'category' => 'by OZY',
			"params" => array(
				array(
					"type" => 'dropdown',
					"heading" => esc_attr__("Panel Align", "ozy-salon-essentials"),
					"param_name" => "align",
					"value" => array("left", "right"),
					"admin_label" => true,
				),							
				$add_css_animation
		   )
		   ,"js_view" => 'VcColumnView'
		) );
		
		class WPBakeryShortCode_Ozy_Vc_Multiscroll_wrapper extends WPBakeryShortCodesContainer{}		
	}
	
	/**
	* Multiscroll Panel
	*/
	if (!function_exists('ozy_vc_multiscroll_panel')) {
		function ozy_vc_multiscroll_panel( $atts, $content = null ) {
            $atts = vc_map_get_attributes('ozy_vc_multiscroll_panel', $atts);
			extract(shortcode_atts(array(
				'hide_on_mobile' => 'false',
				'caption' => '',
				'image' => '',
				'bg_color' => '',
				'css_animation' => ''
			), $atts));
			
			if($css_animation) {
				wp_enqueue_style( 'animate-css' );
				$css_animation = ' wpb_animate_when_almost_visible wpb_'. esc_attr($css_animation) .' '. esc_attr($css_animation) .' wpb_start_animation animated ';
			}

			$bg_image = wp_get_attachment_image_src($image, 'full'); $style = '';
			if(isset($bg_image[0])) {
				$style.= 'background-image:url('. esc_url($bg_image[0]) .');';
			}
			if($bg_color) {
				$style.= 'background-color:'. esc_attr($bg_color) .';';
			}			
			$output = '<div data-id="'. esc_attr($GLOBALS['OZY_MULTISCROLL_PANEL_ID']) .'" class="ms-section hide-on-mobile-'. esc_attr($hide_on_mobile) .' '. $css_animation . '" style="'. $style .'" data-caption="'. esc_attr($caption) .'"><div class="content">' . PHP_EOL;
			$output.= do_shortcode($content);
			$output.= '</div></div>';
			
			$GLOBALS['OZY_MULTISCROLL_PANEL_ID'] = $GLOBALS['OZY_MULTISCROLL_PANEL_ID'] + 1;
			
			return $output;
		}

		add_shortcode( 'ozy_vc_multiscroll_panel', 'ozy_vc_multiscroll_panel' );
		
		vc_map( array(
			"name" => esc_attr__("Multi Scroll Panel", "ozy-salon-essentials"),
			"base" => "ozy_vc_multiscroll_panel",
			"icon" => "icon-wpb-ozy-el",
			"as_child" => array('only' => 'ozy_vc_multiscroll_wrapper'),
			//"as_parent" => '',
			"class" => '',
			"controls" => "full",
			"category" => "by OZY",
			"content_element" => true,
			"is_container" => true,
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_attr("Hide On Mobile", "ozy-salon-essentials"),
					"param_name" => "hide_on_mobile",
					"value" => array("false", "true"),
					"admin_label" => true,
					"description" => esc_attr("When selected, this panel will not be shown on if window width equal or less than 768px (tablet in portrait mode).", "ozy-salon-essentials")
				),			
				array(
					"type" => "textfield",
					"heading" => esc_attr("Caption", "ozy-salon-essentials"),
					"param_name" => "caption",
					"admin_label" => true,
				),array(
					"type" => "colorpicker",
					"heading" => esc_attr__("Background Color", "ozy-salon-essentials"),
					"param_name" => "bg_color",
					"admin_label" => false,
					"value" => "#ffffff"
				),array(
					"type" => "attach_image",
					"class" => "",
					"heading" => esc_attr__("Background Image", "ozy-salon-essentials"),
					"param_name" => "image",
					"admin_label" => false,
					"value" => "",
					"description" => esc_attr__("Select a background image for your panel.", "ozy-salon-essentials")
				),$add_css_animation
		   )
		   ,"js_view" => 'VcColumnView'
		) );	
		
		class WPBakeryShortCode_Ozy_Vc_Multiscroll_panel extends WPBakeryShortCodesContainer{}	
	}
	
	/**
	* Multi Carousel
	*/
	if (!function_exists('ozy_vc_multi_carousel')) {
		function ozy_vc_multi_carousel( $atts, $content = null ) {
			$atts = vc_map_get_attributes('ozy_vc_multi_carousel', $atts);
			extract(shortcode_atts(array(
				'autoplay'		=> 'true',
				'groupcells'	=> 'false',
				'navigation_dots'=> 'true',
				'navigation_arrows'=> 'false',
				'item_count' => '4',
				'extra_css'		=> '',
				'css_animation' => ''
			), $atts));
					
			if($css_animation) {
				wp_enqueue_style( 'animate-css' );
				$css_animation = ' wpb_animate_when_almost_visible wpb_'. esc_attr($css_animation) .' '. esc_attr($css_animation) .' wpb_start_animation animated ';
			}
			
			wp_enqueue_script('isotope');
			wp_enqueue_script('isotope-packery');

			$GLOBALS['OZY_CAROUSEL_ITEM_TYPE'] = 'multi';
			
			$output = '<div class="flickity-carousel-wrapper wpb_content_element"><div class="carousel flickity-carousel item-count-'. esc_attr($item_count) .'" data-flickity=\'{ "pageDots": '. esc_attr($navigation_dots) .', "prevNextButtons": '. esc_attr($navigation_arrows) .', "groupCells": '. esc_attr($groupcells) .', "contain" : true, "cellAlign": "left", "adaptiveHeight": false, "imagesLoaded": true, "setGallerySize": true, "autoPlay": '. esc_attr($autoplay) .' }\'>';
			$output.= do_shortcode( $content );			
			$output.= '</div>';
			$output.= '<a href="#see-all" class="flickity-see-all" data-label="'. esc_html('SLIDER', 'ozy-salon-essentials') .'">' . esc_html('SEE ALL', 'ozy-salon-essentials') . '</a>';
			$output.= '</div>';
			
			return $output;
		}
		
		add_shortcode('ozy_vc_multi_carousel', 'ozy_vc_multi_carousel');
		
		vc_map( array(
			"name" => esc_attr("Multi Carousel", "ozy-salon-essentials"),
			"base" => "ozy_vc_multi_carousel",
			"as_parent" => array('only' => 'ozy_vc_carousel_item'),
			"content_element" => true,
			"show_settings_on_create" => true,
			"is_container" => true,
			"icon" => "icon-wpb-ozy-el",
			'category' => 'by OZY',
			"params" => array(			
				array(
					"type" => "dropdown",
					"heading" => esc_attr("Auto Play", "ozy-salon-essentials"),
					"param_name" => "autoplay",
					"value" => array("true", "false", "1000", "2000", "3000", "4000", "5000", "6000", "7000", "8000", "9000", "10000"),
					"admin_label" => true,
					"description" => esc_attr("Change to any available integrer for example 3000 to play every 3 seconds. If you set it true default speed will be 5 seconds.", "ozy-salon-essentials")
				),		
				array(
					"type" => "dropdown",
					"heading" => esc_attr("Cell Group", "ozy-salon-essentials"),
					"param_name" => "groupcells",
					"value" => array("false", "true", "2", "3", "4", "5", "6"),
					"admin_label" => true,
					"description" => esc_attr("This variable allows you to set the maximum amount of items displayed at a time with the widest browser width.", "ozy-salon-essentials")
				),
				array(
					"type" => "dropdown",
					"heading" => esc_attr("Visible Item Count", "ozy-salon-essentials"),
					"param_name" => "item_count",
					"value" => array("4", "2", "3"),
					"admin_label" => true,
					"description" => esc_attr("Choose how many items will be visible on the carousel at once.", "ozy-salon-essentials")
				),				
				array(
					"type" => 'dropdown',
					"heading" => esc_attr("Show Dots", "ozy-salon-essentials"),
					"param_name" => "navigation_dots",
					"value" => array("true", "false"),
					"description" => esc_attr("Show navigation dots on this carousel.", "ozy-salon-essentials")
				),
				array(
					"type" => 'dropdown',
					"heading" => esc_attr("Show Arrows", "ozy-salon-essentials"),
					"param_name" => "navigation_arrows",
					"value" => array("false", "true"),
					"description" => esc_attr("Show navigation arrows on this carousel.", "ozy-salon-essentials")
				),
				$add_css_animation,
				array(
					"type" => "textfield",
					"heading" => esc_attr("Extra class name", "ozy-salon-essentials"),
					"param_name" => "el_class",
					"description" => esc_attr("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "ozy-salon-essentials")
				)			
		   )
		   ,"js_view" => 'VcColumnView'
		) );
		
		class WPBakeryShortCode_Ozy_Vc_Multi_Carousel extends WPBakeryShortCodesContainer{}		
	}	
	
	/**
	* Regular Carousel
	*/
	if (!function_exists('ozy_vc_regular_carousel')) {
		function ozy_vc_regular_carousel( $atts, $content = null ) {
			$atts = vc_map_get_attributes('ozy_vc_regular_carousel', $atts);
			extract(shortcode_atts(array(
				'autoplay'		=> 'true',
				'groupcells'	=> 'false',
				'navigation_dots'=> 'true',
				'navigation_arrows'=> 'false',
				'item_count' => '1',
				'extra_css'		=> '',
				'css_animation' => ''
			), $atts));
					
			if($css_animation) {
				wp_enqueue_style( 'animate-css' );
				$css_animation = ' wpb_animate_when_almost_visible wpb_'. esc_attr($css_animation) .' '. esc_attr($css_animation) .' wpb_start_animation animated ';
			}
			
			wp_enqueue_script('isotope');
			wp_enqueue_script('isotope-packery');
			
			$GLOBALS['OZY_CAROUSEL_ITEM_TYPE'] = 'single';
			
			$output = '<div class="carousel single wpb_content_element flickity-carousel '. esc_attr($extra_css) .' item-count-'. esc_attr($item_count) .'" data-flickity=\'{ "pageDots": '. esc_attr($navigation_dots) .', "prevNextButtons": '. esc_attr($navigation_arrows) .', "groupCells": '. esc_attr($groupcells) .', "contain" : true, "cellAlign": "left", "adaptiveHeight": false, "imagesLoaded": true, "setGallerySize": true, "autoPlay": '. esc_attr($autoplay) .' }\'>';
			$output.= do_shortcode( $content );			
			$output.= '</div>';
			
			return $output;
		}
		
		add_shortcode('ozy_vc_regular_carousel', 'ozy_vc_regular_carousel');
		
		vc_map( array(
			"name" => esc_attr("Regular Carousel", "ozy-salon-essentials"),
			"base" => "ozy_vc_regular_carousel",
			"as_parent" => array('only' => 'ozy_vc_carousel_item'),
			"content_element" => true,
			"show_settings_on_create" => true,
			"is_container" => true,
			"icon" => "icon-wpb-ozy-el",
			'category' => 'by OZY',
			"params" => array(			
				array(
					"type" => "dropdown",
					"heading" => esc_attr("Auto Play", "ozy-salon-essentials"),
					"param_name" => "autoplay",
					"value" => array("true", "false", "1000", "2000", "3000", "4000", "5000", "6000", "7000", "8000", "9000", "10000"),
					"admin_label" => true,
					"description" => esc_attr("Change to any available integrer for example 3000 to play every 3 seconds. If you set it true default speed will be 5 seconds.", "ozy-salon-essentials")
				),		
				array(
					"type" => 'dropdown',
					"heading" => esc_attr__("Show Dots", "ozy-salon-essentials"),
					"param_name" => "navigation_dots",
					"value" => array("true", "false"),
					"description" => esc_attr__("Show navigation dots on this carousel.", "ozy-salon-essentials")
				),
				array(
					"type" => 'dropdown',
					"heading" => esc_attr__("Show Arrows", "ozy-salon-essentials"),
					"param_name" => "navigation_arrows",
					"value" => array("false", "true"),
					"description" => esc_attr__("Show navigation arrows on this carousel.", "ozy-salon-essentials")
				),
				$add_css_animation,
				array(
					"type" => "textfield",
					"heading" => esc_attr("Extra class name", "ozy-salon-essentials"),
					"param_name" => "el_class",
					"description" => esc_attr("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "ozy-salon-essentials")
				)			
		   )
		   ,"js_view" => 'VcColumnView'
		) );
		
		class WPBakeryShortCode_Ozy_Vc_Regular_Carousel extends WPBakeryShortCodesContainer{}		
	}	
	
	/**
	* Carousel Item
	*/
	if (!function_exists('ozy_vc_carousel_item')) {
		function ozy_vc_carousel_item( $atts, $content = null ) {
            $atts = vc_map_get_attributes('ozy_vc_carousel_item', $atts);
			extract(shortcode_atts(array(
				'image' => '',
				'title' => '',
				'link' => '',
				'css_animation' => ''
			), $atts));
			
			if($css_animation) {
				wp_enqueue_style( 'animate-css' );
				$css_animation = ' wpb_animate_when_almost_visible wpb_'. esc_attr($css_animation) .' '. esc_attr($css_animation) .' wpb_start_animation animated ';
			}

			$member_image = wp_get_attachment_image_src($image, 'full'); $img_opacity = '' ;
			
			if(!isset($member_image[0])) return '';
			
			if($GLOBALS['OZY_CAROUSEL_ITEM_TYPE'] == 'single') {
				$output = PHP_EOL . '<div class="ozy-caroseul_item carousel-cell '. $css_animation . '" style="background:url('. esc_url($member_image[0]) .');">' . PHP_EOL;
			}else{
				$output = PHP_EOL . '<div class="ozy-caroseul_item carousel-cell '. $css_animation . '">' . PHP_EOL;
			}

			$output.= '<a';
			$link = vc_build_link($link);
			if(is_array($link) && isset($link['url']) && $link['url']) {
				$output.= ' href="'. esc_url($link['url']) .'" '. (isset($link['target']) ? ' target="'. esc_attr($link['target']) .'"' : '');
			}
			
			//if(isset($member_image[0])) {
				$output.= '><img src="'. $member_image[0] .'" alt="'. esc_attr($title) .'">';
			//}
			$output.= esc_attr($title) ? '<strong>'. esc_attr($title) .'</strong>' : '';
			$output.= '</a>';
			$output.= '</div>';
			
			return $output;
		}

		add_shortcode( 'ozy_vc_carousel_item', 'ozy_vc_carousel_item' );
		
		vc_map( array(
			"name" => esc_attr__("Carousel Item", "ozy-salon-essentials"),
			"base" => "ozy_vc_carousel_item",
			"icon" => "icon-wpb-ozy-el",
			"as_child" => array('only' => 'ozy_vc_regular_carousel, ozy_vc_multi_carousel'),
			"class" => '',
			"controls" => "full",
			'category' => 'by OZY',
			"params" => array(
				array(
					"type" => "attach_image",
					"class" => "",
					"heading" => esc_attr__("Image", "ozy-salon-essentials"),
					"param_name" => "image",
					"admin_label" => false,
					"value" => "",
					"description" => esc_attr__("Select an image for your item.", "ozy-salon-essentials")
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Title", "ozy-salon-essentials"),
					"param_name" => "title",
					"admin_label" => true,
					"value" => "",
					"description" => esc_attr__("Title for your carousel item.", "ozy-salon-essentials")
				),array(
					"type" => "vc_link",
					"class" => "",
					"heading" => esc_attr__("Link", "ozy-salon-essentials"),
					"param_name" => "link",
					"admin_label" => false,
					"value" => ""
				),$add_css_animation
		   )
		) );	
		
		class WPBakeryShortCode_Ozy_Vc_Carousel_Item extends WPBakeryShortCode{}	
	}
	
	/**
	* Expandable Call Box
	*/
	if (!function_exists('ozy_vc_callboxwrapper')) {
		function ozy_vc_callboxwrapper( $atts, $content = null ) {
			$atts = vc_map_get_attributes('ozy_vc_callboxwrapper', $atts);
			extract(shortcode_atts(array(
				'title' => ''
			), $atts));

			$GLOBALS['OZY_SALON_CALLBOXCOUNTER'] = 1;
			
			$output = '<section class="strips">'. do_shortcode($content) .'<i class="strip__close">X</i></section>';
			
			global $ozySalonHelper;
			if(!function_exists('salon_get_option') || !is_object($ozySalonHelper)) return null;

			if($GLOBALS['OZY_SALON_CALLBOXCOUNTER'] >= 1){
				$box_count = $GLOBALS['OZY_SALON_CALLBOXCOUNTER'] - 1; $css_output = '';
				for($i = 2; $i <= $box_count; $i++) {
					$css_output.= '.strips__strip:nth-child('. esc_attr($i) .') {left: '. ((100 / $box_count) * ($i-1)) .'vw;}';
				}
				$css_output.= '.strips__strip{width:calc('. (100 / $box_count) .'% + 6px);}';
				$ozySalonHelper->set_footer_style('@media only screen and (min-width: 769px) {' . $css_output . '}');
			}
			
			unset($GLOBALS['OZY_SALON_CALLBOXCOUNTER']);
			
			return $output;
		}
		
		add_shortcode('ozy_vc_callboxwrapper', 'ozy_vc_callboxwrapper');
		
		vc_map( array(
			"name" => esc_attr__("Expandable Call Box", "ozy-salon-essentials"),
			"base" => "ozy_vc_callboxwrapper",
			"as_parent" => array('only' => 'ozy_vc_expandablecallbox'),
			"content_element" => true,
			"show_settings_on_create" => true,
			"icon" => "icon-wpb-ozy-el",
			'category' => 'by OZY',
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_attr__("Title", "ozy-salon-essentials"),
					"param_name" => "title",
					"value" => "Enter an identifier name for your wrapper.",
					"description" => esc_attr__("PLEASE NOTE: Maximum 5 elements will be used to show, after 5 entry rest will be ignored for each wrapper.", "ozy-salon-essentials"),
					"admin_label" => true
				)
		   ),
		   "js_view" => 'VcColumnView'
		) );
		
		class WPBakeryShortCode_Ozy_Vc_Callboxwrapper extends WPBakeryShortCodesContainer{}		
	}	

	if (!function_exists('ozy_vc_expandablecallbox')) {
		function ozy_vc_expandablecallbox( $atts, $content = null ) {
			$atts = vc_map_get_attributes('ozy_vc_expandablecallbox', $atts);
			extract(shortcode_atts(array(
				'title' => '',
				'image_large' => '',
				'title_color' => '#fff',
				'fn_color' => '#fff',
				'bg_color' => '#000',
				'css_animation' => ''
			), $atts));
			
			if($GLOBALS['OZY_SALON_CALLBOXCOUNTER'] > 5) return ''; //don't render more than 5 object
			
			wp_enqueue_script('expandable-callbox');
			wp_enqueue_style('expandable-callbox');
						
			if($css_animation) {
				wp_enqueue_style( 'animate-css' );
				$css_animation = ' wpb_animate_when_almost_visible wpb_'. esc_attr($css_animation) .' '. esc_attr($css_animation) .' wpb_start_animation animated ';
			}

			$large_image = ''; $rand_elm_id = 'ozy-exp-box-' . rand(1, 10000);

			$image_large = wp_get_attachment_image_src($image_large, 'full');
			if(isset($image_large[0])) { $large_image = esc_url($image_large[0]); }		

			$output = 
			'<article class="strips__strip" id='. esc_attr($rand_elm_id) .'>
				<div class="strip__content">
				  <h2 class="strip__title" data-name="'. esc_html($title) .'">'. esc_html($title) .'</h2>
				  <div class="strip__inner-text">
					<h2 data-color="'. esc_attr($fn_color) .'">'. esc_html($title) .'</h2>
					<p>'. do_shortcode($content) .'</p>
				  </div>
				<div class="bg" style="background-image:url('. esc_url($large_image) .');"></div><div class="color-overlay"></div></div>
			  </article>';

			global $ozySalonHelper;
			if(!function_exists('salon_get_option') || !is_object($ozySalonHelper)) return null;
			$ozySalonHelper->set_footer_style("#$rand_elm_id.strips__strip:nth-child(". esc_attr($GLOBALS['OZY_SALON_CALLBOXCOUNTER']) .") .strip__content{background-color:". esc_attr($bg_color) .";color:". esc_attr($fn_color) .";}");
			$ozySalonHelper->set_footer_style("#$rand_elm_id.strips__strip.strips__strip--expanded:nth-child(". esc_attr($GLOBALS['OZY_SALON_CALLBOXCOUNTER']) .") .strip__content h1,#$rand_elm_id.strips__strip.strips__strip--expanded:nth-child(". esc_attr($GLOBALS['OZY_SALON_CALLBOXCOUNTER']) .") .strip__content h2,#$rand_elm_id.strips__strip.strips__strip--expanded:nth-child(". esc_attr($GLOBALS['OZY_SALON_CALLBOXCOUNTER']) .") .strip__content h3,#$rand_elm_id.strips__strip.strips__strip--expanded:nth-child(". esc_attr($GLOBALS['OZY_SALON_CALLBOXCOUNTER']) .") .strip__content h4,#$rand_elm_id.strips__strip.strips__strip--expanded:nth-child(". esc_attr($GLOBALS['OZY_SALON_CALLBOXCOUNTER']) .") .strip__content h5,#$rand_elm_id.strips__strip.strips__strip--expanded:nth-child(". esc_attr($GLOBALS['OZY_SALON_CALLBOXCOUNTER']) .") .strip__content h6{color:". esc_attr($fn_color) .";}");
			$ozySalonHelper->set_footer_style("#$rand_elm_id.strips__strip:nth-child(". esc_attr($GLOBALS['OZY_SALON_CALLBOXCOUNTER']) .") .strip__content h2{color:". esc_attr($title_color) .";}");				
			
			$GLOBALS['OZY_SALON_CALLBOXCOUNTER'] = $GLOBALS['OZY_SALON_CALLBOXCOUNTER'] + 1;
			
			return $output;
		}
		
		add_shortcode( 'ozy_vc_expandablecallbox', 'ozy_vc_expandablecallbox' );
		
		vc_map( array(
			"name" => esc_attr__("Expandable Call Box Content", "ozy-salon-essentials"),
			"base" => "ozy_vc_expandablecallbox",
			"content_element" => true,
			"as_child" => array('only' => 'ozy_vc_callboxwrapper'),
			"icon" => "icon-wpb-ozy-el",
			"params" => array(
				array(
					"type" => "attach_image",
					"class" => "",
					"heading" => esc_attr__("Background Image", "ozy-salon-essentials"),
					"param_name" => "image_large",
					"admin_label" => false,
					"value" => ""
				),array(
					"type" => "colorpicker",
					"heading" => esc_attr__("Title Color", "ozy-salon-essentials"),
					"param_name" => "title_color",
					"admin_label" => false,
					"value" => "#ffffff"
				),array(
					"type" => "colorpicker",
					"heading" => esc_attr__("Foreground Color", "ozy-salon-essentials"),
					"param_name" => "fn_color",
					"admin_label" => false,
					"value" => "#ffffff"
				),array(
					"type" => "colorpicker",
					"heading" => esc_attr__("Background Color", "ozy-salon-essentials"),
					"param_name" => "bg_color",
					"admin_label" => false,
					"value" => "#000000"
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Title", "ozy-salon-essentials"),
					"param_name" => "title",
					"admin_label" => true,
					"value" => ""
				),array(
					"type" => "textarea_html",
					"class" => "",
					"heading" => esc_attr__("Content", "ozy-salon-essentials"),
					"param_name" => "content",
					"admin_label" => false,
					"description" => esc_attr__("This field is not required. Fill only when you need multiple columns on your row", "ozy-salon-essentials"),
					"value" => ""
				),$add_css_animation
		   )
		) );	
	}

	class WPBakeryShortCode_Ozy_Vc_Expandablecallbox extends WPBakeryShortCode{}		
	
	/**
	* Price List
	*/
	if (!function_exists('ozy_vc_pricelistwrapper')) {
		function ozy_vc_pricelistwrapper( $atts, $content = null ) {
			$atts = vc_map_get_attributes('ozy_vc_pricelistwrapper', $atts);
			extract(shortcode_atts(array(
				'title' => '',
				'sub_title' => '',
				'columnt_title1' => '',
				'columnt_title2' => '',
				'columnt_title3' => '',
				'columnt_title4' => '',
				'columnt_title5' => '',
				'columnt_title6' => ''
			), $atts));

			$output = '<div class="ozy-price-list wpb_content_element shared-border-color">';
			if($title) $output.= '<h3>'. esc_attr($title) .'</h3>';
			if($sub_title) $output.= '<p>'. esc_attr($sub_title) .'</p>';
			$output.= '<table>';
			$output.= '<thead>';
			$output.= '<tr>';
			$output.= '<th>&nbsp;</th>';
			if($columnt_title1) $output.= '<th>'. esc_attr($columnt_title1) .'</th>';
			if($columnt_title2) $output.= '<th>'. esc_attr($columnt_title2) .'</th>';
			if($columnt_title3) $output.= '<th>'. esc_attr($columnt_title3) .'</th>';
			if($columnt_title4) $output.= '<th>'. esc_attr($columnt_title4) .'</th>';
			if($columnt_title5) $output.= '<th>'. esc_attr($columnt_title5) .'</th>';
			if($columnt_title5) $output.= '<th>'. esc_attr($columnt_title6) .'</th>';
			$output.= '</tr>';
			$output.= '</thead>';
			$output.= '<tbody>';			
			$output.= do_shortcode($content); 
			$output.= '</tbody>';			
			$output.= '</table>';
			$output.= '</div>';

			return $output;
		}
		
		add_shortcode('ozy_vc_pricelistwrapper', 'ozy_vc_pricelistwrapper');
		
		vc_map( array(
			"name" => esc_attr__("Price List", "ozy-salon-essentials"),
			"base" => "ozy_vc_pricelistwrapper",
			"as_parent" => array('only' => 'ozy_vc_pricelist'),
			"content_element" => true,
			"show_settings_on_create" => true,
			"icon" => "icon-wpb-ozy-el",
			'category' => 'by OZY',
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_attr__("Title", "ozy-salon-essentials"),
					"param_name" => "title",
					"value" => "",
					"admin_label" => true
				),array(
					"type" => "textfield",
					"heading" => esc_attr__("Sub Title", "ozy-salon-essentials"),
					"param_name" => "sub_title",
					"value" => "",
					"admin_label" => true
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Columnt Title #1", "ozy-salon-essentials"),
					"param_name" => "columnt_title1",
					"admin_label" => false,
					"value" => ""
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Columnt Title #2", "ozy-salon-essentials"),
					"param_name" => "columnt_title2",
					"admin_label" => false,
					"value" => ""
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Columnt Title #3", "ozy-salon-essentials"),
					"param_name" => "columnt_title3",
					"admin_label" => false,
					"value" => ""
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Columnt Title #4", "ozy-salon-essentials"),
					"param_name" => "columnt_title4",
					"admin_label" => false,
					"value" => ""
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Columnt Title #5", "ozy-salon-essentials"),
					"param_name" => "columnt_title5",
					"admin_label" => false,
					"value" => ""
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Columnt Title #6", "ozy-salon-essentials"),
					"param_name" => "columnt_title6",
					"admin_label" => false,
					"value" => ""
				)
		   ),
		   "js_view" => 'VcColumnView'
		) );
		
		class WPBakeryShortCode_Ozy_Vc_Pricelistwrapper extends WPBakeryShortCodesContainer{}		
	}	

	if (!function_exists('ozy_vc_pricelist')) {
		function ozy_vc_pricelist( $atts, $content = null ) {
			$atts = vc_map_get_attributes('ozy_vc_pricelist', $atts);
			extract(shortcode_atts(array(
				'icon' => '',
				'label_field' => '',
				'value_field1' => '',
				'value_field2' => '',
				'value_field3' => '',
				'value_field4' => '',
				'value_field5' => '',
				'value_field6' => '',
				'featured' => 'no',
				'css_animation' => ''
			), $atts));
			
			if($css_animation) {
				wp_enqueue_style( 'animate-css' );
				$css_animation = ' wpb_animate_when_almost_visible wpb_'. esc_attr($css_animation) .' '. esc_attr($css_animation) .' wpb_start_animation animated ';
			}		
			
			$output = '<tr class="'. ($featured === 'yes' ? 'featured' : '') .'">';
			$output.= '<td class="label">';
			if($icon) $output.= '<i class="'. esc_attr($icon) .'"></i>';
			$output.= esc_attr($label_field) . '</td>';
			if($value_field1) $output.= '<td class="v">' . esc_attr($value_field1) . '</td>';
			if($value_field2) $output.= '<td class="v">' . esc_attr($value_field2) . '</td>';
			if($value_field3) $output.= '<td class="v">' . esc_attr($value_field3) . '</td>';
			if($value_field4) $output.= '<td class="v">' . esc_attr($value_field4) . '</td>';
			if($value_field5) $output.= '<td class="v">' . esc_attr($value_field5) . '</td>';
			if($value_field6) $output.= '<td class="v">' . esc_attr($value_field6) . '</td>';
			$output.= '</tr>';
			return $output;
		}
		
		add_shortcode( 'ozy_vc_pricelist', 'ozy_vc_pricelist' );
		
		vc_map( array(
			"name" => esc_attr__("Price List Row", "ozy-salon-essentials"),
			"base" => "ozy_vc_pricelist",
			"content_element" => true,
			"as_child" => array('only' => 'ozy_vc_pricelistwrapper'),
			"icon" => "icon-wpb-ozy-el",
			"params" => array(
				array(
					"type" => "select_an_icon",
					"heading" => esc_attr__("Icon", "ozy-salon-essentials"),
					"param_name" => "icon",
					"value" => '',
					"admin_label" => false
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Label", "ozy-salon-essentials"),
					"param_name" => "label_field",
					"admin_label" => true,
					"value" => ""
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Value #1", "ozy-salon-essentials"),
					"param_name" => "value_field1",
					"admin_label" => true,
					"value" => ""
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Value #2", "ozy-salon-essentials"),
					"param_name" => "value_field2",
					"admin_label" => true,
					"description" => esc_attr__("This field is not required. Fill only when you need multiple columns on your row", "ozy-salon-essentials"),
					"value" => ""
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Value #3", "ozy-salon-essentials"),
					"param_name" => "value_field3",
					"admin_label" => true,
					"description" => esc_attr__("This field is not required. Fill only when you need multiple columns on your row", "ozy-salon-essentials"),
					"value" => ""
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Value #4", "ozy-salon-essentials"),
					"param_name" => "value_field4",
					"admin_label" => true,
					"description" => esc_attr__("This field is not required. Fill only when you need multiple columns on your row", "ozy-salon-essentials"),
					"value" => ""
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Value #5", "ozy-salon-essentials"),
					"param_name" => "value_field5",
					"admin_label" => true,
					"description" => esc_attr__("This field is not required. Fill only when you need multiple columns on your row", "ozy-salon-essentials"),
					"value" => ""
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Value #6", "ozy-salon-essentials"),
					"param_name" => "value_field6",
					"admin_label" => true,
					"description" => esc_attr__("This field is not required. Fill only when you need multiple columns on your row", "ozy-salon-essentials"),
					"value" => ""
				),array(
					"type" => "dropdown",
					"heading" => esc_attr__("Featured", "ozy-salon-essentials"),
					"param_name" => "featured",
					"value" => array("no", "yes"),
					"admin_label" => false
				),$add_css_animation
		   )
		) );	
	}

	class WPBakeryShortCode_Ozy_Vc_Pricelist extends WPBakeryShortCode{}
	
	/**
	* Price Table
	*/
	if (!function_exists('ozy_vc_price_table')) {
		function ozy_vc_price_table( $atts, $content = null ) {
            $atts = vc_map_get_attributes('ozy_vc_price_table', $atts);
			extract(shortcode_atts(array(
				'title'			=> '',
				'price'			=> '',
				'extra_css'		=> '',
				'box_heading'	=> '',
				'font_size'		=> '',
				'text_align'	=> '',
				'price_font_size' => '',
				'css_animation' => ''
			), $atts));
			
			if($css_animation) {
				wp_enqueue_style( 'animate-css' );
				$css_animation = ' wpb_animate_when_almost_visible wpb_'. esc_attr($css_animation) .' '. esc_attr($css_animation) .' wpb_start_animation animated ';
			}		
			
			$inline_style = ''; $price_label_inline_style = '';
			if(trim($font_size) != '100%' && trim($font_size) != '') {
				$inline_style.= 'font-size:' . esc_attr($font_size);
			}
			if(trim($text_align) != 'center' && trim($text_align) != '') {
				$inline_style.= ';text-align:' . esc_attr($text_align) . ';padding-left:40px;padding-right:40px;';
			}
			if(trim($price_font_size) != '45px' && trim($price_font_size) != '') {
				$price_label_inline_style.= ';font-size:' . esc_attr($price_font_size) . ';line-height:'. esc_attr(((int)$price_font_size)+20) .'px;';
			}
			$output = '<div class="ozy-price-table ozy-border-color '. $css_animation .'">';
			$output .= '<'. esc_attr($box_heading) .' class="ozy-border-color">'. esc_attr($title) .'</'. esc_attr($box_heading) .'>';
			$output .= '<div '. ($inline_style ? 'style="'. $inline_style .'"' : '') .'>'. do_shortcode($content) .'</div>';
			$output .= '<span class="ozy-border-color heading-font" '. ($price_label_inline_style ? 'style="'. $price_label_inline_style .'"' : '') .'>'. esc_attr($price) .'</span>';
			$output .= '</div>';
			
			return $output;
		}
		
		add_shortcode('ozy_vc_price_table', 'ozy_vc_price_table');
		
		vc_map( array(
			"name" => esc_attr__("Price Table", "ozy-salon-essentials"),
			"base" => "ozy_vc_price_table",
			"content_element" => true,
			"show_settings_on_create" => true,
			"icon" => "icon-wpb-ozy-el",
			'category' => 'by OZY',
			"params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Title", "ozy-salon-essentials"),
					"value" => esc_attr__("TITLE GOES HERE", "ozy-salon-essentials"),
					"param_name" => "title",
					"admin_label" => true
				),
				array(
					"type" => "textarea_html",
					"holder" => "div",
					"class" => "",
					"heading" => esc_attr__("Content", "ozy-salon-essentials"),
					"param_name" => "content"
				),				
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Price", "ozy-salon-essentials"),
					"value" => esc_attr__("$ 100", "ozy-salon-essentials"),
					"param_name" => "price",
					"admin_label" => true
				),				
				$add_css_animation,
				array(
					"type" => "textfield",
					"heading" => esc_attr__("Extra class name", "ozy-salon-essentials"),
					"param_name" => "el_class",
					"description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "ozy-salon-essentials")
				),
				array(
					"type" => "dropdown",
					"heading" => esc_attr__("Box Heading Size", "ozy-salon-essentials"),
					"param_name" => "box_heading",
					"value" => array("h3", "h1", "h2", "h4", "h5", "h6"),
					"admin_label" => false,
					"group" => esc_attr("Styling", "ozy-salon-essentials")
				),					
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Font Size", "ozy-salon-essentials"),
					"value" => esc_attr__("100%", "ozy-salon-essentials"),
					"param_name" => "font_size",
					"admin_label" => false,
					"group" => esc_attr("Styling", "ozy-salon-essentials")
				),
				array(
					"type" => "dropdown",
					"heading" => esc_attr__("Text Align", "ozy-salon-essentials"),
					"param_name" => "text_align",
					"value" => array("center", "left", "right"),
					"admin_label" => false,
					"group" => esc_attr("Styling", "ozy-salon-essentials")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Price Font Size", "ozy-salon-essentials"),
					"value" => esc_attr__("45px", "ozy-salon-essentials"),
					"param_name" => "price_font_size",
					"admin_label" => false,
					"description" => esc_attr__("Please only use px values.", "ozy-salon-essentials"),
					"group" => esc_attr("Styling", "ozy-salon-essentials")
				),				
		   )
		) );
	}	
	
	/**
	* Call To Action With Image
	*/
	if (!function_exists('ozy_vc_calltoactionwimage')) {
		function ozy_vc_calltoactionwimage( $atts, $content = null ) {
            $atts = vc_map_get_attributes('ozy_vc_calltoactionwimage', $atts);
			extract(shortcode_atts(array(
				'image'			=> '',
				'title'			=> '',
				'subtitle' 		=> '',
				'fn_color'		=> '#ffffff',
				'fn_color_sub'	=> '#c09e6f',
				'link'			=> '',
				'extra_css'		=> '',
				'css_animation' => ''
			), $atts));
			
			if($css_animation) {
				wp_enqueue_style( 'animate-css' );
				$css_animation = ' wpb_animate_when_almost_visible wpb_'. esc_attr($css_animation) .' '. esc_attr($css_animation) .' wpb_start_animation animated ';
			}	
			
			$rand_id = "callbox-with-image-" . rand(1,10000);

			$image = wp_get_attachment_image_src($image, 'full'); $style = '';
			if(isset($image[0])) {
				$style = ' style="background-image:url('. esc_url($image[0]) .'" alt="' . esc_attr($title) . ')" ';
			}			
			$output ='<div id="'. esc_attr($rand_id) .'" class="callbox-with-image '. $css_animation .'" '. $style .'><a ';
			$link = vc_build_link($link);			
			if(is_array($link) && isset($link['url']) && $link['url']) {
				$output.= 'href="'. esc_url($link['url']) .'" '. (isset($link['target']) ? ' target="'. esc_attr($link['target']) .'"' : '');
			}
			$output.='>';
			$output.='<div><h2>'. esc_html($title) .'</h2><span class="title content-font">'. esc_html($subtitle) .'</span></div></a></div>';
			
			global $ozySalonHelper;
			if(!function_exists('salon_get_option') || !is_object($ozySalonHelper)) return null;
			$ozySalonHelper->set_footer_style("#$rand_id h2, #$rand_id span.title{color:". esc_attr($fn_color) ."}");
			
			return $output;
		}
		
		add_shortcode('ozy_vc_calltoactionwimage', 'ozy_vc_calltoactionwimage');
		
		vc_map( array(
			"name" => esc_attr__("Call to Action With Image", "ozy-salon-essentials"),
			"base" => "ozy_vc_calltoactionwimage",
			"content_element" => true,
			"show_settings_on_create" => true,
			"icon" => "icon-wpb-ozy-el",
			'category' => 'by OZY',
			"params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Title", "ozy-salon-essentials"),
					"value" => esc_attr__("Title Goes Here", "ozy-salon-essentials"),
					"param_name" => "title",
					"admin_label" => true
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Subtitle", "ozy-salon-essentials"),
					"value" => esc_attr__("Subtitle Goes Here", "ozy-salon-essentials"),
					"param_name" => "subtitle",
					"admin_label" => true
				),array(
					"type" => "attach_image",
					"class" => "",
					"heading" => esc_attr__("Image", "ozy-salon-essentials"),
					"param_name" => "image",
					"admin_label" => false,
					"value" => ""
				),array(
					"type" => "colorpicker",
					"heading" => esc_attr__("Foreground Color", "ozy-salon-essentials"),
					"param_name" => "fn_color",
					"admin_label" => false,
					"value" => "#ffffff"
				),array(
					"type" => "vc_link",
					"class" => "",
					"heading" => esc_attr__("Link", "ozy-salon-essentials"),
					"param_name" => "link",
					"admin_label" => false,
					"value" => ""
				),
				$add_css_animation,
				array(
					"type" => "textfield",
					"heading" => esc_attr__("Extra class name", "ozy-salon-essentials"),
					"param_name" => "el_class",
					"description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "ozy-salon-essentials")
				)			
		   )
		) );
	}	
	
	/**
	* Fancy Hover Image Box
	*/
	if (!function_exists('ozy_vc_fancyhoverimagebox')) {
		function ozy_vc_fancyhoverimagebox( $atts, $content = null ) {
            $atts = vc_map_get_attributes('ozy_vc_fancyhoverimagebox', $atts);
			extract(shortcode_atts(array(
				'image'			=> '',
				'title'			=> '',
				'subtitle' 		=> '',
				'fn_color'		=> '#ffffff',
				'fn_color_sub'	=> '#c09e6f',
				'link'			=> '',
				'extra_css'		=> '',
				'css_animation' => ''
			), $atts));
			
			if($css_animation) {
				wp_enqueue_style( 'animate-css' );
				$css_animation = ' wpb_animate_when_almost_visible wpb_'. esc_attr($css_animation) .' '. esc_attr($css_animation) .' wpb_start_animation animated ';
			}	
			
			$rand_id = "fancy-hover-box-" . rand(1,10000);

			$output ='<div id="'. esc_attr($rand_id) .'" class="fancy-hover-box '. $css_animation .'"><a ';
			$link = vc_build_link($link);			
			if(is_array($link) && isset($link['url']) && $link['url']) {
				$output.= 'href="'. esc_url($link['url']) .'" '. (isset($link['target']) ? ' target="'. esc_attr($link['target']) .'"' : '');
			}
			$output.='>';
			$image = wp_get_attachment_image_src($image, 'full');
			if(isset($image[0])) {
				$output.= '<img src="'. esc_url($image[0]) .'" alt="' . esc_attr($title) . '"/>';
			}
			$output.='<span class="name heading-font">'. esc_html($title) .'<span class="title content-font">'. esc_html($subtitle) .'</span></span></a></div>';
			
			global $ozySalonHelper;
			if(!function_exists('salon_get_option') || !is_object($ozySalonHelper)) return null;
			$ozySalonHelper->set_footer_style("#$rand_id span{color:". esc_attr($fn_color) ."}");
			$ozySalonHelper->set_footer_style("#$rand_id span.title{color:". esc_attr($fn_color_sub) ."}");
			
			return $output;
		}
		
		add_shortcode('ozy_vc_fancyhoverimagebox', 'ozy_vc_fancyhoverimagebox');
		
		vc_map( array(
			"name" => esc_attr__("Fancy Hover Image Box", "ozy-salon-essentials"),
			"base" => "ozy_vc_fancyhoverimagebox",
			"content_element" => true,
			"show_settings_on_create" => true,
			"icon" => "icon-wpb-ozy-el",
			'category' => 'by OZY',
			"params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Title", "ozy-salon-essentials"),
					"value" => esc_attr__("Title Goes Here", "ozy-salon-essentials"),
					"param_name" => "title",
					"admin_label" => true
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Subtitle", "ozy-salon-essentials"),
					"value" => esc_attr__("Subtitle Goes Here", "ozy-salon-essentials"),
					"param_name" => "subtitle",
					"admin_label" => true
				),array(
					"type" => "attach_image",
					"class" => "",
					"heading" => esc_attr__("Image", "ozy-salon-essentials"),
					"param_name" => "image",
					"admin_label" => false,
					"value" => ""
				),array(
					"type" => "colorpicker",
					"heading" => esc_attr__("Foreground Color", "ozy-salon-essentials"),
					"param_name" => "fn_color",
					"admin_label" => false,
					"value" => "#ffffff"
				),array(
					"type" => "colorpicker",
					"heading" => esc_attr__("Subtitle Foreground Color", "ozy-salon-essentials"),
					"param_name" => "fn_color_sub",
					"admin_label" => false,
					"value" => "#c09e6f"
				),array(
					"type" => "vc_link",
					"class" => "",
					"heading" => esc_attr__("Link", "ozy-salon-essentials"),
					"param_name" => "link",
					"admin_label" => false,
					"value" => ""
				),
				$add_css_animation,
				array(
					"type" => "textfield",
					"heading" => esc_attr__("Extra class name", "ozy-salon-essentials"),
					"param_name" => "el_class",
					"description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "ozy-salon-essentials")
				)			
		   )
		) );
	}	
	
	/**
	* Simple Hover Image Box
	*/
	if (!function_exists('ozy_vc_simplehoverimagebox')) {
		function ozy_vc_simplehoverimagebox( $atts, $content = null ) {
            $atts = vc_map_get_attributes('ozy_vc_simplehoverimagebox', $atts);
			extract(shortcode_atts(array(
				'image'			=> '',
				'title'			=> '',
				'hover_caption' => '',
				'fn_color'		=> '#ffffff',
				'main_color'	=> '#0094f9',
				'video_path'	=> '',
				'link'			=> '',
				'link_target'	=> '_self',
				'extra_css'		=> '',
				'css_animation' => ''
			), $atts));
			
			if($css_animation) {
				wp_enqueue_style( 'animate-css' );
				$css_animation = ' wpb_animate_when_almost_visible wpb_'. esc_attr($css_animation) .' '. esc_attr($css_animation) .' wpb_start_animation animated ';
			}	
			
			$rand_id = "simple-hove-box-" . rand(1,10000);
			$output = '<div class="ozy-simple-hove-box" id="'. $rand_id .'">';
			$output .= '<h5><span class="cbox"></span>'. esc_attr($title) .'</h5>';
			if($video_path) {
				$output .= '<a href="'. esc_url($video_path) .'" title="'. esc_attr($title) .'" class="fancybox-media video-link"><img src="'. plugin_dir_url( __FILE__ ) .'/images/video_icon.png" alt=""/></a>';
			}
			$output .= '<a href="'. esc_url($link) .'" target="'. esc_attr($link_target) .'" id="'. $rand_id .'">' . PHP_EOL;

			$image = wp_get_attachment_image_src($image, 'full');
			if(isset($image[0])) {
				$output .= '<img src="'. esc_url($image[0]) .'" alt="' . esc_attr($title) . '"/>';
			}
			$output .= '<section>';
			$output .= '<p class="ozy-vertical-centered-element">'. esc_attr($hover_caption) . '</p>';			
			$output .= '</section>';
			
			$output .= PHP_EOL .'</a>';			
			$output .= PHP_EOL .'</div>';
			
			global $ozySalonHelper;
			if(!function_exists('salon_get_option') || !is_object($ozySalonHelper)) return null;
			$ozySalonHelper->set_footer_style("#$rand_id>h5>span.cbox{background-color:". esc_attr($main_color) ."}");
			$ozySalonHelper->set_footer_style("#$rand_id>a>section{background-color:". $ozySalonHelper->hex2rgba(esc_attr($main_color), '0.7') ."}");
			$ozySalonHelper->set_footer_style("#$rand_id>a>section>p{color:". esc_attr($fn_color) ."}");
			
			return $output;
		}
		
		add_shortcode('ozy_vc_simplehoverimagebox', 'ozy_vc_simplehoverimagebox');
		
		vc_map( array(
			"name" => esc_attr__("Simple Hover Image Box", "ozy-salon-essentials"),
			"base" => "ozy_vc_simplehoverimagebox",
			"content_element" => true,
			"show_settings_on_create" => true,
			"icon" => "icon-wpb-ozy-el",
			'category' => 'by OZY',
			"params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Title", "ozy-salon-essentials"),
					"value" => esc_attr__("TITLE GOES HERE", "ozy-salon-essentials"),
					"param_name" => "title",
					"admin_label" => true
				),
				array(
					"type" => "attach_image",
					"class" => "",
					"heading" => esc_attr__("Image", "ozy-salon-essentials"),
					"param_name" => "image",
					"admin_label" => false,
					"value" => ""
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Hover Caption", "ozy-salon-essentials"),
					"param_name" => "hover_caption",
					"admin_label" => false
				),
				array(
					"type" => "colorpicker",
					"heading" => esc_attr__("Main Color", "ozy-salon-essentials"),
					"param_name" => "main_color",
					"admin_label" => false,
					"value" => "#0094f9"
				),
				array(
					"type" => "colorpicker",
					"heading" => esc_attr__("Foreground Color", "ozy-salon-essentials"),
					"param_name" => "fn_color",
					"admin_label" => false,
					"value" => "#ffffff"
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Video Path", "ozy-salon-essentials"),
					"param_name" => "video_path",
					"admin_label" => true,
					"description" => esc_attr__("Use only YouTube and Vimeo like services", "ozy-salon-essentials")
				),				
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Link", "ozy-salon-essentials"),
					"param_name" => "link",
					"admin_label" => true
				),
				array(
					"type" => "dropdown",
					"heading" => esc_attr__("Link Target", "ozy-salon-essentials"),
					"param_name" => "link_target",
					"value" => array("_self", "_blank", "_parent"),
					"admin_label" => false,
					"description" => esc_attr__("Select link target window.", "ozy-salon-essentials")
				),	
				$add_css_animation,
				array(
					"type" => "textfield",
					"heading" => esc_attr__("Extra class name", "ozy-salon-essentials"),
					"param_name" => "el_class",
					"description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "ozy-salon-essentials")
				)			
		   )
		) );
	}
	
	/**
	* Title with Icon Content
	*/
	if(!function_exists('ozy_vc_title_with_icon')) {
		function ozy_vc_title_with_icon( $atts, $content=null ) {
            $atts = vc_map_get_attributes('ozy_vc_title_with_icon', $atts);
			extract( shortcode_atts( array(
				  'icon' => '',
				  'icon_size' => 'medium',
				  'icon_position' => 'left',
				  'size' => 'h1',
				  'title' => '',
				  'icon_type' => '',
				  'icon_color' => '',
				  'text_color' => '',
				  'icon_bg_color' => 'transparent',
				  'icon_shadow_color' => '',
				  'go_link' => '',
				  'go_target' => '_self',
				  'connected' => 'no',
				  'dot_bg_color' => 'transparent'
				), $atts ) 
			);
			
			global $ozySalonHelper;
			if(!function_exists('salon_get_option') || !is_object($ozySalonHelper)) return null;
			$element_id = 'tile-with-icon_icon' . rand(100,10000);
			$a_begin = $a_end = $add_style = "";
			if(trim($go_link) !== '') {
				$a_begin = '<a href="' . esc_attr($go_link) . '" '. ($go_target=='fancybox' || $go_target=='fancybox-media' ? 'class':'target') .'="' . esc_attr($go_target) . '" style="'. ($text_color ? 'color:' . esc_attr($text_color) : '') .'">';
				$a_end   = '</a>';
			}

			if($icon_type === 'circle') {
				$icon_bg_color = 'transparent';
				$add_style = 'border-color:'. esc_attr($icon_color) .';';
			}
			
			if($title == '' && $content != '') {
				$title = wpb_js_remove_wpautop(do_shortcode($content));
				$content = '';
				$size = 'span';
			}
			
			$o_icon = ($icon ? $a_begin . '<span ' . ($icon_color ? ' style="'. $add_style .'color:'. esc_attr($icon_color) .' !important;background-color:'. esc_attr($icon_bg_color) .' !important;"' : '') . ' class="' . esc_attr($icon) . ' ' . esc_attr($icon_type) . ' ' . esc_attr($icon_size) . ' ' . '" '. (esc_attr($icon_shadow_color) ? 'data-color="'. esc_attr($icon_shadow_color) .'"':'') .'></span>' . $a_end : '');
			
			return '<div id="'. $element_id .'" class="title-with-icon-wrapper '. esc_attr($icon_type) . ' ' . esc_attr($icon_size) .' '. (esc_attr($connected) === 'yes' ? 'connected' : '') .'" data-color="'. esc_attr($dot_bg_color) .'">
			<div class="wpb_content_element title-with-icon clearfix ' . (trim($content) !== '' ? 'margin-bottom-0 ' : '') . ($icon_position !== 'left' ? esc_attr($icon_position).'-style' : '') . '">' . ($icon_position !== 'right' ? $o_icon:'') . 
			'<' . $size . (!$text_color ? (!$icon ? ' class="no-icon content-color"' : ' class="content-color"'):'') . ' style="'. ($text_color ? 'color:' . esc_attr($text_color) : '') .'">' . $a_begin . $title . $a_end . '</' . $size . '>' . ($icon_position === 'right' ? $o_icon:'') .'
			</div>' . (trim($content) !== '' && trim($title) !== '' ? '<div class="wpb_content_element '. esc_attr($icon_position) .'-cs title-with-icon-content '. esc_attr($icon_size) .' clearfix" style="'. (esc_attr($text_color) ? 'color:' . esc_attr($text_color) : '') .'">' 
			. wpb_js_remove_wpautop(do_shortcode($content)) . '</div>' : '') . '</div>';
		}
		
		add_shortcode( 'ozy_vc_title_with_icon', 'ozy_vc_title_with_icon' );
		
		vc_map( array(
			"name" => esc_attr__("Title With Icon", "ozy-salon-essentials"),
			"base" => "ozy_vc_title_with_icon",
			"class" => "",
			"controls" => "full",
			'category' => 'by OZY',
			"icon" => "icon-wpb-ozy-el",
			"params" => array(
			  array(
				"type" => "select_an_icon",
				"heading" => esc_attr__("Icon", "ozy-salon-essentials"),
				"param_name" => "icon",
				"value" => '',
				"admin_label" => false,
				"description" => esc_attr__("Title heading style.", "ozy-salon-essentials")
			  ),array(
				"type" => "dropdown",
				"heading" => esc_attr__("Icon Size", "ozy-salon-essentials"),
				"param_name" => "icon_size",
				"value" => array(esc_attr__("medium", "ozy-salon-essentials") => "medium", esc_attr__("large", "ozy-salon-essentials") => "large", esc_attr__("xlarge", "ozy-salon-essentials") => "xlarge", esc_attr__("xxlarge", "ozy-salon-essentials") => "xxlarge", esc_attr__("xxxlarge", "ozy-salon-essentials") => "xxxlarge"),
				"admin_label" => false,
				"description" => esc_attr__("Size of the Icon.", "ozy-salon-essentials")
			  ),array(
				"type" => "dropdown",
				"heading" => esc_attr__("Icon Position", "ozy-salon-essentials"),
				"param_name" => "icon_position",
				"value" => array(esc_attr__("left", "ozy-salon-essentials") => "left", esc_attr__("right", "ozy-salon-essentials") => "right", esc_attr__("top", "ozy-salon-essentials") => "top"),
				"admin_label" => false,
				"description" => esc_attr__("Position of the Icon.", "ozy-salon-essentials")
			  ),array(
				"type" => "colorpicker",
				"heading" => esc_attr__("Icon Alternative Color", "ozy-salon-essentials"),
				"param_name" => "icon_color",
				"value" => "",
				"admin_label" => false,
				"description" => esc_attr__("This field is not required.", "ozy-salon-essentials")
			  ),array(
				"type" => "dropdown",
				"heading" => esc_attr__("Icon Background Type", "ozy-salon-essentials"),
				"param_name" => "icon_type",
				"value" => array(esc_attr__("rectangle", "ozy-salon-essentials") => "rectangle", esc_attr__("rounded", "ozy-salon-essentials") => "rounded", esc_attr__("circle", "ozy-salon-essentials") => "circle", esc_attr__("clear", "ozy-salon-essentials") => "clear"),
				"admin_label" => false,
				"description" => esc_attr__("Position of the Icon.", "ozy-salon-essentials")
			  ),array(
				"type" => "colorpicker",
				"heading" => esc_attr__("Icon Background Color", "ozy-salon-essentials"),
				"param_name" => "icon_bg_color",
				"value" => "",
				"admin_label" => false,
				"description" => esc_attr__("Background color of Icon.", "ozy-salon-essentials")
			  ),array(
				"type" => "colorpicker",
				"heading" => esc_attr__("Icon Shadow Color", "ozy-salon-essentials"),
				"param_name" => "icon_shadow_color",
				"value" => "",
				"admin_label" => false,
				"description" => esc_attr__("Shadow color of Icon.", "ozy-salon-essentials")
			  ),array(
				"type" => "dropdown",
				"heading" => esc_attr__("Heading Style", "ozy-salon-essentials"),
				"param_name" => "size",
				"value" => array("h1", "h2", "h3", "h4", "h5", "h6"),
				"admin_label" => false,
				"description" => esc_attr__("Title heading style.", "ozy-salon-essentials")
			  ),array(
				 "type" => "textfield",
				 "class" => "",
				 "heading" => esc_attr__("Link", "ozy-salon-essentials"),
				 "param_name" => "go_link",
				 "admin_label" => true,
				 "value" => "",
				 "description" => esc_attr__("Enter full path.", "ozy-salon-essentials")
			  ),array(
				"type" => "dropdown",
				"heading" => esc_attr__("Link Target", "ozy-salon-essentials"),
				"param_name" => "go_target",
				"value" => array("_self", "_blank", "_parent", "fancybox", "fancybox-media"),
				"admin_label" => false,
				"description" => esc_attr__("Select link target window. fancybox will launch an lightbox window for images, and fancybox-media will launch a lightbox window for frames/video.", "ozy-salon-essentials")
			  ),array(
				 "type" => "textfield",
				 "class" => "",
				 "heading" => esc_attr__("Title", "ozy-salon-essentials"),
				 "param_name" => "title",
				 "admin_label" => true,
				 "value" => esc_attr__("Enter your title here", "ozy-salon-essentials"),
				 "description" => esc_attr__("Content of the title.", "ozy-salon-essentials")
			  ),array(
				"type" => "colorpicker",
				"heading" => esc_attr__("Font Color", "ozy-salon-essentials"),
				"param_name" => "text_color",
				"value" => "",
				"admin_label" => false,
				"description" => esc_attr__("This option will affect Title and Content color.", "ozy-salon-essentials")
			  ),array(
				"type" => "dropdown",
				"heading" => esc_attr__("Connected", "ozy-salon-essentials"),
				"param_name" => "connected",
				"value" => array("no", "yes"),
				"admin_label" => false,
				"description" => esc_attr__("Select yes to connect elements to next one with a dashed border.", "ozy-salon-essentials")
			  ),array(
				"type" => "colorpicker",
				"heading" => esc_attr__("Border Color", "ozy-salon-essentials"),
				"param_name" => "dot_bg_color",
				"value" => "",
				"admin_label" => false,
				"dependency" => Array('element' => "connected", 'value' => 'yes')
			  ),array(
				"type" => "textarea_html",
				"holder" => "div",
				"class" => "",
				"heading" => esc_attr__("Content", "ozy-salon-essentials"),
				"param_name" => "content",
				"value" => "",
				"description" => esc_attr__("Type your content here.", "ozy-salon-essentials")
			  )
		   )
		) );
	}

	/**
	* Divider
	*/
	if (!function_exists('ozy_vc_divider')) {
		function ozy_vc_divider( $atts, $content = null ) {
            $atts = vc_map_get_attributes('ozy_vc_divider', $atts);
			extract(shortcode_atts(array(
				'caption_size' => 'h3',
				'caption' 		=> '',
				'caption_color' => '',
				'caption_align'	=> 'center',
				'caption_position' => '',
				'border_style'	=> 'solid',
				'border_size' => '1',
				'border_color' => '',
				'css_animation' => '',
				'more_custom' => 'off',
				'width' => '',
				'align' => 'center'
				), $atts ) 
			);
			
			if($css_animation) {
				wp_enqueue_style( 'animate-css' );
				$css_animation = ' wpb_animate_when_almost_visible wpb_'. esc_attr($css_animation) .' '. esc_attr($css_animation) .' wpb_start_animation animated ';
			}
			
			$output = $more_custom_html = '';
			if(esc_attr($more_custom) == 'on' && esc_attr($width) && esc_attr($align)) {
				$more_custom_html = ';width:'. esc_attr($width) .';max-width:'. esc_attr($width) .';';
				switch(esc_attr($align)) {
					case 'center':
						$more_custom_html .= 'margin:20px auto;';
						break;
					case 'left':
						$more_custom_html .= 'left:0;';
						break;
					case 'right':
						$more_custom_html .= 'right:0;';
						break;						
					default:
						$more_custom_html .= 'margin:0 auto;';
				}
			}
			if('top' === esc_attr($caption_position)){
				$output = ( trim( esc_attr( $caption ) ) ? '<'. esc_attr($caption_size) .' class="ozy-divider-cap-' . esc_attr($caption_align) . ' wpb_content_element '. $css_animation .'" '. ($caption_color ? ' style="color:'. esc_attr($caption_color) .'" ':'') .'>' . esc_attr( $caption ) . '</'. esc_attr($caption_size) .'>' : '' );
				$output.= '<div class="ozy-content-divider '. $css_animation .'" style="border-top-style:'. esc_attr($border_style) . ';border-top-width:' . ('double' == esc_attr($border_style)?'3':esc_attr($border_size)) .'px' . ('' != esc_attr($border_color)?';border-top-color:'. esc_attr($border_color) .'!important':'') . $more_custom_html .'"></div>';
			}else{
				$output = '<fieldset class="ozy-content-divider '. $css_animation .' wpb_content_element" style="border-top-style:'. esc_attr($border_style) . ';border-top-width:' . ('double' == esc_attr($border_style)?'3':esc_attr($border_size)) .'px' . ('' != esc_attr($border_color)?';border-top-color:'. esc_attr($border_color) .'!important':'') . $more_custom_html .'">' . ( trim( esc_attr( $caption ) ) ? '<legend class="d' . esc_attr($caption_align) . '" align="' . esc_attr($caption_align) . '" '. ($caption_color ? ' style="color:'. esc_attr($caption_color) .'" ':'') .'>' . esc_attr( $caption ) . '</legend>' : '' ) . '</fieldset>';
			}
			return $output;
		}

		add_shortcode('ozy_vc_divider', 'ozy_vc_divider');

		vc_map( array(
		   "name" => esc_attr__("Separator With Caption", "ozy-salon-essentials"),
		   "base" => "ozy_vc_divider",
		   "class" => "",
		   "controls" => "full",
		   'category' => 'by OZY',
		   "icon" => "icon-wpb-ozy-el",
		   "params" => array(
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_attr__("Caption Size", "ozy-salon-essentials"),
					"param_name" => "caption_size",
					"admin_label" => true,
					"value" => array("h3","h1","h2","h4","h5","h6")
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Caption", "ozy-salon-essentials"),
					"param_name" => "caption",
					"admin_label" => true,
					"value" => esc_attr__("Enter your caption here", "ozy-salon-essentials"),
					"description" => esc_attr__("Caption of the divider.", "ozy-salon-essentials")
				),array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => esc_attr__("Caption Color", "ozy-salon-essentials"),
					"param_name" => "caption_color",
					"admin_label" => false,
					"value" => ""
				),array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_attr__("Border Style", "ozy-salon-essentials"),
					"param_name" => "border_style",
					"admin_label" => true,
					"value" => array("solid","dotted","dashed","double")
				),array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_attr__("Border Size", "ozy-salon-essentials"),
					"param_name" => "border_size",
					"admin_label" => true,
					"value" => array("1","2","3","4","5","6","7","8","9","10")
				),array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => esc_attr__("Border Color", "ozy-salon-essentials"),
					"param_name" => "border_color",
					"admin_label" => false,
					"value" => ""
				),array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_attr__("Caption Align", "ozy-salon-essentials"),
					"param_name" => "caption_align",
					"admin_label" => true,
					"value" => array("center", "left", "right"),
					"description" => esc_attr__("Caption align.", "ozy-salon-essentials")
				),array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_attr__("Caption Position", "ozy-salon-essentials"),
					"param_name" => "caption_position",
					"admin_label" => true,
					"value" => array("overlay", "top"),
					"description" => esc_attr__("Caption position.", "ozy-salon-essentials")
				),array(
					"type" => 'dropdown',
					"heading" => esc_attr__("More Customization", "ozy-salon-essentials"),
					"param_name" => "more_custom",
					"value" => array("off", "on"),
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Width", "ozy-salon-essentials"),
					"param_name" => "width",
					"admin_label" => true,
					"value" => "400px",
					"dependency" => Array('element' => "more_custom", 'value' => 'on')
				),array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_attr__("Align", "ozy-salon-essentials"),
					"param_name" => "align",
					"admin_label" => true,
					"value" => array("center", "left", "right"),
					"dependency" => Array('element' => "more_custom", 'value' => 'on')
				),$add_css_animation	
			)
		) );
	}
	
	/**
	* Typewriter
	*/
	if (!function_exists('ozy_vc_typewriter')) {
		function ozy_vc_typewriter( $atts, $content = null ) {
			$atts = vc_map_get_attributes('ozy_vc_typewriter', $atts);
			extract(shortcode_atts(array(
				'title'	=> '',
				'typespeed'			=> '100',
				'startdelay'		=> '0',
				'backspeed'			=> '0',
				'backdelay' 		=> '1500',
				'loop'				=> 'true',
				'font_color'		=> '#fff',
				'font_size'			=> '4.2vw',
				'font_weight'		=> '700'
			), $atts));
						
			$rand_id = 'type_writer_data_' . rand(1, 1000000);
			$GLOBALS['OZY_TYPE_WRITER'] = array();
			
			do_shortcode($content);
			
			wp_localize_script( 'salon', 'ozyTypeWriterData', array($rand_id =>  json_encode($GLOBALS['OZY_TYPE_WRITER'])) );
			
			unset($GLOBALS['OZY_TYPE_WRITER']);

			global $ozySalonHelper;
			if(!function_exists('salon_get_option') || !is_object($ozySalonHelper)) return null;
			$ozySalonHelper->set_footer_style("#$rand_id {color:". esc_attr($font_color) ." !important;font-size:". esc_attr($font_size) .";line-height:110%;font-weight:". esc_attr($font_weight) .";}");
			
			return '<div id="'. $rand_id .'" class="ozy-typing-box-wrapper heading-font">' . $title . '<span class="typing-box" 
			data-path="'. esc_attr($rand_id) .'" 
			data-typespeed="'. esc_attr($typespeed) .'" 
			data-startdelay="'. esc_attr($startdelay) .'" 
			data-backspeed="'. esc_attr($backspeed) .'" 
			data-backdelay="'. esc_attr($backdelay) .'" 
			data-loop="'. esc_attr($loop) .'"></span></div>';
		}
		
		add_shortcode('ozy_vc_typewriter', 'ozy_vc_typewriter');
	
		vc_map( array(
			"name" => esc_attr__("Typewriter", "ozy-salon-essentials"),
			"base" => "ozy_vc_typewriter",
			"as_parent" => array('only' => 'ozy_vc_typewriter_line'),
			"content_element" => true,
			"show_settings_on_create" => false,
			"icon" => "icon-wpb-ozy-el",
			'category' => 'by OZY',
			"params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Static Caption", "ozy-salon-essentials"),
					"param_name" => "title",
					"admin_label" => true,
					"value" => ""
				),
				array(
					"type" => "colorpicker",
					"heading" => esc_attr__("Font Color", "ozy-salon-essentials"),
					"param_name" => "font_color",
					"admin_label" => false,
					"value" => "#ffffff"
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Font Size", "ozy-salon-essentials"),
					"param_name" => "font_size",
					"admin_label" => true,					
					"value" => "4.2vw"
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_attr__("Font Weight", "ozy-salon-essentials"),
					"param_name" => "font_weight",
					"admin_label" => true,
					"value" => array("100", "200", "300", "400", "500", "600", "700", "800", "900")
				),					
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Type Speed", "ozy-salon-essentials"),
					"param_name" => "typespeed",
					"admin_label" => true,
					"description" => esc_attr__("Typing Speed", "ozy-salon-essentials"),
					"value" => "100"
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Start Delay", "ozy-salon-essentials"),
					"param_name" => "startdelay",
					"admin_label" => true,
					"description" => esc_attr__("Time before typing starts", "ozy-salon-essentials"),
					"value" => "0"
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Back Speed", "ozy-salon-essentials"),
					"param_name" => "backspeed",
					"admin_label" => true,
					"description" => esc_attr__("Backspacing speed", "ozy-salon-essentials"),
					"value" => "0"
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Back Delay", "ozy-salon-essentials"),
					"param_name" => "backdelay",
					"admin_label" => true,
					"description" => esc_attr__("Time before backspacing", "ozy-salon-essentials"),
					"value" => "1500"
				),				
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_attr__("Loop", "ozy-salon-essentials"),
					"param_name" => "loop",
					"admin_label" => true,
					"description" => esc_attr__("The whole typing is loop or not", "ozy-salon-essentials"),
					"value" => array("true", "false")
				)
				
		   ),
		   "js_view" => 'VcColumnView'		   
		) );
	}
	
	if (!function_exists('ozy_vc_typewriter_line')) {
		function ozy_vc_typewriter_line( $atts, $content = null ) {
			$atts = vc_map_get_attributes('ozy_vc_typewriter_line', $atts);
			extract(shortcode_atts(array(
				'caption'		=> ''
			), $atts));
			
			$GLOBALS['OZY_TYPE_WRITER'][] = esc_attr($caption);
			
			return null;
		}
		
		add_shortcode('ozy_vc_typewriter_line', 'ozy_vc_typewriter_line');

		vc_map( array(
			"name" => esc_attr__("Line", "ozy-salon-essentials"),
			"base" => "ozy_vc_typewriter_line",
			"content_element" => true,
			"as_child" => array('only' => 'ozy_vc_typewriter'),
			"icon" => "icon-wpb-ozy-el",
			"params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Typewriter Line", "ozy-salon-essentials"),
					"param_name" => "caption",
					"admin_label" => true,
					"description" => esc_attr__('Add ^1000 between the words if you like add 1000ms delay to before the next word. Example: First ^1000 sentence.', 'ozy-salon-essentials'),
					"value" => ""
				)		
		   )
		) );
	}

	class WPBakeryShortCode_Ozy_Vc_Typewriter extends WPBakeryShortCodesContainer{}
	class WPBakeryShortCode_Ozy_Vc_Typewriter_Line extends WPBakeryShortCode{}		
	
	/**
	* Pretty Map
	*/
	if (!function_exists('ozy_vc_prettymap')) {
		function ozy_vc_prettymap( $atts, $content = null ) {
			$atts = vc_map_get_attributes('ozy_vc_prettymap', $atts);
			extract(shortcode_atts(array(
				'address_'		=> 'Melbourne, Australia',
				'zoom'			=> '13',
				'custom_icon'	=> '',
				'hue'			=> '',//#ff0000
				'saturation'	=> '',//-30
				'lightness' 	=> '0',
				'height'		=> '350px',
				'extra_class_name' => '',
				'api_key'		=> ''
			), $atts));
			
			$custom_icon = wp_get_attachment_image_src($custom_icon, 'full');
			if(isset($custom_icon[0])) {
				$custom_icon = $custom_icon[0];
			}
			
			//wp_enqueue_script('googlemaps', '//maps.google.com/maps/api/js?sensor=false&language=en', array('jquery'), null, true );
			wp_enqueue_script('googlemaps', '//maps.google.com/maps/api/js?'. ($api_key?'key=' . $api_key .'&':'') .'sensor=false&language=en', array('jquery'), null, true );
			wp_enqueue_script('googlemaps_infobox', '//cdn.rawgit.com/googlemaps/v3-utility-library/master/infobox/src/infobox_packed.js', array('jquery'), null, true );
			
			return '<div class="ozy-google-map '. esc_attr($extra_class_name) .'" 
			data-address="'. esc_attr($address_) .'" 
			data-zoom="'. esc_attr($zoom) .'" 
			data-hue="'. esc_attr($hue) .'" 
			data-saturation="'. esc_attr($saturation) .'" 
			data-lightness="'. esc_attr($lightness) .'" 
			data-height="'. esc_attr($height) .'" 
			data-icon="'. esc_url($custom_icon) .'" style="height:'. esc_attr($height) .'"></div><div class="gmap-infobox-wrapper"><div id="gmap-infobox" class="content-font">'. $content .'</div></div>';
		}
		
		add_shortcode('ozy_vc_prettymap', 'ozy_vc_prettymap');
		
		vc_map( array(
			"name" => esc_attr__("Custom Google Map", "ozy-salon-essentials"),
			"base" => "ozy_vc_prettymap",
			"content_element" => true,
			"show_settings_on_create" => true,
			"icon" => "icon-wpb-ozy-el",
			'category' => 'by OZY',
			"params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr("Google Maps API Key", "ozy-salon-essentials"),
					"param_name" => "api_key",
					"admin_label" => false,
					"value" => "",
					'description' => wp_kses(__('<a href="http://freevision.me/google-maps-key/" target="_blank">Learn how to get an API Key.</a>', 'ozy-salon-essentials'),array('a' => array('href' => array(), 'target' => array()))),					
				),				
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Height", "ozy-salon-essentials"),
					"param_name" => "height",
					"admin_label" => true,
					"value" => "350px"
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Address", "ozy-salon-essentials"),
					"param_name" => "address_",
					"admin_label" => true,
					"value" => esc_attr__("Melbourne, Australia", "ozy-salon-essentials")
				),
				array(
					"type" => "textarea",
					"class" => "",
					"heading" => esc_attr__("Caption", "ozy-salon-essentials"),
					"param_name" => "content",
					"admin_label" => true,
					"value" => esc_attr__("Caption", "ozy-salon-essentials")
				),				
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Zoom Level", "ozy-salon-essentials"),
					"param_name" => "zoom",
					"admin_label" => true,
					"value" => "13"
				),			
				array(
					"type" => "attach_image",
					"class" => "",
					"heading" => esc_attr__("Custom Icon", "ozy-salon-essentials"),
					"param_name" => "custom_icon",
					"description" => esc_attr__("You can select a custom icon for your pin on the map", "ozy-salon-essentials"),
					"admin_label" => false,
					"value" => ""
				),
				array(
					"type" => "colorpicker",
					"heading" => esc_attr__("Hue Color", "ozy-salon-essentials"),
					"param_name" => "hue",
					"admin_label" => false,
					"value" => "#FF0000"
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Saturation", "ozy-salon-essentials"),
					"param_name" => "saturation",
					"admin_label" => true,
					"value" => "-30"
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Lightness", "ozy-salon-essentials"),
					"param_name" => "lightness",
					"admin_label" => true,
					"value" => "0"
				)		
		   )
		) );
	}		
	
	/**
	* Counter
	*/
	if (!function_exists('ozy_vc_count_to')) {
		function ozy_vc_count_to( $atts, $content = null ) {
            $atts = vc_map_get_attributes('ozy_vc_count_to', $atts);
			extract(shortcode_atts(array(
				'color' 		=> '#000000',
				'from'			=> 0,
				'to'			=> 100,
				'subtitle' 		=> '',
				'sign'			=> '',
				'signpos'		=> 'right',
				'css_animation' => ''
			), $atts));
			
			if($css_animation) {
				wp_enqueue_style( 'animate-css' );
				$css_animation = ' wpb_animate_when_almost_visible wpb_'. esc_attr($css_animation) .' '. esc_attr($css_animation) .' wpb_start_animation animated ';
			}	
			
			return '<div class="ozy-counter '. $css_animation .'" style="color:'. esc_attr($color) .'"><div class="timer" data-sign="'. esc_attr($sign) .'" data-signpos="'. esc_attr($signpos) .'" data-from="'. esc_attr($from) .'" data-to="'. esc_attr($to) .'">'. esc_attr($from) .'</div><div class="hr" style="background-color:'. esc_attr($color) .'"></div>'. (esc_attr($subtitle) ? '<span>'. esc_attr($subtitle) .'</span>' : '') .'</div>';
		}
		
		add_shortcode('ozy_vc_count_to', 'ozy_vc_count_to');
		
		vc_map( array(
			"name" => esc_attr__("Count To", "ozy-salon-essentials"),
			"base" => "ozy_vc_count_to",
			"icon" => "",
			"class" => '',
			"controls" => "full",
			'category' => 'by OZY',
			"icon" => "icon-wpb-ozy-el",
			"params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Sub Title", "ozy-salon-essentials"),
					"param_name" => "subtitle",
					"admin_label" => true,
					"value" => "",
					"description" => esc_attr__("Counter title.", "ozy-salon-essentials")
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("From", "ozy-salon-essentials"),
					"param_name" => "from",
					"admin_label" => true,
					"value" => "0",
					"description" => esc_attr__("Counter start from", "ozy-salon-essentials")
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("To", "ozy-salon-essentials"),
					"param_name" => "to",
					"admin_label" => true,
					"value" => "100",
					"description" => esc_attr__("Counter count to", "ozy-salon-essentials")
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Sign", "ozy-salon-essentials"),
					"param_name" => "sign",
					"admin_label" => true,
					"value" => "",
					"description" => esc_attr__("Enter a sign like % or whatever you like", "ozy-salon-essentials")
				),array(
					"type" => "dropdown",
					"heading" => esc_attr__("Sign Position", "ozy-salon-essentials"),
					"param_name" => "signpos",
					"value" => array('right', 'left'),
					"admin_label" => false,
					"description" => esc_attr__("Select position of your sign.", "ozy-salon-essentials")
				),array(
					"type" => "colorpicker",
					"heading" => esc_attr__("Forecolor", "ozy-salon-essentials"),
					"param_name" => "color",
					"value" => "#000000",
					"admin_label" => false
				),$add_css_animation
		   )
		) );	
	}
	
	/**
	* Team Member Extended
	*/
	if (!function_exists('ozy_vc_team_member_ext')) {
		function ozy_vc_team_member_ext( $atts, $content = null ) {
            $atts = vc_map_get_attributes('ozy_vc_team_member_ext', $atts);
			extract(shortcode_atts(array(
				'image' => '',
				'title' => '',
				'sub_title' => '',
				'excerpt' => '',			
				'twitter' => '',
				'facebook' => '',
				'linkedin' => '',
				'pinterest' => '',
				'link' => '',
				'link_caption' => '',
				'use_extended_content' => 'off',
				'css_animation' => ''
			), $atts));
			
			if($css_animation) {
				wp_enqueue_style( 'animate-css' );
				$css_animation = ' wpb_animate_when_almost_visible wpb_'. esc_attr($css_animation) .' '. esc_attr($css_animation) .' wpb_start_animation animated ';
			}
			
			$output = PHP_EOL . '<div class="ozy-team_member wpb_content_element '. $css_animation . ($use_extended_content==='on' ? ' has-extended-content':'') .'">' . PHP_EOL;
			$output.= '<figure>';
			$member_image = wp_get_attachment_image_src($image, 'full');
			if(isset($member_image[0])) {
				$output.= $link? '<a href="'. esc_attr($link) .'">' : '<a>';
				$output.= '<img src="'. $member_image[0] .'" alt="'. esc_attr($title) .'">';
				$member_image = $member_image[0];
				//$output.= $link? '</a>' : '';
				$output.= '</a>';
				
			}else{
				$member_image = '';
			}
			$output.= '<figcaption>';
			$output.= esc_attr($title) ? '<h3>'. esc_attr($title) .'</h3>' : '';
			$output.= esc_attr($sub_title) ? '<h5 class="content-color-alternate">'. esc_attr($sub_title) .'</h5>' : '';
			$output.= '<p>'. esc_attr($excerpt) .'</p>';

			$output.= '<div>';
			$output.= esc_attr($twitter) ? '<a href="http://www.twitter.com/'. esc_attr($twitter) .'" target="_blank" class="symbol-twitter tooltip" title="twitter"><span class="symbol">twitter'.'</span></a>' : '';
			$output.= esc_attr($facebook) ? '<a href="http://www.facebook.com/'. esc_attr($facebook) .'" target="_blank" class="symbol-facebook tooltip" title="facebook"><span class="symbol">facebook'.'</span></a>' : '';
			$output.= esc_attr($linkedin) ? '<a href="http://www.linkedin.com/'. esc_attr($linkedin) .'" target="_blank" class="symbol-linkedin tooltip" title="linkedin"><span class="symbol">linkedin'.'</span></a>' : '';
			$output.= esc_attr($pinterest) ? '<a href="http://pinterest.com/'. esc_attr($pinterest) .'" target="_blank" class="symbol-pinterest tooltip" title="pinterest"><span class="symbol">pinterest'.'</span></a>' : '';
			$output.= '</div>';
			
			$output.= '</figcaption>';
			$output.= '</figure>';
			$output.= ($use_extended_content==='on' ? '<div class="extended-content" data-rand_id="'. rand(10,10000) .'"><table class="team-member-lightbox-table"><tr><td style="background-image:url('. $member_image .');">&nbsp;</td><td class="content-font"><h2 class="heading-font">'. $title . '</h2>'. do_shortcode($content) . ($link && $link_caption ? '<a href="'. esc_url($link) .'" class="lightbox-book-me-now clearfix">'. esc_attr($link_caption) .'</a>':'') .'</td></tr></table></div>' : '');
			$output.= PHP_EOL . '</div>' . PHP_EOL;		
			
			return $output;
		}

		add_shortcode( 'ozy_vc_team_member_ext', 'ozy_vc_team_member_ext' );
		
		vc_map( array(
			"name" => esc_attr__("Team Member - Extended", "ozy-salon-essentials"),
			"base" => "ozy_vc_team_member_ext",
			"icon" => "icon-wpb-ozy-el",
			"class" => '',
			"controls" => "full",
			'category' => 'by OZY',
			"params" => array(
				array(
					"type" => "attach_image",
					"class" => "",
					"heading" => esc_attr__("Member Image", "ozy-salon-essentials"),
					"param_name" => "image",
					"admin_label" => false,
					"value" => "",
					"description" => esc_attr__("Select image for your team member.", "ozy-salon-essentials")
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Title", "ozy-salon-essentials"),
					"param_name" => "title",
					"admin_label" => true,
					"value" => "",
					"description" => esc_attr__("Title for your Team Member, like a name.", "ozy-salon-essentials")
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Sub Title", "ozy-salon-essentials"),
					"param_name" => "sub_title",
					"admin_label" => true,
					"value" => "",
					"description" => esc_attr__("Sub Title for your Team Member, like work title.", "ozy-salon-essentials")
				),array(
					"type" => "textarea",
					"class" => "",
					"heading" => esc_attr__("Excerpt", "ozy-salon-essentials"),
					"param_name" => "excerpt",
					"admin_label" => true,
					"value" => ""
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Twitter", "ozy-salon-essentials"),
					"param_name" => "twitter",
					"admin_label" => true,
					"value" => "",
					"description" => esc_attr__("Enter your Twitter account name", "ozy-salon-essentials")
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Facebook", "ozy-salon-essentials"),
					"param_name" => "facebook",
					"admin_label" => true,
					"value" => "",
					"description" => esc_attr__("Enter your Facebook account name", "ozy-salon-essentials")
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("LinkedIn", "ozy-salon-essentials"),
					"param_name" => "linkedin",
					"admin_label" => true,
					"value" => "",
					"description" => esc_attr__("Enter your LinkedIn account name", "ozy-salon-essentials")
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Pinterest", "ozy-salon-essentials"),
					"param_name" => "pinterest",
					"admin_label" => true,
					"value" => "",
					"description" => esc_attr__("Enter your Pinterest account name", "ozy-salon-essentials")
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Link", "ozy-salon-essentials"),
					"param_name" => "link",
					"admin_label" => false,
					"value" => "",
					"description" => esc_attr__("Define a path to details page", "ozy-salon-essentials")
				),array(
					"type" => 'dropdown',
					"heading" => esc_attr__("Use Extended Content", "ozy-salon-essentials"),
					"param_name" => "use_extended_content",
					"value" => array("off", "on"),
					"description" => esc_attr__("Link will be used in extended content when this option used.", "ozy-salon-essentials")
				),array(
					"type" => "textarea_html",
					"heading" => esc_attr__("Extended Content", "ozy-salon-essentials"),
					"param_name" => "content",
					"value" => "",
					"admin_label" => false,
					"dependency" => Array('element' => "use_extended_content", 'value' => 'on')
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Link Caption", "ozy-salon-essentials"),
					"param_name" => "link_caption",
					"admin_label" => false,
					"value" => esc_attr__("BOOK ME NOW", "ozy-salon-essentials"),
					"dependency" => Array('element' => "use_extended_content", 'value' => 'on')					
				),$add_css_animation
		   )
		) );		
	}
	
	/**
	* Icon Wrapper
	*/
	if (!function_exists('ozy_vc_iconwrapper')) {
		function ozy_vc_iconwrapper( $atts, $content = null ) {
			$atts = vc_map_get_attributes('ozy_vc_iconwrapper', $atts);
			extract(shortcode_atts(array(
				'title' => ''
			), $atts));

			$output = '<div class="ozy-icon-wrapper wpb_content_element">';
			if($title) $output.= '<span>' . esc_attr($title, 'ozy-salon-essentials') . '</span>';
			$output.= do_shortcode($content); 
			$output.= '</div>';

			return $output;
		}
		
		add_shortcode('ozy_vc_iconwrapper', 'ozy_vc_iconwrapper');
		
		vc_map( array(
			"name" => esc_attr__("Icon Wrapper", "ozy-salon-essentials"),
			"base" => "ozy_vc_iconwrapper",
			"as_parent" => array('only' => 'vc_icon'),
			"content_element" => true,
			"show_settings_on_create" => true,
			"icon" => "icon-wpb-ozy-el",
			'category' => 'by OZY',
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_attr__("Title", "ozy-salon-essentials"),
					"param_name" => "title",
					"value" => "",
					"admin_label" => true
				)
		   ),
		   "js_view" => 'VcColumnView'
		) );
		
		class WPBakeryShortCode_Ozy_Vc_Iconwrapper extends WPBakeryShortCodesContainer{}			
	}
	
	/**
	* Compact Post / Portfolio
	*/
	if (!function_exists('ozy_vc_hoverbox_feed')) {
		function ozy_vc_hoverbox_feed( $atts, $content = null ) {
			$atts = vc_map_get_attributes('ozy_vc_hoverbox_feed', $atts);
			extract(shortcode_atts(array(
				'data_source'		=> 'blog',
				'orderby'			=> 'date',
				'order'				=> 'DESC',
				'css_animation' 	=> '',
				'category_name'		=> ''
			), $atts));
			
			if(!function_exists('salon_blog_more')) return '';
			
			wp_enqueue_style('ozy-hoverbox-blog');
			
			if($css_animation) {
				wp_enqueue_style( 'animate-css' );
				$css_animation = ' wpb_animate_when_almost_visible wpb_'. esc_attr($css_animation) .' '. esc_attr($css_animation) .' wpb_start_animation animated ';
			}

			$args = array(
				'post_type' 			=> ($data_source == 'portfolio' ? 'ozy_portfolio' : 'post'),
				'post_status'			=> 'publish',
				'orderby' 				=> $orderby,
				'order' 				=> $order,
				'posts_per_page'		=> 6,
				'ignore_sticky_posts' 	=> 1,
				'meta_key' 				=> '_thumbnail_id',
				'tax_query' => array(
					array(
						'taxonomy' => 'post_format',
						'field'    => 'slug',
						'terms' => array('post-format-aside', 'post-format-link', 'post-format-quote', 'post-format-status', 'post-format-audio', 'post-format-chat'),
						'operator' => 'NOT IN'
					),
				),								
			);
			
			if($data_source !== 'portfolio' && $category_name) {
				$args['category_name'] = $category_name;
			}else if($data_source === 'portfolio' && $category_name) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'portfolio_category',
						'field'    => 'slug',
						'terms'    => $category_name
					));
			}
			
			query_posts( $args );
			
			$effect_array = array(
				'effect-slideleft one-half', 
				'effect-slidedown one-half', 
				'effect-slideleft double-height one-full', 
				'effect-slideup one-half double-height', 
				'effect-slideleft one-half', 
				'effect-slideright one-half');
			$post_counter = 0;

			$excerpt_function = function_exists('salon_excerpt_max_charlength') ? 'salon_excerpt_max_charlength' : 'get_the_excerpt';			
			
			$output = '<div class="hoverbox-blog-grid '. $css_animation .'">';
						
			while (have_posts()) {
				the_post();salon_blog_more();

				$post_image_src = '';
				if ( has_post_thumbnail() ) { 
					$post_image_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'salon_blog' , false );
					if (isset($post_image_src[0])) {
						$post_image_src = $post_image_src[0];
					}else{
						$post_image_src = '';
					}
				}
				
				$dynamic_css_class_name = 'hover-box-1' . get_the_ID();
				
				$output.= 
					'<figure class="'. esc_attr($effect_array[$post_counter]) . '" style="background-image:url('. esc_url($post_image_src) .')">
						<img src="'. esc_attr($post_image_src) .'" alt="'. esc_attr(get_the_title()) .'"/>
						<figcaption class="'.  $dynamic_css_class_name  .'">
							<div>
								<span class="cat">';

				if($data_source !== 'portfolio') {
					$categories = get_the_category();
				}else{
					$categories = get_the_terms( $post->ID , 'portfolio_category' );
				}
				$separator = ' ';
				if ( ! empty( $categories ) ) {
					foreach( $categories as $category ) {
						$output .= $separator . '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( esc_attr( 'View all posts in %s', 'ozy-salon-essentials' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>';
						$separator = ', ';
					}
				}
				
				//$output.=		'</span><h2>'. esc_html(get_the_title()) .'</h2>
				$output.=		'</span><h2>'. get_the_title() .'</h2>
								<p>'. esc_html(call_user_func($excerpt_function, 100)) .'</p>
								<a href="'. esc_url(get_permalink()) .'" class="button">'. esc_html('VIEW NOW', 'ozy-salon-essentials') .'</a>
							</div>
						</figcaption>			
					</figure>';
				
				$post_counter++;
				
				if(function_exists('salon_page_hover_box_blog_css_builder')) {
					salon_page_hover_box_blog_css_builder(get_the_ID(), $dynamic_css_class_name);
				}
			}
			$output.= '</div>';	
			
			wp_reset_postdata();
			
			wp_reset_query();
			
			return $output;
		}
		
		add_shortcode('ozy_vc_hoverbox_feed', 'ozy_vc_hoverbox_feed');
		
		vc_map( array(
			"name" => esc_attr("Compact Post / Portfolio", "ozy-salon-essentials"),
			"base" => "ozy_vc_hoverbox_feed",
			"content_element" => true,
			"show_settings_on_create" => true,
			"icon" => "icon-wpb-ozy-el",
			'category' => 'by OZY',
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_attr("Data Source", "ozy-salon-essentials"),
					"param_name" => "data_source",
					"value" => array("", "blog", "portfolio"),
					"admin_label" => true,
					"description" => esc_attr("Choose source of your feed.", "ozy-salon-essentials")
				),
				array(
					"type" => "textfield",
					"heading" => esc_attr("Categories", "ozy-salon-essentials"),
					"param_name" => "category_name",
					"description" => esc_attr("If you want to narrow output, enter category slug names here. Display posts that have this category (and any children of that category), use category slug (NOT name). Split names with ','. More information; <a href='http://codex.wordpress.org/Class_Reference/WP_Query#Category_Parameters' target='_blank'>http://codex.wordpress.org/Class_Reference/WP_Query#Category_Parameters</a>", "ozy-salon-essentials")
				),
				array(
					"type" => "dropdown",
					"heading" => esc_attr__("Order by", "ozy-salon-essentials"),
					"param_name" => "orderby",
					"value" => array(esc_attr__("Date", "ozy-salon-essentials") => "date", esc_attr__("ID", "ozy-salon-essentials") => "ID", esc_attr__("Author", "ozy-salon-essentials") => "author", esc_attr__("Title", "ozy-salon-essentials") => "title", esc_attr__("Modified", "ozy-salon-essentials") => "modified", esc_attr__("Random", "ozy-salon-essentials") => "rand", esc_attr__("Comment count", "ozy-salon-essentials") => "comment_count", esc_attr__("Menu order", "ozy-salon-essentials") => "menu_order" ),
					"description" => esc_attr__('Select how to sort retrieved posts.', 'ozy-salon-essentials')
				),
				array(
					"type" => "dropdown",
					"heading" => esc_attr__("Order way", "ozy-salon-essentials"),
					"param_name" => "order",
					"value" => array(esc_attr__("Descending", "ozy-salon-essentials") => "DESC", esc_attr__("Ascending", "ozy-salon-essentials") => "ASC" ),
					"description" => esc_attr__('Designates the ascending or descending order.', "ozy-salon-essentials")
				),
				$add_css_animation
		   )
		) );
	}	
	
	/**
	* Accordion Post List
	*/
	if (!function_exists('ozy_vc_fancypostaccordion_feed')) {
		function ozy_vc_fancypostaccordion_feed( $atts, $content = null ) {
			$atts = vc_map_get_attributes('ozy_vc_fancypostaccordion_feed', $atts);
			extract(shortcode_atts(array(
				'data_source'		=> 'blog',
				'link_caption' 		=> 'FIND OUT MORE',
				'link_target'		=> '_self',
				'posts_per_page'	=> '6',
				'css_animation' 	=> '',
				'category_name'		=> ''
			), $atts));
			
			if($css_animation) {
				wp_enqueue_style( 'animate-css' );
				$css_animation = ' wpb_animate_when_almost_visible wpb_'. esc_attr($css_animation) .' '. esc_attr($css_animation) .' wpb_start_animation animated ';
			}

			$args = array(
				'post_type' 			=> ($data_source == 'portfolio' ? 'ozy_portfolio' : 'post'),
				'posts_per_page'		=> esc_attr($posts_per_page),
				'orderby' 				=> 'date',
				'order' 				=> 'DESC',
				'ignore_sticky_posts' 	=> 1,
			);

			if($data_source !== 'portfolio' && $category_name) {
				$args['category_name'] = $category_name;
			}else if($data_source === 'portfolio' && $category_name) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'portfolio_category',
						'field'    => 'slug',
						'terms'    => $category_name
					));
			}

			$the_query = new WP_Query( $args );
			
			$output = '<table class="ozy-fancyaccordion-feed wpb_content_element '. $css_animation .'">';
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$categories = get_the_terms(get_the_ID(), ($data_source === 'blog' ? 'category' : 'portfolio_category'));
				
				$output .= '<tr class="title">';
				$output .= '<td class="heading-font">';
				if(is_array($categories)) {
					$output .= '<span class="category generic-button content-font">';
					$comma = '';			
					foreach ($categories as $cat) {
						$output .= $comma . $cat->name;
						$comma = ', ';
					}
					$output .= '</span>';
				}
				$output .= get_the_date(get_option('date_format'));
				$output .= '</td>';
				$output .= '<td>';
				$output .= '<h3 class="t">'. get_the_title() .'</h3><span class="plus-icon"><span class="h"></span><span class="v"></span></span>';				
				$output .= '</td>';
				$output .= '</tr>';
				$output .= '<tr class="excerpt">';
				$output .= '<td><div>&nbsp;</div></td>';
				$output .= '<td><div>';
				if(function_exists('salon_excerpt_max_charlength')) {
					$output .= salon_excerpt_max_charlength(200, true, false);
				}else{
					$output .= '**not proper theme in use**';
				}
				$output .= '<p>';
				$output .= '<a href="'. esc_url(get_permalink()) .'">'. esc_html($link_caption) .'</a>';
				$output .= '</p>';				
				$output .= '</div></td>';
				$output .= '</tr>';			
			}
			wp_reset_postdata();
			
			$output.= '</table>';
			
			return $output;
		}
		
		add_shortcode('ozy_vc_fancypostaccordion_feed', 'ozy_vc_fancypostaccordion_feed');
		
		vc_map( array(
			"name" => esc_attr("Accordion Post List", "ozy-salon-essentials"),
			"base" => "ozy_vc_fancypostaccordion_feed",
			"content_element" => true,
			"show_settings_on_create" => true,
			"icon" => "icon-wpb-ozy-el",
			'category' => 'by OZY',
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_attr("Data Source", "ozy-salon-essentials"),
					"param_name" => "data_source",
					"value" => array("", "blog", "portfolio"),
					"admin_label" => true,
					"description" => esc_attr("Choose source of your feed.", "ozy-salon-essentials")
				),
				array(
					"type" => "textfield",
					"heading" => esc_attr("Categories", "ozy-salon-essentials"),
					"param_name" => "category_name",
					"description" => esc_attr("If you want to narrow output, enter category slug names here. Display posts that have this category (and any children of that category), use category slug (NOT name). Split names with ','. More information; <a href='http://codex.wordpress.org/Class_Reference/WP_Query#Category_Parameters' target='_blank'>http://codex.wordpress.org/Class_Reference/WP_Query#Category_Parameters</a>", "ozy-salon-essentials")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr("Link Caption", "ozy-salon-essentials"),
					"param_name" => "link_caption",
					"admin_label" => true,
					"value" => esc_attr("FIND OUT MORE", "ozy-salon-essentials")
				),array(
					"type" => "dropdown",
					"heading" => esc_attr("Link Target", "ozy-salon-essentials"),
					"param_name" => "link_target",
					"value" => array("_self", "_blank", "_parent"),
					"admin_label" => false,
					"description" => esc_attr("Select link target window.", "ozy-salon-essentials")
				),					
				array(
					"type" => "dropdown",
					"heading" => esc_attr("Item Count", "ozy-salon-essentials"),
					"param_name" => "posts_per_page",
					"value" => array("6", "1", "2", "3", "4", "5", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16"),
					"admin_label" => true,
					"description" => esc_attr("How many post will be shown on the list.", "ozy-salon-essentials")
				),
				$add_css_animation
		   )
		) );
	}	
	
	/**
	* Team Member (Simple)
	*/
	if (!function_exists('ozy_vc_team_member')) {
		function ozy_vc_team_member( $atts, $content = null ) {
            $atts = vc_map_get_attributes('ozy_vc_team_member', $atts);
			extract(shortcode_atts(array(
				'image' => '',
				'title' => '',
				'link' => '',
				'fg_color' => '',
				'use_extended_content' => 'off',
				'link_caption' => 'availability',
				'css_animation' => ''
			), $atts));
			
			if($css_animation) {
				wp_enqueue_script('waypoints');
				$css_animation = " wpb_animate_when_almost_visible wpb_" . esc_attr($css_animation) . " ";
			}	
			
			$rand_id = 'otms-' . rand(10, 100000);
			
			$output = PHP_EOL . '<div id="'. esc_attr($rand_id) .'" class="ozy-team_member_simple '. $css_animation . ($use_extended_content==='on' ? ' has-extended-content':'') .'">' . PHP_EOL;
			$output.= '<figure>';
			$member_image = wp_get_attachment_image_src($image, 'full');
			if(isset($member_image[0])) {
				$output.= '<img src="'. $member_image[0] .'" alt="'. esc_attr($title) .'">';
			}
			$output.= '<figcaption>';
			$output.= esc_attr($title) ? '<h4>'. esc_attr($title) .'</h4>' : '';
			$link = vc_build_link($link);
			if($use_extended_content == 'off' && (is_array($link) && isset($link['url']) && isset($link['title']) && $link['url'] && $link['title'])) {
				$output .= '<a href="'. esc_url($link['url']) .'" '. (isset($link['target']) ? ' target="'. esc_attr($link['target']).'"':'').'>'. $link['title'] .'</a>';
			}
			$output.= '<svg viewBox="0 0 360.62 37.92"><use xlink:href="' . plugins_url( 'ozy-salon-essentials/images/floral_divider.svg', dirname(__FILE__) ) . '#floral_divider"></use></svg>';
			if($use_extended_content == 'on') {
				$output .= '<a href="#show-more" class="show-more">'. $link_caption .'</a>';
			}
			$output.= '</figcaption>';
			//if($use_extended_content == 'on') $output.= '</a>';
			$output.= '</figure>';
			
			$output.= ($use_extended_content==='on' ? '<div class="extended-content">'. $content .'</div>' : '');
			$output.= PHP_EOL . '</div>' . PHP_EOL;
			
			global $ozySalonHelper;
			if(!function_exists('salon_get_option') || !is_object($ozySalonHelper)) return null;
			$ozySalonHelper->set_footer_style("#$rand_id h4 {color:". esc_attr($fg_color) ."!important}");
			$ozySalonHelper->set_footer_style("#$rand_id svg use, #$rand_id svg path {stroke-width: 0px;fill:". esc_attr($fg_color) .";stroke:". esc_attr($fg_color) ."}");
			
			return $output;
		}

		add_shortcode( 'ozy_vc_team_member', 'ozy_vc_team_member' );
		
		vc_map( array(
			"name" => esc_attr__("Team Member (Simple)", "ozy-salon-essentials"),
			"base" => "ozy_vc_team_member",
			"icon" => "icon-wpb-ozy-el",
			"class" => '',
			"controls" => "full",
			'category' => 'by OZY',
			"params" => array(
				array(
					"type" => "attach_image",
					"class" => "",
					"heading" => esc_attr__("Member Image", "ozy-salon-essentials"),
					"param_name" => "image",
					"admin_label" => false,
					"value" => "",
					"description" => esc_attr__("Select image for your team member.", "ozy-salon-essentials")
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Title", "ozy-salon-essentials"),
					"param_name" => "title",
					"admin_label" => true,
					"value" => "",
					"description" => esc_attr__("Title for your Team Member, like a name.", "ozy-salon-essentials")
				),array(
					"type" => "vc_link",
					"class" => "",
					"heading" => esc_attr__("Link", "ozy-salon-essentials"),
					"param_name" => "link",
					"admin_label" => false,
					"value" => ""
				),array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => esc_attr__("Foregound Color", "ozy-salon-essentials"),
					"param_name" => "fg_color",
					"admin_label" => false,
					"value" => "#ffffff"
				),array(
					"type" => 'dropdown',
					"heading" => esc_attr__("Use Extended Content", "ozy-salon-essentials"),
					"param_name" => "use_extended_content",
					"value" => array("off", "on"),
					"description" => esc_attr__("Link will be ignored when extended content used to display in page content.", "ozy-salon-essentials")
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Link Caption", "ozy-salon-essentials"),
					"param_name" => "link_caption",
					"admin_label" => false,
					"value" => esc_attr__("availability", "ozy-salon-essentials"),
					"dependency" => Array('element' => "use_extended_content", 'value' => 'on')					
				),array(
					"type" => "textarea_html",
					"heading" => esc_attr__("Extended Content", "ozy-salon-essentials"),
					"param_name" => "content",
					"value" => "",
					"admin_label" => false,
					"dependency" => Array('element' => "use_extended_content", 'value' => 'on')
				),$add_css_animation
		   )
		) );		
	}	
	
	/**
	* Instagram Feed
	*/
	if (!function_exists('ozy_vc_instagram')) {
		function ozy_vc_instagram( $atts, $content = null ) {
            $atts = vc_map_get_attributes('ozy_vc_instagram', $atts);
			extract(shortcode_atts(array(
				'username' => '',
				'num_items' => '10',
				'access_token' => '',
				'css_animation' => ''
			), $atts));
			
			if($css_animation) {
				wp_enqueue_style( 'animate-css' );
				$css_animation = ' wpb_animate_when_almost_visible wpb_'. esc_attr($css_animation) .' '. esc_attr($css_animation) .' wpb_start_animation animated ';
			}

			return '<div class="ozy-instagram-gallery-wrapper wpb_content_element '. $css_animation .'"><span class="alternate-text-color">@'. esc_html($username) .'</span><ul class="ozy-instagram-gallery" data-username="'. esc_attr($username) .'" data-numitems="'. esc_attr($num_items) .'" data-accesstoken="'. esc_attr($access_token) .'"></ul></div>';
		}

		add_shortcode('ozy_vc_instagram', 'ozy_vc_instagram');
		
		vc_map( array(
			"name" => esc_attr__("Instagram Feed", "ozy-salon-essentials"),
			"base" => "ozy_vc_instagram",
			"icon" => "icon-wpb-ozy-el",
			"class" => '',
			"controls" => "full",
			'category' => 'by OZY',
			"params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Username", "ozy-salon-essentials"),
					"param_name" => "username",
					"admin_label" => true,
					"value" => "",
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Number Of Items", "ozy-salon-essentials"),
					"param_name" => "num_items",
					"admin_label" => true,
					"value" => "10",
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Access Token Key", "ozy-salon-essentials"),
					"param_name" => "access_token",
					"description" => esc_attr('Please click <a href="http://freevision.me/instagram" target="_blank">here</a> to get your access token key', 'ozy-salon-essentials'),
					"admin_label" => false,
					"value" => ""
				),$add_css_animation
		   )
		) );	
	}	
	
	/**
	* Call To Action Box
	*/
	if (!function_exists('ozy_vc_calltoactionbox')) {
		function ozy_vc_calltoactionbox( $atts, $content = null ) {
            $atts = vc_map_get_attributes('ozy_vc_calltoactionbox', $atts);
			extract(shortcode_atts(array(
				'image'			=> '',
				'caption'		=> '',
				'icon'			=> '',
				'link_caption' 	=> '',
				'link'			=> '',
				'link_target'	=> '_self',
				'box_height'	=> '',
				'extra_css'		=> '',
				'css_animation' => ''
			), $atts));
			
			if($css_animation) {
				wp_enqueue_style( 'animate-css' );
				$css_animation = ' wpb_animate_when_almost_visible wpb_'. esc_attr($css_animation) .' '. esc_attr($css_animation) .' wpb_start_animation animated ';
			}

			$image = wp_get_attachment_image_src($image, 'full');
			if(isset($image[0])) {
				$image = ' style="background-image:url('. esc_url($image[0]) .');'. ($box_height ? 'height:' . esc_attr($box_height):'') .'"';
			}else{
				$image = ' style="height:'. ($box_height ? 'height:' . esc_attr($box_height):'') .'"';
			}
			$output = '<div class="ozy-call-to-action-box '. $css_animation .'"'. $image .'>';			
			$output .= '<div class="shadow-wrapper"></div>';
			$output .= '<div class="overlay-wrapper">';
			$output .= '<h2>'. $caption .'</h2>';
			$output .= '<span class="shared-border-color"></span>';
			$output .= '<a href="'. esc_url($link) .'" target="'. esc_attr($link_target) .'" class="heading-font">'. $link_caption .'</a>';
			if($icon) {
				$output .= '<i class="'. esc_attr($icon) .'"></i>';
			}
			$output .= '</div>';
			$output .= '</div>';
			
			return $output;
		}
		
		add_shortcode('ozy_vc_calltoactionbox', 'ozy_vc_calltoactionbox');
		
		vc_map( array(
			"name" => esc_attr__("Call To Action Box", "ozy-salon-essentials"),
			"base" => "ozy_vc_calltoactionbox",
			"content_element" => true,
			"show_settings_on_create" => true,
			"icon" => "icon-wpb-ozy-el",
			'category' => 'by OZY',
			"params" => array(
				array(
					"type" => "attach_image",
					"class" => "",
					"heading" => esc_attr__("Image", "ozy-salon-essentials"),
					"param_name" => "image",
					"admin_label" => false,
					"value" => ""
				),		
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Caption", "ozy-salon-essentials"),
					"param_name" => "caption",
					"admin_label" => true,
					"value" => esc_attr__("Box Title", "ozy-salon-essentials")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Height", "ozy-salon-essentials"),
					"param_name" => "box_height",
					"admin_label" => true,
					"value" => "640px"
				),
				array(
					"type" => "select_an_icon",
					"heading" => esc_attr__("Icon", "ozy-salon-essentials"),
					"param_name" => "icon",
					"value" => '',
					"admin_label" => false
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Link Caption", "ozy-salon-essentials"),
					"param_name" => "link_caption",
					"admin_label" => true,
					"value" => esc_attr__("SHOP USED EQUIPMENT &rarr;", "ozy-salon-essentials")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Link", "ozy-salon-essentials"),
					"param_name" => "link",
					"admin_label" => true
				),
				array(
					"type" => "dropdown",
					"heading" => esc_attr__("Link Target", "ozy-salon-essentials"),
					"param_name" => "link_target",
					"value" => array("_self", "_blank", "_parent"),
					"admin_label" => false,
					"description" => esc_attr__("Select link target window.", "ozy-salon-essentials")
				),	
				$add_css_animation,
				array(
					"type" => "textfield",
					"heading" => esc_attr__("Extra class name", "ozy-salon-essentials"),
					"param_name" => "el_class",
					"description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "ozy-salon-essentials")
				)			
		   )
		) );
	}
	
	/**
	* Canvas Slider
	*/
	if (!function_exists('ozy_vc_canvas_slider')) {
		function ozy_vc_canvas_slider( $atts, $content = null ) {
            $atts = vc_map_get_attributes('ozy_vc_canvas_slider', $atts);
			extract(shortcode_atts(array(
				'image'			=> '',
				'extra_css'		=> '',
				'css_animation' => ''
			), $atts));
			
			if($css_animation) {
				wp_enqueue_style( 'animate-css' );
				$css_animation = ' wpb_animate_when_almost_visible wpb_'. esc_attr($css_animation) .' '. esc_attr($css_animation) .' wpb_start_animation animated ';
			}		
			
			wp_enqueue_script('tweenmax');
			wp_enqueue_script('canvas-slider');
			wp_enqueue_style('canvas-slider');

			$output='<div class="ozy-canvas-slider-wrapper '. $css_animation . ' ' . esc_attr($extra_css)  .'"><canvas id="canvas0" width="800" height="480"></canvas>
				<canvas id="canvas1" width="800" height="480"></canvas>
				<canvas id="canvas2" width="800" height="480"></canvas>
				<canvas id="canvas3" width="800" height="480"></canvas>

				<nav class="link-list">
					<ul>';
			$image = explode(',', $image);
			if(is_array($image)) {
				$data_order = 0;
				foreach($image as $img) {
					$img_src = wp_get_attachment_image_src($img, 'full');
					if(isset($img_src[0])) {
						$output .= '<li><a href="" data-order="'. $data_order .'" data-imagesrc="'. esc_url($img_src[0]) .'"></a></li>';
						$data_order++;
					}
				}
			}
			/*use following lines as button when you want to use alternate canvas slider css file*/
			/*
			<button class="show-prev"></button>
			<button class="show-next"></button>
			*/
			$output.=
			'</ul>
				</nav>
				<nav class="btns">
					<button class="show-prev"><span>'. esc_attr('PREV', 'ozy-salon-essentials') .'</span></button>
					<button class="show-next"><span>'. esc_attr('NEXT', 'ozy-salon-essentials') .'</span></button>
				</nav>
				<p class="loading-txt">'. esc_attr('Loading images...', 'ozy-salon-essentials') .'</p>
				<div class="overlay-elements-canvas">'. do_shortcode($content) .'</div>
				</div>';
			
			return $output;
		}
		
		add_shortcode('ozy_vc_canvas_slider', 'ozy_vc_canvas_slider');
		
		vc_map( array(
			"name" => esc_attr__("Canvas Slider", "ozy-salon-essentials"),
			"base" => "ozy_vc_canvas_slider",
			"as_parent" => array('except' => ''),
			"content_element" => true,
			"show_settings_on_create" => true,
			"icon" => "icon-wpb-ozy-el",
			'category' => 'by OZY',
			"params" => array(
				array(
					"type" => "attach_images",
					"class" => "",
					"heading" => esc_attr__("Image", "ozy-salon-essentials"),
					"param_name" => "image",
					"admin_label" => false,
					"value" => ""
				),
				$add_css_animation,
				array(
					"type" => "textfield",
					"heading" => esc_attr__("Extra class name", "ozy-salon-essentials"),
					"param_name" => "el_class",
					"description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "ozy-salon-essentials")
				)			
		   ),"js_view" => 'VcColumnView'
		) );

		if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
			class WPBakeryShortCode_Ozy_Vc_Canvas_Slider extends WPBakeryShortCodesContainer {}
		}		
	}	
	
	/**
	* Pointy Slider
	*/
	if (!function_exists('ozy_vc_pointy_slider')) {
		function ozy_vc_pointy_slider( $atts, $content = null ) {
            $atts = vc_map_get_attributes('ozy_vc_pointy_slider', $atts);
			extract(shortcode_atts(array(
				'extra_css'		=> '',
				'css_animation' => ''
			), $atts));
			
			if($css_animation) {
				wp_enqueue_style( 'animate-css' );
				$css_animation = ' wpb_animate_when_almost_visible wpb_'. esc_attr($css_animation) .' '. esc_attr($css_animation) .' wpb_start_animation animated ';
			}	
			
			wp_enqueue_script('pointy-slider');
			
			$GLOBALS['OZY_POINTY_SLIDER_IS_FIRST_ITEM_VISIBLE'] = ' is-visible';
			
			$output = '<div class="salon-slider-wrapper '. $css_animation . ' ' . esc_attr($extra_css)  .'">
						<ul class="salon-slider">
						'. do_shortcode($content) .'
						</ul>
						</div>';
		
			return $output;
		}
		
		add_shortcode('ozy_vc_pointy_slider', 'ozy_vc_pointy_slider');
		
		vc_map( array(
			"name" => esc_attr__("Pointy Slider", "ozy-salon-essentials"),
			"base" => "ozy_vc_pointy_slider",
			"as_parent" => array('only' => 'ozy_vc_pointy_slider_item'),
			"content_element" => true,
			"show_settings_on_create" => false,
			"icon" => "icon-wpb-ozy-el",
			'category' => 'by OZY',
			"params" => array(
				$add_css_animation,
				array(
					"type" => "textfield",
					"heading" => esc_attr__("Extra class name", "ozy-salon-essentials"),
					"param_name" => "el_class",
					"description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "ozy-salon-essentials")
				)			
		   ),"js_view" => 'VcColumnView'
		) );

		if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
			class WPBakeryShortCode_Ozy_Vc_Pointy_Slider extends WPBakeryShortCodesContainer {}
		}		
	}
	
	if (!function_exists('ozy_vc_pointy_slider_item')) {
		function ozy_vc_pointy_slider_item( $atts, $content = null ) {
            $atts = vc_map_get_attributes('ozy_vc_pointy_slider_item', $atts);
			extract(shortcode_atts(array(
				'src' 			=> '',
				'video'			=> '',
				'bg_color'		=> '',
				'title' 		=> '',
				'title_color'	=> '',
				'sub_title' 	=> '',
				'tag_title' 	=> '',
				'sub_title_color'=> '',
				'link' 			=> '',
				'link_target'	=> '_self'
			), $atts));			
			
			$bg_src = ''; $rand_class_name = 'pointy-slide-' . mt_rand();
			$src = wp_get_attachment_image_src($src, 'full');
			if(isset($src[0])) {$bg_src = esc_url($src[0]);}else{$bg_src = get_template_directory_uri() . '/images/blank-large.gif';}
			
			$output = '<li class="'. $rand_class_name . $GLOBALS['OZY_POINTY_SLIDER_IS_FIRST_ITEM_VISIBLE'] .'"><div class="salon-half-block image" style="background-image:url('. $bg_src .')">';
			if($video) {
				$output.= '<video width="100%" height="100%" '. ($GLOBALS['OZY_POINTY_SLIDER_IS_FIRST_ITEM_VISIBLE'] != '' ? 'autoplay' : '') .' loop poster="'. $bg_src .'"><source src="'. esc_url($video) .'" type="video/mp4"></video>';
			}
			$output.= '</div><div class="salon-half-block content"><div>';
			if($tag_title) $output .= '<span>'. esc_html($tag_title) .'<span></span></span>';
			//if($title) $output .= '<h2>'. ($link ? '<a href="'. esc_url($link) .'" target="'. esc_attr($link_target) .'">':'') . esc_html($title) . ($link ? '</a>':'') .'</h2>';
			if($title) {
				$output .= '<h2>';
				$link = vc_build_link($link);			
				if(is_array($link) && isset($link['url']) && $link['url']) {
					$output.= '<a href="'. esc_url($link['url']) .'" '. (isset($link['target']) ? ' target="'. esc_attr($link['target']) .'"' : '') . '>' . esc_html($title) .'</a>';
				}else{
					$output.= esc_html($title);
				}
				$output .= '</h2>';
			}			
			if($sub_title) $output .= '<p>'. esc_html($sub_title) .'</p>';
			$output	.=	'</div></div></li>';
			
			$GLOBALS['OZY_POINTY_SLIDER_IS_FIRST_ITEM_VISIBLE'] = '';
			
			global $ozySalonHelper;
			if(!function_exists('salon_get_option') || !is_object($ozySalonHelper)) return null;
			$ozySalonHelper->set_footer_style('.'. $rand_class_name .' .content{background-color:'. esc_attr($ozySalonHelper->rgba2rgb($bg_color)) .';}');
			if($title_color) { 
				$ozySalonHelper->set_footer_style('.'. $rand_class_name .' .content h2,.'. $rand_class_name .' .content h2>a{color:'. esc_attr($title_color) .' !important;}');
				$ozySalonHelper->set_footer_style('.'. $rand_class_name .' .content span>span{background-color:'. esc_attr($ozySalonHelper->rgba2rgb($title_color)) .';}');
			}
			if($sub_title_color) $ozySalonHelper->set_footer_style('.'. $rand_class_name .' .content{color:'. esc_attr($sub_title_color) .' !important;}');
			
			return $output;
		}
		
		add_shortcode('ozy_vc_pointy_slider_item', 'ozy_vc_pointy_slider_item');

		vc_map( array(
			"name" => esc_attr__("Pointy Slider Item", "ozy-salon-essentials"),
			"base" => "ozy_vc_pointy_slider_item",
			"content_element" => true,
			"as_child" => array('only' => 'ozy_vc_pointy_slider'),
			"icon" => "icon-wpb-ozy-el",
			"params" => array(
				array(
					"type" => "attach_image",
					"class" => "",
					"heading" => esc_attr__("Image", "ozy-salon-essentials"),
					"param_name" => "src",
					"admin_label" => false,
					"value" => ""
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("or Self Hosted MP4 file path", "ozy-salon-essentials"),
					"param_name" => "video",
					"admin_label" => false,
					"description" => esc_attr__("When this option is set, Image field will be used as a fallback image, so please fill Image field too.", "ozy-salon-essentials"),
					"value" => ""
				),array(
					"type" => "colorpicker",
					"heading" => esc_attr__("Background Color", "ozy-salon-essentials"),
					"param_name" => "bg_color",
					"admin_label" => false,
					"value" => "#160915"
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Title", "ozy-salon-essentials"),
					"param_name" => "title",
					"admin_label" => true,
					"value" => ""
				),array(
					"type" => "colorpicker",
					"heading" => esc_attr__("Title Color", "ozy-salon-essentials"),
					"param_name" => "title_color",
					"admin_label" => false,
					"value" => "#c09e6f"
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Sub Title", "ozy-salon-essentials"),
					"param_name" => "sub_title",
					"admin_label" => true,
					"value" => ""
				),array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Tag", "ozy-salon-essentials"),
					"param_name" => "tag_title",
					"admin_label" => true,
					"value" => ""
				),array(
					"type" => "colorpicker",
					"heading" => esc_attr__("Sub Title and Tag Color", "ozy-salon-essentials"),
					"param_name" => "sub_title_color",
					"admin_label" => false,
					"value" => "#ffffff"
				),array(
					"type" => "vc_link",
					"class" => "",
					"heading" => esc_attr__("Link", "ozy-salon-essentials"),
					"param_name" => "link",
					"admin_label" => false,
					"value" => ""
				)
		   )
		) );
		
		class WPBakeryShortCode_Ozy_Vc_Pointy_Slider_Item extends WPBakeryShortCode{}	
	}
	
	/**
	* Blockquote Box
	*/
	if (!function_exists('ozy_vc_blockquotebox')) {
		function ozy_vc_blockquotebox( $atts, $content = null ) {
            $atts = vc_map_get_attributes('ozy_vc_blockquotebox', $atts);
			extract(shortcode_atts(array(
				'image'			=> '',
				'title'			=> '',
				'sub_title1'	=> '',
				'sub_title2'	=> '',
				'image_align'	=> 'left',
				'extra_css'		=> '',
				'fn_color'		=> '',
				'css_animation' => ''
			), $atts));
			
			if($css_animation) {
				wp_enqueue_style( 'animate-css' );
				$css_animation = ' wpb_animate_when_almost_visible wpb_'. esc_attr($css_animation) .' '. esc_attr($css_animation) .' wpb_start_animation animated ';
			}	

			$image_src = wp_get_attachment_image_src($image, 'full'); $image = ''; $has_image = 'has_image';
			if(isset($image_src[0])) {
				$image = '<span class="img-wrapper" class="shared-border-color" style="background-image:url('. esc_url($image_src[0]) .')">&nbsp;</span>';
			}else{
				$has_image = '';
			}
			
			$style = ($fn_color ? ' style="color:'. esc_attr($fn_color) .'"':'');
			
			$output = '
				<div class="ozy-testimonial-quote group '. $css_animation . ' ' . $extra_css . ' ' . $image_align .'" '. $style .'>
					'. ($image_align === 'left' ? $image : '') .'
					<div class="ozy-quote-container '. $has_image .'">
						<blockquote>
							<p '. $style .'>'. $content .'</p>
						</blockquote>  
						<cite><span>'. $title .'</span><br>
							'. $sub_title1 .'
							'. ($sub_title2 ? '<br>' . $sub_title2 : '') .'
						</cite>
					</div>
					'. ($image_align === 'right' ? $image : '') .'
				</div>';
			
			return $output;
		}
		
		add_shortcode('ozy_vc_blockquotebox', 'ozy_vc_blockquotebox');
		
		vc_map( array(
			"name" => esc_attr__("Blockquote Box", "ozy-salon-essentials"),
			"base" => "ozy_vc_blockquotebox",
			"content_element" => true,
			"show_settings_on_create" => true,
			"icon" => "icon-wpb-ozy-el",
			'category' => 'by OZY',
			"params" => array(
				array(
					"type" => "attach_image",
					"class" => "",
					"heading" => esc_attr__("Image", "ozy-salon-essentials"),
					"param_name" => "image",
					"admin_label" => false,
					"value" => ""
				),		
				array(
					"type" => "textarea",
					"class" => "",
					"heading" => esc_attr__("Quote", "ozy-salon-essentials"),
					"param_name" => "content",
					"admin_label" => true
				),				
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Title", "ozy-salon-essentials"),
					"param_name" => "title",
					"admin_label" => true
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Sub Title #1", "ozy-salon-essentials"),
					"param_name" => "sub_title1",
					"admin_label" => true
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Sub Title #2", "ozy-salon-essentials"),
					"param_name" => "sub_title2",
					"admin_label" => true
				),
				array(
					"type" => "dropdown",
					"heading" => esc_attr__("Align", "ozy-salon-essentials"),
					"param_name" => "image_align",
					"value" => array("left", "right")
				),array(
					"type" => "colorpicker",
					"heading" => esc_attr__("Foreground Color", "ozy-salon-essentials"),
					"param_name" => "fn_color",
					"admin_label" => false,
					"value" => ""
				),	
				$add_css_animation,
				array(
					"type" => "textfield",
					"heading" => esc_attr__("Extra class name", "ozy-salon-essentials"),
					"param_name" => "el_class",
					"description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "ozy-salon-essentials")
				)			
		   )
		) );
	}	
	
	/**
	* Padding Box
	*/
	if (!function_exists('ozy_vc_anywrapper2')) {
		function ozy_vc_anywrapper2( $atts, $content = null ) {
            $atts = vc_map_get_attributes('ozy_vc_anywrapper2', $atts);
			extract(shortcode_atts(array(
				'width' => '100%',
				'text_align' => 'left',
				'padding_top' => '30px',
				'padding_right' => '30px',
				'padding_bottom' => '30px',
				'padding_left' => '30px',
				'bg_color' => '',
				'border_color' => '',
				'border_width' => '1px',
				'border_style' => 'none'
			), $atts));
					
			$rand_el_id = 'oawx-' . rand(0, 100000);

			global $ozySalonHelper;
			if(!function_exists('salon_get_option') || !is_object($ozySalonHelper)) return null;

			$inline_style = 'text-align:'. esc_attr($text_align) .';width:'. esc_attr($width) .';padding:'. esc_attr($padding_top) .' '. esc_attr($padding_right) .' '. esc_attr($padding_bottom) .' '. esc_attr($padding_left);
			$ozySalonHelper->set_footer_style('@media only screen and (min-width: 479px) {#'. $rand_el_id .'{'. $inline_style .'}}');
			
			$inline_style = '';
			if($bg_color && $bg_color != 'transparent') { $inline_style.=';background-color:'.esc_attr($bg_color); }
			if($border_color && $border_width && $border_style && $border_style != 'none') { $inline_style.=';border:' . esc_attr($border_width) . ' ' . esc_attr($border_style) . ' ' . esc_attr($border_color); }
						
			$ozySalonHelper->set_footer_style('#'. $rand_el_id .'{'. $inline_style .'}');
			
			return '<div id="'. esc_attr($rand_el_id) .'" class="ozy-anything-wrapper-x">'. do_shortcode($content) .'</div>';

		}
		
		add_shortcode('ozy_vc_anywrapper2', 'ozy_vc_anywrapper2');
		
		vc_map( array(
			"name" => esc_attr__("Padding Box", "ozy-salon-essentials"),
			"base" => "ozy_vc_anywrapper2",
			"as_parent" => array('except' => 'ozy_vc_iabox,ozy_vc_flipbox'),
			"content_element" => true,
			"show_settings_on_create" => false,
			"icon" => "icon-wpb-ozy-el",
			'category' => 'by OZY',			
			"params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_attr__("Width", "ozy-salon-essentials"),
					"param_name" => "width",
					"admin_label" => true,
					"value" => "100%"
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_attr__("Text Align", "ozy-salon-essentials"),
					"param_name" => "text_align",
					"admin_label" => true,
					"value" => array("left","center","right")
				),						
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_attr__("Padding Top", "ozy-salon-essentials"),
					"param_name" => "padding_top",
					"admin_label" => true,
					"value" => array("30px","0","5px","10px","15px","20px","25px","35px","40px","45px","50px","55px","60px","65px","70px","75px","80px","85px","90px","95px","100px","105px","110px","115px","120px","125px","130px","135px","140px","145px","150px","155px","160px","165px","170px","175px","180px","185px","190px","195px","200px")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_attr__("Padding Right", "ozy-salon-essentials"),
					"param_name" => "padding_right",
					"admin_label" => true,
					"value" => array("30px","0","5px","10px","15px","20px","25px","35px","40px","45px","50px","55px","60px","65px","70px","75px","80px","85px","90px","95px","100px","105px","110px","115px","120px","125px","130px","135px","140px","145px","150px","155px","160px","165px","170px","175px","180px","185px","190px","195px","200px")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_attr__("Padding Bottom", "ozy-salon-essentials"),
					"param_name" => "padding_bottom",
					"admin_label" => true,
					"value" => array("30px","0","5px","10px","15px","20px","25px","35px","40px","45px","50px","55px","60px","65px","70px","75px","80px","85px","90px","95px","100px","105px","110px","115px","120px","125px","130px","135px","140px","145px","150px","155px","160px","165px","170px","175px","180px","185px","190px","195px","200px")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_attr__("Padding Left", "ozy-salon-essentials"),
					"param_name" => "padding_left",
					"admin_label" => true,
					"value" => array("30px","0","5px","10px","15px","20px","25px","35px","40px","45px","50px","55px","60px","65px","70px","75px","80px","85px","90px","95px","100px","105px","110px","115px","120px","125px","130px","135px","140px","145px","150px","155px","160px","165px","170px","175px","180px","185px","190px","195px","200px")
				),array(
					"type" => "colorpicker",
					"heading" => esc_attr__("Background Color", "ozy-salon-essentials"),
					"param_name" => "bg_color",
					"admin_label" => false,
					"value" => "transparent"
				),array(
					"type" => "colorpicker",
					"heading" => esc_attr__("Border Color", "ozy-salon-essentials"),
					"param_name" => "border_color",
					"admin_label" => false,
					"value" => "#dedede"
				),array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_attr__("Border Width", "ozy-salon-essentials"),
					"param_name" => "border_width",
					"admin_label" => true,
					"value" => array("1px","2px","3px","4px","5px","6px","7px","8px","9px","10px","11px","12px","13px","14px","15px")
				),array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_attr__("Border Style", "ozy-salon-essentials"),
					"param_name" => "border_style",
					"admin_label" => true,
					"value" => array("none","hidden","dotted","dashed","solid","double","groove","ridge","inset","outset","initial","inherit")
				)
		   ),
		   "js_view" => 'VcColumnView'
		) );
	}

	class WPBakeryShortCode_Ozy_Vc_Anywrapper2 extends WPBakeryShortCodesContainer{}		
}
?>