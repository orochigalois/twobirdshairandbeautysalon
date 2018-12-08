<?php 
/*
Template Name: Transparent Content Page Layout
*/

get_header(); 

// meta params & bg slider for page
salon_page_meta_params();

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
<div id="content" class="<?php echo esc_attr(salon_gd('_page_content_css_name')); ?>">
    <?php if ( have_posts() && salon_gd('_page_hide_page_content') != '1') while ( have_posts() ) : the_post(); ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>>
            <article>				
                <div class="post-content page-content">
                    <?php the_content(); ?>
                    <?php wp_link_pages(); ?>
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
