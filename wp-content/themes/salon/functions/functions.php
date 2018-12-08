<?php
/**
* Load necessary style and script files
*/
function salon_enqueue_stylesheets() {

	global $ozySalonHelper, $post;
	
	/* The HTML5 Shim is required for older browsers, mainly older versions IE */	
	if($ozySalonHelper->ielt9()) {
		wp_enqueue_script('html5shim', 'http://html5shim.googlecode.com/svn/trunk/html5.js');
	}

	/*modernizr*/
	wp_enqueue_script('modernizr', SALON_BASE_URL . 'scripts/modernizr.js');

	wp_enqueue_style('style', SALON_CSS_DIRECTORY_URL . 'style.css');
		
	wp_enqueue_script('salon-global-plugins', SALON_BASE_URL . 'scripts/salon-global-plugins.js', array('jquery'), null, true );	
	
	wp_enqueue_style('ozy-fontset', SALON_BASE_URL . 'font/font.min.css');	
	wp_enqueue_style('font-awesome');
	
	/*main script file*/
	wp_enqueue_script('salon', SALON_BASE_URL . 'scripts/salon.js', array('jquery'), null, true );

	/*Following variable will be used in salon.js*/
	wp_localize_script( 'salon', 'ozy_headerType', array(
		'menu_type' => esc_js(salon_gd('menu_type')), 
		'menu_align' => esc_js(salon_gd('menu_align')), 
		'smooth_scroll' => esc_js(salon_get_option('smooth_scroll')), 
		'theme_url' => esc_js(SALON_BASE_URL),
		'$OZY_WP_AJAX_URL' => esc_url(admin_url('admin-ajax.php')),
		'$OZY_WP_IS_HOME' => (is_home() || is_front_page() ? 'true' : 'false'),
		'$OZY_WP_HOME_URL' => esc_url(home_url('/'))
		)
	);
	
	/*comment reply*/
	if ( is_singular() && comments_open() && (get_option('thread_comments') == 1)) {
		wp_enqueue_script('comment-reply');
	}

	/*fancy box*/
	wp_deregister_style('fancybox');
	wp_enqueue_style('fancybox', SALON_BASE_URL . 'scripts/vendor/fancybox/jquery.fancybox.css');
	wp_enqueue_script('fancybox', SALON_BASE_URL . 'scripts/vendor/fancybox/jquery.fancybox.pack.js', array('jquery'), null, true );
	if(salon_get_option('fancbox_media') == '1') {
		wp_enqueue_script('fancybox-media', SALON_BASE_URL . 'scripts/vendor/fancybox/helpers/jquery.fancybox-media.js', array('jquery'), null, true );
	}
	if(salon_get_option('fancbox_thumbnail') == '1') {
		wp_enqueue_style('jquery.fancybox-thumbs', SALON_BASE_URL . 'scripts/vendor/fancybox/helpers/jquery.fancybox-thumbs.css');
		wp_enqueue_script('fancybox-thumbs', SALON_BASE_URL . 'scripts/vendor/fancybox/helpers/jquery.fancybox-thumbs.js', array('jquery'), null, true );
	}	

	/* Search Page */
	if(is_search()) {
		wp_enqueue_script('masonry');
		wp_enqueue_script('imagesLoaded');
	}
	
	/* Supersized BG slider */
	if(salon_get_metabox('background_group.0.ozy_salon_meta_page_background_use_slider') == '1') {
		wp_enqueue_style( 'super-sized-css', get_template_directory_uri() . '/css/supersized.css');
		wp_enqueue_script('super-sized', get_template_directory_uri() . '/scripts/vendor/supersized/js/supersized.3.2.7.min.js', array('jquery'), null, true );
	}
	
	/* Self Hosted Video BG */
	wp_register_script('video-background', SALON_BASE_URL . 'scripts/jquery/videobg.js', array('jquery'), null, true );			
	if(salon_get_metabox('background_group.0.ozy_salon_meta_page_background_use_video_self') == '1') {
		wp_enqueue_script('video-background');
	}
	
	/* scrolltoplugin for smooth scrolling*/
	if(salon_get_option('smooth_scroll') != 0) {
		wp_enqueue_script('scrolltoplugin', '//cdnjs.cloudflare.com/ajax/libs/gsap/latest/plugins/ScrollToPlugin.min.js', array('jquery'), null, true);	
	}
	
	/* TweenMax & Canvas Slider*/
	//wp_register_script('tweenmax', '//cdnjs.cloudflare.com/ajax/libs/gsap/1.16.1/TweenMax.min.js', array('jquery'), null, true);
	wp_enqueue_script('tweenmax', '//cdnjs.cloudflare.com/ajax/libs/gsap/1.16.1/TweenMax.min.js', array('jquery'), null, true);
	wp_register_script('canvas-slider', SALON_BASE_URL . 'scripts/component/canvas-slider-init.js', array('tweenmax','jquery'), null, true);
	wp_register_style('canvas-slider', SALON_BASE_URL . 'css/canvas-slider.css');
	
	/* Button Content Box */
	wp_register_style('extended-box', SALON_BASE_URL . 'css/extended-box.css');
	wp_register_script('extended-box', SALON_BASE_URL . 'scripts/component/extended-content-init.js', array('jquery'), null, true);

	/* Pointy Slider*/
	wp_register_script('pointy-slider', SALON_BASE_URL . 'scripts/component/pointy-slider-init.js', array('jquery'), null, true);
	
	/* YouTube Video BG */
	if(salon_get_metabox('background_group.0.ozy_salon_meta_page_background_use_video_youtube') == '1') {
		wp_enqueue_script('tubular-youtube', SALON_BASE_URL . '/scripts/jquery/jquery.tubular.1.0.js', array('jquery') );
	}
	
	/* Vimeo Video BG */
	if(salon_get_metabox('background_group.0.ozy_salon_meta_page_background_use_video_vimeo') == '1') {
		wp_enqueue_script('ok-video', SALON_BASE_URL . 'scripts/jquery/ok.video.js', array('jquery') );
	}

	/* Animsition */
	salon_sd('is_animsition_active', true);
	if(!salon_get_option('disable_animsition') == '1') {
		if(is_page()) {
			if(salon_get_metabox('disable_loader') != '1') {	
				wp_enqueue_style('animsition', SALON_BASE_URL . 'css/animsition.min.css');
			}else{
				salon_sd('is_animsition_active', false);
			}
		}else{
			wp_enqueue_style('animsition', SALON_BASE_URL . 'css/animsition.min.css');		
		}
	}else{
		salon_sd('is_animsition_active', false);
	}
	wp_localize_script( 'salon', 'ozy_Animsition', array(
		'is_active' => esc_js(salon_gd('is_animsition_active')))
	);
	
	/* 404 Page */
	if(is_404()) {
		wp_enqueue_style('ozy-404', SALON_BASE_URL . 'css/404.css');
	}

	/* Light Gallery */
	wp_enqueue_script('lightgallery', SALON_BASE_URL . 'scripts/vendor/lg/lightgallery-all.min.js', array('jquery'), null, true );
	wp_enqueue_style('lightgallery.min', SALON_BASE_URL . 'css/lg/lightgallery.min.css');
	wp_enqueue_style('lg-transitions.min', SALON_BASE_URL . 'css/lg/lg-transitions.min.css');
	wp_enqueue_style('lg-fb-comment-box.min', SALON_BASE_URL . 'css/lg/lg-fb-comment-box.min.css');

	/* Expandable Call Box */
	wp_register_script('expandable-callbox', SALON_BASE_URL . 'scripts/component/expandable-callbox-init.js', array('jquery'), null, true );
	wp_register_style('expandable-callbox', SALON_BASE_URL . 'css/expandable.callbox.css');

	/* Web Animations */
	wp_register_script('web-animations', SALON_BASE_URL . 'scripts/vendor/web-animations/web-animations-next-2.2.0.min.js', array('jquery'), null, true );
	wp_register_style('photo-sharr', SALON_BASE_URL . 'css/photo-sharr.css');
	
	/* Row Wave */
	wp_register_style('row-wave', SALON_BASE_URL . 'css/row-wave.css');

	/* Flickity */
	wp_enqueue_style('salon-flickity', SALON_BASE_URL . 'css/flickity.min.css');


	/* Isotope */
	wp_register_script('isotope', SALON_BASE_URL . 'scripts/ventor/isotope/isotope.pkgd.min.js', array('jquery') );
	wp_register_script('isotope-packery', SALON_BASE_URL . 'scripts/vendor/isotope/packery-mode.pkgd.js', array('isotope') );	
		
	/*page-portfolio.php*/
	if(is_page_template('page-portfolio.php')) {
		wp_enqueue_style('ozy-portfolio', SALON_BASE_URL . 'css/portfolio.css');
		wp_enqueue_script('isotope');
		wp_enqueue_script('imagesLoaded');
	}	

	/* Portfolio Single */
	if (isset($post->post_type) && $post->post_type === 'ozy_portfolio') {
		wp_enqueue_script('lightslider', SALON_BASE_URL . 'scripts/vendor/lightslider/lightslider.min.js', array('jquery', 'lightgallery'), null, true );
		wp_enqueue_style('lightslider', SALON_BASE_URL . 'css/lightslider.min.css');
	}
	
	/* Multi Scroll */
	if (is_page_template('page-multiscroll.php')) {
		wp_enqueue_script('multiscroll', SALON_BASE_URL . 'scripts/vendor/multiscroll/multiscroll.min.js', array('jquery'), null, true );
		wp_enqueue_style('multiscroll', SALON_BASE_URL . 'css/multiscroll.css');
	}	
	
	/* Full Blog */
	if(is_page_template('page-full-blog.php')) {
		wp_enqueue_style('ozy-full-blog', SALON_BASE_URL . 'css/full-blog.css');
	}
	
	/* Hover Box Blog */
	wp_register_style('ozy-hoverbox-blog', SALON_BASE_URL . 'css/hoverbox-blog.css');
	if(is_page_template('page-hoverbox-blog.php')) {
		wp_enqueue_style('ozy-hoverbox-blog');
	}

	/* Big Blog */
	if(is_page_template('page-big-blog.php')) {
		wp_enqueue_style('ozy-big-blog', SALON_BASE_URL . 'css/big-blog.css');
	}
	
	/* Countdown template */
	if(is_page_template('page-countdown.php')) {
		wp_enqueue_script('salon-countdown', SALON_BASE_URL . 'scripts/jquery/countdown.js', array('jquery') );
		wp_enqueue_style('salon-countdown', SALON_BASE_URL . 'css/countdown.css');
		wp_enqueue_style('salon-countdown-font', '//fonts.googleapis.com/css?family=Teko');		

		$end_year 	= salon_get_option('countdown_year');$end_year = (int)$end_year<=0?date('Y'):$end_year;
		$end_month 	= salon_get_option('countdown_month');$end_month = (int)$end_month<=0?date('m'):$end_month;
		$end_day 	= salon_get_option('countdown_day');$end_day = (int)$end_day<=0?'15':$end_day;
		$end_hour 	= salon_get_option('countdown_hour');$end_hour = (int)$end_hour<=0?'23':$end_hour;
		$end_minute = salon_get_option('countdown_minute');$end_minute = (int)$end_minute<=0?'30':$end_minute;
		wp_localize_script('salon-countdown', 'ozy404assets', array('path' => esc_js(SALON_BASE_URL), '_year' => esc_js($end_year), '_month' => esc_js($end_month), '_day' => esc_js($end_day), '_hour' => esc_js($end_hour), '_minute' => esc_js($end_minute)) );
	}
	
	/* Google Fonts */
	wp_enqueue_style( 'salon-google-fonts', $ozySalonHelper->render_google_fonts(), array(), SALON_THEME_VERSION );		

	return;
}
add_action( 'wp_enqueue_scripts', 'salon_enqueue_stylesheets', 18 );


