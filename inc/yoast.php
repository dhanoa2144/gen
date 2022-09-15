<?php
/**
 * Yoast customisations.
 *
 * @package WordPress
 * 
 * @subpackage GenU_Training
 */

/**
 * Adds Bootstrap classes to Yoast link items, where required.
 *
 * @param string $link_output The HTML content for each link item.
 * 
 * @return string
 */
function grindstone_yoast_links_add_classes( $link_output ) {
    if ( strpos( $link_output, 'a href="' ) !== false ) :
        $link_output = str_replace( 'a href="', 'a class="text-white text-underline" href="', $link_output );
    endif;
    return $link_output;
}
add_filter('wpseo_breadcrumb_single_link', 'grindstone_yoast_links_add_classes');

/**
 * Remove shop and programs links from breadcrumbs and replace with courses
 *
 * @param array $links an array of links in the breadcrumb
 * 
 * @return array
 */
function grindstone_yoast_convert_to_courses( $links )
{
    foreach ($links as $key => $link) {
        if (strtolower($link['text']) == 'shop' || strtolower($link['text']) == 'programs') {
            $links[$key]['url'] = "#";
            $links[$key]['text'] = 'Courses';
        }
    }

    return $links;
}
add_filter('wpseo_breadcrumb_links', 'grindstone_yoast_convert_to_courses');
