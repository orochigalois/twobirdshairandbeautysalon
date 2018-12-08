<?php 
get_header(); 

if(isset($_GET['author_name'])){$curauth = get_userdatabylogin($author_name);}else{$curauth = get_userdata(intval($author));}

if(function_exists( 'dynamic_sidebar' ) && $ozySalonHelper->hasIt(salon_gd('_page_content_css_name'),'left-sidebar') && salon_gd('_page_sidebar_name')) {
?>
	<div id="sidebar" class="<?php echo esc_attr(salon_gd('_page_content_css_name')); ?>">
		<ul>
        	<?php dynamic_sidebar( salon_gd('_page_sidebar_name') ); ?>
		</ul>
	</div>
	<!--sidebar-->
<?php
}
?>
	<div id="content" class="<?php echo esc_attr(salon_gd('_page_content_css_name')); ?> author-page">
        
        <div class="wpb_row vc_row-fluid">
			<div class="parallax-wrapper">
            	<div class="vc_col-sm-12 wpb_column vc_column_container">
                	<div class="wpb_wrapper">

                        <div class="author-bio">
                            <p class="avatar"><?php if(function_exists('get_avatar')) { echo get_avatar( $curauth->user_email, $size = '80' ); } /* Displays the Gravatar based on the author's email address. Visit Gravatar.com for info on Gravatars */ ?></p>
                            
                            <?php if($curauth->description !="") { /* Displays the author's description from their Wordpress profile */ ?>
                                <p><?php echo $curauth->description; ?></a></p>
                            <?php } ?>
                        </div>
                        <h3 class="page-title"><?php esc_attr_e('Recent Posts by ', 'salon'); echo $curauth->display_name; ?></h3>
                        
                        <?php							
							
                            if (have_posts()) : while (have_posts()) : the_post(); 
							
								// Number of posts to display
								static $count = 0;
								if ($count == "5") { 
									break;
								}
							
                                global $more; $more = 0; 
								
								salon_sd('media_object', '');
                                
                                /*get post format*/
                                salon_sd('ozy_temporary_post_format', get_post_format());
								salon_sd('ozy_current_post_format', get_post_format());
                                if ( false === salon_gd('ozy_current_post_format') ) {
                                    salon_sd('ozy_current_post_format', 'standard');
                                }
                                $hide_title = false;
                                
                                /*here i am handling content to extract media objects*/
                                ob_start();
                                if($post->post_excerpt) {
                                    the_excerpt();
                                }else{
                                    //if this is a gallery post, please remove gallery shortcode to render it as expected
                                    if('gallery' === salon_gd('ozy_current_post_format')) {
                                        salon_convert_classic_gallery();
                                    } else {
										the_content('');
                                    }                                
								}
								
								wp_link_pages();
								
                                $ozy_content_output = ob_get_clean();
                							
							$ozy_current_post_format = salon_gd('ozy_current_post_format');
							
							if( 'aside' === $ozy_current_post_format || 
								'link' === $ozy_current_post_format || 
								'status' === $ozy_current_post_format || 
								'quote' === $ozy_current_post_format ) {
	                                $hide_title = true;
                            }
                        ?>
						<div <?php post_class('post-single post-format-'. esc_attr($ozy_current_post_format) . ($hide_title || 'audio' === $ozy_current_post_format? ' post-simple':'') . ' ozy-waypoint-animate ozy-appear regular-blog'); ?>>                        
						<?php
							$thumbnail_image_src = $post_image_src = array();
							if ( has_post_thumbnail() ) { 
								$thumbnail_image_src 	= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' , false );
								$post_image_src 		= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'salon_blog' , false );						
							}
							
                            /*post format processing*/
                            if( 'gallery' === $ozy_current_post_format ) {								
								echo $ozySalonHelper->post_flickty_slider(false, $thumbnail_image_src, $post_image_src, $hide_title);
                            } else if( 'video' !== $ozy_current_post_format && 'audio' !== $ozy_current_post_format ) {
                                if ( isset($thumbnail_image_src[0]) && isset($post_image_src[0])) { 
									echo '<div class="featured-thumbnail regular-blog" style="background-image:url('. esc_url($post_image_src[0]) .');">';
									$ozySalonHelper->salon_masonry_blog_date_comment_box();;
									echo '<a href="'. esc_url($thumbnail_image_src[0]) .'" class="fancybox"></a>';
									the_post_thumbnail('salon_blog');
									echo '</div>'; 
                                }
                            }

							if(salon_gd('media_object') && salon_gd('media_object') && 'video' === $ozy_current_post_format) {
								echo '<div class="featured-thumbnail">' . salon_gd('media_object');
								$ozySalonHelper->salon_masonry_blog_date_comment_box();;
								echo '</div>';
							}

							?>
                            <div>
                            	<?php 
								if('audio' != $ozy_current_post_format && !$hide_title) {
								?>
                                <div class="post-meta-simple">
                                    <p class="g"><?php esc_attr_e('By ', 'salon'); ?></p>
                                    <p><?php the_author_posts_link(); ?></p>
                                    <p class="g"><?php esc_attr_e(' in ', 'salon');?></p>
                                    <p><?php the_category(', '); ?></p>
                                </div><!--#post-meta-->
                                <?php
								}
                                if($hide_title) {
                                    echo '<div class="post-excerpt-'. esc_attr($ozy_current_post_format) .' simple-post-format" style="'. (isset($thumbnail_image_src[0]) ? 'background-image:url('. esc_url($thumbnail_image_src[0]) .');':'' ) .'">
                                            <div>';
										$ozySalonHelper->salon_masonry_blog_date_comment_box();;
                                        if('aside' == $ozy_current_post_format) {
											echo '<h2 class="post-title">';the_title();echo '</h2>';
											echo '<div class="header-line"><span></span></div>';
										}
                                        echo $ozy_content_output;
                                    echo '	</div>
                                        </div>';
                                }
                                if('audio' == $ozy_current_post_format) {
									$inline_audio_style = '';
                                    $thumbnail_image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'salon_showbiz' , false );
									if(isset($thumbnail_image_src[0])) {
										$inline_audio_style = 'style="background:url('. esc_url($thumbnail_image_src[0]) .');"';
									}							
                                    echo '<div class="post-excerpt-'. esc_attr($ozy_current_post_format) .' simple-post-format">
                                            <div '. $inline_audio_style .'>';											
										$ozySalonHelper->salon_masonry_blog_date_comment_box();;
                                        echo '<div class="player">';							
                                        echo $ozy_content_output;
                                        echo '</div>';
                                    echo '	</div>
                                        </div>';								
                                }
								
								if('audio' === $ozy_current_post_format || $hide_title) {
								?>
                                <div class="post-meta-simple">
                                    <p class="g"><?php esc_attr_e('By ', 'salon'); ?></p>
                                    <p><?php the_author_posts_link(); ?></p>
                                    <p class="g"><?php esc_attr_e(' in ', 'salon');?></p>
                                    <p><?php the_category(', '); ?></p>
                                </div><!--.post-meta-simple-->
                                <?php
								}								
    
                                if(!$hide_title && 'audio' !== $ozy_current_post_format) {
                                    echo '<h2 class="post-title">';
                                        echo '<a href="'. esc_url(get_permalink()) .'" title="'. esc_attr(get_the_title()) .'" class="a-page-title" rel="bookmark">'. ( get_the_title() ? get_the_title() : get_the_time(get_option('date_format')) ) .'</a>';
                                    echo '</h2>';
    
                                    echo '<div class="header-line"><span></span></div>';
                                    
                                    echo '<div class="post-content">';
                                        echo $ozy_content_output;
                                    echo '</div>';
                                }

								if(!$hide_title && 'audio' !== $ozy_current_post_format) { 
									echo '<div class="post-submeta"><a href="'. esc_url(get_permalink()) .'">'. esc_attr__('READ MORE', 'salon') .'</a></div>'; 
								}
                                ?>
                			</div>
                        </div><!--.post-single-->   
                        
                        <?php endwhile; else: ?>
                        <div class="no-results">
                            <p><strong><?php esc_attr_e('There has been an error.', 'salon'); ?></strong></p>
                            <p><?php esc_attr_e('We apologize for any inconvenience, please hit back on your browser or use the search form below.', 'salon'); ?></p>
                            <?php get_search_form(); /* outputs the default Wordpress search form */ ?>
                        </div><!--noResults-->
                        <?php endif; ?>
                        
                        <p>&nbsp;</p>
                        
                        <div id="recent-author-comments">
                            <h3 class="page-title"><?php esc_attr_e('Recent Comments by ', 'salon'); echo $curauth->display_name; ?></h3>
                            <?php
                                $number=5; // number of recent comments to display
                                $comments = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->comments WHERE comment_approved = '1' and comment_author_email='%s' ORDER BY comment_date_gmt DESC LIMIT %d", $curauth->user_email, $number));
                            ?>
                            <ul>
                                <?php
                                    if ( $comments ) : foreach ( (array) $comments as $comment) :
                                    echo  '<li class="recentcomments"><i class="oic-bubble"></i>&nbsp;' . sprintf(esc_attr__('%1$s on %2$s', 'salon'), get_comment_date(), '<a href="'. get_comment_link($comment->comment_ID) . '">' . get_the_title($comment->comment_post_ID) . '</a>') . '</li>';
                                endforeach; else: ?>
                                    <p><?php esc_attr_e('No comments by ', 'salon'); echo $curauth->display_name; ?></p>
                                <?php endif; ?>
                            </ul>
                        </div><!--#recentAuthorComments-->                        

					</div>
				</div>
             
        	</div>
        </div>
        
	</div><!--#content-->
<?php
/* Widgetized RIGHT sidebar */
if(function_exists( 'dynamic_sidebar' ) && $ozySalonHelper->hasIt(salon_gd('_page_content_css_name'),'right-sidebar') && salon_gd('_page_sidebar_name')) {
?>
	<div id="sidebar" class="<?php echo esc_attr(salon_gd('_page_content_css_name')); ?>">
		<ul>
        	<?php dynamic_sidebar( salon_gd('_page_sidebar_name') ); ?>
		</ul>
	</div>
	<!--sidebar-->
<?php
}                    

get_footer();
?>