<?php
/**
 * Generates a number based on the theme version number and the given file's modified timestamp.
 *
 * @package WordPress
 */

/**
 * Function to generate a version number
 *
 * @param string $path Path to the file, relative to the theme directory.
 * @author Dan Walsh
 * @since 1.0.0
 */
function generate_file_version( $path ) {
	$the_theme     = wp_get_theme();
	$theme_version = $the_theme->get( 'Version' );
	$file_version  = $theme_version . '.' . filemtime( get_template_directory() . $path );
	return $file_version;
}
