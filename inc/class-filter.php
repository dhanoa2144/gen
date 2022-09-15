<?php
/**
 * Events class
 *
 * @package WordPress
 * @subpackage _gc
 * @author Dan Walsh
 * @version 1.0.0
 */

namespace Grindstone\WordPress;

/**
 * Events class
 */
class Filter {

	/**
	 * Initialise status of the class.
	 *
	 * @var boolean $initialised
	 * @since 1.0.0
	 */
	protected static $initialised = false;

	public static $filters = array();

	public static $applied_filters = array();

	public static $url = '';

	public static $page = 1;

	public static $icons = array();

	public static $filter_separator = '!';

	/**
	 * Initialises the class. Runs automatically if the class is autoloaded or when the first public method is executed.
	 *
	 * @author Dan Waslh
	 * @since 1.0.0
	 * @link https://developer.wordpress.org/reference/functions/add_meta_box/
	 */
	public static function init() {
		if ( ! self::$initialised ) :
			self::$initialised = true;
		endif;

		// Add custom variables to the query filter.
		add_filter(
			'query_vars',
			function ( $qvars ) {
				$qvars[] = 'filter';
				$qvars[] = 'filter_page';
				$qvars[] = 'filter_search';
				return $qvars;
			},
			10
		);

		add_filter( 'pre_get_posts', 'Grindstone\WordPress\Filter::init_filters', 50 );

	}

	public static function init_filters( $args = array() ) {
		self::get_filters( $args );
	}

	public static function get_filters( $args = array() ) {
		global $wp;

		self::$url = home_url( $wp->request );

		self::$filters = $args;

		// Define the filter icons.
		if ( is_array( $args ) ) :
			foreach ( $args as $filter ) :
				self::$icons[ $filter ] = "<i class='gc-icon-$filter'></i>";
			endforeach;
		endif;

		// Get currently applied filters.
		$filter_string = ( get_query_var( 'filter', false ) );

		$qo = get_queried_object();

		if ( is_tax() && ! is_tax( 'program_type' ) ) :
			$current_term_index = implode( ':', array( $qo->taxonomy, $qo->term_id, htmlspecialchars_decode( $qo->name ) ) );

			if ( strpos( $filter_string, $current_term_index ) === false ) :
				$filter_string = implode( self::$filter_separator, array( $current_term_index, $filter_string ) );
			endif;
		endif;

		if ( $filter_string ) :
			$filters = array();

			foreach ( explode( self::$filter_separator, $filter_string ) as $filter ) :
				if ( $filter ) :
					$filters[] = self::sanitise_filter_item( $filter );
				endif;
			endforeach;

			self::$url             = add_query_arg( 'filter', join( self::$filter_separator, $filters ), self::$url );
			self::$applied_filters = $filters;
		endif;

		// Get current filter page.
		self::$page = get_query_var( 'filter_page', 1 );

		if ( self::$page > 1 ) :
			self::$url = add_query_arg( 'filter_page', $page, self::$url );
		endif;

		add_action(
			'pre_get_posts',
			function( $query ) {
				if ( ! is_admin() && $query->is_main_query() ) :
					$tax_query = self::get_tax_query();
					$query->set( 'tax_query', $tax_query );
				endif;
			},
			9999
		);
	}

	public static function encode_filter_item( $taxonomy, $term_id, $name ) {
		return implode( ':', array( $taxonomy, $term_id, rawurlencode( htmlspecialchars_decode( $name ) ) ) );
	}

	public static function decode_filter_item( $filter_item ) {
		$filter_item_parts = explode( ':', $filter_item );

		$taxonomy = $filter_item_parts[0];
		$term_id  = $filter_item_parts[1];
		$name     = rawurldecode( htmlspecialchars_decode( $filter_item_parts[2] ) );

		return array(
			'taxonomy' => $taxonomy,
			'term_id'  => $term_id,
			'name'     => $name,
		);
	}

	public static function sanitise_filter_item( $filter_item ) {
		$the_item = self::decode_filter_item( $filter_item );
		return self::encode_filter_item( $the_item['taxonomy'], $the_item['term_id'], $the_item['name'] );
	}

