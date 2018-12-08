<?php
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
    add_action('admin_footer','salon_removed_widgets');
}

function salon_removed_widgets(){
	if(get_option('salon_installed') != '1') {//check if this theme activated once
		//get saved widgets
		$widgets = get_option('sidebars_widgets');

		//remove default widgets from our specific sidebars
		unset($widgets['ozy-footer-widget-bar-one']);
		unset($widgets['ozy-footer-widget-bar-two']);
		unset($widgets['ozy-footer-widget-bar-three']);
		unset($widgets['ozy-footer-widget-bar-four']);
		unset($widgets['ozy-footer-widget-bar-info']);
		/*unset($widgets['ozy-footer-widget-bar-copyright']);*/

		//update with widgets removed
		update_option('sidebars_widgets',$widgets);

		//make sure this will not work again on reactivation
		update_option('salon_installed', '1');
	}
}

/**
* salon_load_dynamic_sidebars()
* Load dynamic and default sidebars here
*/
function salon_load_dynamic_sidebars() {
	
	// Static sidebars
	register_sidebar(array(
		'name'			=> 'Footer Info Bar',
		'id'			=> 'ozy-footer-widget-bar-info',
		'before_widget' => '<div class="widget">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h4 class="heading-font">',
		'after_title' 	=> '</h4>'
	));		
	register_sidebar(array(
		'name'			=> 'Footer Bar #1',
		'id'			=> 'ozy-footer-widget-bar-one',
		'before_widget' => '<div class="widget">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h4 class="heading-font">',
		'after_title' 	=> '</h4>'
	));
	register_sidebar(array(
		'name'			=> 'Footer Bar #2',
		'id'			=> 'ozy-footer-widget-bar-two',
		'before_widget' => '<div class="widget">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h4 class="heading-font">',
		'after_title' 	=> '</h4>'
	));
	register_sidebar(array(
		'name'			=> 'Footer Bar #3',
		'id'			=> 'ozy-footer-widget-bar-three',
		'before_widget' => '<div class="widget">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h4 class="heading-font">',
		'after_title' 	=> '</h4>'
	));
	register_sidebar(array(
		'name'			=> 'Footer Bar #4',
		'id'			=> 'ozy-footer-widget-bar-four',
		'before_widget' => '<div class="widget">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h4 class="heading-font">',
		'after_title' 	=> '</h4>'
	));			

	$sidebar_posts = get_posts(array(
		'posts_per_page' 	=> -1,
		'post_type' 		=> 'ozy_sidebars'
	));

	foreach ($sidebar_posts as $post)
	{
		register_sidebar(array(
			'name'			=> $post->post_title,
			'id'			=> $post->post_name,
			'before_widget'	=> '<li class="widget">',
			'after_widget'	=> '</li>',
			'before_title'	=> '<h4>',
			'after_title'	=> '</h4>'
		));
	}
	
	// If WPML activated create sidebars for available languages too
	if(function_exists("icl_get_languages") && defined("ICL_LANGUAGE_CODE")){
		$languages = icl_get_languages('skip_missing=0&orderby=code');
		if(!empty($languages)){
			foreach($languages as $l){
				if($l['language_code'] != 'en') {
					register_sidebar(array(
						'name'			=> 'Footer Bar #1' . ' (' . $l['native_name'] . ')',
						'id'			=> 'ozy-footer-widget-bar-one_' . $l['language_code'],
						'before_widget' => '<div class="widget">',
						'after_widget' 	=> '</div>',
						'before_title' 	=> '<h4 class="heading-font">',
						'after_title' 	=> '</h4>'
					));
					register_sidebar(array(
						'name'			=> 'Footer Bar #2' . ' (' . $l['native_name'] . ')',
						'id'			=> 'ozy-footer-widget-bar-two_' . $l['language_code'],
						'before_widget' => '<div class="widget">',
						'after_widget' 	=> '</div>',
						'before_title' 	=> '<h4 class="heading-font">',
						'after_title' 	=> '</h4>'
					));
					register_sidebar(array(
						'name'			=> 'Footer Bar #3' . ' (' . $l['native_name'] . ')',
						'id'			=> 'ozy-footer-widget-bar-three_' . $l['language_code'],
						'before_widget' => '<div class="widget">',
						'after_widget' 	=> '</div>',
						'before_title' 	=> '<h4 class="heading-font">',
						'after_title' 	=> '</h4>'
					));
					register_sidebar(array(
						'name'			=> 'Footer Bar #4' . ' (' . $l['native_name'] . ')',
						'id'			=> 'ozy-footer-widget-bar-four_' . $l['language_code'],
						'before_widget' => '<div class="widget">',
						'after_widget' 	=> '</div>',
						'before_title' 	=> '<h4 class="heading-font">',
						'after_title' 	=> '</h4>'
					));			
									
					foreach ($sidebar_posts as $post) {
						register_sidebar(array(
							'name'			=> $post->post_title . ' (' . $l['native_name'] . ')',
							'id'			=> $post->post_name . '_' . $l['language_code'],
							'before_widget'	=> '<li class="widget">',
							'after_widget'	=> '</li>',
							'before_title'	=> '<h4>',
							'after_title'	=> '</h4>'
						));											
					}
				}
			}
		}
	}
	
}

add_action('widgets_init', 'salon_load_dynamic_sidebars');
?>