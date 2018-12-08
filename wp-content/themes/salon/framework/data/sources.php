<?php

/**
 * Here is the place to put your own defined function that serve as
 * datasource to field with multiple options.
 */

function vp_get_categories()
{
	$wp_cat = get_categories(array('hide_empty' => 0 ));

	$result = array();
	foreach ($wp_cat as $cat)
	{
		$result[] = array('value' => $cat->cat_ID, 'label' => $cat->name);
	}
	return $result;
}

function vp_get_users()
{
	$wp_users = VP_WP_User::get_users();

	$result = array();
	foreach ($wp_users as $user)
	{
		$result[] = array('value' => $user['id'], 'label' => $user['display_name']);
	}
	return $result;
}

function vp_get_posts()
{
	$wp_posts = get_posts(array(
		'posts_per_page' => -1,
	));

	$result = array();
	foreach ($wp_posts as $post)
	{
		$result[] = array('value' => $post->ID, 'label' => $post->post_title);
	}
	return $result;
}

function vp_get_pages()
{
	$wp_pages = get_pages();

	$result = array();
	foreach ($wp_pages as $page)
	{
		$result[] = array('value' => $page->ID, 'label' => $page->post_title);
	}
	return $result;
}

function vp_get_tags()
{
	$wp_tags = get_tags(array('hide_empty' => 0));
	$result = array();
	foreach ($wp_tags as $tag)
	{
		$result[] = array('value' => $tag->term_id, 'label' => $tag->name);
	}
	return $result;
}

function vp_get_roles()
{
	$result         = array();
	$editable_roles = VP_WP_User::get_editable_roles();

	foreach ($editable_roles as $key => $role)
	{
		$result[] = array('value' => $key, 'label' => $role['name']);
	}

	return $result;
}

function salon_ozy_vp_get_custom_fonts($fonts = null) {
	$ozy_fonts = get_posts(array(
		'posts_per_page' 	=> -1,
		'post_type' 		=> 'ozy_fonts'
	));
		
	$weight_arr = array(); $style_arr = array();
	foreach ($ozy_fonts as $post) {
		$font_grp = vp_metabox('ozy_salon_meta_font.ozy_salon_meta_font_group', null, $post->ID);
		if(is_array($font_grp) && count($font_grp) > 0) {
			foreach($font_grp as $fnt) {
				$weight = $fnt['ozy_salon_meta_font_weight'];
				if(!in_array($weight, $weight_arr)) array_push($weight_arr, $weight);
				$style = $fnt['ozy_salon_meta_font_style'];
				if(!in_array($style, $style_arr)) array_push($style_arr, $style);
			}
		}
		$fonts->{'___' . $post->post_title} = new StdClass;
		$fonts->{'___' . $post->post_title}->weights = $weight_arr;
		$fonts->{'___' . $post->post_title}->styles = $style_arr;
	}
	
	return $fonts;
}

function vp_get_gwf_family(){
	
	$fonts = wp_remote_get(get_template_directory_uri() . '/framework/data/gwf.json');
	$fonts = wp_remote_retrieve_body($fonts);
	//$fonts = json_decode($fonts,true);

	$fonts = salon_ozy_vp_get_custom_fonts(json_decode($fonts));
	
	$fonts = array_keys(get_object_vars($fonts));
	//$fonts = array_keys($fonts);

	foreach ($fonts as $font)
	{
		$result[] = array('value' => $font, 'label' => $font);
	}

	return $result;
}

VP_Security::instance()->whitelist_function('vp_get_gwf_weight');

function vp_get_gwf_weight($face)
{
	if(empty($face))
		return array();
	
	$fonts = wp_remote_get(get_template_directory_uri() . '/framework/data/gwf.json');
	$fonts = wp_remote_retrieve_body($fonts);
	
	//$fonts   = json_decode($fonts);
	$fonts = salon_ozy_vp_get_custom_fonts(json_decode($fonts));
	
	$weights = isset($fonts->{$face}->weights) ? $fonts->{$face}->weights : null;
	
	if(is_array($weights)) {
		foreach ($weights as $weight)
		{
			$result[] = array('value' => $weight, 'label' => $weight);
		}
	}else{
		$result[] = array('value' => '', 'label' => '');
	}
	return $result;
}

VP_Security::instance()->whitelist_function('vp_get_gwf_style');

