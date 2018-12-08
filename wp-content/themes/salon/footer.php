		<?php 
			if(salon_gd('hide_everything_but_content') < 1): 
		?> 
        <div class="clear"></div>
        </div><!--.container-->    
        <?php
            /* footer slider */
            salon_put_footer_slider(salon_gd('footer_slider'));
        ?>
    </div><!--#main-->
    
	<?php
		include(SALON_BASE_DIR . 'include/footer-bars.php');       
	?>

    <div class="salon-btt-container">
        <div tooltip="<?php esc_attr_e('BACK TO TOP', 'salon') ?>" class="top salon-btt"><img src="<?php echo SALON_CSS_DIRECTORY_URL ?>images/up-arrow.svg" class="svg" alt=""/></div>
    </div>
    
    <?php endif; 
		if(isset($ozySalonHelper->footer_html)) echo $ozySalonHelper->footer_html;		
		if(salon_gd('is_animsition_active')) echo '</div>';
		wp_footer();	
	?>
</body>
</html>