/**
* This function modifies the main WordPress query to include an array of post types instead of the default 'post' post type.
*
* @param mixed $query The original query
* @return $query The amended query
*/
function salon_custom_search( $query ) {
	if(!is_admin()) {
		if ( isset($query->is_search) && $query->is_search ) {
			$query->set( 'post_type', array( 'product', 'post', 'page', 'ozy_portfolio' ) );
		}
	}
	return $query;
};
add_filter( 'pre_get_posts', 'salon_custom_search' );

function salon_load_custom_wp_admin_style() {
	global $ozySalonHelper;
	wp_enqueue_script('ozy-admin', SALON_BASE_URL . 'scripts/admin/admin.js', array('jquery'), null, true );

    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');

	$params = array('ozy_theme_path' => esc_js(SALON_BASE_URL));
	wp_localize_script( 'ozy-admin', 'ozyAdminParams', $params );
	
	wp_enqueue_style( 'ozy-admin', SALON_BASE_URL . 'css/admin.css');	

	wp_enqueue_style('ozy-fontset', SALON_BASE_URL . 'font/ozy/styles.css');
	
	wp_enqueue_style('salon-fontset1', SALON_BASE_URL . 'font/salon1/flaticon.css');
	wp_enqueue_style('salon-fontset2', SALON_BASE_URL . 'font/salon2/flaticon.css');
	wp_enqueue_style('salon-fontset3', SALON_BASE_URL . 'font/salon3/flaticon.css');		
		
	// Color picker
	wp_enqueue_script('ozy-color-picker', SALON_BASE_URL . 'scripts/admin/color-picker/jquery.minicolors.js', false, '1.0', false);
	wp_enqueue_style('ozy-color-picker', SALON_BASE_URL . 'css/admin/jquery.minicolors.css', false, '1.0', 'all');	
	wp_enqueue_media();
	
}
add_action( 'admin_enqueue_scripts', 'salon_load_custom_wp_admin_style' );

/**
* Add page model CSS to body dag
*/
add_filter('body_class','salon_page_model_css');
function salon_page_model_css($classes) {

	global $post, $ozySalonHelper;
	
	$page_model = (salon_get_option('page_model') ? salon_get_option('page_model') : 'full');
	if(!is_search()) {
		if(salon_get_metabox('page_model') && salon_get_metabox('page_model') !== 'generic') {
			$page_model = salon_get_metabox('page_model');
		}
	}
	
	$_classes = 'ozy-page-model-' . $page_model;
	$_page_type = 'page';
	if(is_single()) { $_page_type = 'blog'; }


	$sidebar_position		= salon_get_option('page_'. $_page_type .'_sidebar_position');
	$sidebar_name			= salon_get_option('page_'. $_page_type .'_sidebar_id');
	if(!is_404() && isset($post->ID)){	
		$_post_id = $post->ID;
		$use_custom_sidebar		= salon_get_metabox('use_sidebar', 0, $_post_id);
		if($use_custom_sidebar == '1') {
			$sidebar_position 	= salon_get_metabox('sidebar_group.0.ozy_salon_meta_page_sidebar_position', 0, $_post_id);
			$sidebar_name 		= salon_get_metabox('sidebar_group.0.ozy_salon_meta_page_sidebar', 0, $_post_id);
		}
	}

	// Check for Transparent Menu option
	if(is_page()) {
		if(salon_get_metabox('use_transparent_menu')) {
			$_classes.= ' force-transparent-menu';
		}
	}

	if(!is_search() && (!is_singular('ozy_portfolio'))) {
		$_classes.= ' ozy-page-model-'. (($sidebar_position == 'left' || $sidebar_position == 'right') ? 'has' : 'no') .'-sidebar';
	}else{
		$_classes.= ' ozy-page-model-no-sidebar';
	}
	
	// Extras
	salon_sd('hide_everything_but_content', 0);
	if(is_page_template('page-countdown.php')) {
		salon_sd('hide_everything_but_content', 2);
	}else{
		$_classes.= ' ozy-classic';	
	}
	
	if(is_page_template('page-ftp-album.php') || is_page_template('page-gallery-album.php') || is_page_template('page-revo-full.php') || is_page_template('page-multiscroll.php')) {
		salon_sd('hide_everything_but_content', salon_gd('hide_everything_but_content')+1);
	}
	
	if(is_page_template('page-blank-mode.php')) {
		salon_sd('hide_everything_but_content', 999); //all blank but content
	}	
	
	// Hide page title?
	if(salon_get_metabox('hide_title') !== '1' || !is_page()) {
		$_classes.= ' has-page-title';
	}else if(salon_get_metabox('hide_title') === '1' || !is_page()) {
		$_classes.= ' no-page-title';
	}
	
	// If post / page has featured image?
	if (has_post_thumbnail()) {
		array_push($classes, 'has-featured-image');
	}	
	
	// Footer info bar
	if(salon_get_option('section_footer_info_bar' . salon_gd('wpml_current_language_')) == '1' || salon_get_metabox('footer_info_bar') == '1') {
		salon_sd('footer_info_bar', 1);	
	}
	
	// Is full page template?
	if(is_page_template('page-revo-full.php') || is_page_template('page-multiscroll.php') || is_page_template('page-blank-mode.php') || is_page_template('page-masterslider-full.php')) {
		$_classes.= ' full-page-template';
	}
	
	$classes[] = $_classes;
	
	return $classes;
}

function salon_load_custom_wp_admin_stuff() {
	include(SALON_BASE_DIR . 'include/admin-icon-list.php');
	include(SALON_BASE_DIR . 'include/admin-menu-style-editor.php');
}
add_action( 'admin_footer', 'salon_load_custom_wp_admin_stuff' );

/**
* ozy_init_test
*
* Initialize some early parameters
*/
function salon_init_test() {
	$d = new Ozy_Mobile_Detect;
	salon_sd('device_type', ($d->isMobile() ? ($d->isTablet() ? 'tablet' : 'phone') : 'computer'));
	salon_sd('script_version', $d->getScriptVersion());
	
	// Page layout width
	salon_sd('container_width', '1212'); //1528 //1600
	if(salon_get_option('page_layout_width') != '') {
		salon_sd('container_width', salon_get_option('page_layout_width'));
	}
	
	if(salon_get_metabox('layout_width') != '' 
		&& salon_get_metabox('layout_width') != 'global' 
		&& salon_get_metabox('layout_width') != salon_gd('container_width')) 
	{
		salon_sd('container_width', salon_get_metabox('layout_width'));
	}

	salon_sd('content_width', '792');//792 //828
	salon_sd('sidebar_width', '312');
	
	salon_sd('menu_type', 'classic');
	salon_sd('menu_align', salon_get_option('primary_menu_align', 'left'));
	
	salon_sd('custome_primary_menu', false);
	
	if(salon_sd('_page_content_css_name'))
		salon_sd('_page_content_css_name', '');
}
add_action( 'get_header', 'salon_init_test' );

/**
* Filter for showing attachmend counts on post listing
*/
add_filter('manage_posts_columns', 'salon_posts_columns_attachment_count', 5);
function salon_posts_columns_attachment_count($defaults){
    $defaults['wps_post_attachments'] = esc_attr__('Attached', 'salon');
    return $defaults;
}
/**
* Action for showing attachmend counts on post listing
*/
add_action('manage_posts_custom_column', 'salon_posts_custom_columns_attachment_count', 5, 2);
function salon_posts_custom_columns_attachment_count($column_name, $id){
	if($column_name === 'wps_post_attachments'){
        $attachments = get_children(array('post_parent'=>$id));
        $count = count($attachments);
        if($count !=0){echo $count;}
    }
}

/**
* salon_init_metaboxes
*
* Initialize defined meta boxes for desired post types.
*/
function salon_init_metaboxes() {
	// Built path to metabox template array file
	$ozy_salon_meta_page_tmp 		= SALON_BASE_DIR . 'admin/metabox/page.php';
	$ozy_salon_meta_font_tmp		= SALON_BASE_DIR . 'admin/metabox/ozy_custom_font.php';
	$ozy_salon_meta_page_blog_tmp 	= SALON_BASE_DIR . 'admin/metabox/page_blog_options.php';
	$ozy_salon_meta_blog_tmp 		= SALON_BASE_DIR . 'admin/metabox/blog.php';
	
	// Initialize the Metabox's object
	$ozy_salon_meta_page_tmp 		= new VP_Metabox($ozy_salon_meta_page_tmp);	
	$ozy_salon_meta_font_tmp 		= new VP_Metabox($ozy_salon_meta_font_tmp);
	$ozy_salon_meta_page_blog_tmp	= new VP_Metabox($ozy_salon_meta_page_blog_tmp);
	$ozy_salon_meta_blog_tmp 		= new VP_Metabox($ozy_salon_meta_blog_tmp);	
	
	// check if ESESENTIALS plugin is activated
	if(defined('OZY_SALON_ESSENTIALS_ACTIVATED')) {
		$ozy_salon_meta_page_portfolio_tmp = SALON_BASE_DIR . 'admin/metabox/page_portfolio_options.php';
		$ozy_salon_meta_page_portfolio_tmp	= new VP_Metabox($ozy_salon_meta_page_portfolio_tmp);
		$ozy_salon_meta_portfolio_tmp	= SALON_BASE_DIR . 'admin/metabox/portfolio.php';
		$ozy_salon_meta_portfolio_tmp 	= new VP_Metabox($ozy_salon_meta_portfolio_tmp);
	}
}
add_action( 'after_setup_theme', 'salon_init_metaboxes', 99 );

/**
* salon_print_inline_script
*
* Footer inline script. Prints defined inline script into to the footer.
*/	
function salon_print_inline_script_style() {
	global $ozySalonHelper;
	
	$ozySalonHelper->set_footer_style(salon_get_option('custom_css'));
	if($ozySalonHelper->footer_style) {
		echo "<style type=\"text/css\">\r\n";
		echo $ozySalonHelper->footer_style;
		echo "\r\n</style>\r\n";
	}

	$ozySalonHelper->set_footer_script(salon_get_option('custom_script'));
	if($ozySalonHelper->footer_script) {
		echo "<script type=\"text/javascript\">\r\n";
		echo $ozySalonHelper->footer_script;
		echo "\r\n</script>\r\n";
	}	
}
add_action( 'wp_footer', 'salon_print_inline_script_style' );

