<?php 
$show_slider = get_field('show_slider');
?>
<section class="slider">
    <?php 
    if($show_slider) { ?>
        <div class="front-slider" id="front-slider">

            <?php if ( have_rows( 'homepage_slider' ) ) : //phpcs:ignore -- Inline post loop. ?>
                <?php while ( have_rows( 'homepage_slider' ) ) : the_row(); //phpcs:ignore -- Inline post loop. 
                $slider_mobile_image = get_sub_field('slider_mobile_image');
                
                $slider_button = get_sub_field('slide_link');
                $second_link = get_sub_field('second_link');

                if( $slider_button ):
                    $link_url = $slider_button['url'];
                    $link_title = $slider_button['title'];
                    $link_target = $slider_button['target'] ? $slider_button['target'] : '_self';
                    endif;

                    if($second_link ):
                        $link_url2 = $second_link['url'];
                        $link_title2 = $second_link['title'];
                        $link_target2 = $second_link['target'] ? $second_link['target'] : '_self';
                        endif;
                ?>
                
                <div class="item slick-slide">
                        <div class="campaign-banner-alt bg-inverted-darker">
                            <picture class="campaign-banner-alt__img">  
                            
                            <?php if($slider_mobile_image): ?>
                                <source media="(max-width: 767px)"
                                srcset="<?php echo esc_url($slider_mobile_image['url']);  ?>"> 
                                <?php endif;?>         

                            <img src="<?php the_sub_field('slide_image'); ?>">
                            </picture>
                                        
                                    <div class="container">
                                        <div class="row">
                                            <div class="max campaign-banner-alt__inner home_slider col-lg-6 col-md-6"> 
                                                    <div class="campaign-banner-text">    
                                                        <h1 class="mt-4 mb-4 text-white"><?php the_sub_field('slide_title'); ?></h1>
                                                        <span class="d-block mb-4"><?php the_sub_field('slide_description'); ?></span>  
                                                        
                                                        <?php if($slider_button):?>
                                                        <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" class="mt-2 py-3 btn-lg btn-secondary button-one"><?php echo esc_html($link_title); ?></a>  
                                                        <?php endif;?>   
                                                        
                                                        <?php if($second_link):?>
                                                        <a href="<?php echo esc_url($link_url2); ?>" target="<?php echo esc_attr($link_target2); ?>" class="mt-2 py-3 btn-secondary-optional"><?php echo esc_html($link_title2); ?>
                                                        </a>
                                                        <?php endif;?> 

                                                    </div>
                                            </div> 
                                        </div>
                                    </div>
                        </div>                
                </div>
                <?php endwhile; ?>
            <?php endif; ?>
    </div>
    <?php } 

      else{ 
        $link = get_field('header_button_one');
        $link2 = get_field('header_button_two');
        if( $link ):
        $link_url = $link['url'];
        $link_title = $link['title'];
        $link_target = $link['target'] ? $link['target'] : '_self';
        endif;

        if($link2 ):
        $link_url2 = $link2['url'];
        $link_title2 = $link2['title'];
        $link_target2 = $link2['target'] ? $link['target'] : '_self';
        endif;
        
        $image = get_field('header_image');
        $mobile_image = get_field('mobile_image');
        $size = 'full';
        ?>

        <div class="campaign-banner-alt bg-inverted-darker" id="banner-home">
           <picture class="campaign-banner-alt__img">          
                <?php if($mobile_image): ?>
                <source media="(max-width: 767px)"
                srcset="<?php echo esc_url($mobile_image['url']);  ?>"> 
                <?php endif;?>
                <?php  echo wp_get_attachment_image( $image, 'custom_header' );?>
            </picture>


                <div class="container">
                    <div class="row">
                        <div class="max campaign-banner-alt__inner col-lg-7 col-md-6"> 
                            <div class="campaign-banner-text">    
                                <h1 class="mt-4 mb-4 text-white"><?php the_field('header_title'); ?></h1>
                                <span class="d-block mb-4"><?php the_field('header_description'); ?></span>            
                                <?php if($link):?>
                                <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" class="mt-2 py-3  btn-lg btn-secondary button-one"><?php echo esc_html($link_title); ?></a>  
                                <?php endif;?>
                                <?php if($link2):?>
                                <a href="<?php echo esc_url($link_url2); ?>" target="<?php echo esc_attr($link_target2); ?>" class="mt-2 py-3 btn-secondary-optional"><?php echo esc_html($link_title2); ?>
                                </a>
                                <?php endif;?>          
                            </div>
                        </div> 
                    </div>
                </div><!-- container-->
        </div>


<?php }?>
    
</section>

<style>
.front-slider .slick-slide img{
    height: 600px;
}

    </style>