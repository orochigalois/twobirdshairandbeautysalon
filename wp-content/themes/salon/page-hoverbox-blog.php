<?php 
/*
Template Name: Blog : Hover Box
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
                                'cat'					=> salon_gd('_blog_include_categories'),
                                'post_type' 			=> 'post',
                                'post_status'			=> 'publish',
                                'orderby' 				=> salon_gd('_blog_orderby'),
                                'order' 				=> salon_gd('_blog_order'),
                                'paged'					=> get_query_var('paged'),
								'posts_per_page'		=> 6,
								'ignore_sticky_posts' 	=> 1,
								'meta_key' 				=> '_thumbnail_id',
								'tax_query' => array(
									array(
										'taxonomy' => 'post_format',
										'field'    => 'slug',
										'terms' => array('post-format-aside', 'post-format-link', 'post-format-quote', 'post-format-status', 'post-format-audio', 'post-format-chat'),
										'operator' => 'NOT IN'
									),
								),								
							));
							
							$effect_array = array(
								'effect-slideleft one-half', 
								'effect-slidedown one-half', 
								'effect-slideleft double-height one-full', 
								'effect-slideup one-half double-height', 
								'effect-slideleft one-half', 
								'effect-slideright one-half');
							$post_counter = 0;

							echo '<div class="hoverbox-blog-grid">';
							while (have_posts()) {
								the_post();salon_blog_more();

								$post_image_src = '';
								if ( has_post_thumbnail() ) { 
									$post_image_src 		= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'salon_blog' , false );
									if (isset($post_image_src[0])) {
										$post_image_src = $post_image_src[0];
									}else{
										$post_image_src = '';
									}
								}
								
								$dynamic_css_class_name = 'hover-box-1' . get_the_ID();
								
								echo 
									'<figure class="'. esc_attr($effect_array[$post_counter]) . '" style="background-image:url('. esc_url($post_image_src) .')">
										<img src="'. esc_attr($post_image_src) .'" alt="'. esc_attr(get_the_title()) .'"/>
										<figcaption class="'.  $dynamic_css_class_name  .'">
											<div>
												<span class="cat">';
												the_category(', ');
								echo			'</span><h2>'. esc_html(get_the_title()) .'</h2>
												<p>'. esc_html(get_the_excerpt()) .'</p>
												<a href="'. esc_url(get_permalink()) .'" class="button">'. esc_html('VIEW NOW', 'salon') .'</a>
											</div>
										</figcaption>			
									</figure>';
								
								$post_counter++;
								
								salon_page_hover_box_blog_css_builder(get_the_ID(), $dynamic_css_class_name);
							}
							echo '</div>';													
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