/**
* salon_add_query_vars
*
* Adds extra paremeter to existing query vars
*
* @aVars (array) Default return parameter, set by WordPress
*/	
function salon_add_query_vars($aVars) {
	$aVars[] = "replytocom"; // represents the name of the product category as shown in the URL
	return $aVars;
}
// hook add_query_vars function into query_vars
add_filter('query_vars', 'salon_add_query_vars');	

/**
* ozy_cwc_rss_post_thumbnail
*
* Adds the post thumbnail to the RSS feed
*
* @content (string) set by WordPress
*/	
function salon_cwc_rss_post_thumbnail($content) {
	global $post;
	if(isset($post->ID)) {
		if(has_post_thumbnail($post->ID)) {
			$content = '<p>' . get_the_post_thumbnail($post->ID) .
			'</p>' . get_the_content();
		}
	}
	return $content;
}
add_filter('the_excerpt_rss', 'salon_cwc_rss_post_thumbnail');
add_filter('the_content_feed', 'salon_cwc_rss_post_thumbnail');

/**
* wb_remove_version
*
* Removes the WordPress version from your header for security
*
* @count (int) Default return parameter, set by WordPress
*/	
function salon_wb_remove_version() {
	return '';
}
add_filter('the_generator', 'salon_wb_remove_version');
	
	
/**
* comment_count
*
* Removes Trackbacks from the comment cout
*
* @count (int) Default return parameter, set by WordPress
*/
function salon_comment_count( $count ) {
	if ( ! is_admin() ) {
		global $post;
		if(isset($post->ID)) {
			$comment = get_comments('status=approve&post_id=' . $post->ID);
			$comments_by_type = separate_comments( $comment );
			return count($comments_by_type['comment']);
		}
		return $count;
	} else {
		return $count;
	}
}
add_filter('get_comments_number', 'salon_comment_count', 0);

/**
* salon_excerpt_max_charlength
*
* Returns necessary sidebar CSS class definition name
*
* @charlength (int) How many words will be returned
* @cleanurl (bool) Make the returnings raw or not
* @dots (bool) Add ... end of the return
* @exceprt (string) Input string
*/
function salon_excerpt_max_charlength($charlength, $cleanurl = false, $dots = true, $excerpt = '') {
	if(!$excerpt) {
		$excerpt =  get_the_excerpt();
	}
	$charlength++;
	$r = "";
	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			$r.= mb_substr( $subex, 0, $excut );
		} else {
			$r.= $subex;
		}
		if($dots) $r.= '...';
	} else {
		$r.= $excerpt;
	}
	
	return $cleanurl ?  salon_cleaner($r) : $r;
}

/**
* salon_cleaner
*
* Used to make a raw string
*
* @string (string) Input string
*/
function salon_cleaner($string) {
	return preg_replace('/\b(https?):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $string);		
}
	
function salon_get_option($opt_name, $default = null) {
	if($default) {
		if(!vp_option('vpt_ozy_salon_option.ozy_salon_' . $opt_name)) {
			return $default;
		}else{
			return wp_kses(vp_option('vpt_ozy_salon_option.ozy_salon_' . $opt_name), wp_kses_allowed_html());
		}
	}else{
		return wp_kses(vp_option('vpt_ozy_salon_option.ozy_salon_' . $opt_name), wp_kses_allowed_html());
	}
}

function salon_get_metabox($opt_name, $default = null, $post_id = null) {
	return wp_kses(vp_metabox('ozy_salon_meta_page.ozy_salon_meta_page_' . $opt_name, $default, $post_id), wp_kses_allowed_html());
}

function salon_safe_html_output($input) {
	return wp_kses($input, wp_kses_allowed_html());
}

/**
* salon_sidebar_check
*
* Returns necessary sidebar CSS class definition name
*
* @sidebar_position (string)
*/
function salon_sidebar_check($sidebar_position) {
	global $post;
	if(is_search() || (isset($post->post_type) && $post->post_type === 'ozy_portfolio')) return 'no-sidebar ';
	switch($sidebar_position) {
		case 'full':
			return 'no-sidebar ';
		case 'left':
			return 'left-sidebar ';
		case 'right':
			return 'right-sidebar ';
		default:
			return 'no-sidebar ';
	}		
}
	
/** 
* A pagination function 
*
* @param integer $range: The range of the slider, works best with even numbers 
*
* Used WP functions: 
* get_pagenum_link($i) - creates the link, e.g. http://site.com/page/4 
* previous_posts_link('<span class="prev">&nbsp;</span>'); - returns the Previous page link 
* next_posts_link('<span class="next">&nbsp;</span>'); - returns the Next page link 
*/  
function salon_get_pagination($before='',$after='',$range = 4) {  
	// output variable
	$output = "";
	
	$paged = 0;
	if (get_query_var('paged')) {
		$paged = get_query_var('paged');
	}elseif( get_query_var('page') ) {
		$paged = get_query_var('page');
	}else{
		$paged = 1;
	}

	// $paged - number of the current page  
	global $wp_query; 
	// How much pages do we have?  
	if ( !isset($max_page) ) {  
		$max_page = $wp_query->max_num_pages;  
	}  
	// We need the pagination only if there are more than 1 page  
	if($max_page > 1){
	
		$output .= $before;
		
		if(!$paged){  
			$paged = 1;  
		}  
		// On the first page, don't put the First page link  
		if($paged != 1){  
			$output .= ' <a href=' . get_pagenum_link(1) . '><span>&laquo;</span></a>';  		  
		}  
		// To the previous page  
		$output .= get_previous_posts_link('<span>&larr;</span>');  
		// We need the sliding effect only if there are more pages than is the sliding range  
		if($max_page > $range){  
			// When closer to the beginning  
			if($paged < $range){  
				for($i = 1; $i <= ($range + 1); $i++){  
					$output .= "<a href='" . get_pagenum_link($i) ."'";  
					if($i==$paged) $output .= "class='current'";  
					$output .= ">$i</a>";  
				}  
			}  
			// When closer to the end  
			elseif($paged >= ($max_page - ceil(($range/2)))){  
				for($i = $max_page - $range; $i <= $max_page; $i++){  
				$output .= "<a href='" . get_pagenum_link($i) ."'";  
				if($i==$paged) $output .= " class='current'";  
				$output .= ">$i</a>";  
			}  
		}  
		// Somewhere in the middle  
		elseif($paged >= $range && $paged < ($max_page - ceil(($range/2)))){  
			for($i = ($paged - ceil($range/2)); $i <= ($paged + ceil(($range/2))); $i++){  
				$output .= "<a href='" . get_pagenum_link($i) ."'";  
				if($i==$paged) $output .= " class='current'";  
				$output .= ">$i</a>";  
			}  
		}  
	}  
	// Less pages than the range, no sliding effect needed  
	else{  
		for($i = 1; $i <= $max_page; $i++){  
			$output .= "<a href='" . get_pagenum_link($i) ."'";  
			if($i==$paged) $output .= " class='current'";  
			$output .= ">$i</a>";  
		}  
	}  
	// Next page  
	$output .= get_next_posts_link('<span>&rarr;</span>');  
	// On the last page, don't put the Last page link  
	if($paged != $max_page){  
		$output .= ' <a href=' . get_pagenum_link($max_page) . '><span>&raquo;</span></a>';  
	}  

	$output .= $after;
	} 

	return $output;
}	

/**
* salon_add_extra_page
*
* Category id in body and post class
*
* @classes (array) Exisiting definitions
*/
function salon_category_id_class($classes) {
	global $post;
	if(isset($post->ID)) {
		foreach((get_the_category($post->ID)) as $category) {
			$classes [] = 'cat-' . $category->cat_ID . '-id';			
		}
	}
	return $classes;
}
add_filter('post_class', 'salon_category_id_class');
add_filter('body_class', 'salon_category_id_class');

/**
* salon_has_thumb_class
*
* Adds a class to the post if there is a thumbnail
*
* @classes (array) Exisiting definitions
*/
function salon_has_thumb_class($classes) {
	global $post;
	if(isset($post->ID)){
		if( has_post_thumbnail($post->ID) ) { 
			$classes[] = 'has_thumb'; 
		}
	}
	return $classes;
}
add_filter('post_class', 'salon_has_thumb_class');

function salon_return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }
    return $val;
}

function salon_check_limit_size($a, $r) {
	if((int)$r > (int)$a) {
		return "red-text";
	}
	return "green-text";
}

/**
* salon_ajax_auto_install_revo_slider
*
* Like button handling function. Parameters passed by GET
*/
function salon_ajax_auto_install_revo_slider() {

	error_reporting(0); /*DISABLE ERROR REPORTING*/

	$selected_sliders = isset($_GET["selected_sliders"]) ? (sanitize_text_field($_GET["selected_sliders"])) : NULL;
	
	if($selected_sliders != NULL) {
		$selected_sliders = explode(',', $selected_sliders);
		
		if(count($selected_sliders)) {
			$slider_array = array();
			foreach($selected_sliders as $slider) {
				$slider_array[] = get_template_directory() . "/samples/sliders/". $slider .".zip";
			}

			$absolute_path = __FILE__;
			$path_to_file = explode( 'wp-content', $absolute_path );
			$path_to_wp = $path_to_file[0];

			$slider = new RevSlider();
			 
			foreach($slider_array as $filepath){
				$slider->importSliderFromPost(true, true, $filepath);  
			}
			exit();		
		}else{
			echo 'Nothing Imported';
			exit();
		}
	}
	echo 'Nothing Imported. Please make sure Revolution Slider installed and activated.';
	exit();

}
add_action( 'wp_ajax_salon_ajax_auto_install_revo_slider', 'salon_ajax_auto_install_revo_slider' ); 

/**
* salon_ajax_like
*
* Like button handling function. Parameters passed by GET
*/
function salon_ajax_like() {
	
	$id = isset($_GET["vote_post_id"]) ? (sanitize_text_field($_GET["vote_post_id"])) : 0;
	
	if((int)$id <= 0) die( 'Invalid Operation' );
	
	$like_count = (int)get_post_meta((int)$id, "ozy_post_like_count", true);
	
	update_post_meta((int)$id, "ozy_post_like_count", $like_count + 1);
	
	echo $like_count + 1;

	exit();

}
add_action( 'wp_ajax_nopriv_salon_ajax_like', 'salon_ajax_like' ); 
add_action( 'wp_ajax_salon_ajax_like', 'salon_ajax_like' ); 

