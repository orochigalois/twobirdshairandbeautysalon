<?php

return array(
	'id'          => 'ozy_salon_meta_post',
	'types'       => array('post'),
	'title'       => esc_attr__('Post Options', 'salon'),
	'priority'    => 'high',
	'template'    => array(
		array(
			'type'      => 'group',
			'repeating' => false,
			'length'    => 1,
			'name'      => 'ozy_salon_meta_post_color_group',
			'title'     => esc_attr__('Hover Box Coloring', 'salon'),
			'fields'    => array(	
				array(
					'type' => 'color',
					'name' => 'ozy_salon_meta_post_color_overlay',
					'label' => esc_attr__('Overlay Color', 'salon'),
					'description' => esc_attr__('Select an Overlay Color.', 'salon'),
					'default' => 'rgba(255,255,255,1)',
					'format' => 'rgba',
				),
				array(
					'type' => 'color',
					'name' => 'ozy_salon_meta_post_color_foreground',
					'label' => esc_attr__('Foreground Color', 'salon'),
					'description' => esc_attr__('Select a color for foreground elements.', 'salon'),
					'default' => '#000000',
					'format' => 'hex',
				)															
			),
		)		
	),	
);

/**
 * EOF
 */