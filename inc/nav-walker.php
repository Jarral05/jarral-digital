<?php
/**
 * Mega menu walker.
 *
 * WHAT THIS DOES, AND WHY IT IS BUILT THIS WAY
 *
 * You edit the menu in Appearance > Menus like any WordPress site: drag a page
 * under "Services" and it becomes a child. The theme reads that structure and
 * renders the children as a rich panel - icon, name, description and price -
 * instead of a plain dropdown list.
 *
 * So the editing IS visual. WordPress's menu screen is the editor; this file
 * is only the renderer. You never touch code to change the navigation.
 *
 * The icon, description and price are not stored in the menu. They are looked
 * up from jd_get_services() by matching the menu item's URL, so there is one
 * source of truth: change a price in inc/template-tags.php and it changes in
 * the menu, on the homepage and in the footer at the same time.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

/*
 * Guarded because extending a class that is not loaded is a fatal error, and
 * a fatal error on a live site is a white screen. WordPress loads
 * Walker_Nav_Menu before a theme's functions.php in every normal request, so
 * this guard should never fire - but if it ever does, header.php falls back
 * to the default menu renderer and the site stays up.
 */
if ( class_exists( 'Walker_Nav_Menu' ) ) :

/**
 * Renders a top-level menu item with children as a mega panel.
 */
class JD_Mega_Walker extends Walker_Nav_Menu {

	/**
	 * Service data keyed by URL path, built once per request.
	 *
	 * @var array<string,array>|null
	 */
	private $lookup = null;

	/**
	 * The top-level item whose panel is being rendered, if it links anywhere.
	 *
	 * @var array{url:string,title:string}|null
	 */
	private $parent_link = null;

	/**
	 * Build the path => service map.
	 *
	 * @return array<string,array>
	 */
	private function services() {
		if ( null !== $this->lookup ) {
			return $this->lookup;
		}

		$this->lookup = array();

		if ( function_exists( 'jd_get_services' ) ) {
			foreach ( jd_get_services() as $service ) {
				$path = trim( (string) wp_parse_url( $service['url'], PHP_URL_PATH ), '/' );
				$this->lookup[ $path ] = $service;
			}
		}

		return $this->lookup;
	}

	/**
	 * Find the service record matching a menu item's URL, if any.
	 *
	 * @param string $url Menu item URL.
	 * @return array|null
	 */
	private function match( $url ) {
		$path = trim( (string) wp_parse_url( $url, PHP_URL_PATH ), '/' );
		$map  = $this->services();
		return isset( $map[ $path ] ) ? $map[ $path ] : null;
	}

	/**
	 * Open a submenu level.
	 *
	 * @param string   $output Menu HTML, by reference.
	 * @param int      $depth  Current depth.
	 * @param stdClass $args   Menu args.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		if ( 0 === $depth ) {
			$output .= '<div class="jd-mega" hidden><div class="jd-mega-inner"><ul class="jd-mega-grid">';
		} else {
			$output .= '<ul class="sub-menu">';
		}
	}

	/**
	 * Close a submenu level.
	 *
	 * @param string   $output Menu HTML, by reference.
	 * @param int      $depth  Current depth.
	 * @param stdClass $args   Menu args.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		if ( 0 === $depth ) {
			$output .= '</ul>';

			// The top-level item is a button that opens this panel, so the
			// page it points at (e.g. /services/) needs its own link in here.
			if ( $this->parent_link ) {
				$output .= sprintf(
					'<a class="jd-mega-all" href="%s">%s<span aria-hidden="true"> &rarr;</span></a>',
					esc_url( $this->parent_link['url'] ),
					/* translators: %s: top-level menu item in lowercase, e.g. "services" */
					esc_html( sprintf( __( 'All %s', 'jarral-digital' ), $this->parent_link['title'] ) )
				);
			}

			$output .= '</div></div>';
		} else {
			$output .= '</ul>';
		}
	}

	/**
	 * Render one menu item.
	 *
	 * @param string   $output Menu HTML, by reference.
	 * @param WP_Post  $item   Menu item.
	 * @param int      $depth  Current depth.
	 * @param stdClass $args   Menu args.
	 * @param int      $id     Menu ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {

		$has_children = in_array( 'menu-item-has-children', (array) $item->classes, true );
		$title        = apply_filters( 'the_title', $item->title, $item->ID );
		$url          = $item->url ? $item->url : '#';

		// --- top level -----------------------------------------------------
		if ( 0 === $depth ) {

			$classes = 'jd-top' . ( $has_children ? ' jd-has-mega' : '' );
			$output .= '<li class="' . esc_attr( $classes ) . '">';

			if ( $has_children ) {
				// Remembered for end_lvl(). A "#" placeholder links nowhere.
				$lower             = function_exists( 'mb_strtolower' ) ? mb_strtolower( $title ) : strtolower( $title );
				$this->parent_link = ( '#' !== $url ) ? array( 'url' => $url, 'title' => $lower ) : null;

				/*
				 * A real <button> rather than a styled link. The panel is a
				 * disclosure, and a button is what screen readers and keyboards
				 * already understand. aria-expanded is kept in sync by main.js.
				 */
				$output .= sprintf(
					'<button type="button" class="jd-top-link jd-mega-toggle" aria-expanded="false" aria-haspopup="true">%s<span class="jd-caret" aria-hidden="true"></span></button>',
					esc_html( $title )
				);
			} else {
				$output .= sprintf(
					'<a class="jd-top-link" href="%s">%s</a>',
					esc_url( $url ),
					esc_html( $title )
				);
			}
			return;
		}

		// --- inside the mega panel ------------------------------------------
		$service = $this->match( $url );

		$output .= '<li class="jd-mega-item">';
		$output .= '<a class="jd-mega-link" href="' . esc_url( $url ) . '">';

		if ( $service && function_exists( 'jd_icon' ) ) {
			$output .= '<span class="jd-mega-ico">';
			ob_start();
			jd_icon( 'icon-' . $service['icon'] );
			$output .= ob_get_clean();
			$output .= '</span>';
		}

		$output .= '<span class="jd-mega-text">';
		$output .= '<span class="jd-mega-name">' . esc_html( $title ) . '</span>';

		if ( $service ) {
			$output .= '<span class="jd-mega-desc">' . esc_html( $service['desc'] ) . '</span>';
			$output .= '<span class="jd-mega-price">' . esc_html( $service['price'] ) . '</span>';
		}

		$output .= '</span></a>';
	}

	/**
	 * Close a menu item.
	 *
	 * @param string   $output Menu HTML, by reference.
	 * @param WP_Post  $item   Menu item.
	 * @param int      $depth  Current depth.
	 * @param stdClass $args   Menu args.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= '</li>';
	}
}

endif;
