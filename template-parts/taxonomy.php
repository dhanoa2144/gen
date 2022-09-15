<?php
/**
 * Taxonomy: Program Type -- Archive Template
 *
 * @package WordPress
 * @subpackage genU Training
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

<main id="content" class="py-5">
	<div class="container">
			<?php echo do_shortcode('[readspeaker_listen_button readid=read_this]'); ?>
		<div class="row mb-3">
		
		<?php 
		$show_studymode= get_field('show_studymode', get_queried_object());
		?>
				<div class="<?=$show_studymode ? 'col-lg-8' : 'col-lg-12'?>">
				
			<?php
					
					$mode_heading= get_field('mode_heading', get_queried_object());
					$modeText = get_field('mode_text', get_queried_object());
					$link= get_field('mode_link', get_queried_object());
					$text_link= get_field('text_link', get_queried_object());

					if($link) :
					$link_url = $link['url'];
					//$link_title = $link['title'];
					$link_target = $link['target'] ? $link['target'] : '_self';
					endif;

					if($text_link):
						$link_title = get_field('text_link', get_queried_object());
					else:
						if($link):	
							$link_title = $link['title'];
							endif;	
					endif;	

					// Pull the default term description
					$content = term_description(get_queried_object()->term_id);
					// Sometimes the content is stored in a custom field
					$customContent = get_field(get_queried_object()->taxonomy . '_content', get_queried_object());

					if(!empty($customContent)){
						echo $customContent;
					}elseif(!empty($content)){
						echo $content;
					}
					?>

			</div>
			<?php if($show_studymode) :?>
			<div class="col-lg-4">
				<div class="study-mode">
					<div class="study-content">
						<h3><?php echo $mode_heading;?></h3>
						<p><?php echo $modeText;?></p>
						<button onclick="window.location.href='<?php echo $link_url;?>'"><?php echo $link_title;?></button>
					</div>
				</div>
			</div>
			<?php endif;?>
			<div class="col" id="read_this">
				
				<hr>

				<p class="h6 mb-3" id="filters">Filter by:</p>
				<div class="row gc-filter-container d-flex px-3 px-lg-0">
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

												<?php
												$productMeta = get_post_meta(get_the_id(), 'product_options', true);

												if(!empty($productMeta['moodle_post_course_id'][0])){
													$courseID = get_field('course_idnumber', (int) $productMeta['moodle_post_course_id'][0]);

													if(!empty($courseID)){
														echo $courseID;
													}
												}
												?>

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
				<?php // echo '<strong> Share :</strong>' . do_shortcode( '[addtoany]' ); ?>
			</div><!-- .col -->
		</div><!-- .row -->

	</div><!-- .container -->
</main>
<style>
#curve {
    background: none !important;
}
</style>

<?php
get_footer();
