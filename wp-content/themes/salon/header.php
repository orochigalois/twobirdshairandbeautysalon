<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
	<meta charset="<?php esc_attr(bloginfo( 'charset' )); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="format-detection" content="telephone=no">
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php echo esc_url(get_bloginfo('pingback_url')); ?>" />
	<?php wp_head(); /* this is used by many Wordpress features and for plugins to work proporly */ ?>
</head>

<body <?php body_class(); ?>>
	<?php 
	if(salon_gd('is_animsition_active')) echo '<div class="animsition">';
    
	if(salon_gd('hide_everything_but_content') != 999) {
		include_once(SALON_BASE_DIR . 'include/primary-menu.php');        
	    include_once(SALON_BASE_DIR . 'include/google-maps_bg.php'); /* google maps background */ 
	}
    ?>        
    <div class="none">
        <p><a href="#content"><?php esc_attr_e('Skip to Content', 'salon'); ?></a></p><?php /* used for accessibility, particularly for screen reader applications */ ?>
    </div><!--.none-->
    <?php
		if(salon_gd('hide_everything_but_content') <= 0): 
	?> 
    
    <div id="main" class="<?php echo esc_attr(salon_gd('header_slider_class')); echo esc_attr(salon_gd('footer_slider_class')); ?>">
        <?php
		salon_ozy_custom_header();
        ?>
        <div class="container <?php echo esc_attr(salon_gd('_page_content_css_name')); ?>">
	<?php endif; ?>        
            