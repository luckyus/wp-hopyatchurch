<?php

// ref: 2. Gutenberg from Scratch: How to Create a Custom Block (210125)
function hyc_block_default_color()
{
	add_theme_support("editor-color-palette", array(
		array(
			'name' => 'Justine',
			'slug' => 'white',
			'color' => '#ffffff'
		)
	));
}
// add_action('init', 'hyc_block_default_color');

function klnc_gutenberg_blocks()
{
	wp_register_script(
		'my-card-js',
		get_template_directory_uri() . '/build/index.js',
		array('wp-blocks', 'wp-block-editor', 'wp-components')
	);

	register_block_type('klnc/my-card', array(
		'editor_script' => 'my-card-js'
	));
}
add_action('init', 'klnc_gutenberg_blocks');
