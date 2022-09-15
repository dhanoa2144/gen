<?php
/**
 * Skeletor functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package skeletor
 */

require __DIR__ . '/inc/generate-file-version.php';


// Store the theme's directory path and uri in constants.
define( 'THEME_DIR_PATH', get_template_directory() );
define( 'THEME_DIR_URI', get_template_directory_uri() );
define( 'GRINDSTONE_CDN', get_stylesheet_directory_uri() . '/cdn' );
define( 'AUTH_REMOTE_REQUEST', 'Basic Z3JpbmRzdG9uZTpncmluZDV0b24z' );


$env = explode('.', get_site_url());
if ( end($env) != 'local' && end($env) != 'dev' ) {
	define( 'WP_ENVIRONMENT_TYPE', 'production' );
} else {
	define( 'WP_ENVIRONMENT_TYPE', 'development' );
}

/**
 * Enqueue styles and scripts.
 *
 * @return void
 */
function add_theme_assets() {
	wp_enqueue_script( 'popper-js', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', array( 'jquery' ), '1.16.0', true );
	wp_enqueue_script( 'bootstrap-4-js', GRINDSTONE_CDN . '/bootstrap/4.3.1/js/bootstrap.min.js', array( 'jquery' ), '4.3.1', true );
	wp_enqueue_script( 'slick-slider-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array( 'jquery' ), '1.8.1', false );
	wp_enqueue_style( 'fontawesome', GRINDSTONE_CDN . '/fontawesome/latest/css/all.min.css', array(), '5.8.1' );
	wp_enqueue_script( 'google-apis', 'https://maps.googleapis.com/maps/api/js?key=' . get_field('google-api', 'options'), array('jquery') );

	wp_enqueue_script( 'theme-scripts', THEME_DIR_URI . '/assets/build/js/main.js', array(), generate_file_version( '/assets/build/js/main.js' ), true );
	
 // wp_enqueue_style( 'theme-bootstrap', THEME_DIR_URI . '/cdn/bootstrap/4.3.1/css/bootstrap.min.css', array(), generate_file_version( '/cdn/bootstrap/4.3.1/css/bootstrap.min.css' ) );
	wp_enqueue_style( 'theme-styles', THEME_DIR_URI . '/assets/build/css/styles.css', array(), generate_file_version( '/assets/build/css/styles.css' ) );
	

	wp_enqueue_style( 'theme-styles', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array() );
	wp_enqueue_style( 'theme-styles', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', array() );
}
add_action( 'wp_enqueue_scripts', 'add_theme_assets' );

/**
 * Add support for common theme features.
 *
 * @return void
 */
function set_up_theme_support() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'set_up_theme_support' );

/**
 * Disables the WooCommerce sidebar.
 *
 * @return void
 */
function disable_woo_commerce_sidebar() {
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
}
add_action( 'init', 'disable_woo_commerce_sidebar' );

// Inludes.
require_once __DIR__ . '/inc/custom-taxonomies.php';
require_once __DIR__ . '/inc/template-tags.php';
require_once __DIR__ . '/inc/yoast.php';
require_once __DIR__ . '/inc/advanced-custom-fields.php';
require_once __DIR__ . '/inc/class-filter.php';
require_once __DIR__ . '/inc/woocommerce.php';
require_once __DIR__ . '/inc/edwiser-bridge.php';
require_once __DIR__ . '/inc/shortcodes.php';

// Initialise the post type filter.
\Grindstone\WordPress\Filter::init();

add_image_size( 'header_icon', 64, 64, false );
add_image_size( 'header_image', 1400, 500, true );
add_image_size( 'home_thumb', 350, 235, true );
add_image_size( 'custom_header', 1620, 600, true );
add_image_size( 'callout', 1620, 400, true );


// -----------------------------------------------------------------------------
// Add bootstrap responsive embed code
// -----------------------------------------------------------------------------
add_filter( 'the_content', function($content){
	$content = preg_replace( "/<iframe.+?src=\"(.+?)\"/Si", '<div class="embed-responsive embed-responsive-16by9"><iframe src="\1" frameborder="0" allowfullscreen>', $content );
	$content = preg_replace( "/<\/iframe>/Si", '</iframe></div>', $content );

	return $content;
});

//truncate long post titles
function max_title_length( $title ) {
	$max = 35;

	return strlen ($title );

	}
	 


// -----------------------------------------------------------------------------
// Edwiser bridge registers a post type with a slug of courses. This conficts
// with the url structure used for some pages. This results in the pages showing
// 404 pages as the slug cannot be found in the post type. To address this, we
// modify the query for the courses post type to also permit pages to be found.
//
// Warning, this can result in unexpected behaviour if courses are actually used
// -----------------------------------------------------------------------------
add_action('pre_get_posts', function($query){
	if(!$query->is_main_query() || !isset($query->query['eb_course'])){
		return;
	}

	if(!empty($query->query['name'])){
		$query->set('post_type', ['eb_course', 'page']);
	}
});

function gc_acf_google_map_api( $api ){
    $api['key'] = get_field('google-api', 'options');
    return $api;
}
add_filter('acf/fields/google_map/api', 'gc_acf_google_map_api');

/**
 * add sitemap short code with exclude functionality
 */
function yk_sidebar_function( $atts ){
    $atts = shortcode_atts(array('exclude' => ''), $atts, 'sitemap');
    $args = $atts;
    $args['title_li'] = '';
    $args['child_of'] = $post->ID;
    $args['echo'] = 0;

    $yk_sitemap = wp_list_pages($args); //&echo=0&exclude=1643
	return '<div class="site-map">'.$yk_sitemap.'</div>';
}

add_shortcode( 'sitemap', 'yk_sidebar_function' );


//tester


add_action('wp_head', 'feature_image_script');

function feature_image_script() {

$hideupcomingcourses = get_field( 'hide_upcoming_courses' );

if ( $hideupcomingcourses == 2 ) { 

	echo '<style>';
	
	echo '.upcoming { display: none; }';

	echo '</style>';

	}

} 

function filter_wpseo_breadcrumb_separator($this_options_breadcrumbs_sep) {
    return '<i class="fa fa-chevron-right"></i>';
};

// add the filter
add_filter('wpseo_breadcrumb_separator', 'filter_wpseo_breadcrumb_separator', 10, 1);


