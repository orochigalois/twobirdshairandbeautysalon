<?php

return array(

	////////////////////////////////////////
	// Localized JS Message Configuration //
	////////////////////////////////////////

	/**
	 * Validation Messages
	 */
	'validation' => array(
		'alphabet'     => esc_attr__('Value needs to be Alphabet', 'salon'),
		'alphanumeric' => esc_attr__('Value needs to be Alphanumeric', 'salon'),
		'numeric'      => esc_attr__('Value needs to be Numeric', 'salon'),
		'email'        => esc_attr__('Value needs to be Valid Email', 'salon'),
		'url'          => esc_attr__('Value needs to be Valid URL', 'salon'),
		'maxlength'    => esc_attr__('Length needs to be less than {0} characters', 'salon'),
		'minlength'    => esc_attr__('Length needs to be more than {0} characters', 'salon'),
		'maxselected'  => esc_attr__('Select no more than {0} items', 'salon'),
		'minselected'  => esc_attr__('Select at least {0} items', 'salon'),
		'required'     => esc_attr__('This is required', 'salon'),
	),

	/**
	 * Import / Export Messages
	 */
	'util' => array(
		'import_success'    => esc_attr__('Import succeed, option page will be refreshed..', 'salon'),
		'import_failed'     => esc_attr__('Import failed', 'salon'),
		'export_success'    => esc_attr__('Export succeed, copy the JSON formatted options', 'salon'),
		'export_failed'     => esc_attr__('Export failed', 'salon'),
		'restore_success'   => esc_attr__('Restoration succeed, option page will be refreshed..', 'salon'),
		'restore_nochanges' => esc_attr__('Options identical to default', 'salon'),
		'restore_failed'    => esc_attr__('Restoration failed', 'salon'),
	),

	/**
	 * Control Fields String
	 */
	'control' => array(
		// select2 select box
		'select2_placeholder' => esc_attr__('Select option(s)', 'salon'),
		// fontawesome chooser
		'fac_placeholder'     => esc_attr__('Select an Icon', 'salon'),
	),

);

/**
 * EOF
 */