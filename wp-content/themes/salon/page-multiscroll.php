<?php
/*
Template Name: Multi Scroll
*/

get_header(); 
?>
<div id="main">
    <div id="content" class="full-slider template-clean-page">
        <?php 
        if ( have_posts() ) while ( have_posts() ) : the_post();
            the_content();
        endwhile;
        ?>
    </div><!--#content-->
</div>
<?php
get_footer();
?>