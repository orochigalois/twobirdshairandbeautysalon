<?php
/*
Template Name: Full Page Revolution Slider
*/

get_header(); 
?>
<div id="content" class="full-slider template-clean-page">
    <?php 
	if ( have_posts() ) while ( have_posts() ) : the_post();

		$rev_slider_id = salon_get_metabox('revolution_slider');
		
		if(function_exists( 'putRevSlider' )) {
			putRevSlider( $rev_slider_id );
		}
		
	endwhile;
	?>
</div><!--#content-->
<div id="revo-offset-container"></div>
<?php
get_footer();
?>