<?php 
get_header(); 

$hide_title = false;

/*get post format*/
salon_sd('ozy_temporary_post_format', get_post_format());
salon_sd('ozy_current_post_format', get_post_format());
if ( false === salon_gd('ozy_current_post_format') ) {
	salon_sd('ozy_current_post_format', 'standard');
}

if ( have_posts() ) while ( have_posts() ) : the_post();

/* Widgetized LEFT sidebar */
if(function_exists( 'dynamic_sidebar' ) && $ozySalonHelper->hasIt(salon_gd('_page_content_css_name'),'left-sidebar') && salon_gd('_page_sidebar_name')) {
?>
	<div id="sidebar" class="<?php echo esc_attr(salon_gd('_page_content_css_name')); echo esc_attr(salon_gd('blog_has_super_header') ? ' has-super-header' : ''); ?>">
		<ul>
        	<?php dynamic_sidebar( salon_gd('_page_sidebar_name') ); ?>
		</ul>
	</div>
	<!--sidebar-->
<?php
}
?>
<div id="content" class="<?php echo esc_attr(salon_gd('_page_content_css_name')); ?>">
    <div class="wpb_row vc_row-fluid">
        <div class="parallax-wrapper">
            <div class="vc_col-sm-12 wpb_column vc_column_container">
                <div class="wpb_wrapper">

                    <div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
                
                        <article>
                            <?php
							$ozy_current_post_format = salon_gd('ozy_current_post_format');
                            /*here i am handling content to extract media objects*/
                            ob_start();
                            //if this is a gallery post, please remove gallery shortcode to render it as expected
                            if('gallery' === $ozy_current_post_format) {
                                salon_convert_classic_gallery();
                            } else {
                                the_content('<p>' . esc_attr__('READ MORE &rarr;', 'salon') . '</p>');
                            }
							
							wp_link_pages();
							
                            $ozy_content_output = ob_get_clean();
                        
                            /*if( 'gallery' === $ozy_current_post_format ) {
                                //echo $ozySalonHelper->post_flickty_slider();
								echo $ozySalonHelper->post_flickty_slider(false, '', '', $hide_title);
                            } else */
							if( 'aside' === $ozy_current_post_format || 'link' === $ozy_current_post_format ) {
                                $hide_title = true;
                            } else if( 'video' !== $ozy_current_post_format && 'audio' !== $ozy_current_post_format ) {
                               	if(!salon_gd('blog_has_super_header')) {
									if ( has_post_thumbnail() ) { 
										$thumbnail_image_src	= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' , false );
										$post_image_src 		= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'salon_blog' , false );
										 if ( isset($thumbnail_image_src[0]) && isset($post_image_src[0])) { 
											 echo '<div class="featured-thumbnail" style="background-image:url('. esc_url($post_image_src[0]) .');"><a href="'. esc_url($thumbnail_image_src[0]) .'" class="fancybox"></a>'; the_post_thumbnail('salon_blog'); echo '</div>';
										 }
									}
								}
                            }
                
                            /*and here i am printing media object which handled in functions.php ozy_add_video_embed_title()*/
                            if(salon_gd('media_object')) echo salon_gd('media_object');
                            
                            if('audio' == $ozy_current_post_format) {
                                $thumbnail_image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'salon_showbiz' , false );
                                echo '<div class="post-excerpt-'. esc_attr($ozy_current_post_format) .' simple-post-format">
                                        <div>';
                                    if(isset($thumbnail_image_src[0])) {
                                        echo '<img src="'. esc_url($thumbnail_image_src[0]) .'" class="audio-thumb" alt=""/>';
                                    }
                                    echo '<div>';							
                                    echo $ozy_content_output;
                                    echo '</div>';
                                echo '	</div>
                                    </div>';								
                            }
                            
							if(!salon_gd('blog_has_super_header')) {
								if(has_post_thumbnail()) {
									$ozySalonHelper->salon_masonry_blog_date_comment_box();;
								}
                            ?>
                            <div class="post-meta-simple">
                                <p class="g"><?php esc_attr_e('By ', 'salon'); ?></p>
                                <p><?php the_author_posts_link(); ?></p>
                                <p class="g"><?php esc_attr_e(' in ', 'salon');?></p>
                                <p><?php the_category(', '); ?></p>
                                <?php if(!has_post_thumbnail()) { echo '<p>'; esc_attr_e(' at ', 'salon'); the_time(SALON_DATE_FORMAT); echo '</p>'; } ?>
                            </div><!--.post-meta-simple-->

                            <div class="clear"></div> 

                            <?php
								if(!$hide_title && 'audio' !== $ozy_current_post_format) {
									echo '<h2 class="post-title">';
									echo '<a href="'. esc_url(get_permalink()) .'" title="'. esc_attr(get_the_title()) .'" class="a-page-title" rel="bookmark">'. 
									( get_the_title() ? get_the_title() : get_the_time(SALON_DATE_FORMAT) ) .
									'</a>';
									echo '</h2>';
									echo '<div class="header-line"><span></span></div>';
								}
							}
                            ?>
                            <div class="post-content">                               
                                <?php
                                    if('audio' !== $ozy_current_post_format) {
                                        echo $ozy_content_output;
                                    }					
                                ?>
                            </div><!--.post-content-->

                            <?php edit_post_link('<p><small>Edit this entry</small></p>','',''); ?>
                            
                        </article>
                
                        <?php 
						if( has_tag() ) {
						?>
                        <div id="single-blog-tags"><?php the_tags('', '', ''); ?></div><!--#single-blog-tags-->
                        <?php						
						}
                        if(salon_get_option('page_blog_share') == '1') {
                            include(SALON_BASE_DIR . 'include/share-buttons.php');
                            echo '<div class="clear"></div>';
                        }						
						?>
                
                    </div><!-- #post-## -->
                    
                    <div class="clear"></div> 
                    
                    <?php
                    /* If a user fills out their bio info, it's included here */ 
                    if (get_the_author_meta('description') && salon_get_option('page_blog_author') == '1') : 
                    ?>
                    <div id="post-author">
                        <p class="gravatar"><?php if(function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '80' ); } ?></p>
                        <div id="authorDescription">
                            <h3><?php esc_attr_e('About ', 'salon'); the_author_posts_link() ?></h3>
                            <?php the_author_meta('description') ?> 
                        </div><!--#author-description -->
                    </div><!--#post-author-->
                    <?php
                    endif;
                    ?>                   
                    <div class="clear"></div> 
                    <?php 
                        if( salon_get_option('page_blog_comment') == '1' && comments_open()) { 
                            comments_template( '', true );
                        }
                    ?>                    
                </div>
            </div>
        </div>
	</div>
</div><!--#content-->

<div class="clear"></div> 
<?php
    $ozySalonHelper->previous_next_post_navigation();
    
    $ozySalonHelper->blog_related_posts();
?>

<?php 
/* Widgetized RIGHT sidebar */
if(function_exists( 'dynamic_sidebar' ) && $ozySalonHelper->hasIt(salon_gd('_page_content_css_name'),'right-sidebar') && salon_gd('_page_sidebar_name')) {
?>
	<div id="sidebar" class="<?php echo esc_attr(salon_gd('_page_content_css_name')); echo esc_attr(salon_gd('blog_has_super_header') ? ' has-super-header' : ''); ?>">
		<ul>
        	<?php dynamic_sidebar( salon_gd('_page_sidebar_name') ); ?>
		</ul>
	</div>
	<!--sidebar-->
<?php
}
endwhile; /* end loop */
get_footer(); 
?>