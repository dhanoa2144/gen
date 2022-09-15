<?php

/**
 * The template for displaying all single moodle courses.
 */
namespace app\wisdmlabs\edwiserBridge;

$wrapper_args = array();

$eb_template = get_option('eb_template');
if (isset($eb_template['single_enable_right_sidebar']) && $eb_template['single_enable_right_sidebar'] === 'yes') {
	$wrapper_args['enable_right_sidebar'] = true;
	$wrapper_args['parentcss'] = '';
} else {
	$wrapper_args['enable_right_sidebar'] = false;
	$wrapper_args['parentcss'] = 'width:100%;';
}
$wrapper_args['sidebar_id'] = isset($eb_template['single_right_sidebar']) ? $eb_template['single_right_sidebar'] : '';

$template_loader = new EbTemplateLoader(
	edwiserBridgeInstance()->getPluginName(),
	edwiserBridgeInstance()->getVersion()
);
?>

<?php get_header(); ?>

<?php gc_get_header(); ?>

<?php // $template_loader->wpGetTemplate('global/wrapper-start.php', $wrapper_args); ?>

<section id="primary" class="content-area" style="overflow:auto; padding:15px;">
	<main id="content" class="site-main" role="main">

		<?php get_template_part( 'template-parts/single-beforecontent', get_post_type() ); ?>
		<?php do_action( 'eb_before_single_course' ); ?>

		<div class="container my-5">
			<div class="row">
				<div class="col">

					<?php
					$ebShrtcodeWrapper = new EbShortcodeMyCourses();

					while ( have_posts() ) :
						the_post();
						$template_loader->wpGetTemplatePart( 'content-single', get_post_type() );
						$ebShrtcodeWrapper->generateRecommendedCourses();
						comments_template();
					endwhile;
					?>

				</div><!-- .col -->
			</div><!-- .row -->
		</div><!-- .container -->

		<?php do_action( 'eb_after_single_course' ); ?>
		<?php get_template_part( 'template-parts/single-aftercontent', get_post_type() ); ?>

	</main>
</section>

<?php // $template_loader->wpGetTemplate('global/wrapper-end.php', $wrapper_args); ?>

<?php
if ( file_exists( get_template_directory_uri() . '/sidebar.php' ) ) :
	get_sidebar();
endif;
?>

<?php
get_footer();
