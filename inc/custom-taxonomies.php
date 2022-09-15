<?php
/**
 * Custom taxonomies used by the genU Training website.
 *
 * @package WordPress
 * @subpackage genU Training
 */

/**
 * Registers custom taxonomies.
 *
 * @return void
 */
function gc_register_custom_taxonomies() {

	/**
	 * Taxonomy: Program Types.
	 */

	$labels = array(
		'name'          => __( 'Program Types', '_gc' ),
		'singular_name' => __( 'Program Type', '_gc' ),
	);

	$args = array(
		'label'                 => __( 'Program Types', '_gc' ),
		'labels'                => $labels,
		'public'                => true,
		'publicly_queryable'    => true,
		'hierarchical'          => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'query_var'             => true,
		'rewrite'               => array(
			'slug'       => 'training-courses',
			'with_front' => true,
		),
		'show_admin_column'     => true,
		'show_in_rest'          => false,
		'rest_base'             => 'program_type',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
		'show_in_quick_edit'    => false,
	);
	register_taxonomy( 'program_type', array( 'program', 'eb_course', 'product' ), $args );

	/**
	 * Taxonomy: Locations.
	 */

	$labels = array(
		'name'          => __( 'Locations', '_gc' ),
		'singular_name' => __( 'Location', '_gc' ),
	);

	$args = array(
		'label'                 => __( 'Locations', '_gc' ),
		'labels'                => $labels,
		'public'                => true,
		'publicly_queryable'    => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'query_var'             => true,
		'rewrite'               => array(
			'slug'       => 'location',
			'with_front' => true,
		),
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'rest_base'             => 'location',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
		'show_in_quick_edit'    => false,
	);
	register_taxonomy( 'location', array( 'program', 'eb_course', 'product' ), $args );

	/**
	 * Taxonomy: Industries.
	 */

	$labels = array(
		'name'          => __( 'Industries', '_gc' ),
		'singular_name' => __( 'Industry', '_gc' ),
	);

	$args = array(
		'label'                 => __( 'Industries', '_gc' ),
		'labels'                => $labels,
		'public'                => true,
		'publicly_queryable'    => false,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'query_var'             => true,
		'rewrite'               => array(
			'slug'       => 'industry',
			'with_front' => true,
		),
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'rest_base'             => 'industry',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
		'show_in_quick_edit'    => false,
	);
	register_taxonomy( 'industry', array( 'program', 'eb_course', 'product' ), $args );

	/**
	 * Taxonomy: Study modes.
	 */

	$labels = array(
		'name'          => __( 'Study modes', '_gc' ),
		'singular_name' => __( 'Study mode', '_gc' ),
	);

	$args = array(
		'label'                 => __( 'Study modes', '_gc' ),
		'labels'                => $labels,
		'public'                => true,
		'publicly_queryable'    => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'query_var'             => true,
		'rewrite'               => array(
			'slug'       => 'study_mode',
			'with_front' => true,
		),
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'rest_base'             => 'study_mode',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
		'show_in_quick_edit'    => false,
	);
	register_taxonomy( 'study_mode', array( 'program', 'eb_course', 'product' ), $args );

	/**
	 * Taxonomy: Course times.
	 */

	$labels = array(
		'name'          => __( 'Course times', '_gc' ),
		'singular_name' => __( 'Course time', '_gc' ),
	);

	$args = array(
		'label'                 => __( 'Course times', '_gc' ),
		'labels'                => $labels,
		'public'                => true,
		'publicly_queryable'    => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'query_var'             => true,
		'rewrite'               => array(
			'slug'       => 'course_time',
			'with_front' => true,
		),
		'show_admin_column'     => false,
		'show_in_rest'          => true,
		'rest_base'             => 'course_time',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
		'show_in_quick_edit'    => false,
	);
	register_taxonomy( 'course_time', array( 'program', 'eb_course', 'product' ), $args );
}
add_action( 'init', 'gc_register_custom_taxonomies' );
