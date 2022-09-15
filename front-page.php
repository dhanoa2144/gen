<?php
/**
 * Homepage Template
 *
 * @package WordPress
 */

get_header();
?>
<?php require locate_template( '/template-parts/front-page-slider.php', false, false ); ?>
<section class="course-search">
	<div class="container">
		<div class="row">
			<div class="col-lg-7">
				<?php echo do_shortcode( '[wpdreams_ajaxsearchpro id=1]' ); ?>
			</div>
		</div>
	</div>
</section>

<section class="categories bg-cool-grey pt-0">
	<div class="container pt-5 pb-4 text-center">
		<div class="row pt-5">
			<div class="col" id="read_this">
				<?php echo do_shortcode('[readspeaker_listen_button readid=read_this]'); ?>
				<!--<h1 class="font-50 text-primary">Quality Education and Training</h1>-->
			</div>
		</div>
		<!--<div class="row">
			<div class="col-lg-8 offset-lg-2">
				<p>As a genU Training student you can expect high quality training and individual support services that deliver job-ready and nationally-recognised qualifications and vocational short courses.</p>
			</div>
		</div>-->
	</div>
</section>

<section class="features bg-white pt-lg-5">
	<div class="container">
		<div class="row">

			<?php if ( have_rows( 'feat_types' ) ) : ?>
				<?php while ( have_rows( 'feat_types' ) ) : the_row(); //phpcs:ignore -- Inline post loop. ?>

					<div class="featured-cards col-md-4 mb-4">
						<div class="card shadow-lg" style="z-index: 2;">
							<div class="card-image-wrapper">
								<div class="card-image">
									<img class="d-block" style="z-index: 1;"
										src="<?php the_sub_field( 'image' ); ?>" />
									<!-- <img class="d-block" style="z-index: 1;"
										src="<?php //echo get_template_directory_uri() ?>/assets/images/test.jpg" /> -->
									<div class="overlay w-100 h-100"></div>
								</div>
							</div>
							<div class="card-body">
								<div class="d-flex flex-row px-lg-3 pb-2">
									<div class="text-left">
										<h2 class="h4 mb-md-3 mt-4 text-primary"><?php echo wp_kses( get_sub_field( 'program_type' )->name, array() ); ?></h2>
										<p class="mx-0">
											<?php the_sub_field( 'text' ); ?>
										</p>
										<a href="<?php echo esc_url( get_term_link( get_sub_field( 'program_type' )->term_id, 'program_type' ) ); ?>" class="feat-links pb-1">
											View courses
										</a>
									</div><!-- .card-body -->
								</div><!-- .d-flex -->
							</div><!-- .card-body -->
						</div><!-- .card -->
					</div><!-- .col -->

				<?php endwhile; ?>
			<?php endif; ?>

		</div>
	</div>
</section>

<?php if ( get_field( 'program_types' ) ) : ?>

	<section class="py-5 bg-white">
		<div class="container">

			<div class="row">
				<div class="col-12">
					<h2 class="font-40 text-primary"><?php  echo get_field( 'featured_course_heading' ); ?></h2>
					<p class="mb-5"><?php  echo get_field( 'featured_course_info' ); ?></p>
				</div>
			</div>

			<div class="row">

				<?php foreach ( get_field( 'program_types' ) as $program_type ) : ?>

					<div class="col-sm-6 col-md-4 col-lg-3 mb-4">
						<div class="card h-100 border-0 rounded-lg bg-primary">
							<div class="card-body h-100 d-flex flex-column">
								<?php
								echo wp_get_attachment_image(
									get_field( 'program_type_icon', 'program_type_' . $program_type->term_id ),
									'full',
									true,
									array(
										'class' => 'd-block mb-3',
										'style' => 'max-width: 70px; height: auto;',
									)
								);
								?>
								<h2 class="h4 mb-3 text-white"><?php echo wp_kses( $program_type->name, array() ); ?></h2>
								<a title="Click here to view programs for <?php echo esc_attr( $program_type->name ); ?>" href="<?php echo esc_url( get_category_link( $program_type->term_id ) ); ?>" class="mt-auto stretched-link text-white gencourse-area">
									View courses
								</a>
							</div>
						</div>
					</div>

				<?php endforeach; ?>

			</div>
		</div>
	</section>

<?php endif; ?>

<?php if ( get_field( 'course_info_enable' ) ) : ?>
<section class="course-info bg-white pb-5">
	<div class="container">
		<div class="row mx-0">
			<div class="card w-100 no-hover shadow-lg mb-4">
				<div class="card-body">
					<div class="row">

						<div class="col-12 col-lg-6 py-3">
							<h2 class="h4 mb-3"><?php echo get_field('course_info_title'); ?></h2>
							<p class="mb-3 pb-3"><?php echo get_field('course_info_description'); ?></p>
							<?php $button = get_field('course_info_button'); ?>
							<a class="btn btn-secondary py-3 info-link" href="<?php echo $button['url']; ?>" target="<?php echo $button['target']; ?>">
								<?php echo $button['title']; ?>
							</a>
						</div>

						<div class="col-12 col-lg-6">
						<?php if ( get_field( 'course_info_links' ) ) : ?>
							<div class="links mx-3">
							<?php foreach ( get_field( 'course_info_links' ) as $course_info_links ) : ?>
								<div class="link row mb-2 mb-lg-3 border rounded-lg">
									<?php $link = $course_info_links['link']; ?>
									<a class="text-primary row w-100 px-3 py-3 mx-0 align-items-start" href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>">
										<img class="link-image col-3 p-0 mr-2 mr-md-3" src="<?php echo $course_info_links['image'] ?>" />
										<span class="col-9 p-0"><?php echo $link['title']; ?></span>
									</a>
								</div>
							<?php endforeach; ?>
							</div>
						<?php endif; ?>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>


<?php require locate_template('/template-parts/testimonials.php', false, false); ?>


<?php
get_footer();
