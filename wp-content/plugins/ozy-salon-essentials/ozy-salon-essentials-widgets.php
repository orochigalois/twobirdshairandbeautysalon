<?php
/**
 * Custom defined widgets
 */

add_action( 'widgets_init', 'salon_ozy_custom_widgets' );

function salon_ozy_custom_widgets() {
	register_widget( 'SALON_OZY_Twitter_Widget' );
	register_widget( 'SALON_OZY_SocialBar_Widget' );
	register_widget( 'SALON_OZY_LatestPosts_Widget' );
	register_widget( 'SALON_OZY_CustomMenu_Widget' );
	register_widget( 'SALON_OZY_Flickr_Widget' );
}

/**
 * Twitter
 */

class SALON_OZY_Twitter_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'twitter', 'description' => esc_attr__('This widget will get posts from your Twitter account. To set necessary parameters visit Settings > ozy Essentials section.', 'ozy-salon-essentials') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'twitter-widget' );
		
		parent::__construct( 'twitter-widget', esc_attr__('(Salon) Twitter', 'ozy-salon-essentials'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		$title 			= isset($instance['title']) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$screenname		= isset($instance['username']) ? $instance['username'] : 'envato';
		$sub_title		= isset($instance['sub_title']) ? $instance['sub_title'] : '';
		$count	 		= isset($instance['post_per_page']) && (int)$instance['post_per_page'] > 0 ? $instance['post_per_page'] : 1;

		echo $before_widget;

		echo '<a href="http://www.twitter.com/'. esc_attr($screenname) .'" class="ozy-twitter-widget-icon" target="_blank" class="symbol-twitter"><span class="symbol" title=""></span></a>';

		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		
		echo '<div class="ozy-twitter-widget">';
		
		$essentials_options = get_option('ozy_salon_essentials');
		if( is_array($essentials_options) && 
			isset($essentials_options['twitter_consumer_key']) && 
			isset($essentials_options['twitter_secret_key']) &&
			isset($essentials_options['twitter_token_key']) &&
			isset($essentials_options['twitter_token_secret_key']) ) 
		{					
			require_once(plugin_dir_path( __FILE__ ) . "twitter/twitteroauth.php"); //Path to twitteroauth library
			
			if(!function_exists('getConnectionWithAccessToken')) {
				function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
					$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
					return $connection;
				}
			}

			$connection = getConnectionWithAccessToken(
				$essentials_options['twitter_consumer_key'],
				$essentials_options['twitter_secret_key'],
				$essentials_options['twitter_token_key'],
				$essentials_options['twitter_token_secret_key']
			);
			 
			$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=". esc_attr($screenname) ."&count=". esc_attr($count));

			if(!function_exists('makeLinks')) {
				function makeLinks($str) {    
					return preg_replace('/(https?):\/\/([A-Za-z0-9\._\-\/\?=&;%,]+)/i', '<a href="$1://$2" target="_blank">$1://$2</a>', $str);
				}
			}

			$output = '';
			if(is_array($tweets)) {
				foreach($tweets as $tweet) {
					$h_time = sprintf( esc_attr__('%s ago', 'ozy-salon-essentials'), human_time_diff( date( 'U', strtotime( $tweet->created_at ) )));
					$output .= '<div>'. makeLinks($tweet->text) .'<br><span>'. $h_time  .'</span></div>';
				}
				
				$output .= '<a href="http://twitter.com/'. $screenname .'" class="heading-font" target="_blank">'. $sub_title .'</a>';
				
				echo $output;
			}else{
				echo 'Possible Twitter data error.';
			}
		}else{
			echo '<p>**Required Twitter parameters are not supplied. Please go to your admin panel, Settings > ozy Essentials.**</p>';		
		}
		
		echo '</div>';
		
		echo $after_widget;
	}
	
	// Update the widget 	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		//Strip tags from title and name to remove HTML 
		$instance['title'] 				= strip_tags( $new_instance['title'] );
		$instance['username'] 			= $new_instance['username'];
		$instance['sub_title'] 			= strip_tags( $new_instance['sub_title'] );
		$instance['post_per_page'] 		= $new_instance['post_per_page'];

		return $instance;
	}

	
	function form( $instance ) {

		//Set up some default widget settings.
		$defaults = array( 
			'title' => esc_attr__('LATEST TWEET', 'ozy-salon-essentials'), 
			'username' => 'envato',
			'sub_title' => esc_attr__('FOLLOW US ON TWITTER', 'ozy-salon-essentials'),
			'post_per_page' => 1
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_attr_e('Title:', 'ozy-salon-essentials'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'username' )); ?>"><?php esc_attr_e('Username:', 'ozy-salon-essentials'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'username' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'username' )); ?>" value="<?php echo esc_attr($instance['username']); ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'sub_title' )); ?>"><?php esc_attr_e('Sub Title:', 'ozy-salon-essentials'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'sub_title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'sub_title' )); ?>" value="<?php echo esc_attr($instance['sub_title']); ?>" style="width:100%;" />
		</p>        
        
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'post_per_page' )); ?>"><?php esc_attr_e('Post Count:', 'ozy-salon-essentials'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'post_per_page' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'post_per_page' )); ?>" value="<?php echo esc_attr($instance['post_per_page']); ?>" style="width:100%;" />
		</p>        

	<?php
	}	
}

