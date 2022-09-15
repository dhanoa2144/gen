<?php
/**
 * Advanved Custom Fields functions
 *
 * @package WordPress
 * @subpackage genU Training
 */

if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page(
		array(
			'page_title' => 'Theme General Settings',
			'menu_title' => 'Theme Settings',
			'menu_slug'  => 'theme-general-settings',
			'capability' => 'edit_posts',
			'redirect'   => false,
		)
	);
	acf_add_options_page(
		array(
			'page_title' => 'Testimonials',
			'menu_title' => 'Testimonials',
			'menu_slug'  => 'testimonials',
			'capability' => 'edit_posts',
			'redirect'   => false,
		)
	);
}
