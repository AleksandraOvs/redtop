<?php
add_action( 'after_setup_theme', 'set_color_palette' );
 
function set_color_palette(){
	add_theme_support( 
		'editor-color-palette', 
		array(
			array(
				'name'  => 'White',
				'slug'  => 'white',
				'color'	=> '#fff',
			),

			array(
				'name'  => 'Black',
				'slug'  => 'black',
				'color'	=> '#272727',
			),

			array(
				'name'  => 'Dark Grey',
				'slug'  => 'dark-grey',
				'color'	=> '#3e3e3e',
			),

			array(
				'name'  => 'Accent',
				'slug'  => 'accent',
				'color' => '#B70000',
			),
			array(
				'name'  => 'Accent Light',
				'slug'  => 'accent-light',
				'color' => '#e86c6c',
			),
			array(
				'name'  => 'Light',
				'slug'  => 'light',
				'color' => '#FCFBF5',
			),
			array(
				'name'	=> 'Grey',
				'slug'	=> 'grey',
				'color'	=> '#A2A2A2',
			),
			array(
				'name'	=> 'Dark Grey',
				'slug'	=> 'dark-grey',
				'color'	=> '#3e3e3e',
			),
			array(
				'name'	=> 'Light Grey',
				'slug'	=> 'light-grey',
				'color'	=> '#d6d6d6',
			),
		)
	);
}

add_theme_support( 'disable-custom-colors' );