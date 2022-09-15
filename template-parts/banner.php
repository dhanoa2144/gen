<?php
/**
 * Share buttons template part.
 *
 * @package WordPress
 * @subpackage genU Training
 */

$showBanner = false;
if (get_field('banner_image')) {
    if (array_key_exists('isShortcode', $args)) {
        $showBanner = true;
    } elseif (get_field('banner_show_above_footer')) {
        $showBanner = true;
    }
}
?>
<?php if ($showBanner) : ?>
    <div class="container my-5">
        <div class="row">
            <div class="col">
                <div class="d-flex justify-content-center">

                    <?php if (get_field('banner_link')) : ?>
                        <a id="banner-link" href="<?php the_field('banner_link'); ?>" target="<?php the_field('banner_target'); ?>" class="hoverable focusable-secondary rounded-xl">
                    <?php endif; ?>

                    <?php
                    echo wp_get_attachment_image(
                        get_field('banner_image'),
                        'full',
                        false,
                        array(
                            'id'    => 'banner-image',
                            'class' => 'shadow-lg rounded-xl mw-100 h-auto',
                        )
                    );
                    ?>

                    <?php if (get_field('banner_link')) : ?>
                        </a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
