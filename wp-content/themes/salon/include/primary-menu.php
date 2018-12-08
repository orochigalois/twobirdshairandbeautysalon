		<?php 
		if(salon_gd('hide_everything_but_content') <= 1) { 
		?>
            <div class="logo">
                <?php
                if(salon_get_option('use_custom_logo') == '1') {
                    echo '<a href="'. esc_url(get_home_url('/')) .'" id="logo">';
                    echo '<img id="logo-default" src="'. salon_get_option('custom_logo') .'" '. (salon_get_option('custom_logo_retina') ? 'data-at2x="'. salon_get_option('custom_logo_retina') .'"' : '') .' data-src="'. salon_get_option('custom_logo') .'" alt="logo"/>';
                    echo '<img id="logo-alternate" src="'. esc_url(salon_get_option('custom_logo_alternate')) .'" '. (salon_get_option('custom_logo_retina_alternate') ? 'data-at2x="'. salon_get_option('custom_logo_retina_alternate') .'"' : '') .' data-src="'. esc_url(salon_get_option('custom_logo_alternate')) .'" alt="logo"/>';								
                    echo '</a>';										
                }else{
                     echo '<h1><a href="'. esc_url(home_url('/')) .'/" title="'. esc_attr(get_bloginfo('description')) .'">'. get_bloginfo('name') .'</a></h1>';
                }
                ?>
            </div>
            
            <!--language-switcher-booking-button-->
			<?php 
			salon_wpml_language_switcher(false);
			salon_floating_booking_button();
			?>
            <!--language-switcher-booking-button-end-->

            <a href="#salon-nav" class="salon-nav-trigger"><?php esc_attr_e('Menu', 'salon') ?>
                <span class="salon-nav-icon"></span><svg x="0px" y="0px" width="54px" height="54px" viewBox="0 0 54 54"><circle fill="transparent" stroke="#656e79" stroke-width="1" cx="27" cy="27" r="25" stroke-dasharray="157 157" stroke-dashoffset="157"></circle></svg>
            </a>
            
            <div id="salon-nav" class="salon-nav">
                <div class="salon-navigation-wrapper">           
                     <div class="salon-half-block salon-navigation">
                        <h2 class="content-font"><?php esc_html_e('Navigation', 'salon') ?></h2>
        
                        <nav>
                        <?php
                            $args = array(
                                'menu_class' => 'salon-primary-nav', 
                                'container' => '',
                                'fallback_cb' => true,								
                                'walker' => new BootstrapNavMenuWalker
                            );
                            if (has_nav_menu('logged-in-menu') && has_nav_menu('header-menu')) {
                                $args['theme_location'] = (is_user_logged_in() ? 'logged-in-menu' : 'header-menu');							
                            }else{
                                salon_sd('custome_primary_menu', true); //if no location selected, make sure SEARCH button will be visible on menu
                            }
                            if(salon_get_metabox('custom_menu') !== '-1' && salon_get_metabox('custom_menu')) {
                                $args['menu'] = salon_get_metabox('custom_menu');
                                salon_sd('custome_primary_menu', true);
                            }
                            wp_nav_menu( $args );
                        ?>                                         
                        </nav>
                    </div><!-- .salon-half-block -->
                   <div class="salon-half-block salon-contact-info">
                        <?php
                            $tmp_lang = str_replace('_', '', salon_gd('wpml_current_language_'));   
                            if(salon_get_option('primary_menu_address_text' . $tmp_lang)) {
                                echo nl2br(salon_get_option('primary_menu_address_text' . $tmp_lang));
                            }
                        ?>
                        <div class="salon-social-icons">
	                        <?php salon_header_social_icons(); ?>
                        </div>
                    </div> <!-- .salon-half-block -->                                
                </div> <!-- .salon-navigation-wrapper -->
            </div> <!-- .salon-nav -->                         
            
        <?php
		}
        ?>