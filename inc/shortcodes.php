<?php
/**
 * Create any custom shortcodes here.
 *
 * @return void
 */
function gc_show_advertising_banner()
{
    ob_start();
    get_template_part('template-parts/banner', null, array('isShortcode' => '1'));
    return ob_get_clean(); 
} 
 // register shortcode
 add_shortcode('advert_banner', 'gc_show_advertising_banner');

 function gc_show_accordion()
{
    ob_start();
    get_template_part('template-parts/accordion', null, array('isShortcode' => '1'));
    return ob_get_clean(); 
} 
 // register shortcode
 add_shortcode('accordion', 'gc_show_accordion'); 
