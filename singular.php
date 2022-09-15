<?php
/**
 * The styleguide template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage _gc
 * @since 1.0.0
 */

get_header();
?>

<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); //phpcs:ignore -- Inline post loop. ?>

		<?php gc_get_header(); ?>

		<main id="content">
		
		
<?php if ( get_field( 'prog_code' ) || get_field( 'course_length' ) || get_field( 'course_study_mode' ) || get_field( 'course_title' ) ) : 
$class = 'col-lg-8'; 
else: $class = 'col-lg-12'; 
endif;?>
		<!-- Container added for sidebar!-->	
		<div class="container my-5">
				<div class="row">
					<div class="col" id="read_this">
						<?php echo do_shortcode('[readspeaker_listen_button readid=read_this]'); ?>
						<?php //the_content(); ?>
					</div><!-- .col -->
				</div><!-- .row -->

				<div class="row">
						<div class="<?php echo $class;?>">					
						<?php the_content(); ?>
						</div>
						<div class="col-lg-4 col-md-12 order-first order-lg-1 py-3">
						<?php get_template_part( 'template-parts/single-beforecontent', get_post_type() ); ?>
						</div>
				</div>
		</div>
		<!-- Container finished!-->	


			<div class="container my-5">
				<div class="row">
					<?php 
						$page_title = get_the_title();
						if ($location = get_field('linked_location')) {
							global $post;
							$my_post = get_post($location->ID);
							if (!empty($my_post)) {
								$post = $my_post;
								setup_postdata( $post );
								$fields = get_fields();
								$fields["page_title"] = $page_title;
								get_template_part('template-parts/singular-campus-location', null, $fields);
								wp_reset_postdata();
							}
						}
					?>
				</div>

				
			</div><!-- .container -->

			<?php get_template_part( 'template-parts/single-aftercontent', get_post_type() ); ?>

		</main>

	<?php endwhile; ?>
<?php endif; ?>
<style>
#curve {
    background: none !important;
}
</style>

<?php
get_footer();
