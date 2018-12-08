<?php

return array(
	'id'          => 'ozy_salon_meta_page_portfolio',
	'types'       => array('page'),
	'title'       => esc_attr__('Portfolio Options', 'salon'),
	'priority'    => 'high',
	'template'    => array(
		array(
			'type' => 'notebox',
			'name' => 'ozy_salon_meta_page_portfolio_infobox',
			'label' => esc_attr__('Portfolio Options', 'salon'),
			'description' => esc_attr__('Below this point all the options are only works with portfolio template types.', 'salon'),
			'status' => 'info',
		),
		array(
			'type' => 'sorter',
			'name' => 'ozy_salon_meta_page_portfolio_category_sort',
			'label' => esc_attr__('Category Select / Order', 'salon'),
			'description' => esc_attr__('If you leave this field blank, all available categories will be listed. By this option, you can create multiple portfolio/gallery pages with different items.', 'salon'),			
			'default' => '{{all}}',
			'items' => array(
				'data' => array(
					array(
						'source' => 'function',
						'value' => 'vp_bind_ozy_salon_portfolio_categories_simple',
					),
				),
			),
		),	
		array(
			'type' => 'radiobutton',
			'name' => 'ozy_salon_meta_page_portfolio_order',
			'label' => esc_attr__('Item Order', 'salon'),
			'description' => esc_attr__('By selecting "Custom Order ..." you will have to set the order field of each of the items.', 'salon'),			
			'items' => array(
				array(
					'value' => 'date-desc',
					'label' => 'Date DESC',
				),
				array(
					'value' => 'date-asc',
					'label' => 'Date ASC',
				),
				array(
					'value' => 'menu_order-desc',
					'label' => 'Custom DESC',
				),
				array(
					'value' => 'menu_order-asc',
					'label' => 'Custom ASC',
				),
			),
			'default' => '{{first}}'
		),
		array(
			'type' => 'radiobutton',
			'name' => 'ozy_salon_meta_page_portfolio_column_count',
			'label' => esc_attr__('Column Count', 'salon'),
			'items' => array(
				array(
					'value' => '3',
					'label' => '3',
				),
				array(
					'value' => '4',
					'label' => '4',
				)
			),
			'default' => '3'
		),			
		array(
			'type' => 'textbox',
			'name' => 'ozy_salon_meta_page_portfolio_count',
			'label' => esc_attr__('Item Count Per Load', 'salon'),
			'description' => esc_attr__('How many portfolio item will be loaded for each load.', 'salon'),
			'default' => '32',
			'validation' => 'numeric',
		),			
	),	
);

/**
 * EOF
 */