	public static function the_tax_icon( $taxonomy, $display = true, $attr = array() ) {
		$taxes = get_field( 'taxes', 'options' );
		if ( is_array( $taxes ) ) :
			foreach ( $taxes as $tax ) :
				if ( $taxonomy === $tax['tax'] ) :

					$default_attr = array(
						'class' => 'svg-icon',
					);

					$attr = wp_parse_args( $attr, $default_attr );

					$attributes = '';
					foreach ( $attr as $name => $value ) :
						$attributes .= " $name=" . '"' . $value . '"';
					endforeach;

					$result = sprintf(
						'<span %s>%s</span>',
						$attributes,
						file_get_contents( $tax['icon'] ) //phpcs:ignore -- Need to use file_get_contents() to pull SVG contents.
					);
					if ( $display ) :
						echo $result;
					else :
						return $result;
					endif;
				endif;
			endforeach;
		endif;
	}

	public static function the_filters() {
		global $post, $wp;

		$filters = self::$filters;

		// ---------------------------------------------------------------------
		// Turns out the industries filter is not always required, specifically
		// when the term page we are currently on is an industry itself. To create
		// a better interface, we allow for the industries filter to be hidden
		// when viewing a specific term.
		// ---------------------------------------------------------------------
		if(get_field('hide_industries_filter', get_queried_object()) === true){
			if (($key = array_search('industry', $filters)) !== false) {
			    unset($filters[$key]);
			}
		}

		foreach ($filters as $filter ) :

			$tax_counter = 0;
			foreach ( self::$applied_filters as $filter_string ) :
				if ( 0 === strpos( $filter_string, $filter ) ) :
					$tax_counter++;
				endif;
			endforeach;

			$the_taxonomy = get_taxonomy( $filter );

			$filter_label = $the_taxonomy->labels->singular_name;

			if ( $tax_counter > 0 ) :
				$filter_label = $filter_label . " <span class='gc-filter-counter'>$tax_counter</span>";
			endif;

			$filter_icon = self::the_tax_icon(
				$the_taxonomy->name,
				false,
				array( 'class' => 'svg-icon svg-icon-lg svg-icon-white mr-2 mr-md-3' )
			);
			?>

			<div class="gc-filter col-12 col-md-6 col-lg-3 px-md-2 px-lg-3">
				<a href="#" onClick="" class="gc-filter-header d-flex align-items-center">
					<div class="d-flex align-items-center"><?php echo $filter_icon; //phpcs:ignore -- Echoing pre-sanitised SVG. ?><?php echo wp_kses_post( $filter_label ); ?></div>
					<i class="fas fa-chevron-down"></i>
				</a>
				<div class="gc-filter-content">
					<ul class="gc-filter-menu" style="max-height: 0px">
						<?php
						foreach ( get_terms( $filter, array( 'hide_empty' => false ) ) as $term ) :

							$filter_term  = join( ':', array( $filter, $term->term_id, rawurlencode( htmlspecialchars_decode( $term->name ) ) ) );
							$filter_link  = self::get_link( $filter, $term->term_id, $term->name );
							$filter_class = ( in_array( $filter_term, self::$applied_filters, true ) ) ? 'gc-filter-selected' : '';

							echo sprintf(
								'<li><a class="%s" href="%s"><span class="far"></span>%s</a></li>',
								esc_attr( $filter_class ),
								esc_attr( $filter_link ),
								esc_attr( $term->name )
							);
						endforeach;
						?>
					</ul>
				</div>
			</div>

			<?php
		endforeach;
	}

	/**
	 * Displays a reset button if filters have been applied.
	 *
	 * @return void
	 */
	public static function the_reset_button() {
		if ( self::has_filters_applied() ) :
			global $wp;
			echo sprintf(
				'<a class="btn btn-secondary btn-small mb-2" href="%s">Reset Filter</a>',
				esc_attr( home_url( $wp->request ) )
			);
		endif;
	}

	public static function the_unfilters() {
		if ( self::$applied_filters ) :

			$total_filters = count( self::$applied_filters );

			echo '<ul class="gc-unfilter d-inline-block list-unstyled mb-0">';
			foreach ( self::$applied_filters as $filter ) :
				$current_filter = explode( self::$filter_separator, htmlspecialchars_decode( get_query_var( 'filter', '' ) ) );

				unset( $current_filter[ array_search( $filter, $current_filter, true ) ] );

				$new_filter = array_values( $current_filter );

				$filter_url = remove_query_arg( 'filter', self::$url );

				if ( count( $new_filter ) > 0 ) :
					$filter_url = add_query_arg( 'filter', join( self::$filter_separator, $new_filter ), $filter_url );
				endif;

				$tax_term = self::decode_filter_item( $filter );

				echo sprintf(
					'<li class="chip">%s%s<a data-value="%s" href="%s"><i class="far fa-times-circle"></i></a></li>',
					self::the_tax_icon( $tax_term['taxonomy'], false, array( 'class' => 'svg-icon svg-icon-white mr-2' ) ),
					wp_kses_post( $tax_term['name'] ),
					wp_kses_post( $tax_term['term_id'] ),
					esc_attr( $filter_url )
				);
			endforeach;
			echo '</ul>';
		endif;
	}

