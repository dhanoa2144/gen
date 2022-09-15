<?php
/**
 * Course footer template part.
 *
 * @package WordPress
 * @subpackage genU Training
 */
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

<?php //get_template_part( 'template-parts/course-callout' ); ?>

<?php get_template_part( 'template-parts/banner' ); ?>

<?php get_template_part( 'template-parts/share' ); ?>
<?php $featured_posts= get_field('related_courses_tab');?>

<div class="container ">
	<div class="row mb-3">
		<div class="col-lg-12 my-3">
	<h2 class="related-section-title"><?php the_field('related_course_title');?></h2>
</div>
	<?php if( $featured_posts ): ?>
	<?php foreach( $featured_posts as $featured_post ): 
			$permalink = get_permalink( $featured_post->ID );
			$title = get_the_title( $featured_post->ID );
			$custom_field = get_field( 'prog_code', $featured_post->ID );
			?>
			<div class="col-lg-6 mb-4">
							<div class="card h-100 shadow-lg">
								<div class="card-body d-flex flex-column">
									<div>
										<p class="mb-1 font-weight-medium">
											<?php echo $custom_field;?>
										</p>
										<h2 class="h4 card-title related-title"><?php echo $title; ?></h2>
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
												gc_the_post_terms( $featured_post->ID , $filter_taxonomy, '<li class="d-flex mb-2">' . $tax_icon, '</li>' );
											endforeach;
											?>
										</ul>
									</div>

									<div class="mt-auto">
										<a href="<?php echo $permalink; ?>" class="btn btn-secondary stretched-link">Read more</a>
									</div>
								</div>
							</div>
						</div>
		<?php endforeach; ?>
		
	<?php endif; ?>

</div>
</div>

<!-- Old Related course container removed for new related course footer //check old file if anything breaks-->



