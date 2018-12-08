<?php 
get_header(); 

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

if(!salon_gd('_page_hide_page_content')) {
?>
<div id="content" class="<?php echo esc_attr(salon_gd('_page_content_css_name')); ?>">
	<?php     
		if ( have_posts() && salon_gd('_page_hide_page_content') != '1') while ( have_posts() ) : the_post(); ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>>
            <article>
                <?php if ( has_post_thumbnail() ) { echo '<div class="featured-thumbnail">'; the_post_thumbnail(); echo '</div>'; } ?>
                <div class="post-content page-content">
                    <?php 
						if(!post_password_required()) {
							the_content();
							wp_link_pages();
						}else{
							echo get_the_password_form();
						}
					?>
                </div><!--.post-content .page-content -->
            </article>
			
            <?php if( salon_get_option('page_page_author') == '1') { ?>
            <div id="page-meta">
                <h3><?php esc_attr_e('Written by ', 'salon'); the_author_posts_link() ?></h3>
                <p class="gravatar"><?php if(function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '80' ); } ?></p>
                <p><?php esc_attr_e('Posted on ', 'salon'); the_time(SALON_DATE_FORMAT); esc_attr_e(' at ', 'salon'); the_time() ?></p>
            </div><!--#pageMeta-->
            <?php } ?>
        </div><!--#post-# .post-->

		<?php 
			if( salon_get_option('page_page_comment') == '1' && comments_open()) { 
        		comments_template( '', true );
			}
		endwhile; 
	?>
</div><!--#content-->
<?php
}
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