	public static function get_tax_query() {
		if ( self::$applied_filters ) :

			$temp_array = array();

			$sorted_filters = self::$applied_filters;
			sort( $sorted_filters );

			$current_tax      = '';
			$current_tax_list = array();

			foreach ( $sorted_filters as $filter ) :

				$filter_data = explode( ':', $filter );

				if ( $current_tax !== $filter_data[0] ) :
					// This is a new group of terms, add the current array to the post query and reset the current array.
					if ( count( $current_tax_list ) > 0 ) :
						array_push(
							$temp_array,
							array(
								'taxonomy' => $current_tax,
								'field'    => 'id',
								'terms'    => $current_tax_list,
								'operator' => 'IN',
							)
						);
						$current_tax_list = array();
					endif;
				endif;

				$current_tax        = $filter_data[0];
				$current_tax_list[] = $filter_data[1];

			endforeach;

			array_push(
				$temp_array,
				array(
					'taxonomy' => $current_tax,
					'field'    => 'id',
					'terms'    => $current_tax_list,
					'operator' => 'IN',
				)
			);

			return $temp_array;

		else :

			return array();

		endif;
	}

	public static function has_filters_applied() {
		if (count(self::$applied_filters) > 0) {
			return true;
		} else {
			return false;
		}
	}

	public static function generate_paged_link( $page ) {
		return add_query_arg( 'filter_page', $page, self::$url );
	}

	public static function generate_link( $tax_slug, $term_id, $label, $base_url ) {
		$new_filter_term = join( ':', [ $tax_slug, $term_id, rawurlencode( htmlspecialchars_decode( $label ) ) ] );

		$current_filter = self::$applied_filters ?: array(); // phpcs:ignore -- Short ternary.

		if ( in_array( $new_filter_term, $current_filter, true ) ) :
			// Already filtering for this term, generate link to unfilter the term.
			unset( $current_filter[ array_search( $new_filter_term, $current_filter, true ) ] );
			$current_filter = array_values( $current_filter );
		else :
			// Term is not yet being filtered for, add it to the filter.
			$current_filter[] = $new_filter_term;
		endif;

		return add_query_arg( 'filter', join( self::$filter_separator, $current_filter ), $base_url ) . '#filters';
	}

	public static function get_link( $tax_slug, $term_id, $label, $base_url = '' ) {
		if ( '' === $base_url) :
			if ( '' === self::$url ) :
				global $wp;
				self::$url = home_url( $wp->request );
				$base_url  = self::$url;
			else :
				$base_url = self::$url;
			endif;
		endif;

		// $base_url = ( '' === $base_url ) ? self::$url : $base_url;
		return self::generate_link( $tax_slug, $term_id, $label, $base_url );
	}

	public static function the_link( $tax_slug, $term_id, $label, $base_url = '' ) {
		$base_url = ( '' === $base_url ) ? self::$url : $base_url;
		echo wp_kses_post( self::generate_link( $tax_slug, $term_id, $label, $base_url ) );
	}

	public static function the_no_results_message() {
		global $wp;
		echo wp_kses_post(
			'<h2>No results</h2>
			<p>No results were found with the selected filters. <a href="' . esc_attr( home_url( $wp->request ) ) . '">Reset your filter</a> to start searching again.</p>'
		);
	}

