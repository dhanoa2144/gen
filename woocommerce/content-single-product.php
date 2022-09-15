<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}

$product_options = get_post_meta($product->get_id(), 'product_options', true);
$fields = false;
if (! empty($product_options)) {
    if (isset($product_options['moodle_post_course_id']) && is_array($product_options['moodle_post_course_id']) && ! empty($product_options['moodle_post_course_id'])) {
        foreach ($product_options['moodle_post_course_id'] as $single_course_id) {
            $fields = get_fields($single_course_id);
        }
    }
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
<div class="row">

    <?php
    /**
     * Hook: woocommerce_before_single_product_summary.
     *
     * @hooked woocommerce_show_product_sale_flash - 10
     * @hooked woocommerce_show_product_images - 20
     */
    // do_action( 'woocommerce_before_single_product_summary' );
    ?>

    <!-- <div class="summary entry-summary"> -->
    <div class="col-12 mb-5">
        <h2>Course Overview</h2>

        <?php the_content(); // phpcs:ignore -- Already sanitizes in get_the_content(). ?>
        <?php
        /**
         * Hook: woocommerce_single_product_summary.
         *
         * @hooked woocommerce_template_single_title - 5
         * @hooked woocommerce_template_single_rating - 10
         * @hooked woocommerce_template_single_price - 10
         * @hooked woocommerce_template_single_excerpt - 20
         * @hooked woocommerce_template_single_add_to_cart - 30
         * @hooked woocommerce_template_single_meta - 40
         * @hooked woocommerce_template_single_sharing - 50
         * @hooked WC_Structured_Data::generate_product_data() - 60
         */
        // do_action( 'woocommerce_single_product_summary' );
        ?>
    </div>

    <div class="col-12">
        <h2>Enrol In This Course</h2>

        <div class="row my-4">

            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-lg">
                    <div class="card-body d-flex flex-column">
                        <?php if($product->is_on_sale()) : ?>
                            <div class="sale-badge">
                                <span>sale</span>
                            </div>
                        <?php endif; ?>
                        <div>
                        <?php if (is_array($fields)) : ?>
                            <?php 
                            if (array_key_exists('course_shortname', $fields) && $fields['course_shortname_status']) {
                                echo '<h5 class="h5 mt-0 card-title">' . $fields['course_shortname'] . '</h5>';
                                unset($fields['course_shortname']);
                            }
                            ?>
                            <ul class="list-unstyled mb-0">
                            <?php  ?>
                            <?php 
                            woocommerce_template_single_price();
                            if (array_key_exists('course_startdate', $fields) && $fields['course_startdate_status']) {
                                if ($fields['course_startdate'] != 0) {
                                    echo '<li><span class="font-weight-bold">Start Date:</span> ' . wp_kses(gmdate('l, jS M Y', $fields['course_startdate']), array()) . '</li>';
                                }
                                unset($fields['course_startdate']);
                            }
                            if (array_key_exists('course_enddate', $fields) && $fields['course_enddate_status']) {
                                if ($fields['course_enddate'] != 0) {
                                    echo '<li><span class="font-weight-bold">End Date:</span> ' . wp_kses(gmdate('l, jS M Y', $fields['course_enddate']), array()) . '</li>';
                                }
                                unset($fields['course_enddate']);
                            }
                            ?>
                        </ul>
                        <?php else : ?>
                            <h5 class="h5 mt-0 card-title"><?php echo get_title(); ?></h5>
                            <ul class="list-unstyled mb-0">
                                <?php woocommerce_template_single_price(); ?>
                            </ul>
                        <?php endif; ?>
                        </div>
                        <div class="enrol-btn mt-auto">
                            <?php woocommerce_template_single_add_to_cart(); ?>
                        </div><!-- .mt-auto -->
                    </div><!-- .card-body -->
                </div><!-- .card -->
            </div><!-- .col -->

        </div>
    </div>

    <?php
    /**
     * Hook: woocommerce_after_single_product_summary.
     *
     * @hooked woocommerce_output_product_data_tabs - 10
     * @hooked woocommerce_upsell_display - 15
     * @hooked woocommerce_output_related_products - 20
     */
    // do_action( 'woocommerce_after_single_product_summary' );
    ?>
</div>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
