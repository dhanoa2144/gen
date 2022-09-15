<?php
/**
 * Pagination template part.
 *
 * Injects the required classes to properly render accessible pagination buttons akin to the theme. Uses Bootstrap 4 and Fontawesome.
 *
 * @package WordPress
 */

$paginate_classes_base = ' btn btn-sm border rounded-0 py-3 px-4 mx-0 ';

// When pulling in the pagination links, add screen reader text to make them accessible.
$paginate_links = paginate_links(
	array(
		'prev_text'          => '<span class="fa fa-arrow-left mr-2"></span> Prev',
		'next_text'          => 'Next <span class="fa fa-arrow-right ml-2"></span>',
		'before_page_number' => '<span class="sr-only">Go to Page </span>',
		'type'               => 'array',
	)
);
?>

<?php if ( $paginate_links ) : ?>
	<div id="pagination" class="d-flex justify-content-start">
		<?php
		foreach ( $paginate_links as $paginate_link ) :
			$paginate_classes = $paginate_classes_base;

			if ( false !== strpos( $paginate_link, 'aria-current="page"' ) ) :
				$paginate_classes .= ' btn-primary active ';
			else :
				$paginate_classes .= ' btn-white ';
			endif;

			$string_position = strpos( $paginate_link, 'page-numbers' );
			$paginate_link   = substr( $paginate_link, 0, $string_position ) . $paginate_classes . substr( $paginate_link, $string_position );
			echo wp_kses_post( $paginate_link );
		endforeach;
		?>
	</div>
<?php endif; ?>