/**
* salon_ajax_load_more
*
* Load more posts for blog and portfolio. Parameters passed by GET
*/
function salon_ajax_load_more() {
	
	global $ozySalonHelper;
	
	$order 			= isset($_GET["p_order"]) 			? esc_sql($_GET["p_order"]) 			: '';
	$orderby 		= isset($_GET["p_orderby"]) 		? esc_sql($_GET["p_orderby"]) 			: '';
	$item_count 	= isset($_GET["p_item_count"]) 		? esc_sql($_GET["p_item_count"]) 		: '';
	$category_name 	= isset($_GET["p_category_name"]) 	? esc_sql($_GET["p_category_name"]) 	: '';
	$offset 		= isset($_GET["p_offset"]) 			? esc_sql($_GET["p_offset"]) 			: '';
	$layout_type	= isset($_GET["p_layout_type"]) 	? esc_sql($_GET["p_layout_type"]) 		: 'folio';
	
	$post_type = 'post';
	switch($layout_type) {
		case 'portfolio':
			$post_type = 'ozy_portfolio';
			break;
		default:
			$post_type = 'post';
	}
	
	$args = array(
		'post_type' 		=> $post_type,
		'offset'			=> $offset,
		'posts_per_page' 	=> ( (int)$item_count <= 0 ? get_option("posts_per_page") : ((int)$item_count > 0 ? $item_count : 6) ),		
		'orderby' 			=> $orderby,
		'order' 			=> $order,
		'ignore_sticky_posts' 	=> 1,		
		'tax_query' => array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array( 'post-format-quote', 'post-format-status', 'post-format-link' ),
				'operator' => 'NOT IN'
			)
		)
	);
	
	if($layout_type === 'portfolio') {
		$terms = explode(',', $category_name);
		if(is_array($terms) && count($terms)>0 && isset($terms[0]) && $terms[0]) {
			$args['tax_query'] = array(
						array(
							'taxonomy' 	=> 'portfolio_category',
							'field' 	=> 'id',
							'terms' 	=> $terms,
							'operator' 	=> 'IN'
						),
					);
		}
	}else{
		$args['cat'] = $category_name;
	}

	$the_query = new WP_Query( $args );
	if('portfolio' === $layout_type) {
		include(SALON_BASE_DIR . 'include/loop-ajax-portfolio-posts.php');
	}else{
		include(SALON_BASE_DIR . 'include/loop-ajax-posts.php');
	}
	
	exit();
}
add_action( 'wp_ajax_nopriv_salon_ajax_load_more', 'salon_ajax_load_more' ); 
add_action( 'wp_ajax_salon_ajax_load_more', 'salon_ajax_load_more' ); 

/**
* salon_grab_ids_from_gallery
*
* In some page templates we are only using attachment IDs from gallery shortcode
*/
function salon_grab_ids_from_gallery() {
	global $post;
	$attachment_ids = array();
	$pattern = get_shortcode_regex();
	$ids = array();
	
	if(isset($post->post_content)) {
		if (preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches ) ) { //finds the     "gallery" shortcode and puts the image ids in an associative array at $matches[3]
			$count=count($matches[3]); //in case there is more than one gallery in the post.
			for ($i = 0; $i < $count; $i++){
				$atts = shortcode_parse_atts( $matches[3][$i] );
				if ( isset( $atts['ids'] ) ){
					$attachment_ids = explode( ',', $atts['ids'] );
					$ids = array_merge($ids, $attachment_ids);
				}
			}
		}
	}
	
	return $ids;
}

/**
* salon_add_video_embed_title
*
* In regular blog post we are using WordPress embeds as featured media before the title.
*
* @html (string)
* @url (string)
* @attr (string)
*/
function salon_add_video_embed_title($html, $url, $attr) {
	if(salon_gd('ozy_temporary_post_format') != '' && (salon_gd('current_theme_template') == 'page-regular-blog.php' || salon_gd('current_theme_template') == 'index.php' || is_single())) {
		salon_sd('media_object', '<div class="post-' . salon_gd('ozy_temporary_post_format') . '">' . (salon_gd('ozy_temporary_post_format') === 'video' ? '<div class="ozy-video-wrapper">'. $html .'</div>' : $html )  . '</div>');
		return '';
	}
	return $html;
}
add_filter('embed_oembed_html', 'salon_add_video_embed_title', 99, 4);

/**
* salon_template_include
*
* Finds and sets 'current_theme_template' current page template name.
*
* @t (unknown) set by WordPress
*/
function salon_template_include( $t ){
	salon_sd('current_theme_template', basename($t));
    return $t;
}
add_filter( 'template_include', 'salon_template_include', 1 );

/**
* custom_excerpt_length
*
* Set how many words we want on excerpt.
*
* @length (int) required for WordPress
*/
function salon_custom_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'salon_custom_excerpt_length', 999 );

/**
* ozy_enable_more_buttons
*
* Add more buttons to the visual editor
*
* @buttons (array) early defined buttons on editor
*/
function salon_enable_more_buttons($buttons) {
	$buttons[] = 'hr';
	$buttons[] = 'sub';
	$buttons[] = 'sup';
	$buttons[] = 'fontselect';
	$buttons[] = 'fontsizeselect';
	$buttons[] = 'cleanup';
	$buttons[] = 'charmap';
	return $buttons;
}
add_filter( 'mce_buttons_3', 'salon_enable_more_buttons' );

/**
* ozy_customize_text_sizes
*
* Add custom text sizes in the font size drop down list of the rich text editor (TinyMCE) in WordPress.
* Value 'theme_advanced_font_sizes' needs to be added, if an overwrite to the default font sizes in the list, is needed.
*
* @initArray (array)  is a variable of type array that contains all default TinyMCE parameters.
*/
function salon_customize_text_sizes($initArray){
	$initArray['theme_advanced_font_sizes'] = "10px,11px,12px,13px,14px,15px,16px,17px,18px,19px,20px,21px,22px,23px,24px,25px,26px,27px,28px,29px,30px,32px,48px,60px,72px,84px,96px,108px,120px";
	return $initArray;
}
add_filter('tiny_mce_before_init', 'salon_customize_text_sizes');

/**
 * Extended Walker class for use with the
 * Twitter Bootstrap toolkit Dropdown menus in Wordpress.
 * Edited to support n-levels submenu.
 * @author johnmegahan https://gist.github.com/1597994, Emanuele 'Tex' Tessore https://gist.github.com/3765640
 */
class BootstrapNavMenuWalker extends Walker_Nav_Menu {
	function start_lvl( &$output, $depth = 0 , $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$submenu = ($depth > 0) ? ' sub-menu' : '';
		$output	   .= "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth\">\n";
	}
 
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) 
	{		 
		if (!is_object($args))
			return false;
		
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
 
		$li_attributes = '';
		$class_names = $value = '';
 
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		
		// managing divider: add divider class to an element to get a divider before it.
		$divider_class_position = array_search('divider', $classes);
		if($divider_class_position !== false){
			$output .= "<li class=\"divider\"></li>\n";
			unset($classes[$divider_class_position]);
		}
		
		$classes[] = ($args->has_children) ? 'dropdown' : '';
		$classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
		$classes[] = 'menu-item-' . $item->ID;
		if($depth && $args->has_children){
			$classes[] = 'dropdown-submenu';
		}
 
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		
		$class_names = ' class="' . esc_attr( $class_names ) . '"';
 
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		$li_attributes .= ! empty( $item->title ) ? ' data-text="'  . esc_attr( apply_filters( 'the_title', $item->title, $item->ID ) ) .'"' : '';
		$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';
 
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';			
		$attributes .= ($args->has_children) 	    ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';
 
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;
 
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	
 
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
		if ( !$element )
			return;

		$id_field = $this->db_fields['id'];

		//display this element
		if ( is_array( $args[0] ) )
			$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
		else if ( is_object( $args[0] ) )
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'start_el'), $cb_args);
 
		$id = $element->$id_field;
 
		// descend only when the depth is right and there are childrens for this element
		if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {
 
			foreach( $children_elements[ $id ] as $child ){
 
				if ( !isset($newlevel) ) {
					$newlevel = true;
					//start the child delimiter
					$cb_args = array_merge( array(&$output, $depth), $args);
					call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
				}
				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
			unset( $children_elements[ $id ] );
		}
 
		if ( isset($newlevel) && $newlevel ){
			//end the child delimiter
			$cb_args = array_merge( array(&$output, $depth), $args);
			call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
		}
 
		//end this element
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'end_el'), $cb_args);
	}
}

/**
* ozy_run_on_template_include
*
* We are using dynamic slug for portfolio, so handle it.
*
* @template (string) early defined by WordPress
*/
function salon_run_on_template_include($template){
    global $wp_query;
	if(isset($wp_query->query['post_type']) && $wp_query->query['post_type'] === 'ozy_portfolio') {
		$template = SALON_BASE_DIR . 'single-portfolio.php';
	}
    return $template;
}
add_filter('template_include', 'salon_run_on_template_include', 1, 1);

/*
* salon_portfolio_gallery_converter
*
* Custom gallery output only for Portfolio post type
*/
function salon_portfolio_gallery_converter( $output, $attr ) {
	extract( shortcode_atts( array(
		'include'    => ''
	), $attr ) );

	$attachments = explode(',', $include);
 
	$output = '<ul class="ozy-light_slider">';
	foreach($attachments as $attachment_id) {
		$attachment = get_post($attachment_id);
		$thumb_image = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
		if(is_array($thumb_image) && count($thumb_image)>0) {									
			$output .= '<li data-thumb="'. esc_url($thumb_image[0]) .'" data-src="'. esc_url($attachment->guid) .'" data-sub-html="'. ($attachment->post_title ? '<h3>' . esc_attr($attachment->post_title) . '</h3>' : '') . ($attachment->post_excerpt ? '<p>' . esc_attr($attachment->post_excerpt) . '</p>' : '')  .'"><img src="'. esc_url($attachment->guid) .'" alt=""/>';			
			$output .= '</li>';
		}
	}
	$output .= '</ul>'; 
	
	return $output;
}
 
// Apply filter to default gallery shortcode only for Portfolio post type
function salon_portfolio_gallery_init_check() {
	if(is_singular('ozy_portfolio')) {
		add_filter( 'post_gallery', 'salon_portfolio_gallery_converter', 10, 2 );
	}
}
add_action( 'wp', 'salon_portfolio_gallery_init_check' );

function salon_portfolio_related_posts_content_filter($content) {
	if ( is_singular('ozy_portfolio') ):	
		global $post;
		$original_post = $post; //save original post for rest of the page		
		$args = array(
			'post_type' 			=> 'ozy_portfolio',
			'post__not_in' 			=> array($post->ID),
			'posts_per_page'		=> 15,
			'ignore_sticky_posts' 	=> 1,
			'meta_key' 				=> '_thumbnail_id',
			'orderby'				=> 'rand'
		);

		$related_posts_query = new WP_Query($args);
		if( $related_posts_query->have_posts() ) {
			$html = '<h2 class="portfolio-h2-title">'. esc_html__('Galleries', 'salon') .'</h2>';
			$html .= '<ul class="ozy-light_slider_carousel">';			
			while ($related_posts_query->have_posts()) : $related_posts_query->the_post();
				$html .= '<li>'. get_the_post_thumbnail(get_the_ID(), 'sixteennine') . '<a href="'. esc_url(get_permalink()) .'"><span><span class="slide-title heading-font content-color-alternate3">' . get_the_title() . '</span><span class="shared-border-color"></span><span class="slide-view-gallery">'. esc_html('View Gallery', 'salon') .'</span></span></a></li>';
			endwhile;
			$html .= '</ul>';
			$content .= $html;
		}		
		$post = $original_post;
		wp_reset_query();
		
	endif;

	return $content;
}
add_filter( 'the_content', 'salon_portfolio_related_posts_content_filter' );


