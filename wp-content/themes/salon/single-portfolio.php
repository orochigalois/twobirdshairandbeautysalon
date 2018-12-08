<?php 
get_header(); 

$hide_title = false;

/*get post format*/
$ozy_temporary_post_format = $ozy_current_post_format = get_post_format();
if ( false === $ozy_current_post_format ) { $ozy_current_post_format = 'standard'; }

if ( have_posts() ) while ( have_posts() ) : the_post();
?>
<div id="content" class="<?php echo esc_attr(salon_gd('_page_content_css_name')); ?>">
    <div class="wpb_row vc_row-fluid">
        <div class="parallax-wrapper">
            <div class="vc_col-sm-12 wpb_column vc_column_container">
                <div class="wpb_wrapper">

                    <div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
                
                        <article>
                            <?php
								the_content();
								
								edit_post_link('<p><small>Edit this entry</small></p>','',''); 
							?>
                        </article>

                    </div><!-- #post-## -->
                    
                    <div class="clear"></div> 
                                        
                </div>
            </div>
        </div>
	</div>
</div><!--#content-->

<?php 
endwhile; /* end loop */
get_footer(); 
?>