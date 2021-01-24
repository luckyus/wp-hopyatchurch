<?php

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
add_action('init', 'hyc_block_default_color');