/**
 * Social Bar
 */

class SALON_OZY_SocialBar_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'socialbar', 'description' => esc_attr__('This widget will put social site icons which previously set on Theme Options > Social panel.', 'ozy-salon-essentials') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'socialbar-widget' );
		
		parent::__construct( 'socialbar-widget', esc_attr__('(Salon) Social Bar', 'ozy-salon-essentials'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		global $ozySalonHelper;
		
		$title 			= isset($instance['title']) ? apply_filters( 'widget_title', $instance['title'] ) : '';

		echo $before_widget;

		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		
        echo '<div id="social-icons">' . PHP_EOL;
		$ozySalonHelper->social_icons();
	    echo '</div>' . PHP_EOL;
		
		echo $after_widget;
	}
	
	// Update the widget 	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		//Strip tags from title and name to remove HTML 
		$instance['title'] 				= strip_tags( $new_instance['title'] );

		return $instance;
	}

	
	function form( $instance ) {

		//Set up some default widget settings.
		$defaults = array( 'title' => esc_attr__('Follow Us', 'ozy-salon-essentials'));
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_attr_e('Title:', 'ozy-salon-essentials'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:100%;" />
		</p>

	<?php
	}	
}


/**
 * Custom Menu
 */

class SALON_OZY_CustomMenu_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'custommenu', 'description' => esc_attr__('This widget will display custom menu from selected menu.', 'ozy-salon-essentials') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'custommenu-widget' );
		
		parent::__construct( 'custommenu-widget', esc_attr__('(Salon) Custom Menu', 'ozy-salon-essentials'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		global $ozySalonHelper;
		
		$title 			= isset($instance['title']) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$active_menu	= isset($instance['active_menu']) ? $instance['active_menu'] : '';
		
		echo $before_widget;

		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		
		if($active_menu) {
			$args = array( 'menu_class' => 'menu', 'menu' => $active_menu, 'walker' => new BootstrapNavMenuWalker('0') );
			wp_nav_menu( $args );
		}
		
		echo $after_widget;
	}

	// Update the widget 	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		//Strip tags from variables to remove HTML 
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['active_menu'] = strip_tags( $new_instance['active_menu'] );

		return $instance;
	}

	
	function form( $instance ) {

		//Set up some default widget settings.
		$defaults = array( 'title' => esc_attr__('Custom Menu', 'ozy-salon-essentials'), 'active_menu' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_attr_e('Title:', 'ozy-salon-essentials'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:100%;" />
		</p>
        
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'active_menu' )); ?>"><?php esc_attr_e('Menu:', 'ozy-salon-essentials'); ?></label>
			<?php
				$menus = get_terms('nav_menu');
			?>
            <select id="<?php echo esc_attr($this->get_field_id( 'active_menu' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'active_menu' )); ?>" style="width:100%;">
            	<?php
					foreach($menus as $menu){
					   	echo '<option value="'. esc_attr($menu->slug) .'" '. selected( $menu->slug, $instance['active_menu'], false ) .'>'. $menu->name .'</option>' . PHP_EOL;
					}
				?>
            </select>
		</p>

	<?php
	}
}

