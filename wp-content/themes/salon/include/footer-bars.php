            <?php
				$tmp_lang = salon_gd('wpml_current_language_');
				if(salon_gd('hide_everything_but_content') <= 0) { 
				
				if(salon_get_metabox('hide_footer_widget_bar') !== '1' && salon_get_metabox('hide_footer_widget_bar') !== '2') { 
				
				if(salon_gd('footer_info_bar')) {
				?>
                <div id="footer-widget-bar-sticky" class="widget">                
                    <div class="container info-bar">
                        <section class="widget-area">
                        	<a href="#close-footer-info-bar" id="close-footer-info-bar">X</a>
                            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("ozy-footer-widget-bar-info" . $tmp_lang) ) : ?><?php endif; ?>
                        </section>
					</div>
				</div>
                <?php 
				}
				?>
                <div id="footer-widget-bar" class="widget">                
                    <div class="container">
                        
                        <section class="widget-area">
                            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("ozy-footer-widget-bar-two" . $tmp_lang) ) : ?><?php endif; ?>
                        </section>
                        <section class="widget-area">
                            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("ozy-footer-widget-bar-three" . $tmp_lang) ) : ?><?php endif; ?>
                        </section>
                                                                      
                    </div><!--.container-->                     
                </div><!--#footer-widget-bar-->
                <?php } ?>
                <?php if(salon_get_metabox('hide_footer_widget_bar') !== '2') { ?>
                <div id="footer"><footer>
                    <div class="container">
                    	<hr>
                        <?php
							$tmp_lang = str_replace('_', '', salon_gd('wpml_current_language_'));
							if(salon_get_option('section_footer_copyright_text' . $tmp_lang)) {
								echo '<div id="footer-line-1">' . salon_get_option('section_footer_copyright_text' . $tmp_lang) . '</div>';
							}
							if(salon_get_option('section_footer_social_icons' . $tmp_lang)) {
								echo '<div id="social-icons">' . PHP_EOL;
								salon_header_social_icons();
								echo '</div>' . PHP_EOL;
							}
                        ?>                       
                    </div><!--.container-->
                </footer></div><!--#footer-->
                <?php } ?>
            <?php } ?>