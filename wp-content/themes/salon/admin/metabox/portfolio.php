<?php

return array(
	'id'          => 'ozy_salon_meta_portfolio',
	'types'       => array('ozy_portfolio'),
	'title'       => esc_attr__('Portfolio Post Options', 'salon'),
	'priority'    => 'high',
	'template'    => array(
		array(
			'type' => 'toggle',
			'name' => 'ozy_salon_meta_portfolio_page_title',
			'label' => esc_attr__('Hide Page Title', 'salon'),
			'description' => esc_attr__('In some cases you may like to hide page title for your portfolio post.', 'salon'),
		),
	),	
);

/**
 * EOF
 */