<?php


// Initialise the post type filter.
use \app\wisdmlabs\edwiserBridge\EbShortcodeMyCourses;


if (!is_user_logged_in()) {
    ?>
    <p>
        <?php
        printf(
            __('You are not logged in. %s to login.', 'eb-textdomain'),
            "<a href='".esc_url(site_url('/user-account'))."'>".__("Click here", "eb-textdomain")."</a>"
        );
        ?>
    </p>
    <?php
} else {
    $my_courses = EbShortcodeMyCourses::getUserCourses(get_current_user_id());
    if (count($my_courses)) {
        //My Courses.
        $args = array(
            'post_type' => 'eb_course',
            'post_status' => 'publish',
            'post__in' => $my_courses,
            'ignore_sticky_posts' => true,
            'posts_per_page' => -1
        );

        $courses = new \WP_Query($args);

        if ($courses->have_posts()) : ?>
            <h5>My Courses</h5>
            <hr/>
            <div class="row eb-my-course">
            <?php while ( $courses->have_posts() ) : $courses->the_post(); //phpcs:ignore -- Inline post loop. ?>

                <div class="col-lg-6 mb-4">
                    <div class="card h-100 shadow-lg">
                        <div class="card-body d-flex flex-column">
                            <div>
                                <p class="mb-1 font-weight-medium">
                                    <?php if ( 'program' === get_post_type() ) : ?>
                                        <?php the_field( 'prog_code' ); ?>
                                    <?php else : ?>
                                        <?php echo 'MOODLE'; ?>
                                    <?php endif; ?>
                                </p>
                                <h2 class="h4 card-title"><?php the_title(); ?></h2>
                                <p>
                                    <?php if ( 'program' === get_post_type() ) : ?>
                                        <?php the_field( 'prog_desc' ); ?>
                                    <?php else : ?>
                                        <?php echo get_the_excerpt(); ?>
                                    <?php endif; ?>
                                </p>
                                <ul class="mb-4 font-weight-medium list-unstyled">
                                    <?php
                                    foreach ( $filter_taxonomies as $filter_taxonomy ) :
                                        $tax_icon = Filter::the_tax_icon( $filter_taxonomy, false, array( 'class' => 'svg-icon svg-icon-primary mr-2' ) );
                                        gc_the_post_terms( get_the_ID(), $filter_taxonomy, '<li class="d-flex mb-2">' . $tax_icon, '</li>' );
                                    endforeach;
                                    ?>
                                </ul>
                            </div>

                            <div class="mt-auto">
                                <a href="<?php the_permalink(); ?>" class="btn btn-secondary stretched-link">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>
            </div><!-- .row -->
        <?php
        endif;
    } else {
        $ebGeneralSettings = get_option("eb_general");
        if (isset($ebGeneralSettings['eb_my_course_link']) && !empty($ebGeneralSettings['eb_my_course_link'])) {
            $link = $ebGeneralSettings['eb_my_course_link'];
        } else {
            $link = site_url('/training-courses/short-courses/');
        }
        ?>
        <h5>
            <?php
            printf(
                __('You are not yet enrolled to any course. %s to access the courses page.', 'eb-textdomain'),
                "<a href='".$link."'>".__("Click here", "eb-textdomain")."</a>"
            );
            ?>
        </h5>
        <?php
    }
}

// echo do_shortcode('[eb_my_courses my_courses_wrapper_title="My Courses" recommended_courses_wrapper_title="Recommended Courses" number_of_recommended_courses="4" ]');
