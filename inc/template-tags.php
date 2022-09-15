<?php
/**
 * Template tags to support the genU Training theme.
 *
 * @package WordPress
 * @subpackage genU Training
 */

/**
 * Undocumented function
 *
 * @param [type] $post_id
 * @return string
 */
function gc_get_header_image( $post_id = null ) {
	$post_id = gc_sanitise_post_id( $post_id );

	$image_id = null;

	if( get_field( 'header_banner_image', get_queried_object() ) ) :
		$image_id = get_field( 'header_banner_image', get_queried_object() );
	elseif ( get_field( 'program_type_banner_image', get_queried_object() ) ) :
		$image_id = get_field( 'program_type_banner_image', get_queried_object() );
	else :
		$image_id = get_field( 'header_image', 'options' );
	endif;

	/*$image_html = wp_get_attachment_image(
		$image_id,
		'original',
		false
	);*/

	$image_html = wp_get_attachment_image($image_id,'full');

	return $image_html;
}

/**
 * Undocumented function
 *
 * @param [type] $post_id
 * @return void
 */
function gc_get_header_icon( $post_id = null ) {
	$post_id = gc_sanitise_post_id( $post_id );

	$icon_html = '';

	if ( is_tax( 'program_type' ) ) :
		$icon_html = wp_get_attachment_image(
			get_field( 'program_type_icon', get_queried_object() ),
			'full',
			true,
			array(
				'class' => 'd-block mb-3',
				'style' => 'max-width: 80px; height: auto;',
			)
		);
	endif;

	return $icon_html;
}

/**
 * Undocumented function
 *
 * @param [type] $post_id
 * @return void
 */
function gc_get_header_title( $post_id = null ) {
	$header_title = '';

	if ( is_tax() ) :
		$header_title = single_term_title( '', false );

	elseif ( is_home() ) :
		$header_title = get_the_title( get_option( 'page_for_posts' ) );

	else :
		if ( ! $post_id ) :
			global $post;
			$post_id = $post->ID;
		endif;

		$header_title = get_the_title( $post_id );
	endif;

	return $header_title;
}

/**
 * Undocumented function
 *
 * @param [type] $post_id
 * @return void
 */
function gc_get_header( $post_id = null ) {
	$post_id = gc_sanitise_post_id( $post_id );
	$header_image = gc_get_header_image( $post_id );

	$header_mobile_image = get_field('header_mobile_image', get_queried_object());
	$mobile_image = get_field('program_type_mobile_image', get_queried_object());
	
	$content=get_field( 'program_type_header_content', get_queried_object());

	$title=wp_kses( gc_get_header_title( $post_id ), array() );
	if ( function_exists( 'yoast_breadcrumb' ) ) : 
	//$breadcrumb=yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
	endif;

	if($mobile_image):
		$mobile_image = get_field('program_type_mobile_image', get_queried_object());
		elseif($header_mobile_image ):
			$mobile_image = get_field('header_mobile_image', get_queried_object());
	endif;
	?>

	<section class="slider">
		<div class="inner">
			<div class="campaign-banner-alt bg-inverted-darker-inner">
					<picture class="campaign-banner-alt__img_inner">
							<?php if (($mobile_image) || ($header_mobile_image) ): ?>
						<source media="(max-width: 767px)"
						srcset="<?php echo esc_url($mobile_image['url']);  ?>"> 
						<?php endif;?>
							
						<?php echo $header_image; ?>
					</picture>
					

					  <div class="container">
							<div class="row">
								
										<?php
										$title_count = max_title_length($title);
										if($title_count > 35) :
										?>
										<style>
											section.slider .max.campaign-banner-alt__inner{
												padding-top: 0rem;
												
											}
											section.slider .max.campaign-banner-alt__inner h1{
												padding: 0 10px 0 0 !important;
											}
											@media screen and (max-width: 767px) {
												section.slider .max.campaign-banner-alt__inner{
												padding-top: 3rem;
												}
												section.slider .max.campaign-banner-alt__inner h1{
												padding: 0 !important;
												}
											}
											
											</style>
										<?php endif;?>
								<div class="max campaign-banner-alt__inner banner-text col-lg-7 col-md-7">    
									<div class="banner-text-info">   
										<h1 class="mt-5 mb-4 text-white"><?php echo $title; ?></h1>
										<span class="d-block mb-4"><?php echo $content; ?></span>                  
									</div>
								</div>
							</div>
            		 </div><!-- container-->
			</div>
		</div>		

	</section>
	<?php if ( function_exists( 'yoast_breadcrumb' ) ) : ?>
			<div class="yoast"><div class="gen-bread container">
			<?php
			yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
			?>
			</div></div>
			<?php
			endif;
	?>
	
	<!-- .header -->

	<?php
}

/**
 * Generates the HTML for a location tooltip
 *
 * @param integer $location_id The post ID of the location.
 * @return string
 */