/**
* Header slider check
*/
function salon_check_header_slider() {
	if(is_search()) return array('','');
	
	$slider_type = $slider_alias = '';
	if ( have_posts() && 
		!is_page_template('page-revo-full.php') && !is_page_template('page-multiscroll.php') && !is_page_template('page-blank-mode.php') )
	{
		wp_reset_postdata();
		global $post;
		$post_id = isset($post->ID) ? $post->ID : 0;
		
		/*Revolution slider*/
		$revo_slider_alias = salon_get_metabox('revolution_slider', null, $post_id);
		if( $revo_slider_alias != '-1' && $revo_slider_alias != '' && function_exists('putRevSlider') ) {
			$slider_type 	= 'revo';
			$slider_alias 	= $revo_slider_alias;
		}

		/*Master slider*/
		$master_slider_alias = salon_get_metabox('master_slider', null, $post_id);
		if( $master_slider_alias != '-1' && $master_slider_alias != '' && function_exists('masterslider') ) {
			$slider_type 	= 'master';
			$slider_alias 	= $master_slider_alias;
		}
	}
	return array($slider_type, $slider_alias);			
}

/**
* Adds header slider if defined on metaboxes
*/
function salon_put_header_slider($args) {
	if(!is_page_template('page-revo-full.php') && !is_page_template('page-multiscroll.php') && !is_page_template('page-blank-mode.php') && !is_page_template('page-masterslider-full.php')) {	
		if(is_array($args) && isset($args[0]) && $args[0]) {
			echo '<div class="ozy-header-slider">';
			if($args[0] == 'revo') {
				if(function_exists('putRevSlider')) putRevSlider( $args[1] );
			} else if($args[0] == 'master') {
				if(function_exists('masterslider')) masterslider( $args[1] );
			}		
			echo '</div><!--#header-slider-->';
		}
	}
}		

/**
* Footer slider check
*/
function salon_check_footer_slider() {
	if(is_search()) return array('','');
		
	$slider_type = $slider_alias = '';
	if ( have_posts() && 
		!is_page_template('page-revo-full.php') && !is_page_template('page-multiscroll.php') && !is_page_template('page-blank-mode.php') && 
		salon_get_metabox('use_footer_slider') == '1' )
	{
		/*Revolution slider*/
		$revo_slider_alias = salon_get_metabox('use_footer_slider_group.0.ozy_salon_meta_page_revolution_footer_slider');
		if( $revo_slider_alias != '-1' && $revo_slider_alias != '' && function_exists('putRevSlider') ) {
			$slider_type 	= 'revo';
			$slider_alias 	= $revo_slider_alias;
		}
		
		/*Master slider*/
		$master_slider_alias = salon_get_metabox('use_footer_slider_group.0.ozy_salon_meta_page_master_footer_slider');
		if( $master_slider_alias != '-1' && $master_slider_alias != '' && function_exists('masterslider') ) {
			$slider_type 	= 'master';
			$slider_alias 	= $master_slider_alias;
		}		
	}
	return array($slider_type, $slider_alias);
}

/**
* Add footer slider to page if defined on metaboxes
*/
function salon_put_footer_slider($args) {
	if(is_array($args) && isset($args[0]) && $args[0]) {
		echo '<div class="ozy-footer-slider">';
		if($args[0] == 'revo') {
			putRevSlider( $args[1] );
		} else if($args[0] == 'master') {
			masterslider( $args[1] );
		}
		echo '</div><!--#footer-slider-->';
	}
}

/**
* Load theme options generic metabox parameters for blog
*/
function salon_blog_meta_params() {
	/*post per load*/
	$post_per_load 			= (int)vp_metabox('ozy_salon_meta_page_blog.ozy_salon_meta_page_blog_count');
	
	/*order & order by*/
	$order = 'ASC'; $orderby = 'date';
	$order_orderby			= vp_metabox('ozy_salon_meta_page_blog.ozy_salon_meta_page_blog_order');
	$order_orderby			= explode('-', $order_orderby);
	if(is_array($order_orderby) && isset($order_orderby[0]) && isset($order_orderby[1])) {
		$order = $order_orderby[1]; $orderby = $order_orderby[0];
	}
	
	/*check if category filter set for blog page*/
	$include_categories = vp_metabox('ozy_salon_meta_page_blog.ozy_salon_meta_page_blog_category');
	if(is_array($include_categories) && isset($include_categories[0]) && $include_categories[0] != '-1') {
		//user not choosed to show all categories
		$include_categories = join(',', $include_categories);
	}else{
		$include_categories = '';
	}
	
	salon_sd('_blog_order', $order);
	salon_sd('_blog_orderby', $orderby);
	salon_sd('_blog_include_categories', $include_categories);
	salon_sd('_blog_post_per_load', $post_per_load);
}

/**
* Load theme options generic metabox parameters for pages / posts
*/
function salon_page_meta_params($opt_param = "page") {
	global $ozySalonHelper;

	/*background slider*/
	$background_use_slider = salon_get_metabox('background_group.0.ozy_salon_meta_page_background_use_slider');
	if($background_use_slider == '1') {
		$ozySalonHelper->fullscreen_slide_show();
	}	
	/*custom page options*/
	$hide_page_title		= salon_get_metabox('hide_title');
	$hide_page_content 		= salon_get_metabox('hide_content');
	$custom_page_title		= salon_get_metabox('use_custom_title') == '1' ? salon_get_metabox('custom_title') : '';
	$use_custom_sidebar		= salon_get_metabox('use_sidebar');
	
	/*generic sidebar options*/
	$sidebar_position		= salon_get_option('page_'.$opt_param.'_sidebar_position');
	$sidebar_name			= salon_get_option('page_'.$opt_param.'_sidebar_id');
	
	/*custom sidebar used?*/
	if($use_custom_sidebar == '1') {
		$sidebar_position 	= salon_get_metabox('sidebar_group.0.ozy_salon_meta_page_sidebar_position');
		$sidebar_name 		= salon_get_metabox('sidebar_group.0.ozy_salon_meta_page_sidebar');
	}
	
	/*sidebar check*/
	$content_css_name = salon_sidebar_check($sidebar_position);
	
	if($hide_page_title !== '1') {
		$content_css_name.= ' has-title ';
	}

	if(!$ozySalonHelper->has_shortcode('vc_row') || !function_exists('vc_map') && (!is_single())) {
		$content_css_name.= ' no-vc ';
	}

	salon_sd('_page_background_use_slider', $background_use_slider);
	salon_sd('_page_hide_page_title', salon_gd('_page_hide_page_title') && salon_gd('_page_hide_page_title') != '0' ? salon_gd('_page_hide_page_title') : $hide_page_title);
	salon_sd('_page_hide_page_content', $hide_page_content);
	salon_sd('_page_custom_page_title', $custom_page_title);
	salon_sd('_page_use_custom_sidebar', $use_custom_sidebar);
	salon_sd('_page_sidebar_position', $sidebar_position);
	salon_sd('_page_sidebar_name', $sidebar_name . salon_gd('wpml_current_language_'));
	if(salon_gd('_page_content_css_name')) 
		salon_sd('_page_content_css_name', '');
	
	salon_sd('_page_content_css_name', salon_gd('_page_content_css_name') . $content_css_name);	
}

/**
* Load theme options generic metabox parameters for pages
*/
function salon_page_master_meta_params() {
	wp_reset_postdata();
	global $ozySalonHelper;
	// background slider
	if(salon_get_metabox('use_custom_background') == '1') {
		$meta_opt_path = 'ozy_salon_meta_page.ozy_salon_meta_page_background_group.0.ozy_salon_meta_page_background_video';
		if(salon_get_metabox('background_group.0.ozy_salon_meta_page_background_use_slider') == '1') {
			$ozySalonHelper->fullscreen_slide_show();
		}
		if(salon_get_metabox('background_group.0.ozy_salon_meta_page_background_use_video_self') == '1') {
			$ozySalonHelper->fullscreen_video_show(
				vp_metabox($meta_opt_path . '_self_group.0.ozy_salon_meta_page_background_video_self_image'),
				vp_metabox($meta_opt_path . '_self_group.0.ozy_salon_meta_page_background_video_self_mp4'),
				vp_metabox($meta_opt_path . '_self_group.0.ozy_salon_meta_page_background_video_self_webm'),
				vp_metabox($meta_opt_path . '_self_group.0.ozy_salon_meta_page_background_video_self_ogv')
			);
		}
		if(salon_get_metabox('background_group.0.ozy_salon_meta_page_background_use_video_youtube') == '1') {
			$ozySalonHelper->fullscreen_youtube_video_show(
				vp_metabox($meta_opt_path . '_youtube_group.0.ozy_salon_meta_page_background_video_youtube_image'),
				vp_metabox($meta_opt_path . '_youtube_group.0.ozy_salon_meta_page_background_video_youtube_id')
			);
		}
		if(salon_get_metabox('background_group.0.ozy_salon_meta_page_background_use_video_vimeo') == '1') {
			$ozySalonHelper->fullscreen_vimeo_video_show(
				vp_metabox($meta_opt_path . '_vimeo_group.0.ozy_salon_meta_page_background_video_vimeo_image'),
				vp_metabox($meta_opt_path . '_vimeo_group.0.ozy_salon_meta_page_background_video_vimeo_id')
			);
		}	
	}
	
	// custom page options
	$hide_page_title		= salon_get_metabox('hide_title');
	$hide_page_content 		= salon_get_metabox('hide_content');//ozy_salon_meta_page.ozy_salon_meta_page_
	$custom_page_title		= salon_get_metabox('use_custom_title') == '1' ? salon_get_metabox('use_custom_title_group.0.ozy_salon_meta_page_custom_title') : '';
	$custom_page_sub_title	= salon_get_metabox('use_custom_title') == '1' ? salon_get_metabox('use_custom_title_group.0.ozy_salon_meta_page_custom_sub_title') : '';
	$use_custom_sidebar		= salon_get_metabox('use_sidebar');
	
	// generic sidebar options
	// absolute
	$_page_type = 'page';
	if(is_single()) { $_page_type = 'blog'; }	
	$sidebar_position		= salon_get_option('page_'. $_page_type .'_sidebar_position');
	$sidebar_name			= salon_get_option('page_'. $_page_type .'_sidebar_id');
		
	// custom sidebar used?
	if($use_custom_sidebar == '1') {
		$sidebar_position 	= salon_get_metabox('sidebar_group.0.ozy_salon_meta_page_sidebar_position');
		$sidebar_name 		= salon_get_metabox('sidebar_group.0.ozy_salon_meta_page_sidebar');
	}
	
	// sidebar check
	$content_css_name = salon_sidebar_check($sidebar_position);

	if(!$ozySalonHelper->has_shortcode('vc_row') || is_search()) {
		$content_css_name.= ' no-vc ';
	}
	
	salon_sd('_page_hide_page_title', $hide_page_title);
	salon_sd('_page_hide_page_content', $hide_page_content);
	salon_sd('_page_custom_page_title', $custom_page_title);
	salon_sd('_page_custom_page_sub_title', $custom_page_sub_title);
	salon_sd('_page_use_custom_sidebar', $use_custom_sidebar);
	salon_sd('_page_sidebar_position', $sidebar_position);
	salon_sd('_page_sidebar_name', $sidebar_name . salon_gd('wpml_current_language_'));
	if(salon_gd('_page_content_css_name')) 
		salon_sd('_page_content_css_name', '');
	
	salon_sd('_page_content_css_name', salon_gd('_page_content_css_name') . $content_css_name);

	$hide_page_title_arr = array(
		'page-classic-gallery', 
		'page-horizontal-gallery', 
		'page-thumbnail-gallery',
		'page-nearby-gallery',
		'page-row-slider',
		'page-big-blog'
	);
	foreach($hide_page_title_arr as $p) {
		if(is_page_template($p . '.php')) {
			salon_sd('_page_hide_page_title', '1');
			break;
		}
	}	
}

