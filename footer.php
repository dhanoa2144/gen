<?php
/**
 * The template for displaying the footer
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage _gc
 * @since 1.0.0
 */

?>


<!-- Callout Section-->

<?php 
$background_image = get_field('background_image', 'options');
$callout_mobile_image = get_field('callout_mobile_image', 'options');
 ?>
	<section class="right-course">
				
		<div class="help">
			<picture class="image">
			<?php if($callout_mobile_image):?>
				<source media="(max-width: 767px)"
				 srcset="<?php echo esc_url($callout_mobile_image['url']);  ?>">
				 <?php endif;?>
				 <?php if($background_image):?>
					<img src="<?php echo esc_url($background_image['url']);  ?>">
					<?php endif;?>
			</picture>
			

			<div class="container">
                <div class="row">
					<div class="col-lg-7 col-md-6"></div>
					<div class="help-info col-lg-5 col-md-6">
						<div class="help-text">
								<?php if (get_field( 'help_heading', 'options' )) : ?>
										<h2><?php  the_field('help_heading', 'options');?>
										<span><?php  the_field('help_sub_heading', 'options');?></span></h2>
								<?php endif;?>	

								<?php 
									if (get_field( 'help_message', 'options' )) : ?>	
									<p><?php  the_field('help_message', 'options');?></p>
								<?php endif;?>	
									<?php  $link = get_field('help_cta_link', 'options');
									$link_url = $link['url'];?>
									<a class="py-3 enquiry" onclick="window.location.href=('<?php echo $link_url;?>');" >Make an enquiry</a>	
						</div>
					</div>
				</div>
            </div><!-- container-->
		</div>
			


	</section>

<!-- Callout Section Ends-->



		<footer class="bg-dark-blues text-white py-5 no-margin-footer">
			<div class="container">
				<div class="row">
					<div class="col-6 col-lg-3 mb-3 text-left text-lg-left">
						<h6 class="text-white">Karingal St Laurence Limited</h6>
						<ul class="list-unstyled">
							<li>TOID 5553</li>
							<li>ABN 74 614 366 031</li>
							<li>ACN 614 366 031</li>
						</ul>
					</div>
					<div class="col-6 col-lg-3 mb-3 text-left text-lg-left">
						<h6 class="text-white">Contact Us</h6>
						<ul class="list-unstyled">
							<li><a class="text-white" href="tel:1300582687">1300 582 687</a></li>
							<li><a class="text-white" href="mailto:training@genu.org.au">training@genu.org.au</a></li>
						</ul>
					</div>
					<div class="col-6 col-lg-3 mb-3 text-left text-lg-left">
						<h6 class="text-white">Quick Links</h6>
						<ul class="d-block list-unstyled">
							<li>
								<a class="text-white" href="<?= home_url(); ?>/about-us/">About Us</a>
							</li>
							<li>
								<a class="text-white" href="<?= home_url(); ?>/news/">News</a>
							</li>
							<li>
								<a class="text-white" href="<?= home_url(); ?>/contact/feedback/">Feedback</a>
							</li>
							<li>
								<a class="text-white" href="<?= home_url(); ?>/contact/faqs/">FAQs</a>
							</li>
							<li>
								<a class="text-white" href="<?= home_url(); ?>/about-us/current-vacancies/">Employment</a>
							</li>
						</ul>
					</div>
					<div class="col-6 col-lg-3 mb-3 text-left text-lg-left">
						<h6 class="text-white">Social Media</h6>
						<div class="d-block mb-2 social-links">
							<?php if (get_field( 'facebook_link', 'options' )) : ?>
							<a class="btn btn-white btn-sm font-weight-normal mb-2 mb-sm-0" href="<?php the_field( 'facebook_link', 'options' ); ?>" target="_blank" rel="noopener noreferrer">
								<span class="fab fa-facebook-f"></span>
							</a>
							<?php endif; ?>
							<?php if (get_field( 'twitter_link', 'options' )) : ?>
							<a class="btn btn-white btn-sm font-weight-normal mb-2 mb-sm-0" href="<?php the_field( 'twitter_link', 'options' ); ?>" target="_blank" rel="noopener noreferrer">
								<span class="fab fa-twitter"></span>
							</a>
							<?php endif; ?>
							<?php if (get_field( 'youtube_link', 'options' )) : ?>
							<a class="btn btn-white btn-sm font-weight-normal mb-2 mb-sm-0" href="<?php the_field( 'youtube_link', 'options' ); ?>" target="_blank" rel="noopener noreferrer">
								<span class="fab fa-youtube"></span>
							</a>
							<?php endif; ?>
							<?php if (get_field( 'linkedin_link', 'options' )) : ?>
							<a class="btn btn-white btn-sm font-weight-normal mb-2 mb-sm-0" href="<?php the_field( 'linkedin_link', 'options' ); ?>" target="_blank" rel="noopener noreferrer">
								<span class="fab fa-linkedin-in"></span>
							</a>
							<?php endif; ?>
							<?php if (get_field( 'instagram_link', 'options' )) : ?>
							<a class="btn btn-white btn-sm font-weight-normal mb-2 mb-sm-0" href="<?php the_field( 'instagram_link', 'options' ); ?>" target="_blank" rel="noopener noreferrer">
								<span class="fab fa-instagram"></span>
							</a>
							<?php endif; ?>
						</div>
						<img class="footer-logo" src="<?= esc_url( get_bloginfo( 'template_directory' ) ); ?>/assets/images/GenU-Training-Rev.svg" alt="<?= esc_attr( bloginfo( 'name' ) ); ?> Logo">
					</div>
				</div>
				
			</div>
		</footer>
		<div id="copyright" class="bg-dark-blues py-4 text-white">

		<div class="border-footer-top"></div>
			<div class="container">
				<div class="row">
					<div class="col-12">
					<p class="footer-text">
					In the spirit of reconciliation, genU acknowledges the Traditional Custodians of Country throughout Australia. 
We recognise their continuing connection to land, sea and community and we pay our respects to elders past, present and emerging.
							</p>
						<?= esc_attr( date( 'Y' ) ); ?> genU Training. All rights reserved <span class="mx-1 mx-sm-2">|</span> <a href="/sitemap" class="text-white">Sitemap</a> <span class="mx-1 mx-sm-2">|</span> <a href="/privacy-policy" class="text-white">Privacy Policy</a>
					</div>
				</div>
			</div>
		</div>
		<?php wp_footer(); ?>
	</body>
</html>
