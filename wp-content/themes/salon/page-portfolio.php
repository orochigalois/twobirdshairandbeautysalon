<?php
/*
Template Name: Portfolio Listing
*/
get_header();

salon_portfolio_meta_params();

/* Widgetized LEFT sidebar */
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
<div id="content" class="<?php echo esc_attr(salon_gd('_page_content_css_name')); ?> template-clean-page">
    <?php if ( have_posts() && salon_gd('_page_hide_page_content') != '1') while ( have_posts() ) : the_post(); ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>>
            <article>
                
                <div class="post-content page-content">
                    <?php the_content(); ?>
					
                    <!--filter-->
                    <ul id="portfolio-filter">
                        <li class="active"><a href="#all" data-filter=".category-all"><?php esc_attr_e('ALL', 'salon') ?></a></li>
                        <?php
                        echo salon_print_portfolio_filter(
							salon_gd('_portfolio_portfolio_categories_tree'), 
							salon_gd('_portfolio_category_filter_parent'), 
							0, 
							salon_gd('_portfolio_category_search_type'), 
							''
						);
                        ?>
                    </ul>
                    
                    <!--grid-->
                    <div class="wpb_wrapper isotope column-<?php echo esc_attr(salon_gd('_portfolio_column_count'))?>">
					<?php
						$args = array(
							'post_type' 			=> 'ozy_portfolio',
							'posts_per_page'		=> salon_gd('_portfolio_post_per_load'),
							'orderby' 				=> salon_gd('_portfolio_orderby'),
							'order' 				=> salon_gd('_portfolio_order'),
							'ignore_sticky_posts' 	=> 1,
							'meta_key' 				=> '_thumbnail_id',
							'tax_query' => array(
								array(
									'taxonomy' 	=> 'portfolio_category',
									'field' 	=> 'id',
									'terms' 	=> salon_gd('_portfolio_include_categories'),
									'operator' 	=> 'IN'
								),
							),											
						);

						$the_query = new WP_Query( $args );

						while ( $the_query->have_posts() ) {
							$the_query->the_post();
														
							$tax_terms = get_the_terms($post->ID, 'portfolio_category');						
							$tax_terms_slug = wp_list_pluck($tax_terms, 'slug');
							$tax_terms_name = wp_list_pluck($tax_terms, 'name');
						?>
						<div <?php post_class('category-all category-' . implode(' category-', $tax_terms_slug) . ' post-single'); ?>>                        
						<?php
							$thumbnail_image_src = $post_image_src = array();
							if ( has_post_thumbnail() ) { 
								$thumbnail_image_src 	= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'blog' , false );
								$post_image_src 		= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' , false );						
	
								if ( isset($thumbnail_image_src[0]) && isset($post_image_src[0])) { 
									echo '<div class="featured-thumbnail" style="background-image:url('. esc_url($thumbnail_image_src[0]) .');">';
										echo '<div class="caption">';
											echo '<h3 class="heading">';
											echo '<a href="'. esc_attr(get_permalink()) .'" title="'. esc_attr(get_the_title()) .'" rel="bookmark">' . 
											( get_the_title() ? get_the_title() : get_the_time(SALON_DATE_FORMAT) ) 
											. '</a>';
											echo '</h3>';
											echo '<div class="border shared-border-color"><span></span></div>';
											echo '<p class="content-color-alternate3">' . implode(', ', $tax_terms_name) . '</p>';
											echo '<a href="'. esc_url($post_image_src[0]) .'" class="lightgallery plus-icon" title="'. esc_attr(get_the_title()) .'" rel="portfolio-gallery"><i class="oic-plus-1"></i><img src="'. esc_url($thumbnail_image_src[0]) .'" alt=""/></a>';
										echo '</div>'; 
									the_post_thumbnail('blog');
									echo '</div>'; 
								}
							}

							?>
                        </div><!--.post-single-->                           
                        <?php													
						}
					?>
                    </div>
                    <!--grid-->
					
                    <?php if($the_query->found_posts > salon_gd('_portfolio_post_per_load')) { ?>
                    <div class="button-container load_more_blog" data-layout_type="portfolio" data-item_count="<?php echo esc_attr(salon_gd('_portfolio_post_per_load')) ?>" data-offset="0" data-found="<?php echo esc_attr($the_query->found_posts) ?>" data-order_by="<?php echo esc_attr(salon_gd('_portfolio_orderby')) ?>" data-order="<?php echo esc_attr(salon_gd('_portfolio_order')) ?>" data-category_name="<?php  echo esc_attr((is_array(salon_gd('_portfolio_include_categories')) ? join(salon_gd('_portfolio_include_categories'),',') : '')) ?>" data-loadingcaption="<?php echo esc_attr__('LOADING...', 'salon') ?>" data-loadmorecaption="<?php echo esc_attr__('LOAD MORE', 'salon') ?>">
                        <a href="#load-more" class="button"><?php echo esc_attr__('LOAD MORE', 'salon') ?><span></span><span></span></a>
                    </div>
					<!--.load more portfolio-->
                    <?php } ?>
                </div><!--.post-content .page-content -->
            </article>
			
        </div><!--#post-# .post-->

    <?php endwhile; ?>
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
