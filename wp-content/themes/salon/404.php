<?php
// Look for custom 404 page, Apperance > Theme Options > Layout > Content / Page / Post : Custom 404 Page
$notfound_page_id = salon_get_option("page_404_page_id");
if((int)$notfound_page_id > 0 && get_page($notfound_page_id)) {
	wp_redirect(get_permalink($notfound_page_id));
	exit();
}

get_header(); 
?>
<div id="content">
	<div id="error404" class="post">
    	<span></span>
		<h1 class="content-color"><?php esc_attr_e('404!', 'salon'); ?></h1>
        <h2 class="content-color"><?php esc_attr_e('Sorry! That page doesn\'t seem to exist.', 'salon'); ?></h2>
        <p><?php esc_attr_e('Try clicking on the navigation to find what you\'re looking for.', 'salon'); ?></p>
        <p><a href="<?php echo esc_url(SALON_HOME_URL) ?>" class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-rounded vc_btn3-style-modern vc_btn3-color-white"><?php esc_attr_e('Take Me Home', 'salon'); ?></a></p>
	</div><!--#error404 .post-->
</div><!--#content-->

<?php get_footer(); ?>