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

$filter_taxonomies = array(
	'location',
	'industry',
	'study_mode',
	'course_time',
);

// Initialise the post type filter.
use \Grindstone\WordPress\Filter;
Filter::get_filters( $filter_taxonomies );
?>

<?php gc_get_header(); ?>

<main id="content" class="py-5 archive">
	<div class="container">
		<div class="row mb-3">
			<div class="col">

				<?php the_field( get_queried_object()->taxonomy . '_content', get_queried_object() ); ?>
				<hr>

				<p class="h6 mb-3">Filter by:</p>
				<div class="d-flex justify-content-between">
					<?php Filter::the_filters(); ?>
				</div>

				<?php Filter::the_unfilters(); ?>
				<?php Filter::the_reset_button(); ?>
				<hr>

				<?php if ( have_posts() ) : ?>
					<div class="row">
					<?php while ( have_posts() ) : the_post(); //phpcs:ignore -- Inline post loop. ?>

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
				<?php endif; ?>

			</div><!-- .col -->
		</div><!-- .row -->

		<div class="row mb-5">
			<div class="col">
				<?php require locate_template( '/template-parts/pagination.php', false, false ); ?>
			</div><!-- .col -->
		</div><!-- .row -->

		<div class="row">
			<div class="col">
				<?php echo '<strong> Share :</strong>' . do_shortcode( '[addtoany]' ); ?>
			</div><!-- .col -->
		</div><!-- .row -->

	</div><!-- .container -->
</main>
<?php
get_footer();
