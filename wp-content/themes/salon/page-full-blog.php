<?php 
/*
Template Name: Blog : Full Page
*/
get_header(); 
?>
	<div id="content" class="<?php echo esc_attr(salon_gd('_page_content_css_name')); ?>">
        
        <div class="wpb_row vc_row-fluid">
			<div class="parallax-wrapper">
            	<div class="vc_col-sm-12 wpb_column vc_column_container">
                	<div class="wpb_wrapper">
						<?php
                            query_posts( array(
                                'cat'					=> salon_gd('_blog_include_categories'),
                                'post_type' 			=> 'post',
                                'post_status'			=> 'publish',
                                'orderby' 				=> salon_gd('_blog_orderby'),
                                'order' 				=> salon_gd('_blog_order'),
								'meta_key' 				=> '_thumbnail_id',
								'ignore_sticky_posts' 	=> 1,
                                'paged'					=> get_query_var('paged'),
								'tax_query' 			=> 
									array(
										array(
											'taxonomy' => 'post_format',
											'field' => 'slug',
											'terms' => array( 'post-format-quote', 'post-format-status', 'post-format-link', 'post-format-audio' ),
											'operator' => 'NOT IN'
										)
									)					
								)
							);
                            $counter = 0;
                            if (have_posts()) : while (have_posts()) : the_post(); 
                                salon_sd('media_object', '');
								salon_blog_more();
                                
                                /*get post format*/
                                $ozy_temporary_post_format = $ozy_current_post_format = get_post_format();
                                if ( false === $ozy_current_post_format ) {
                                    $ozy_current_post_format = 'standard';
                                }
                                $hide_title = false;
                                
                                /*here i am handling content to extract media objects*/
                                ob_start();
                                if($post->post_excerpt) {
                                    the_excerpt();
                                }else{
                                    //if this is a gallery post, please remove gallery shortcode to render it as expected
                                    if('gallery' === $ozy_current_post_format) {
                                        salon_convert_classic_gallery();
                                    } else {
										the_content('');										
                                    }
                                }
                                $ozy_content_output = ob_get_clean();				
                
                        ?>
						<div <?php post_class('post-single post-format-'. esc_attr($ozy_current_post_format) . ' ozy-waypoint-animate ozy-appear'); ?>>
                        	<div class="p <?php echo $counter%2===0 ? 'l' : 'r' ?>">
                                <div class="arrow"></div>
							<?php
                                $thumbnail_image_src = $post_image_src = array();
                                if ( has_post_thumbnail() ) { 
                                    $thumbnail_image_src 	= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' , false );
                                    $post_image_src 		= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'blog' , false );						
                                }
                                
                                /*post format processing*/
                                if( 'gallery' === $ozy_current_post_format ) {
                                    //echo $ozySalonHelper->post_flickty_slider();
									echo $ozySalonHelper->post_flickty_slider(false, $thumbnail_image_src, $post_image_src, $hide_title);
                                } 
                                else if( 'video' !== $ozy_current_post_format && 'audio' !== $ozy_current_post_format )
                                {
                                    if ( isset($thumbnail_image_src[0]) && isset($post_image_src[0])) { 
                                        echo '<div class="featured-thumbnail" style="background-image:url('. esc_url($post_image_src[0]) .');"><a href="'. get_permalink() .'"><div>'. esc_html__('SHOW ME MORE PLEASE', 'salon') .'</div></a>'; the_post_thumbnail('blog'); echo '</div>'; 
                                    }									
                                }
                
                                /*and here i am printing media object which handled in functions.php salon_add_video_embed_title()*/
                                if(isset($ozy_global_params['media_object'])) echo $ozy_global_params['media_object'];
                            ?>
                            </div>
                            <div class="t <?php echo $counter%2===0 ? 'r' : 'l' ?>">
								<?php
                                if($hide_title) {
    
                                        echo '<h2 class="post-title">';
                                        the_title();
                                        echo '</h2>';
                                        echo the_excerpt();
    
                                }
                                if('audio' == $ozy_current_post_format) {
                                    $thumbnail_image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'showbiz' , false );
                                    echo '<div class="post-excerpt-'. esc_attr($ozy_current_post_format) .' simple-post-format">
                                            <div>
                                                <span class="icon"></span>';
                                        if(isset($thumbnail_image_src[0])) {
                                            echo '<img src="'. esc_url($thumbnail_image_src[0]) .'" class="audio-thumb" alt=""/>';
                                        }
                                        echo '<div>';							
                                        echo the_excerpt();
                                        echo '</div>';
                                    echo '	</div>
                                        </div>';								
                                }

                                if(!$hide_title && 'audio' !== $ozy_current_post_format) {
									echo '<strong>'; the_category(', '); echo '</strong>';
                                    echo '<h2 class="post-title">';
                                        echo '<a href="'. get_permalink() .'" title="'. get_the_title() .'" class="a-page-title" rel="bookmark">'. ( get_the_title() ? get_the_title() : get_the_time(SALON_DATE_FORMAT) ) .'</a>';
                                    echo '</h2>';

                                    echo '<div class="post-content">';
                                        echo the_excerpt();
                                    echo '</div>';
                                }
                                ?>
                                <div class="post-meta-full content-color-alternate">
                                    <?php esc_attr_e('Published by', 'salon');echo ' '; the_author_posts_link();echo ' &bull; '; the_time(SALON_DATE_FORMAT); ?>
                                </div><!--#post-meta-->          
                                <div class="post-submeta-full">
                                    <?php if(!$hide_title) {
                                        echo '<a href="'. get_permalink() .'" class="read-more content-color" title="'. esc_html__('SHOW ME MORE PLEASE', 'salon') .'">'. salon_full_blog_arrow_svg() .'</a>';	
                                    ?>                                          
                                    	<br>
                                        <span class="share-buttons">
                                            <a href="http://www.facebook.com/share.php?u=<?php echo esc_url(get_permalink()) ?>"><span class="tooltip-top symbol content-color" title="Facebook">&#xe027;</span></a>
                                            <a href="https://twitter.com/share?url=<?php echo esc_url(get_permalink()) ?>"><span class="tooltip-top symbol content-color" title="Twitter">&#xe086;</span></a>
                                            <a href="//pinterest.com/pin/create/link/?url=<?php echo esc_url(get_permalink()) ?>&description=<?php the_title();?>"><span class="tooltip-top symbol content-color" title="Pinterest">&#xe064;</span></a>
                                        </span>
                                    <?php
                                    }
                                    ?>
                                </div>                                
                			</div>
                        </div><!--.post-single-->        
                        
                        <?php $counter++; endwhile; else: ?>
                        <div class="no-results">
                            <p><strong><?php esc_attr_e('There has been an error.', 'salon'); ?></strong></p>
                            <p><?php esc_attr_e('We apologize for any inconvenience, please hit back on your browser or use the search form below.', 'salon'); ?></p>
                            <?php get_search_form(); /* outputs the default Wordpress search form */ ?>
                        </div><!--noResults-->
                        <?php endif; ?>
                        
                        <?php echo salon_get_pagination('<div class="page-pagination">', '</div>'); ?>

					</div>
				</div>
             
        	</div>
        </div>
        
	</div><!--#content-->
    
<?php                 
get_footer();
?>