<?php
/**
 * Template to appear after single content
 *
 * @package WordPress
 * @subpackage genU Training
 */

$filter_taxonomies = array(
	'location',
	'study_mode',
);

// Initialise the post type filter.
use \Grindstone\WordPress\Filter;
Filter::get_filters( $filter_taxonomies );
Filter::init_filters();

?>
 <div class="grey-bg"><!-- Grey background-->
	<div class="container my-5 upcoming" id="upcoming">
	<div class="row">
		<div class="col">
		<?php 
			$courses = getProgramOccurrencesFromVETtrak( get_field( 'prog_id' ) );
			
			//$courses_number = ( is_object( $courses ) ) ? array( $courses ) : $courses;
		
			if ( ! $courses ) : 
			$courses = array();
			endif;
			
			if(is_object( $courses )) :
			$total_course = 1 ;
			endif;
	
			if( is_array ($courses) &&  count($courses) )
			{
			 $total_course = count($courses);	
			}
			if($total_course == 0){
				$heading = 'Upcoming Courses';
			}
			elseif($total_course == 1){
				$heading = 'Apply Now';
			}
			elseif($total_course > 1){
				$heading = 'Select Your Preferred Course Location and Date';
			}
			?>
		  
			<h2 class="mb-4"><?php echo $heading ;?></h2>

			<?php if ( ! $courses ) : ?>

				<p>For more information about upcoming courses in your area, please <a href="/course-enquiry/">make an enquiry</a></p>
<br/>
			<?php else : ?>

				<?php
				// If a single course is returned, make sure it's stored in an array.
				$upcoming_courses = ( is_object( $courses ) ) ? array( $courses ) : $courses;
				$none_shown = true;
				?>
				<?php echo Filter::the_unfilters(); ?>
				<?php Filter::the_reset_button(); ?>
				<div class="row my-4">
					<?php foreach ( $upcoming_courses as $upcoming_course ) : ?>
						<?php

						$studyMode = studyModeFromDeliveryMode($upcoming_course->DeliveryModes->string);

						$location_details = getLocationDetails( $upcoming_course->Loca_Code );

						$location_id = $location_details->ID;

						if($_GET['filter']) {
							$filters = explode('!', $_GET['filter']);

							$stateArr = [
								'national' => 'nat',
								'victoria' => 'vic',
								'new south wales' => 'nsw',
								'queensland' => 'qld',
								'south australia' => 'sa',
								'western australia' => 'wa',
								'australian capital territory' => 'act'
							];

							$continue = true;
							$location = false;
							$study_mode = false;
							foreach($filters as $f) {
								$filter = explode(':', $f);
								$filterArr[$filter[0]] = $filter[2];
								if($stateArr[strtolower($filter[2])] == strtolower(get_field( 'loca_state', $location_id ))) {
									$location = true;
								} elseif(strtolower($filter[2]) == strtolower($studyMode)) {
									$study_mode = true;
								}
							}

							if(array_key_exists('study_mode', $filterArr) && array_key_exists('location', $filterArr)) {
								if($location && $study_mode) {
									$continue = false;
								}
							} elseif(array_key_exists('study_mode', $filterArr)) {
								if($study_mode) {
									$continue = false;
								}
							} elseif(array_key_exists('location', $filterArr)) {
								if($location) {
									$continue = false;
								}
							}
						}

						if($continue) {
							continue;
						} else {
							$none_shown = false;
						}

						$applyURL = property_exists($upcoming_course, 'Description') && rapidURLFromDescription($upcoming_course->Description) != ''
							? rapidURLFromDescription($upcoming_course->Description)
							: 'https://enrol.vetenrol.com.au/?clientid=VT-GENU&occuID=' . $upcoming_course->ID;

						if( strtolower($studyMode) === 'virtual') {
							$location = sprintf(
								'<span data-toggle="tooltip" data-html="true" title="%s">%s</span>',
								'genU Training - this training is delivered online via a virtual training room',
								'Online'
							);
						} else {
							$location = sprintf(
								'<a href="#" data-toggle="tooltip" data-html="true" title="%s">%s</a>',
								gc_get_location_tooltip_clean( $location_id ),
								get_field( 'loca_city', $location_id )
							);
						}

						$course_details = [
							'Delivery State' => get_field('loca_state', $location_id),
							'Location'  => $location,
							'Study Mode' => $studyMode,
							'Study Time' => $upcoming_course->EnrolmentType,
 							// 'Fee' => '$' . $upcoming_course->Amount,
							'Vacancies' => $upcoming_course->Vacancies,
						];

						?>
						<div class="col-md-6 col-lg-4 mb-4">
							<div class="card h-100 shadow-lg">
								<div class="card-body d-flex flex-column">
									<div>
										<h3 class="h5 card-title"><?php echo wp_kses( gmdate( 'l, jS M Y', strtotime( $upcoming_course->StartDate ) ), array() ); ?></h3>
										<ul class="list-unstyled">
											<?php
											foreach ( $course_details as $label => $value ) :
												if(!empty($value)){
													echo sprintf( '<li><span class="font-weight-bold">%s:</span> %s</li>', $label, $value );
												}
											endforeach;
											?>
										</ul>
									</div>
									<div class="mt-auto">
										<a href="<?php echo esc_url($applyURL); ?>" class="btn btn-secondary apply" target="_blank" rel="noopener noreferrer">Apply</a>
									</div><!-- .mt-auto -->
								</div><!-- .card-body -->
							</div><!-- .card -->
						</div><!-- .col -->
					<?php endforeach; ?>
				<?php if($none_shown) : ?>
					<p class="ml-3">For more information about upcoming courses in your area, please <a href="/course-enquiry/">make an enquiry</a></p>
				<?php endif; ?>
				</div><!-- .row -->

			<?php endif; ?>

			<?php get_template_part( 'template-parts/newcourse-callout' ); ?>


		 
		</div><!-- .col -->
	</div><!-- .row -->
</div><!-- .container -->
</div><!--Grey Background -->		
<?php get_template_part( 'template-parts/course', 'footer' ); ?>
