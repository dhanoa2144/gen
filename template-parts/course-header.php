<?php
/**
 * Template to appear before the course info
 *
 * @package WordPress
 * @subpackage genU Training
 */

?>
<script>
    jQuery(document).ready(function($) {
        jQuery("#apply-now").click(function() {
            jQuery('html, body').animate({
        scrollTop: $("#upcoming").offset().top
    }, 2000);
});
})
    </script>
<?php if ( get_field( 'prog_code' ) || get_field( 'course_length' ) || get_field( 'course_study_mode' ) || get_field( 'course_title' ) ) : ?>


        <div class="course-details">
            <div class="single-course">
                <h2 class="course-title"><?php if ( get_field( 'course_title' ) ) : ?> 
                    <?php the_field( 'course_title' ); ?> <?php endif; ?></h2>
              <div id="apply-now" class="apply-now"> 
                 <a class="apply" >Apply Now</a></div><br/>
                <?php if ( get_field( 'prog_code' ) ) : ?>
                <span class="code"><b>Course Code:</b><br/><?php the_field( 'prog_code' ); ?></span><br/><br/>
                <?php endif; ?>
                <span class="length"></span>
                <?php if ( get_field( 'course_study_mode' ) ) : ?>
                     <span class="mode"><b>Study Mode:</b><br/><?php the_field( 'course_study_mode' ); ?></span><br/><br/>
                      <?php endif; ?>

                      <?php if ( get_field( 'course_length' ) ) : ?>
                        <span class="length"> <b>Course Length</b><br/><?php the_field( 'course_length' ); ?>
                      </span>
                        <?php endif; ?>
            </div>
        </div>



<?php else : ?>
    <?php
    global $product;
    $product_options = get_post_meta($product->get_id(), 'product_options', true);
    if (! empty($product_options)) {
        if (isset($product_options['moodle_post_course_id']) && is_array($product_options['moodle_post_course_id']) && ! empty($product_options['moodle_post_course_id'])) {
            foreach ($product_options['moodle_post_course_id'] as $single_course_id) {
                $fields = get_fields($single_course_id);
            }
        }
    }

    if (array_key_exists('course_shortname', $fields)) {
        unset($fields['course_shortname']);
    } 
    if (array_key_exists('course_startdate', $fields)) {
        unset($fields['course_startdate']);
    } 
    if (array_key_exists('course_enddate', $fields)) {
        unset($fields['course_enddate']);
    }
    ?>
    <?php if (!empty($fields)) : ?>
<div class="container my-5">
    <div class="row">
        <div class="col">
            <table class="table table-bordered table-striped">
            <?php foreach ($fields as $key => $value) : ?>
                <?php if (array_key_exists( $key . '_status', $fields )) : ?>
                    <?php if (strpos($key, '_status') === false && $fields[$key . '_status']) : ?>

                <tr>
                    <td><?php echo $key; ?></td>
                    <td><?php echo $value; ?></td>
                </tr>

                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>

            </table>
        </div>
    </div>
</div>
    <?php endif; ?>

<?php endif; ?>
