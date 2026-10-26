<?php
/**
 * Indexing rules that Rank Math's settings cannot express.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

/**
 * True on the Blog page or the /work/ archive while it lists nothing.
 *
 * An empty listing is thin content for a new site. Both pages start counting
 * the moment the first post or project is published, with no setting to
 * change: the check reads the page's own query on every request.
 *
 * @return bool
 */
function jd_is_empty_listing() {
	$listing = ( is_home() && ! is_front_page() ) || is_post_type_archive( 'jd_project' );
	return $listing && 0 === (int) $GLOBALS['wp_query']->found_posts;
}

/**
 * Rank Math prints the robots tag and removes core's wp_robots filters, so
 * this is the one that takes effect on the live site. Links stay followed.
 *
 * @param array $robots Rank Math directives, e.g. array( 'index' => 'index' ).
 * @return array
 */
function jd_noindex_empty_listing( $robots ) {
	if ( jd_is_empty_listing() ) {
		$robots['index'] = 'noindex';
	}
	return $robots;
}
add_filter( 'rank_math/frontend/robots', 'jd_noindex_empty_listing' );

/**
 * The same rule for core's robots tag, used only when Rank Math is inactive.
 *
 * @param array $robots Core directives, e.g. array( 'max-image-preview' => 'large' ).
 * @return array
 */
function jd_core_noindex_empty_listing( $robots ) {
	if ( jd_is_empty_listing() ) {
		$robots['noindex'] = true;
	}
	return $robots;
}
add_filter( 'wp_robots', 'jd_core_noindex_empty_listing' );
