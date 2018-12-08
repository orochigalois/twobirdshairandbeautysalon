					<?php
                    while ( $the_query->have_posts() ) {
							$the_query->the_post();
														
							$tax_terms = get_the_terms(get_the_ID(), 'portfolio_category');						
							$tax_terms_slug = wp_list_pluck($tax_terms, 'slug');
							$tax_terms_name = wp_list_pluck($tax_terms, 'name');
						?>
						<div <?php post_class('ozy_portfolio type-ozy_portfolio category-all category-' . esc_attr(implode(' category-', $tax_terms_slug)) . ' post-single'); ?>>                        
						<?php
							$thumbnail_image_src = $post_image_src = array();
							if ( has_post_thumbnail() ) { 
								$thumbnail_image_src 	= wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'blog' , false );
								$post_image_src 		= wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' , false );						
	
	
								if ( isset($thumbnail_image_src[0]) && isset($post_image_src[0])) { 
									echo '<div class="featured-thumbnail" style="background-image:url('. esc_url($thumbnail_image_src[0]) .');">';
										echo '<div class="caption">';
											echo '<h3 class="heading">';
											echo '<a href="'. esc_url(get_permalink()) .'" title="'. esc_attr(get_the_title()) .'" rel="bookmark">' . 
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