/**
* Load theme options generic metabox parameters for Portfolio
*/
function salon_portfolio_meta_params() {
	// order & order by
	$order = 'ASC'; $orderby = 'date';
	$order_orderby			= vp_metabox('ozy_salon_meta_page_portfolio.ozy_salon_meta_page_portfolio_order');
	$order_orderby			= explode('-', $order_orderby);
	if(is_array($order_orderby) && isset($order_orderby[0]) && isset($order_orderby[1])) {
		$order = $order_orderby[1]; $orderby = $order_orderby[0];
	}					

	// category filter
	$category_filter = vp_metabox('ozy_salon_meta_page_portfolio.ozy_salon_meta_page_portfolio_filter');
	
	// check if category filter set for blog page
	$include_categories = vp_metabox('ozy_salon_meta_page_portfolio.ozy_salon_meta_page_portfolio_category_sort');

	$portfolio_categories = array(); $category_search_type = 'tax';
	if(is_array($include_categories) && count($include_categories)>=0) {
		foreach($include_categories as $cat) {
			$portfolio_categories[] = get_term($cat, 'portfolio_category');
			foreach(get_term_children($cat, 'portfolio_category') as $sub_cat) {
				$portfolio_categories[] = get_term($sub_cat, 'portfolio_category');
			}
		}
	}else{
		$portfolio_categories = get_categories(array('taxonomy' => 'portfolio_category', 'post_type' => 'ozy_portfolio', 'hide_empty' => 1));		
		$category_search_type = 'cat';
	}	
	
	$column_count = vp_metabox('ozy_salon_meta_page_portfolio.ozy_salon_meta_page_portfolio_column_count');
	
	$post_per_load = (int)vp_metabox('ozy_salon_meta_page_portfolio.ozy_salon_meta_page_portfolio_count');
	
	$page_title =vp_metabox('ozy_salon_meta_portfolio.ozy_salon_meta_portfolio_page_title'); 
	
	salon_sd('_portfolio_order', $order);
	salon_sd('_portfolio_orderby', $orderby);
	salon_sd('_portfolio_include_categories', $include_categories);
	salon_sd('_portfolio_portfolio_categories', $portfolio_categories);
	salon_sd('_portfolio_post_per_load', $post_per_load);
	salon_sd('_portfolio_category_filter', $category_filter);
	salon_sd('_portfolio_category_search_type', $category_search_type);
	salon_sd('_portfolio_column_count', $column_count);
	salon_sd('_portfolio_hide_page_title', $page_title);

	/*Built hierarchical category list*/
	global $cats_by_parent;
	$cats_by_parent = array();
	foreach ($portfolio_categories as $cat) {
		$parent_id = ($category_search_type === 'tax' ? $cat->parent : $cat->category_parent);
		if (!array_key_exists($parent_id, $cats_by_parent)) {
			$cats_by_parent[$parent_id] = array();
		}
		$cats_by_parent[$parent_id][] = $cat;
	}	
	$cat_tree = array();

	$first_category = (isset($cats_by_parent[0]) ? $cats_by_parent[0] : reset($cats_by_parent));
	salon_add_cats_to_bag($cat_tree, $first_category, $category_search_type);
	salon_sd('_portfolio_portfolio_categories_tree', $cat_tree);
	salon_sd('_portfolio_portfolio_filter_parent', NULL);
	salon_sd('_portfolio_category_filter_parent', NULL);
	if(isset($cat_tree->parent)) {
		salon_sd('_portfolio_category_filter_parent', (isset($cats_by_parent[0]) ? 0 : reset($cat_tree)->parent));
	}
}

/**
* Then build a hierarchical tree
*
* http://stackoverflow.com/questions/3287603/wordpress-wp-list-categories-problem
*/
function salon_add_cats_to_bag(&$child_bag, &$children, $category_search_type) {
	global $cats_by_parent;
	if(is_array($children)) {
		foreach ($children as $child_cat) {
			$child_id = ($category_search_type === 'tax' ? $child_cat->term_id : $child_cat->cat_ID);
			if (array_key_exists($child_id, $cats_by_parent)) {
				$child_cat->children = array();
				salon_add_cats_to_bag($child_cat->children, $cats_by_parent[$child_id], $category_search_type);
			}
			$child_bag[$child_id] = $child_cat;
		}
	}
}

/**
* Generates content of the Horizontal Portfolio filter
*/
function salon_print_portfolio_filter($cat_tree, $cat_parent = 0, $level = 0, $category_search_type, $output) {
	foreach($cat_tree as $cat) {
		if($cat->taxonomy == 'portfolio_category') {		
			$current_cat_parent = ($category_search_type === 'tax' ? $cat->parent : $cat->category_parent);
			if($current_cat_parent == $cat_parent) {
				$output .= '<li class="s"></li><li><a href="#' . $cat->slug . '" data-filter=".category-' . $cat->slug . '">' . $cat->name . '</a></li>' . PHP_EOL;
				if(isset($cat->children)) {
					salon_print_portfolio_filter($cat->children, $cat->term_id, $level+1, $category_search_type, $output);
				}
			}
		}
	}
	return $output;
}


/**
* Generates content of the Horizontal Blog filter
*/
function salon_print_blog_filter() {
	$args = array(
		'type'              => 'post',
		'child_of'          => 0,
		'parent'            => 0,
		'orderby' 			=> salon_gd('_blog_orderby'),
		'order' 			=> salon_gd('_blog_order'),
		'hide_empty'        => 1,
		'hierarchical'      => 1,
		'exclude'           => '',
		'include'           => salon_gd('_blog_include_categories'),
		'number'            => '0',
		'taxonomy'          => 'category',
		'pad_counts'		=> false 
	);
	
	$categories = get_categories($args);
	foreach ($categories as $category) {
		echo '<li class="s"></li><li><a href="#'. $category->category_nicename .'" data-filter=".category-'. $category->category_nicename .'">' . $category->cat_name . '</a></li>' . PHP_EOL;
	}
}

/**
* ozy_convert_classic_gallery
*
* Catches [gallery] shortcode fromt content, removes it and turns into array
*/
function salon_convert_classic_gallery() {
	echo apply_filters('the_content', preg_replace('/\[gallery ids=[^\]]+\]/', '',  get_the_content()));
}

/**
* wp_title Filter to avoid theme check errors
*/
function salon_filter_wp_title( $title ) {
	$filtered_title = get_bloginfo( 'name' );
	if ( is_category() ) {
		$filtered_title = 'Category Archive for &quot;' . single_cat_title('', false) . '&quot; | ' . get_bloginfo( 'name' );
	} elseif ( is_tag() ) {
		$filtered_title = 'Tag Archive for &quot;' . single_tag_title('', false) . '&quot; | ' . get_bloginfo( 'name' );
	} elseif ( is_archive() ) {
		$filtered_title = $title . ' Archive | ' . get_bloginfo( 'name' );
	} elseif ( is_search()) {
		$filtered_title = 'Search for &quot;'. esc_html(get_search_query()) .'&quot; | ' . get_bloginfo( 'name' );
	} elseif ( is_home() ) {
		$filtered_title = get_bloginfo( 'name' ) .  ' | ' . get_bloginfo( 'description' );
	}  elseif ( is_404() ) {
		$filtered_title = 'Error 404 Not Found | ' . get_bloginfo( 'name' );
	} elseif ( is_single() ) {
		$filtered_title = $title;
	} else {
		$filtered_title = get_bloginfo( 'name' );
		if($title) {
			$filtered_title .= $title;
		}		
	}	
    return $filtered_title;
}
add_filter( 'wp_title', 'salon_filter_wp_title' );
/**
* To enable font upload, adding file mime types
*/
function salon_custom_upload_mimes ( $existing_mimes=array() ) {
	// add your extension to the array
	$existing_mimes['eot'] 	= 'application/vnd.ms-fontobject';
	$existing_mimes['ttf'] 	= 'application/octet-stream';
	$existing_mimes['woff'] = 'application/x-woff';
	$existing_mimes['svg'] 	= 'image/svg+xml';
	
	return $existing_mimes;
}
add_filter('upload_mimes', 'salon_custom_upload_mimes');

function salon_custom_nextpage_links($defaults) {
	$args = array(
		'before' => '<div class="pagination">' . esc_attr__('Pages: ', 'salon'),
		'after' => '</div>',
	);
	
	$r = wp_parse_args($args, $defaults);
	
	return $r;
}
add_filter('wp_link_pages_args','salon_custom_nextpage_links');

function salon_custom_password_form() {
    global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    $o = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form content-font" method="post">
    <h3 class="heading-font">' . esc_attr__( "This content is password protected. To view it please enter your password below.", "salon" ) . '</h3>
    <label for="' . $label . '">' . esc_attr__( "Password:", "salon" ) . ' </label><input name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" /><input type="submit" name="Submit" value="' . esc_attr__( "Submit", "salon" ) . '" />
    </form>
    ';
    return $o;
}
add_filter( 'the_password_form', 'salon_custom_password_form' );

