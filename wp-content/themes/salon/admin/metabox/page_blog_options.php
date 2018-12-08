<?php

return array(
	'id'          => 'ozy_salon_meta_page_blog',
	'types'       => array('page'),
	'title'       => esc_attr__('Blog Options', 'salon'),
	'priority'    => 'high',
	'template'    => array(	
		array(
			'type' => 'notebox',
			'name' => 'ozy_salon_meta_page_blog_infobox',
			'label' => esc_attr__('Post Options', 'salon'),
			'description' => esc_attr__('Below this point all the options are only works with blog page template types.', 'salon'),
			'status' => 'info',
		),
		array(
			'type' => 'checkbox',
			'name' => 'ozy_salon_meta_page_blog_category',
			'label' => esc_attr__('Display Items From Categories', 'salon'),
			'description' => esc_attr__('If you select "All" select, all the Blog items will be displayed. When another category is selected, only the Blog items that belong to this category or this category\'s subcategories will be displayed. By this way, you can create multiple blog pages with different items.', 'salon'),
			'items' => array(
				'data' => array(
					array(
						'source' => 'function',
						'value' => 'vp_bind_ozy_salon_blog_categories',
					),
				),
			),
			'default' => '{{first}}'
		),
		array(
			'type' => 'radiobutton',
			'name' => 'ozy_salon_meta_page_blog_order',
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
					'value' => 'title-desc',
					'label' => 'Title DESC',
				),
				array(
					'value' => 'title-asc',
					'label' => 'Title ASC',
				),
			),
			'default' => '{{first}}'
		),
		array(
			'type' => 'textbox',
			'name' => 'ozy_salon_meta_page_blog_count',
			'label' => esc_attr__('Item Count Per Load', 'salon'),
			'description' => esc_attr__('How many portfolio item will be loaded when LOAD MORE button clicked.', 'salon'),
			'default' => '12',
			'validation' => 'numeric',
		)
	),
);

/**
 * EOF
 */