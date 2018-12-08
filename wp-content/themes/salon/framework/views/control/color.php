<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_head', $head_info); ?>

<label class="indicator" for="<?php echo esc_attr($name); ?>"><span style="background-color: <?php echo esc_attr($value); ?>;"></span></label>
<input id="<?php echo esc_attr($name); ?>" class="vp-input vp-js-colorpicker"
	type="text" name="<?php echo esc_attr($name) ?>" value="<?php echo esc_attr($value); ?>" data-vp-opt="<?php echo esc_attr($opt); ?>" /> <?php if(isset($default) && trim($default) != ''){ ?><small><span><strong>Default:</strong> <i><?php echo $default ?></i></span></small><?php } ?>

<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_foot'); ?>