function vp_get_gwf_style($face)
{
	if(empty($face))
		return array();
	
	$fonts = wp_remote_get(get_template_directory_uri() . '/framework/data/gwf.json');
	$fonts = wp_remote_retrieve_body($fonts);
	
	//$fonts   = json_decode($fonts);
	$fonts = salon_ozy_vp_get_custom_fonts(json_decode($fonts));
	
	$styles = isset($fonts->{$face}->styles) ? $fonts->{$face}->styles : null;

	if(is_array($styles)) {
		foreach ($styles as $style)
		{
			$result[] = array('value' => $style, 'label' => $style);
		}
	}else{
		$result[] = array('value' => '', 'label' => '');
	}
	return $result;
}

function vp_get_social_medias() {
	$socmeds = array(
		array('value' => 'blogger', 'label' => 'Blogger'),
		array('value' => 'behance', 'label' => 'Behance'),
		array('value' => 'delicious', 'label' => 'Delicious'),
		array('value' => 'deviantart', 'label' => 'DeviantArt'),
		array('value' => 'digg', 'label' => 'Digg'),
		array('value' => 'dribble', 'label' => 'Dribble'),
		array('value' => 'email', 'label' => 'Email'),
		array('value' => 'facebook', 'label' => 'Facebook'),
		array('value' => 'flickr', 'label' => 'Flickr'),
		array('value' => 'forrst', 'label' => 'Forrst'),
		array('value' => 'foursquare', 'label' => 'Foursquare'),
		array('value' => 'github', 'label' => 'Github'),
		array('value' => 'googleplus', 'label' => 'Google+'),
		array('value' => 'instagram', 'label' => 'Instagram'),
		array('value' => 'lastfm', 'label' => 'Last.FM'),
		array('value' => 'linkedin', 'label' => 'LinkedIn'),
		array('value' => 'myspace', 'label' => 'MySpace'),
		array('value' => 'pinterest', 'label' => 'Pinterest'),
		array('value' => 'reddit', 'label' => 'Reddit'),
		array('value' => 'rss', 'label' => 'RSS'),
		array('value' => 'soundcloud', 'label' => 'SoundCloud'),
		array('value' => 'stumbleupon', 'label' => 'StumbleUpon'),
		array('value' => 'tumblr', 'label' => 'Tumblr'),
		array('value' => 'twitter', 'label' => 'Twitter'),
		array('value' => 'vimeo', 'label' => 'Vimeo'),
		array('value' => 'wordpress', 'label' => 'WordPress'),
		array('value' => 'yahoo', 'label' => 'Yahoo!'),
		array('value' => 'youtube', 'label' => 'Youtube'),
		array('value' => 'vk', 'label' => 'VK'),
		array('value' => 'yelp', 'label' => 'Yelp'),		
		array('value' => 'fivehundredpx', 'label' => '500px')
	);

	return $socmeds;
}

function vp_get_share_buttons() {
	$socmeds = array(
		array('value' => 'facebook', 'label' => 'Facebook'),
		array('value' => 'twitter', 'label' => 'Twitter'),
		array('value' => 'pinterest', 'label' => 'Pinterest'),
		array('value' => 'tumblr', 'label' => 'Tumblr'),
		array('value' => 'googleplus', 'label' => 'Google+'),
		array('value' => 'digg', 'label' => 'Digg'),
		array('value' => 'linkedin', 'label' => 'LinkedIn'),
		array('value' => 'stumbleupon', 'label' => 'Stumbleupon'),
		array('value' => 'email', 'label' => 'Email')
	);

	return $socmeds;
}

function vp_get_fontawesome_icons()
{
	// scrape list of icons from fontawesome css
	if( false === ( $icons  = get_transient( 'vp_fontawesome_icons' ) ) )
	{
		$pattern = '/\.(oic-(?:\w+(?:-)?)+):before\s*{\s*content/';
		$subject = wp_remote_get(get_template_directory_uri() . '/font/font.min.css');
		$subject = wp_remote_retrieve_body($subject);		

		preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

		$icons = array();

		foreach($matches as $match)
		{
		    $icons[] = array('value' => $match[1], 'label' => $match[1]);
		}
		set_transient( 'vp_fontawesome_icons', $icons, 60 * 60 * 24 );
	}
	//set_transient( 'vp_fontawesome_icons', $icons, -10 );
	return $icons;
}

VP_Security::instance()->whitelist_function('vp_dep_boolean');

function vp_dep_boolean($value)
{
	$args   = func_get_args();
	$result = true;

	foreach ($args as $val)
	{
		$result = ($result and !empty($val));
	}
	return $result;
}

VP_Security::instance()->whitelist_function('vp_dep_if_center_selected');
function vp_dep_if_center_selected($value)
{
	if($value == 'center') {
		return true;
	}
	return false;
}

/**
 * EOF
 */