<?php
if(salon_get_metabox('background_group.0.ozy_salon_meta_page_background_use_gmap') == '1') {
	$address = salon_get_metabox('background_group.0.ozy_salon_meta_page_background_gmap_group.0.ozy_salon_meta_page_background_gmap_address');
	if( trim($address) != '' ) {
?>
<div id="ozy-google-map-background"><iframe width="100%" height="1400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php echo esc_url($address); ?>"></iframe></div>
<?php
	}
}
?>