	/**
	 * Generates and echoes post pagination HTML.
	 *
	 * @param int $pages Total number of pages returned by WP_Query.
	 * @param int $range The maximum number of pages appearing to the left and right of the current page.
	 */
	public static function the_pagination( $pages = false, $range = 3 ) {

		global $paged, $wp_query;

		$current_page = ( $paged ) ? intval( $paged ) : 1;
		$showitems    = ( $range * 2 ) + 1;

		if ( ! $pages ) {
			$pages = $wp_query->max_num_pages;
			if ( ! $pages ) {
				$pages = 1;
			}
		}

		if ( 1 !== $pages ) {

			$the_jumpto_link = function( $page_num, $link_desc, $link_label ) {
				echo sprintf(
					'<a href="%s" class="jump-to" aria-label="Go to %s page, Page %s">%s</a>',
					esc_url( self::generate_paged_link( $page_num ) ),
					esc_attr( $link_desc ),
					esc_attr( $page_num ),
					esc_html( $link_label )
				);
			};

			echo '<nav class="gc-filter-pagination" role="navigation" aria-label="Pagination Navigation">';

			if ( $current_page > 2 && $current_page > $range + 1 && $showitems < $pages ) {
				$the_jumpto_link( 1, 'first', '&laquo;' );
			}

			if ( $current_page > 1 && $showitems < $pages ) {
				$the_jumpto_link( $current_page - 1, 'previous', '&lsaquo;' );
			}

			for ( $i = 1; $i <= $pages; $i++ ) {

				if ( 1 !== $pages && ( ! ( $i >= $current_page + $range + 1 || $i <= $current_page - $range - 1 ) || $pages <= $showitems ) ) {

					if ( $current_page === $i ) {
						echo sprintf(
							'<span class="current" aria-label="Current page, Page %s" aria-current="true">%s</span>',
							esc_attr( $i ),
							esc_attr( $i )
						);
					} else {
						echo sprintf(
							'<a href="%s" class="inactive" aria-label="Go to page, Page %s">%s</a>',
							esc_url( self::generate_paged_link( $i ) ),
							esc_attr( $i ),
							esc_attr( $i )
						);
					}
				}
			}

			if ( $current_page < $pages && $showitems < $pages ) {
				$the_jumpto_link( $current_page + 1, 'next', '&rsaquo;' );
			}

			if ( $current_page < $pages - 1 && $current_page + $range - 1 < $pages && $showitems < $pages ) {
				$the_jumpto_link( $pages, 'last', '&raquo;' );
			}

			echo '</nav>';
		}
	}


	/**
	 * Returns a linked list of taxonomy terms, linking to a filtered archive page.
	 *
	 * @param string $tax_slug The slug of the taxonomy being queried.
	 * @param string $base_url The URL of the archive page. For example: home_url( 'news' ).
	 */
	public static function get_the_taxonomy_links( $tax_slug, $base_url = false ) {
		if ( ! $base_url ) {
			$base_url = self::$url;
		}

		global $post;

		$tax_terms = get_the_terms( $post->ID, $tax_slug );

		if ( $tax_terms ) {

			$links_list = array();

			foreach ( $tax_terms as $tax_term ) {
				$links_list[] = sprintf(
					'<a href="%s">%s</a>',
					esc_url( self::generate_link( $tax_slug, $tax_term->term_id, $tax_term->name, $base_url ) ),
					$tax_term->name
				);
			}

			return '<span>' . join( ', ', $links_list ) . '</span>';

		} else {

			return false;

		}
	}


	/**
	 * Echoes the ouput of the get_the_taxonomy_links function, which returns a linked list of taxonomy terms.
	 *
	 * @param string $tax_slug The slug of the taxonomy being queried.
	 * @param string $base_url The URL of the archive page. For example: home_url( 'news' ).
	 */
	public static function the_taxonomy_links( $tax_slug, $base_url = false ) {
		if ( ! $base_url ) {
			$base_url = self::$url;
		}
		echo wp_kses_post( self::get_the_taxonomy_links( $tax_slug, $base_url ) );
	}

	/**
	 * Generates the HTML to display the search form for arhive pages.
	 */
	public static function the_search_form() {
		global $wp;
		$post_type_label = ( is_home() ) ? 'news' : strtolower( get_queried_object()->label );
		?>
		<h4>Search <?php echo wp_kses_post( $post_type_label ); ?></h4>
		<form action="<?php echo esc_url( home_url( $wp->request ) ); ?>" method="get" class="filter-search">
			<input type="search" name="filter_search" id="filter_search" placeholder="Enter keyword" value="<?php echo esc_attr( get_query_var( 'filter_search', '' ) ); ?>">
			<button type="submit" class="btn-search"><i class="fa fa-search"></i></button>
		</form>
		<?php
		if ( get_query_var( 'filter_search', false ) ) {
			echo sprintf(
				'<a class="btn btn-secondary btn-small" href="%s">Reset Search</a>',
				esc_attr( home_url( $wp->request ) )
			);
		}
	}

	/**
	 * Constructor, set to private to prevent object instantiation.
	 */
	private function __construct() {
		// Do nothing.
	}

}
