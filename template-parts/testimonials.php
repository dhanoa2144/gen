<?php if (get_field( 'testimonial', 'options' )) : ?>
	<section class="genu-train">
			
			<div class="choose"><!--choose-->
				<picture class="image">		
					<?php if (get_field( 'genu_training_mobile_image', 'options' )) : 
						$genu_training_mobile_image = get_field( 'genu_training_mobile_image', 'options' );?>
					
					<source media="(max-width: 767px)"
					srcset="<?php echo $genu_training_mobile_image['url'];?>">
					<?php endif;?>	

					<?php if (get_field( 'genu_training_image', 'options' )) : 
						$genu_training_image = get_field( 'genu_training_image', 'options' );?>
						<img src="<?php echo $genu_training_image['url'];?>">
					<?php endif;?>	
				</picture>

				<div class="container">

				<div class="row">

					<div class="choose-info col-lg-7 col-md-6">
							<div class="choose-text">
								<?php if (get_field( 'genu_heading', 'options' )) : ?>
									<h2><?php echo get_field('genu_heading', 'options'); ?></h2>
									<?php endif; ?>
									<?php if (get_field( 'genu_training_info', 'options' )) : ?>
								<p><?php echo get_field('genu_training_info', 'options'); ?></p>
								<?php endif; ?>
								<?php if (get_field( 'training_button', 'options' )) : 
									$link = get_field('training_button', 'options');
									$link_url = $link['url'];
									$link_title = $link['title'];
									?>
									
								<a class="btn btn-secondary py-3 train-button" href="<?php echo $link_url;?>"><?php echo esc_html($link_title); ?></a>
								<?php endif; ?>	
							</div>
					</div><!-- chooseinfo-->
				</div>
				</div>		
			</div><!-- choose-->
		
</section>

	<section class="testimonials bg-white py-5">
		<div class="container people mx-md-100">
			<div class="headings row mt-4">
            <?php if (get_field( 'testimonial_heading', 'options' )) : ?>
                <h4 class="col-12 text-primary font-weight-light"><?php //echo get_field('testimonial_heading', 'options'); ?></h4>
            <?php endif; ?>
            <?php if (get_field( 'testimonial_sub_heading', 'options' )) : ?>
                <h2 class="col-12 mb-4 text-primary"><?php echo get_field('testimonial_sub_heading', 'options'); ?></h2>
            <?php endif; ?>
			</div>
			<div class="row mb-4">
			<?php $testimonial_count = 0; ?>
			<?php foreach ( get_field( 'testimonial', 'options' ) as $testimonial ) : ?>
                <?php $testimonial_count = ($testimonial['enable']) ? $testimonial_count + 1 : $testimonial_count; ?>
				<?php if($testimonial['enable'] && $testimonial_count <= 3) : ?>
				<div class="testimonial-card col-12 col-md-4 mb-3 mb-md-0">
					<div class="card no-hover shadow-lg">
						<div class="card-body">
							<div class="profile-image mb-3">
								<!-- <img class="d-block w-100 h-100" style="z-index: 1;"
									src="<?php //echo get_template_directory_uri() ?>/assets/images/test.jpg" /> -->
								<img class="d-block w-100 h-100" style="z-index: 1;"
									src="<?php echo $testimonial['image']['url'] ?>" />
							</div>
							<div class="profile-content">
								<h5 class="text-primary"><?php echo $testimonial['name'] ?></h5>
								<p class="font-weight-medium"><?php echo $testimonial['position'] ?></p>
								<p class="mb-0"><?php echo $testimonial['comment'] ?></p>
							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>
			<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>