/**
 * Latest Posts
 */

class SALON_OZY_LatestPosts_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'latestposts', 'description' => esc_attr__('This widget will display latest posts in multiple view modes.', 'ozy-salon-essentials') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'latestposts-widget' );
		
		parent::__construct( 'latestposts-widget', esc_attr__('(Salon) Latest Posts', 'ozy-salon-essentials'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		global $ozySalonHelper;
		
		echo $before_widget;

		$title 			= isset($instance['title']) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$type 			= isset($instance['type']) ? $instance['type'] : 'list_with_thumbs';
		$post_type 		= isset($instance['post_type']) ? $instance['post_type'] : 'post';
		$order 			= isset($instance['order']) ? $instance['order'] : 'ASC';
		$orderby 		= isset($instance['orderby']) ? $instance['orderby'] : 'title';
		$posts_per_page = isset($instance['post_per_page']) && (int)$instance['post_per_page'] > 0 ? $instance['post_per_page'] : 9;
		
		$args = array(
			'post_type' 			=> $post_type,
			'posts_per_page'		=> $posts_per_page,
			'orderby' 				=> $orderby,
			'order' 				=> $order,
			'ignore_sticky_posts' 	=> 1,
			'meta_key' 				=> '_thumbnail_id'
		);

		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		
		$the_query = new WP_Query( $args );

		switch($type) {
			case 'thumbs':		
				echo '<div class="ozy-latest-posts">' . PHP_EOL;
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					echo '<a href="' . esc_url(get_permalink()) . '" title="' . esc_attr( get_the_title() ) . '">';
					echo get_the_post_thumbnail(get_the_ID(), 'thumbnail');
					echo '<span>'. get_the_title() .'</span>';
					echo '</a>';
				}
				echo '</div>' . PHP_EOL;			
				break;
			case 'list_with_thumbs':
				echo '<ul class="ozy-latest-posts-with-thumbs">' . PHP_EOL;
				while ( $the_query->have_posts() ) {
					$the_query->the_post();			
					echo '<li><a href="' . esc_url(get_permalink()) . '" title="' . esc_attr( get_the_title() ) . '">';
					echo get_the_post_thumbnail(get_the_ID(), 'thumbnail');
					echo '<span>';
					echo '<strong>' . get_the_title() . '</strong>';
					echo '<small>' . get_the_date() . '</small>';
					echo '</span>';
					echo '</a></li>';
				}
				echo '</ul>' . PHP_EOL;	
				break;
			case 'simple_list':
				echo '<ul class="ozy-simple-latest-posts">' . PHP_EOL;
				while ( $the_query->have_posts() ) {
					$the_query->the_post();			
					echo '<li><a href="' . esc_url(get_permalink()) . '" title="' . esc_attr( get_the_title() ) . '">';
					echo '<strong>' . get_the_title() . '</strong>';
					echo '</a>';
					echo '<small>' . get_the_date() . '</small></li>';
				}
				echo '</ul>' . PHP_EOL;	
				break;
		}
		
		
		//wp_reset_query();
		
		wp_reset_postdata();
		
		echo $after_widget;
	}

	// Update the widget 	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		//Strip tags from variables to remove HTML 
		$instance['type'] = strip_tags( $new_instance['type'] );
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['post_type'] = strip_tags( $new_instance['post_type'] );
		$instance['order'] = strip_tags( $new_instance['order'] );
		$instance['orderby'] = strip_tags( $new_instance['orderby'] );
		$instance['post_per_page'] = strip_tags( $new_instance['post_per_page'] );

		return $instance;
	}

	
	function form( $instance ) {

		//Set up some default widget settings.
		$defaults = array( 'title' => esc_attr__('Latest Posts', 'ozy-salon-essentials'), 'type' => 'list_with_thumbs', 'post_type' => 'post', 'order' => 'ASC', 'orderby' => 'title', 'post_per_page' => 6 );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_attr_e('Title:', 'ozy-salon-essentials'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'type' )); ?>"><?php esc_attr_e('Type:', 'ozy-salon-essentials'); ?></label>
			<?php
				$type_arr = array('list_with_thumbs', 'simple_list', 'thumbs');
			?>
            <select id="<?php echo esc_attr($this->get_field_id( 'type' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'type' )); ?>" style="width:100%;">
            	<?php
					foreach ( $type_arr as $type ) {
					   	echo '<option value="'. esc_attr($type) .'" '. selected( $type, $instance['type'], false ) .'>'. $type .'</option>' . PHP_EOL;
					}
				?>
            </select>
		</p>
        
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'post_type' )); ?>"><?php esc_attr_e('Post Type:', 'ozy-salon-essentials'); ?></label>
			<?php
				$args = array(
				   'public'   => true,
				   '_builtin' => false
				);
				$post_types = get_post_types( $args, 'names' );
				$post_types['post'] = 'post';
				$post_types['page'] = 'page';
			?>
            <select id="<?php echo esc_attr($this->get_field_id( 'post_type' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'post_type' )); ?>" style="width:100%;">
            	<?php
					foreach ( $post_types as $post_type ) {
					   	echo '<option value="'. esc_attr($post_type) .'" '. selected( $post_type, $instance['post_type'], false ) .'>'. $post_type .'</option>' . PHP_EOL;
					}
				?>
            </select>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'order' )); ?>"><?php esc_attr_e('Order:', 'ozy-salon-essentials'); ?></label>
			<?php
				$order_arr = array('ASC', 'DESC');
			?>
            <select id="<?php echo esc_attr($this->get_field_id( 'order' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'order' )); ?>" style="width:100%;">
            	<?php
					foreach ( $order_arr as $order ) {
					   	echo '<option value="'. esc_attr($order) .'" '. selected( $order, $instance['order'], false ) .'>'. $order .'</option>' . PHP_EOL;
					}
				?>
            </select>
		</p>
        
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'orderby' )); ?>"><?php esc_attr_e('Order By:', 'ozy-salon-essentials'); ?></label>
			<?php
				$orderby_arr = array('ID', 'title', 'date', 'rand', 'comment_count');
			?>
            <select id="<?php echo esc_attr($this->get_field_id( 'orderby' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'orderby' )); ?>" style="width:100%;">
            	<?php
					foreach ( $orderby_arr as $orderby ) {
					   	echo '<option value="'. esc_attr($orderby) .'" '. selected( $orderby, $instance['orderby'], false ) .'>'. $orderby .'</option>' . PHP_EOL;
					}
				?>
            </select>
		</p>
        
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'post_per_page' )); ?>"><?php esc_attr_e('Count:', 'ozy-salon-essentials'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'post_per_page' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'post_per_page' )); ?>" value="<?php echo esc_attr($instance['post_per_page']); ?>" style="width:100%;" />
		</p>        

	<?php
	}
}