function salon_ozy_custom_header() {
	global $post, $ozySalonHelper;
	salon_sd('blog_has_super_header', false);
	
	/*header slider*/
	salon_put_header_slider(salon_gd('header_slider'));

	salon_page_master_meta_params();
	
	salon_blog_meta_params();
	
	if(is_single()) {
		salon_page_meta_params('blog');
	}else{
		salon_page_meta_params();
	}
	
	$content_css 			= salon_gd('_page_content_css_name');
	$page_title_available 	= is_page() || is_search() || is_archive() || is_category() || is_home();
	
	if (is_single() && isset($post->post_type) && $post->post_type === 'post'){
		$custom_blog_page_id = salon_get_option('page_blog_page_id');
		if($custom_blog_page_id) {
			salon_sd('_page_custom_page_title', 
				salon_get_metabox('use_custom_title', 0) == '1' ? 
				salon_get_metabox('use_custom_title_group.0.ozy_salon_meta_page_custom_title', '', $custom_blog_page_id) : get_the_title($custom_blog_page_id));
			salon_sd('_page_custom_page_sub_title', 
				salon_get_metabox('use_custom_title_group.0.ozy_salon_meta_page_custom_sub_title', '', $custom_blog_page_id));
			salon_sd('_page_hide_page_title', '0');
			$page_title_available = true;
			salon_sd('_page_title_custom_id_for_post', $custom_blog_page_id);
		}				
	}else{				
		if(is_search()) {
			salon_sd('_page_custom_page_title', esc_attr('Search results for: "', 'salon') . get_search_query() . '"');
			salon_sd('_page_custom_page_sub_title', '');
			salon_sd('_page_hide_page_title', '0');
		}else if(is_home()) {
			salon_sd('_page_custom_page_title', esc_attr('Blog', 'salon'));
			salon_sd('_page_custom_page_sub_title', '');
			salon_sd('_page_hide_page_title', '0');
		}else if(is_author()) {
			if(isset($_GET['author_name'])){$curauth = get_userdatabylogin($author_name);}else{$curauth = get_userdata(intval($author));}
			salon_sd('_page_custom_page_title', esc_attr('About: ', 'salon') . $curauth->display_name);
			salon_sd('_page_custom_page_sub_title', '');
			salon_sd('_page_hide_page_title', '0');
		}else if(is_category()) {
			salon_sd('_page_custom_page_title', esc_attr('Category Archives: ', 'salon') . '<span>' . single_cat_title( '', false ) . '</span>');
			salon_sd('_page_custom_page_sub_title', '');
			salon_sd('_page_hide_page_title', '0');
		}else if(is_archive()) {
			if ( is_day() ) : /* if the daily archive is loaded */
				salon_sd('_page_custom_page_title', sprintf(esc_attr__('Daily Archives: <span>%s</span>', 'salon'), get_the_date() ));
			elseif ( is_month() ) : /* if the montly archive is loaded */
				salon_sd('_page_custom_page_title', sprintf( esc_attr__('Monthly Archives: <span>%s</span>', 'salon'), get_the_date('F Y')));
			elseif ( is_year() ) : /* if the yearly archive is loaded */
				salon_sd('_page_custom_page_title', sprintf(esc_attr__( 'Yearly Archives: <span>%s</span>', 'salon'), get_the_date('Y')));
			else : /* if anything else is loaded, ex. if the tags or categories template is missing this page will load */
				salon_sd('_page_custom_page_title', esc_attr__('Blog Archives', 'salon'));
			endif;
			salon_sd('_page_custom_page_sub_title', '');
			salon_sd('_page_hide_page_title', '0');					
		}else if(is_tag()) {
			salon_sd('_page_custom_page_title', sprintf(esc_attr__( 'Tag Archives: %s', 'salon'), '<span>' . single_tag_title( '', false ) . '</span>'));
			salon_sd('_page_custom_page_sub_title', '');
			salon_sd('_page_hide_page_title', '0');
		}else{
			if(isset($post->ID)) {
				salon_sd('_page_custom_page_title', 
					salon_get_metabox('use_custom_title', 0) == '1' ? 
					salon_get_metabox('use_custom_title_group.0.ozy_salon_meta_page_custom_title', '') : get_the_title($post->ID));
				salon_sd('_page_custom_page_sub_title', 
					salon_get_metabox('use_custom_title_group.0.ozy_salon_meta_page_custom_sub_title', '', $post->ID));
			}
		}
	}
	if (is_single() && get_post_type() === 'post' ) {
		if ( have_posts() ) while ( have_posts() ) : the_post();
			$header_background = ''; $header_extra_class = 'small-header';
			if ( has_post_thumbnail() ) { 
				$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' , false );
				if(isset($src[0])) {
					$header_background = ' style="background-image:url('. esc_url($src[0]) .')"';
					$header_extra_class = '';
				}
			}	
			echo '<div class="featured-thumbnail-header '. esc_attr($header_extra_class) .'" '. $header_background .'>';

			$image_ids_arr = salon_grab_ids_from_gallery(); $image_o = '';
			if(count($image_ids_arr)>0){
				foreach ( $image_ids_arr as $id ) {
					$large_image = wp_get_attachment_image_src( $id, 'full' );
					$image_o .= '<div style="background-image:url(' . esc_url($large_image[0]) . ');" class="carousel-cell"></div>'. PHP_EOL;
				}				
				echo '<div class="carousel blog-slider-single" data-flickity=\'{"prevNextButtons": false, "autoPlay": 3500, "pageDots": false, "adaptiveHeight": false}\'>';
				echo $image_o;
				echo '</div>';
			}

			echo '	<div>';
			echo '		<div class="container">
							<div>';
			echo '				<div class="post-meta content-font content-color-alternate bold-text">';
			echo '					<p>'; the_category(', '); echo '</p>';
			echo '				</div>';
			echo '				<h1 class="heading-font content-color-alternate3">'. ( get_the_title() ? strip_tags(get_the_title()) : get_the_time(SALON_DATE_FORMAT) ) .'</h1>';
			echo '				<div class="post-meta content-font content-color-alternate3">';
			echo '					<p class="g">' . esc_attr__('Published By ', 'salon') . '</p>';
			echo '					<p>'; the_author_posts_link(); echo '</p>';
			echo '					<p class="g">&bull;</p>';
			echo '					<p>'; the_time(SALON_DATE_FORMAT); echo '</p>';
			echo '				</div>';
			$ozySalonHelper->salon_blog_super_header_share_buttons();
			echo '			</div>
						</div>';
			echo '	</div>';
			echo '</div>';

			salon_sd('blog_has_super_header', true);
		endwhile;
	}else if (is_single() && get_post_type() === 'ozy_portfolio' ) {
		salon_portfolio_meta_params();
		if(!salon_gd('_portfolio_hide_page_title')) {
			echo '<div class="portfolio-single-title">';
			echo '<h1 class="heading-font">'. ( get_the_title() ? strip_tags(get_the_title()) : get_the_time(SALON_DATE_FORMAT) ) .'</h1>';
			echo '<img src="' . SALON_BASE_URL . 'images/assets/zigzag-lines.svg' . '#zigzag" class="svg" alt=""/>';
			echo '</div>';
		}
	}
	else
	{			
		/*page title*/			
		if(salon_gd('_page_hide_page_title') != '1' && $page_title_available && salon_gd('hide_everything_but_content') <= 0) { 
		?>
		<div id="page-title-wrapper">
			<div>
				<h1 class="page-title"><?php echo trim(salon_gd('_page_custom_page_title')) ? strip_tags(salon_gd('_page_custom_page_title')) : strip_tags(get_the_title()) ?></h1>
				<?php if(salon_gd('_page_custom_page_sub_title')) { echo '<h4>'. strip_tags(salon_gd('_page_custom_page_sub_title')) .'</h4>'; } ?>
			</div>
		</div>
	<?php
		}
	}
}

/**
* salon_wpml_language_switcher
*
* Check form WPML plugin and build language links if available
*/			 
function salon_wpml_language_switcher($use_static = false) {
	if(!$use_static) {
		if(function_exists("icl_get_languages") && function_exists("icl_disp_language") && defined("ICL_LANGUAGE_CODE") && defined("ICL_LANGUAGE_NAME")){
			salon_sd('lang_switcher_booking_button', 2);
			$languages = icl_get_languages('skip_missing=0&orderby=code');
			echo '<div class="lang-switcher-booking-button-wrapper">';
			echo '	<span class="heading-font" title="'. ICL_LANGUAGE_NAME .'">'. ICL_LANGUAGE_CODE .'</span>';
			echo '	<div>';
			if(!empty($languages)){
				foreach($languages as $l){
					if(ICL_LANGUAGE_CODE != $l['language_code']) {
						echo '<a href="' . $l['url'] . '" class="heading-font" title="' . $l['native_name'] . '">' . $l['language_code'] . '</a>';
					}
				}
			}
			echo '	</div>';
			echo '</div>';
		}
	}else{ 
		//if you don't want to use or don't have WPML plugin you can pass true to use_static parameter to build your own switcher
		salon_sd('lang_switcher_booking_button', 2);
		echo 
		'<div class="lang-switcher-booking-button-wrapper">
			<span class="heading-font" title="English">EN</span>
			<div >
				<a href="#" class="heading-font" title="Français">FR</a>
				<a href="#" class="heading-font" title="Italiano">IT</a>
				<a href="#" class="heading-font" title="Deutsch">DE</a>
				<a href="#" class="heading-font" title="Español">ES</a>
			</div>
		</div>';				
	}
}

/**
* salon_floating_booking_button
*/			 
function salon_floating_booking_button() {
	$tmp_lang = salon_gd('wpml_current_language_');
	if(salon_get_option('section_floating_buttons_is_active' . $tmp_lang) != '0' && salon_get_option('section_floating_buttons_booking_page' . $tmp_lang) != '') {
		echo '<div class="lang-switcher-booking-button-wrapper book-now '. ((int)salon_gd('lang_switcher_booking_button' . $tmp_lang) < 2 ? 'book-now-alone' : '') .'">';
		echo '<a href="'. esc_url(get_permalink(salon_get_option('section_floating_buttons_booking_page' . $tmp_lang))) .'" class="heading-font"><span>'. esc_html(salon_get_option('section_floating_buttons_short_label' . $tmp_lang)) .'</span><span>'. esc_attr(salon_get_option('section_floating_buttons_long_label' . $tmp_lang)) .'</span></a>';
		echo '</div>';
	}
}

/*
* Generates selected social icons from theme options panel
*/
function salon_header_social_icons() {
	global $ozySalonHelper;
	$ozySalonHelper->social_icons();
}

/*
* Custom typography css output for VC column shortcode
*/
function salon_custom_column_typography($column_use_custom_typography, 
	$column_use_custom_typography_color, 
	$column_use_custom_typography_size, 
	$column_use_custom_typography_line_height,
	$column_use_custom_typography_align, &$css_classes) {
	
	if($column_use_custom_typography == '1') {		
		$rand_class_name = 'occ-' . rand(0, 1000000);
		array_push($css_classes, $rand_class_name);
		
		$css_output = '';
		if($column_use_custom_typography_color) { $css_output .= 'color:'. esc_attr($column_use_custom_typography_color) .';'; }
		if($column_use_custom_typography_size) { $css_output .= 'font-size:'. esc_attr($column_use_custom_typography_size) .';'; }
		if($column_use_custom_typography_line_height) { $css_output .= 'line-height:'. esc_attr($column_use_custom_typography_line_height) .';'; }
		if($column_use_custom_typography_align) { $css_output .= 'text-align:'. esc_attr($column_use_custom_typography_align) .';'; }
		
		global $ozySalonHelper;
		$ozySalonHelper->set_footer_style('.'. $rand_class_name .'{'. $css_output .'}');		
	}	
}