function gc_get_location_tooltip( $location_id ) {
	$tooltip_content = '<div>' . get_the_title( $location_id ) . '</div>';

	if ( get_field( 'loca_building', $location_id ) ) :
		$tooltip_content .= get_field( 'loca_building', $location_id ) . '/ ';
	endif;

	if ( get_field( 'loca_unit', $location_id ) ) :
		$tooltip_content .= get_field( 'loca_unit', $location_id ) . '<br>';
	endif;

	if ( get_field( 'loca_streetnumber', $location_id ) ) :
		$tooltip_content .= get_field( 'loca_streetnumber', $location_id ) . ' ';
	endif;

	if ( get_field( 'loca_streetname', $location_id ) ) :
		$tooltip_content .= get_field( 'loca_streetname', $location_id ) . '<br>';
	endif;

	if ( get_field( 'loca_city', $location_id ) ) :
		$tooltip_content .= get_field( 'loca_city', $location_id ) . ' ';
	endif;

	if ( get_field( 'loca_state', $location_id ) ) :
		$tooltip_content .= get_field( 'loca_state', $location_id ) . ' - ';
	endif;

	if ( get_field( 'loca_postcode', $location_id ) ) :
		$tooltip_content .= get_field( 'loca_postcode', $location_id ) . '<br><br>';
	endif;

	if ( get_field( 'loca_phone', $location_id ) ) :
		$tooltip_content .= '<strong>Phone: </strong><br>' . get_field( 'loca_phone', $location_id ) . '<br><br>';
	endif;

	if ( get_field( 'loca_timings', $location_id ) ) :
		$tooltip_content .= '<strong>Timings: </strong><br>' . get_field( 'loca_timings', $location_id ) . '<br>';
	endif;

	return $tooltip_content;
}

function gc_get_location_tooltip_clean( $location_id ) {
	$tooltip_content = get_the_title( $location_id );

	if ( get_field( 'loca_building', $location_id ) ) :
		$tooltip_content .= ' ' . get_field( 'loca_building', $location_id ) . '/ ';
	endif;

	if ( get_field( 'loca_unit', $location_id ) ) :
		$tooltip_content .= ' ' . get_field( 'loca_unit', $location_id ) . '<br>';
	endif;

	if ( get_field( 'loca_streetnumber', $location_id ) ) :
		$tooltip_content .= ' ' . get_field( 'loca_streetnumber', $location_id ) . ' ';
	endif;

	if ( get_field( 'loca_streetname', $location_id ) ) :
		$tooltip_content .= ' ' . get_field( 'loca_streetname', $location_id );
	endif;

	if ( get_field( 'loca_city', $location_id ) ) :
		$tooltip_content .= ' ' . get_field( 'loca_city', $location_id ) . ' ';
	endif;

	if ( get_field( 'loca_state', $location_id ) ) :
		$tooltip_content .= ' ' . get_field( 'loca_state', $location_id ) . ' - ';
	endif;

	if ( get_field( 'loca_postcode', $location_id ) ) :
		$tooltip_content .= ' ' . get_field( 'loca_postcode', $location_id );
	endif;

	if ( get_field( 'loca_phone', $location_id ) ) :
		$tooltip_content .= ', Phone: ' . get_field( 'loca_phone', $location_id );
	endif;

	if ( get_field( 'loca_timings', $location_id ) ) :
		$tooltip_content .= ', Timings: ' . get_field( 'loca_timings', $location_id );
	endif;

	return $tooltip_content;
}

/**
 * Returns a comma-separated list of taxonomy terms for a given post.
 *
 * @param integer $post_id  The post ID being queried.
 * @param string  $taxonomy The taxonomy to find terms for.
 * @param string  $before   Any HTML to appear before the output.
 * @param string  $after    Any HTML to appear after the output.
 * @param boolean $display  Whether to echo the output or return it. Default is true (echo the output).
 * @return mixed
 */
function gc_the_post_terms( $post_id = null, $taxonomy, $before = null, $after = null, $display = true ) {
	$post_id = gc_sanitise_post_id( $post_id );

	$tax_terms = get_the_terms( $post_id, $taxonomy );

	if ( $tax_terms && ! is_wp_error( $tax_terms ) ) :

		$the_terms = array();

		foreach ( $tax_terms as $term ) {
			$the_terms[] = $term->name;
		}

		$result = join( ', ', $the_terms );
		$result = ( $before ) ? $before . $result : $result;
		$result = ( $after ) ? $result . $after : $result;

		if ( $display ) :
			echo $result;
		else :
			return $result;
		endif;
	else :
		return false;
	endif;
}

/**
 * Returns the current post ID if no post ID was passed.
 *
 * @param integer $post_id The post ID to check.
 * @return integer
 */
function gc_sanitise_post_id( $post_id = null ) {
	if ( ! $post_id ) :
		global $post;
		$post_id = $post->ID;
	endif;
	return $post_id;
}
