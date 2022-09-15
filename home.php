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

<?php gc_get_header(); ?>

<main id="content">

	<div class="container my-5">

		<div class="row">
			<div class="col" id="read_this">
				<?php echo do_shortcode('[readspeaker_listen_button readid=read_this]'); ?>

				<div class="card bg-cool-grey border-0 mb-4">
					<div class="card-body">

						<form class="form-inline" action="" method="GET">

							<span class="mx-2">Filter by:</span>

							<select class="custom-select mx-2" name="year" id="year">
							<option value=""><?php esc_attr( _e( 'All', 'textdomain' ) ); ?></option> 
								<option value="2018">2019</option>
								<option value="2017">2018</option>
							</select>

							<select class="custom-select mx-2" name="month">
								<option value=""><?php esc_attr( _e( 'Month', 'textdomain' ) ); ?></option> 
								<?php
								for ( $month = 1; $month <= 12; ++$month ) :
									echo sprintf(
										'<option value="%s">%s</option>',
										gmdate( 'm', mktime( 0, 0, 0, $month, 1 ) ),
										gmdate( 'F', mktime( 0, 0, 0, $month, 1 ) ),
									);
								endfor;
								?>
							</select>

							<button type="submit" class="btn btn-secondary mx-2">Submit</button>

						</form>

					</div><!-- .card-body -->
				</div><!-- .card -->

			</div><!-- .col -->
		</div><!-- .row -->

		<?php if ( have_posts() ) : ?>
			<div class="row">
			<?php while ( have_posts() ) : the_post(); //phpcs:ignore -- Inline post loop. ?>

				<div class="col-12 mb-4">
					<div class="row border-bottom">

						<div class="col-12 col-md-4 pb-4">

							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'home_thumb', array( 'class' => 'w-100 h-auto border rounded-xl shadow' ) ); ?>
							<?php else : ?>
								<div class="bg-cool-grey border rounded-xl shadow w-100 h-100 d-flex justify-content-center align-items-center">
									<div class="p-4">
										<?php echo file_get_contents( THEME_DIR_URI . '/assets/images/logo-white.svg' ); ?>
									</div>
								</div>
							<?php endif; ?>

						</div><!-- .col -->
						<div class="col-12 col-md-8 pb-4">
							<div class="">
								<h2><?php the_title(); ?></h2>
								<p class="font-weight-medium"><?php echo get_the_date( 'F j, Y' ); ?></p>
								<p><?php echo get_the_excerpt(); //phpcs:ignore -- Already sanitizes in get_the_excerpt(). ?></p>
								<a href="<?php the_permalink(); ?>" class="btn btn-secondary">Read more</a>
							</div>
						</div><!-- .col -->

					</div><!-- .row -->
					<div class="clearfix"></div>
				</div><!-- .col -->

				<?php endwhile; ?>
			</div>
		<?php endif; ?>

		<div class="row mb-5">
			<div class="col">
				<?php require locate_template( '/template-parts/pagination.php', false, false ); ?>
			</div><!-- .col -->
		</div><!-- .row -->

	</div><!-- .container -->

</main>

<?php
get_footer();
