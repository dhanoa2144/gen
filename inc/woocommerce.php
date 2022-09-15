<?php
/**
 * update woocommerce actions and filters
 *
 * @package WordPress
 * @subpackage genU Training
 */

/**
 * Undocumented function
 *
 * @param [type] $post_id
 * @return string
 */

// To change add to cart text on single product page
function woocommerce_custom_single_add_to_cart_text()
{
    return __('Enrol', 'woocommerce'); 
}
add_filter('woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text');

// To change add to cart text on product archives(Collection) page
function woocommerce_custom_product_add_to_cart_text()
{
    return __('Enrol', 'woocommerce');
}
add_filter('woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text');

function update_content_single_product_price_html($return, $price, $args, $unformatted_price)
{
    $return = '<li><span class="font-weight-bold">Fee:</span> ' . sprintf( $args['price_format'], '<span class="woocommerce-Price-currencySymbol">' . get_woocommerce_currency_symbol( $args['currency'] ) . '</span>', $price ) . '</li>';
    return $return;
}
add_filter('wc_price', 'update_content_single_product_price_html', 10, 4);
