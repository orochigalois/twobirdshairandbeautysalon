<?php 
/*
Template Name: Blog : Big
*/
get_header(); 

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
	<div id="content" class="<?php echo esc_attr(salon_gd('_page_content_css_name')); ?>">
        
        <div class="wpb_row vc_row-fluid">
			<div class="parallax-wrapper">
            	<div class="vc_col-sm-12 wpb_column vc_column_container">
                	<div class="wpb_wrapper">
						<?php
                            query_posts( array(
                                'cat'				=> salon_gd('_blog_include_categories'),
                                'post_type' 		=> 'post',
                                'post_status'		=> 'publish',
                                'orderby' 			=> salon_gd('_blog_orderby'),
                                'order' 			=> salon_gd('_blog_order'),
                                'paged'				=> get_query_var('paged'),
								'tax_query' => array(

									array(
										'taxonomy' => 'post_format',
										'field'    => 'slug',
										'terms' => array('post-format-aside', 'post-format-link', 'post-format-quote', 'post-format-status', 'post-format-audio', 'post-format-chat'),
										'operator' => 'NOT IN'										


									),
								),								
							));

							while (have_posts()) { the_post();                            
							    salon_blog_more();
								salon_sd('media_object', '');
                                
                                /*get post format*/
                                salon_sd('ozy_temporary_post_format', get_post_format());
								salon_sd('ozy_current_post_format', get_post_format());
                                if ( false ===  salon_gd('ozy_current_post_format') ) {
                                    salon_sd('ozy_current_post_format', 'standard');
                                }
                                
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
                        ?>
						<div <?php post_class('post-single post-format-'. esc_attr(salon_gd('ozy_current_post_format')) . ' ozy-waypoint-animate ozy-appear regular-blog'); ?>>                        
						<?php
						
							echo '<h2 class="post-title">';
								echo '<a href="'. esc_url(get_permalink()) .'" title="'. esc_attr(get_the_title()) .'" class="a-page-title" rel="bookmark">'. ( get_the_title() ? get_the_title() : get_the_time(SALON_DATE_FORMAT) ) .'</a>';
							echo '</h2>';

							echo '<p class="big-blog-date">'; the_time(SALON_DATE_FORMAT); echo '</p>';
							echo '<span class="big-blog-date-category-seperator"></span>';
                            echo '<p class="big-blog-category">'; $ozySalonHelper->salon_the_category($post->ID); echo '</p>';
						
							echo '<div class="post-content">';
								echo $ozy_content_output;
							echo '</div>';						
						
							$thumbnail_image_src = $post_image_src = array();
							if ( has_post_thumbnail() ) { 
								$thumbnail_image_src 	= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' , false );
								$post_image_src 		= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'salon_blog' , false );						
							}
							
                            /*post format processing*/
                            if( 'gallery' === salon_gd('ozy_current_post_format') ) {								
                                echo $ozySalonHelper->post_flickty_slider();


                            } else if( 'video' !== salon_gd('ozy_current_post_format') && 'audio' !== salon_gd('ozy_current_post_format') ) {
                                if ( isset($thumbnail_image_src[0]) && isset($post_image_src[0])) { 
									echo '<div class="featured-thumbnail regular-blog" style="background-image:url('. esc_url($post_image_src[0]) .');">';

									echo '<a href="'. esc_url($thumbnail_image_src[0]) .'" class="fancybox"></a>';
									the_post_thumbnail('salon_blog');
									echo '</div>'; 
                                }
                            }

							if(salon_gd('media_object') && salon_gd('media_object') && 'video' === salon_gd('ozy_current_post_format')) {
								echo '<div class="featured-thumbnail">' . salon_gd('media_object') . '</div>';


							}

							?>
                            <div>
                                <div class="big-blog-post-submeta">
                                    <a href="<?php echo esc_url(get_permalink()) ?>" class="button blog-like-link" data-post_id="<?php echo $post->ID; ?>"><i class="oic-heart-2"></i><span><?php echo (int)get_post_meta($post->ID, "ozy_post_like_count", true); ?></span>&nbsp;<?php esc_attr_e('Like', 'salon') ?></a>
                                    <?php if(comments_open()) { ?>
                                    <a href="<?php the_permalink() ?>#comments" class="button"><i class="oic-comment-2"></i><span><?php comments_number('No Comment', '1 Comment', '% Comments') ?></span></a>
                                    <?php } ?>                                    
                                    <a href="<?php echo esc_url(get_permalink()) ?>" class="button post-share" data-open="0"><i class="oic-share-2"></i><?php esc_attr_e('Share', 'salon') ?></a>
                                    <div>
                                        <div class="arrow"></div>
                                        <div class="button">
                                            <a href="http://www.facebook.com/share.php?u=<?php echo esc_url(get_permalink()) ?>"><span class="symbol">facebook</span></a>
                                            <a href="https://twitter.com/share?url=<?php echo esc_url(get_permalink()) ?>"><span class="symbol">twitterbird</span></a>
                                            <a href="https://www.linkedin.com/cws/share?url=<?php echo esc_url(get_permalink()) ?>"><span class="symbol">linkedin</span></a>
                                            <a href="https://plus.google.com/share?url=<?php echo esc_url(get_permalink()) ?>"><span class="symbol">googleplus</span></a>
                                            <a href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink()) ?>"><span class="symbol">pinterest</span></a>
                                        </div>
                                    </div>
                                </div>                                
                			</div>
                        </div><!--.post-single-->        
                        
                        <?php 
							}
						?>
                        
                        <?php echo salon_get_pagination('<div class="page-pagination">', '</div>');  ?>

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