/**
* Adds more Google Fonts option to VC
*/
function salon_add_more_google_font_to_vc($fonts_list){
    $rye->font_family = 'Rye';
    $rye->font_types = "300 light:300:normal,400 regular:400:normal";
    $rye->font_styles = 'normal';
    $rye->font_family_description = 'Rye\'s bold attention getting shapes are useful for advertising. Rye is a medium contrast design inspired by posters using wood type.';
    $rye->font_style_description = 'Choose the styles you want';
    $fonts_list[] = $rye;

    $loversq->font_family = 'Lovers Quarrel';
    $loversq->font_types = "300 light:300:normal,400 regular:400:normal";
    $loversq->font_styles = 'normal';
    $loversq->font_family_description = 'Lovers Quarrel is an ornate calligraphic script. It has beautifully embellished uppercase characters and clean, legible lowercase forms.';
    $loversq->font_style_description = 'Choose the styles you want';
    $fonts_list[] = $loversq;
	
	$volkhov->font_family = 'Volkhov';
    $volkhov->font_types = "normal:400 regular:500 regular:400 italic:500 italic";
    $volkhov->font_styles = 'normal:italic';
    $volkhov->font_family_description = 'Volkhov is a low-contrast seriffed typeface with a robust character, intended for providing a motivating reading experience.';
    $volkhov->font_style_description = 'Choose the styles you want';
    $fonts_list[] = $volkhov;

	$sorts_mill_goudy->font_family = 'Sorts Mill Goudy';
    $sorts_mill_goudy->font_types = "normal:400 regular:400 italic";
    $sorts_mill_goudy->font_styles = 'normal:italic';
    $sorts_mill_goudy->font_family_description = 'A revival of Frederic Goudy\'s \'Goudy Oldstyle\' with Regular and Italic styles, and extended Latin character coverage.';
    $sorts_mill_goudy->font_style_description = 'Choose the styles you want';
    $fonts_list[] = $sorts_mill_goudy;

	$cormorant_upright->font_family = 'Cormorant Upright';
    $cormorant_upright->font_types = "normal:300 light:400 regular:500 medium:600 semi-bold:700 bold";
    $cormorant_upright->font_styles = 'normal:italic';
    $cormorant_upright->font_family_description = 'Cormorant is a free display type family developed by Christian Thalmann.';
    $cormorant_upright->font_style_description = 'Choose the styles you want';
    $fonts_list[] = $cormorant_upright;
	
	$cormorant_garamond->font_family = 'Cormorant Garamond';
    $cormorant_garamond->font_types = "normal:300 light:300 italic:400 regular:400 italic:500 medium:500 italic:600 semi-bold:600 italic:700 bold:700 italic";
    $cormorant_garamond->font_styles = 'normal:italic';
    $cormorant_garamond->font_family_description = 'Cormorant is a free display type family developed by Christian Thalmann.';
    $cormorant_garamond->font_style_description = 'Choose the styles you want';
    $fonts_list[] = $cormorant_garamond;	

    return $fonts_list;
}
add_filter('vc_google_fonts_get_fonts_filter', 'salon_add_more_google_font_to_vc');

/**
* Row kenburns & shuffle & photo sharr slider
*/
function salon_row_slideshow($bg_slider, $bg_slider_images, $bg_slider_fallback_image, $wave_bar_color, $sharr_color1 = NULL, $sharr_color2 = NULL) {
		
	if($bg_slider === 'kenburns') {
		$rand_elm_id = 'orkbrns-' . rand(0, 1000000);
		$bg_slider_images = explode(',', $bg_slider_images);
		$output = '<div class="smoothslides" id="'. $rand_elm_id .'">';
		foreach($bg_slider_images as $bg_slider_image) {
			$current_image = wp_get_attachment_image_src($bg_slider_image, 'full');
			if(isset($current_image[0])) {
				$output .= '<img src="'. esc_url($current_image[0]) .'" alt=""/>';
			}
		}
		$output .= '</div>';
		
		if($bg_slider_fallback_image) {
			$fallback_image = wp_get_attachment_image_src($bg_slider_fallback_image, 'full');
			if(isset($fallback_image[0])) {
				$output .= '<div class="smoothslides-fallback" style="background-image:url('. esc_url($fallback_image[0]) .')"></div>';
			}
		}		
		
		return $output;
	}else if($bg_slider === 'shuffle') {
		$rand_elm_id = 'orshffle-' . rand(0, 1000000);
		$bg_slider_images = explode(',', $bg_slider_images);
		$output = '<div class="shuffle-me" id="'. $rand_elm_id .'"><div class="images">';
		foreach($bg_slider_images as $bg_slider_image) {
			$current_image = wp_get_attachment_image_src($bg_slider_image, 'full'); $current_css_class = 'active';
			if(isset($current_image[0])) {
				//$output .= '<img src="'. esc_url($current_image[0]) .'" class="'. esc_attr($current_css_class) .'" alt=""/>';
				$output .= '<div style="background-image:url('. esc_url($current_image[0]) .')" class="'. esc_attr($current_css_class) .'"></div>';
			}
		}
		$output .= '</div></div>';
		
		if($bg_slider_fallback_image) {
			$fallback_image = wp_get_attachment_image_src($bg_slider_fallback_image, 'full');
			if(isset($fallback_image[0])) {
				$output .= '<div class="shuffle-slide-fallback" style="background-image:url('. esc_url($fallback_image[0]) .')"></div>';
			}
		}		
		
		return $output;
	}else if($bg_slider === 'photo_sharr') {
		wp_enqueue_script('web-animations');
		wp_enqueue_style('photo-sharr');
		
		$rand_elm_id = 'orsharr-' . rand(0, 1000000);
		$bg_slider_images = explode(',', $bg_slider_images);
		$output = '<div class="photo-sharr" id="'. $rand_elm_id .'">';
		foreach($bg_slider_images as $bg_slider_image) {
			$current_image = wp_get_attachment_image_src($bg_slider_image, 'full');
			if(isset($current_image[0])) {
				$output .= '<img src="'. esc_url($current_image[0]) .'" alt=""/>';
			}
		}
		$output .= '</div>';
				
		global $ozySalonHelper;
		$ozySalonHelper->set_footer_style("#$rand_elm_id {background: ". esc_attr($sharr_color2) .";background: -webkit-radial-gradient(circle,". esc_attr($sharr_color1) .",". esc_attr($sharr_color2) .");background: radial-gradient(circle,". esc_attr($sharr_color1) .",". esc_attr($sharr_color2) .");}");
		
		return $output;
	}else if($bg_slider === 'wave') {
		wp_enqueue_style('row-wave');
		
		$rand_elm_id = 'orwave-' . rand(0, 1000000);
		
		$output = '<div id="'. esc_attr($rand_elm_id) .'" class="vc_row_wv">';
		for($i = 1;$i <= 100; $i++) {
			$output.= '<div class="bar"></div>';
		}
		$output.= '</div>';

		global $ozySalonHelper;
		$ozySalonHelper->set_footer_style("#$rand_elm_id .bar{background: ". esc_attr($wave_bar_color) .";}");
		
		return $output;
	}
	return '';
}

function salon_row_bottom_arrow($bottom_arrow, $bottom_arrow_caption) {
	if($bottom_arrow == 'on') {
		return '<div id="row-bottom-arrow-wrapper"><div id="row-bottom-arrow-wrapper-inner"><div id="row-bottom-arrow-scroll-down"><span class="row-bottom-arrow-arrow-down"></span><span id="row-bottom-arrow-scroll-title">'. esc_html($bottom_arrow_caption) .'</span></div></div></div>';
	}
	return '';
}

/**
* Row kenburns & shuffle & photo sharr slider
*/
function salon_row_bg_video($bg_video, $bg_video_path, $bg_video_fallback_image) {		
	if($bg_video === 'on') {
		$bg_video_fallback_img_attr = '';
		if($bg_video_fallback_image) {
			$bg_video_fallback_image = wp_get_attachment_image_src($bg_video_fallback_image, 'full');
			if(isset($bg_video_fallback_image[0])) {
				$bg_video_fallback_img_attr = ' poster="'. esc_url($bg_video_fallback_image[0]) .'" ';
			}
		}		
		return '<video width="100%" height="100%" autoplay muted loop '. $bg_video_fallback_img_attr .'><source src="'. esc_url($bg_video_path) .'" type="video/mp4"></video>';
	}
}

/**
* salon_page_hover_box_blog_css_builder
*
* This function used in page-hoverbox-blog.php and related custom shortcode to build custom CSS for the hover boxes
*/
function salon_page_hover_box_blog_css_builder($page_id, $dynamic_css_class_name) {
	global $ozySalonHelper;
	$bg_color = vp_metabox('ozy_salon_meta_post.ozy_salon_meta_post_color_group.0.ozy_salon_meta_post_color_overlay', null, $page_id);
	$fn_color = vp_metabox('ozy_salon_meta_post.ozy_salon_meta_post_color_group.0.ozy_salon_meta_post_color_foreground', null, $page_id);
	
	$ozySalonHelper->set_footer_style('.'. $dynamic_css_class_name .'{background:'. esc_attr($bg_color) .'!important;}');
	$ozySalonHelper->set_footer_style('.'. $dynamic_css_class_name .',.'. $dynamic_css_class_name .' h2,.'. $dynamic_css_class_name .' a{color:'. esc_attr($fn_color) .' !important;}');
	$ozySalonHelper->set_footer_style(
		'.'. $dynamic_css_class_name .' a{border-color:'. esc_attr($fn_color) .' !important;}
		figure.effect-slideleft figcaption.'. $dynamic_css_class_name .'::after{border-left-color:'. esc_attr($bg_color) .' !important;}
		figure.effect-slidedown figcaption.'. $dynamic_css_class_name .'::after{border-top-color:'. esc_attr($bg_color) .' !important;}
		figure.effect-slideright figcaption.'. $dynamic_css_class_name .'::after{border-right-color:'. esc_attr($bg_color) .' !important;}
		figure.effect-slideup figcaption.'. $dynamic_css_class_name .'::after{border-bottom-color:'. esc_attr($bg_color) .' !important;}'
	);
}

/**
* Data Privacy Notice
*/

function salon_data_policy_notice() {
    ?>
    <div class="notice notice-warning ozy-data-privacy-notice is-dismissible">
		<p><strong><?php echo SALON_THEMENAME ?> Theme Data Privacy</strong><br>Some of the files retrieve from our server to perform a clean dummy data import, at this process inspite related files gets download from us however NO data stored at our server.</p>
		<p>Although bundled or installed plugins from WordPress repository might have own rules which the owner of plugin responsible from it.</p>
		<p><strong>Third Party Links</strong><br>Our theme may contain links to other websites provided by third parties not under our control. When following a link and providing information to a 3rd-party website, please be aware that we are not responsible for the data provided to that third party.</p>
        <p><strong>Cookies</strong><br>Additionally, information about how you use our website is collected automatically using “cookies”. Cookies are text files placed on your computer to collect standard internet log information and visitor behaviour information. This information is used to track visitor use of the website and to compile statistical reports on website activity.</p>
    </div>
    <?php
}

function salon_data_policy_notice_check() {
	if( empty( get_option( 'ozy-data-privacy-notice' ) ) ) {
		add_action( 'admin_notices', 'salon_data_policy_notice' );
	}
}
add_action( 'admin_init', 'salon_data_policy_notice_check' );

function salon_data_policy_notice_dismiss() {
	update_option('ozy-data-privacy-notice', '1');
	exit();
}
add_action( 'wp_ajax_salon_data_policy_notice_dismiss', 'salon_data_policy_notice_dismiss' ); 