/**
* Flickr
*/
class SALON_OZY_Flickr_Widget extends WP_Widget {
	function __construct() {
		parent::__construct('flickr_widget', '(Salon) Flickr Widget', array('classname' => 'flickr', 'description' => esc_attr__('(Salon) Flickr Widget for user photo stream!', 'ozy-salon-essentials')), array('id_base' => 'flickr_widget'));
		}

	function widget($args, $instance)
	{
		extract($args);
		$title 		= apply_filters('widget_title', $instance['title']);
		$user_name 	= $instance['user_name'];
		$number 	= $instance['number'];
		$under_text	= $instance['under_text'];
		$img_widht	= $instance['img_widht'];
		$img_height	= $instance['img_height'];

		echo $before_widget;

		if($title!='') {
			echo $before_title.$title.$after_title;
		}

		if($user_name && $number) {
			$api_key = '74b457aa69dd159cd7ac798c08fb5418';

			if($user_name) {
				$url_item = wp_remote_get('https://api.flickr.com/services/rest/?method=flickr.urls.getUserPhotos&api_key='.esc_js($api_key).'&user_id='.urlencode($user_name).'&format=json');
				$url_item = trim($url_item['body'], 'jsonFlickrApi()');
				$url_item = json_decode($url_item);
				$photos = wp_remote_get('https://api.flickr.com/services/rest/?method=flickr.people.getPublicPhotos&api_key='.esc_js($api_key).'&user_id='.urlencode($user_name).'&per_page='.$number.'&format=json');
				$photos = trim($photos['body'], 'jsonFlickrApi()');
				$photos = json_decode($photos);
				?>
				<ul class='flickr-widget'>
					<?php foreach($photos->photos->photo as $photo): $photo = (array) $photo; ?>
					<li class='flickr-single-photo'>
						<a href='<?php echo esc_url($url_item->user->url); ?><?php echo esc_attr($photo['id']); ?>' target='_blank' title="<?php echo esc_attr($photo['title']); ?>">
							<img src='<?php $url = "http://farm" . $photo['farm'] . ".static.flickr.com/" . $photo['server'] . "/" . $photo['id'] . "_" . $photo['secret'] . '_s' . ".jpg"; echo esc_url($url); ?>' alt='<?php echo esc_attr($photo['title']); ?>' width="<?php echo esc_attr($img_widht); ?>" height="<?php echo esc_attr($img_height); ?>" />
						</a>
					</li>
					<?php endforeach; ?>
				</ul>
				<?php
			} else {
				echo '<p>'. esc_attr__('Invalid flickr user ID.', 'ozy-salon-essentials') .'</p>';
			}
		}
		if($under_text!=''){
			echo '<div class="widget_description"><p>'. $instance['under_text'] .'</p></div>';
		}
		echo $after_widget;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Flickr Stream', 'user_name' => '', 'number' => 6,'under_text'=>'','img_widht'=>60,'img_height'=>60);
		$instance = wp_parse_args((array) $instance, $defaults); ?>	
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:</label>
			<input style="width:100%;" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('user_name')); ?>">User ID (<a href="http://idgettr.com/" target="_blank">Get it here</a>):</label>
			<input style="width:100%;" id="<?php echo esc_attr($this->get_field_id('user_name')); ?>" name="<?php echo esc_attr($this->get_field_name('user_name')); ?>" value="<?php echo esc_attr($instance['user_name']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('number')); ?>">Number of photos to show:</label>
			<input style="width:100%;" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" value="<?php echo esc_attr($instance['number']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('under_text')); ?>">Type text under widget(Optional):</label>
			<textarea style="resize:none; width:100%; height:50px;" id="<?php echo esc_attr($this->get_field_id('under_text')); ?>" name="<?php echo esc_attr($this->get_field_name('under_text')); ?>"><?php echo esc_attr($instance['under_text']); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('img_widht')); ?>">Image width:</label>
			<input style="width:100%;" id="<?php echo esc_attr($this->get_field_id('img_widht')); ?>" name="<?php echo esc_attr($this->get_field_name('img_widht')); ?>" value="<?php echo esc_attr($instance['img_widht']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('img_height')); ?>">Image Height:</label>
			<input style="width:100%;" id="<?php echo esc_attr($this->get_field_id('img_height')); ?>" name="<?php echo esc_attr($this->get_field_name('img_height')); ?>" value="<?php echo esc_attr($instance['img_height']); ?>" />
		</p>		
	<?php
	}
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] 		= strip_tags($new_instance['title']);
		$instance['user_name'] 	= $new_instance['user_name'];
		$instance['number'] 	= $new_instance['number'];
		$instance['under_text'] = $new_instance['under_text'];	
		$instance['img_widht'] 	= $new_instance['img_widht'];
		$instance['img_height'] = $new_instance['img_height'];
		return $instance;
	}
}


?>