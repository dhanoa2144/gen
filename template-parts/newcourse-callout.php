<?php
/**
 * Share buttons template part.
 *
 * @package WordPress
 * @subpackage genU Training
 */

?>
<?php if ( get_field( 'cc_content', 'options' ) ) : ?>
	

				<div class="card-help border-0 bg-primary text-light shadow-lg callout-header">
					<div class="course-callout">
					
					<picture class="image">
					<?php if ( get_field( 'course_callout_mobile_image', 'options' ) ) :
							$callout_mobile_image = get_field( 'course_callout_mobile_image', 'options' ); ?>

								<source media="(max-width: 767px)"
								 srcset="<?php echo esc_url($callout_mobile_image['url']);  ?>">

						<?php endif; ?>

						<?php if ( get_field( 'callout_image', 'options' ) ) :

							$image = get_field( 'callout_image', 'options' ); ?>
							<?php  echo wp_get_attachment_image( $image, 'full' );?>

						<?php endif; ?>
						</picture>
							

					</div> <!-- course-callout-->
					
					<div class="new-card">
						<div class="card-body">

							<?php if ( get_field( 'cc_title', 'options' ) ) : ?>
								<h2 class="h4 card-title text-light"><?php the_field( 'cc_title', 'options' ); ?></h2>
							<?php endif; ?>
							<?php if ( get_field( 'callout_sub_title', 'options' ) ) : ?>
								<h4><?php the_field( 'callout_sub_title', 'options' ); ?></h4>
								<?php endif; ?>
							<?php the_field( 'cc_content', 'options' ); ?>

							<?php if ( get_field( 'cc_link', 'options' ) && get_field( 'cc_link_text', 'options' ) ) : ?>
								<a href="<?php the_field( 'cc_link', 'options' ); ?>" class="py-3 btn btn-secondary">
									<?php the_field( 'cc_link_text', 'options' ); ?>
								</a>
							<?php endif; ?>

						</div><!-- .card-body -->
					</div> <!-- .new-card-->
				</div><!-- .card -->
			
<?php endif; ?>
