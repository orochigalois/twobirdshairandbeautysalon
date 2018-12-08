<?php
	$color_meta_path = 'ozy_salon_meta_post.ozy_salon_meta_post_thumbnail_color_group.0.ozy_salon_meta_post_thumbnail_color_';

	while ( $the_query->have_posts() ) {
		$the_query->the_post();							
	
		global $more, $ozy_global_params; $more = 0;
		$excerpt_character_count = 130; $title_color = $text_color = $overlay_color = ''; $heading_size = 'h5';
		$post_item_size = esc_attr(vp_metabox('ozy_salon_meta_post.ozy_salon_meta_post_item_size')); $post_item_size = !$post_item_size ? 'small' : $post_item_size;
		$post_type = esc_attr(vp_metabox('ozy_salon_meta_post.ozy_salon_meta_post_item_type')); $post_type = $post_type ? $post_type : 'standard';
		
		if(vp_metabox('ozy_salon_meta_post.ozy_salon_meta_post_thumbnail_color')==='1') {
			$title_color = ' style="color:'. esc_attr(vp_metabox($color_meta_path . 'heading')) .'!important"';
			$text_color = ' style="border-color:'. esc_attr(vp_metabox($color_meta_path . 'text')) .';color:'. esc_attr(vp_metabox($color_meta_path . 'text')) .'!important"';
			$overlay_color = ' style="background-color:'. esc_attr(vp_metabox($color_meta_path . 'overlay')) .'!important"';
		}
		
		/*get post format*/
		$ozy_temporary_post_format = $ozy_current_post_format = get_post_format();
		if ( false === $ozy_current_post_format ) {
			$ozy_current_post_format = 'standard';
		}

?>
<div <?php post_class('post category-all post-single post-format-'. esc_attr($ozy_current_post_format) . ' post-' . $post_item_size . ' post-type-' . $post_type );?>>                        
<?php
    if($post_type !== 'colorbox') {
        $thumbnail_image_src = $post_image_src = array();
        if ( has_post_thumbnail() ) { 
            $thumbnail_image_src 	= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'blog' , false );
            $post_image_src 		= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' , false );						

            if ( isset($thumbnail_image_src[0]) && isset($post_image_src[0])) { 
                if($post_item_size === 'large') {
                    echo '<div class="featured-thumbnail" style="background-image:url('. esc_url($thumbnail_image_src[0]) .')"><a href="'. esc_url($thumbnail_image_src[0]) .'" class="fancybox"></a>'; the_post_thumbnail('blog'); echo '</div>';										
                }else{
                    echo '<div class="featured-thumbnail"><a href="'. esc_url($thumbnail_image_src[0]) .'" class="fancybox"></a>'; 
                    the_post_thumbnail('blog'); 
                    echo '<div class="post-meta"><span '. $overlay_color .'>';the_category('</span><span '. $overlay_color .'>');echo '</span></div><!--#post-meta-->';
                    echo '</div>';
                }
            }
        }
    }
    ?>
    <div class="caption" <?php echo esc_attr($post_type === 'colorbox' ? $overlay_color : ''); ?>>
        <?php
        if($post_item_size === 'large' || $post_type === 'colorbox') {
            echo '<div class="post-meta"><span '. $overlay_color .'>';the_category('</span><span '. $overlay_color .'>');echo '</span></div><!--#post-meta-->';
        }
        if($post_item_size === 'large' || $post_type === 'colorbox') {
            $excerpt_character_count = 160;
            $heading_size = 'h3';
        }
        echo '<'. $heading_size .' class="post-title">';
            echo '<a href="'. esc_url(get_permalink()) .'" title="'. esc_attr(get_the_title()) .'" class="a-page-title" rel="bookmark" '. $title_color .'>'. ( get_the_title() ? get_the_title() : get_the_time(SALON_DATE_FORMAT) ) .'</a>';
        echo '</'. $heading_size .'>';
        echo '<p '. $text_color .'>' . salon_excerpt_max_charlength($excerpt_character_count, true, true) . '</p>';
        
        if($post_item_size === 'large' || $post_type === 'colorbox') {
            echo '<a href="'. esc_url(get_permalink()) .'" class="read-more" '. $text_color .'>'. esc_attr__('READ MORE &rarr;', 'salon') .'</a>';
        }
        ?>
    </div>
</div><!--.post-single-->   
<?php } ?>
