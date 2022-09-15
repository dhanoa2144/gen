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

<main id="content" class="py-5 index">
	<div class="container">
		<div class="row mb-3">
			<div class="col">
				<?php the_content(); ?>
			</div><!-- .col -->
		</div><!-- .row -->

		<div class="row mb-5">
			<div class="col">
				<?php require locate_template( '/template-parts/pagination.php', false, false ); ?>
			</div><!-- .col -->
		</div><!-- .row -->

		<div class="row">
			<div class="col">
				<?php echo '<strong> Share :</strong>' . do_shortcode( '[addtoany]' ); ?>
			</div><!-- .col -->
		</div><!-- .row -->

	</div><!-- .container -->
</main>
<?php
get_footer();
