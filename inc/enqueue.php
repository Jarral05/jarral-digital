<?php
/**
 * Styles and scripts.
 *
 * Fonts are SELF-HOSTED, not loaded from Google's CDN. Loading fonts from
 * Google sends your EU visitors' IP addresses to Google, which a German court
 * ruled a GDPR violation in 2022. Since you are selling to EU clients, this
 * matters commercially as well as legally.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

/**
 * Load front-end assets.
 */
function jd_assets() {

	// Main stylesheet. filemtime() busts the cache automatically whenever
	// you edit the file, so you never see a stale version while building.
	$css = JD_DIR . '/assets/css/main.css';
	wp_enqueue_style(
		'jd-main',
		JD_URI . '/assets/css/main.css',
		array(),
		file_exists( $css ) ? filemtime( $css ) : JD_VERSION
	);

	// Front-end JavaScript. Loaded in the footer, deferred.
	$js = JD_DIR . '/assets/js/main.js';
	wp_enqueue_script(
		'jd-main',
		JD_URI . '/assets/js/main.js',
		array(),
		file_exists( $js ) ? filemtime( $js ) : JD_VERSION,
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'jd_assets' );

/**
 * Preload the two font files that appear above the fold.
 * Without this the headline renders in a fallback font and then jumps.
 */
function jd_preload_fonts() {
	$fonts = array(
		'/assets/fonts/space-grotesk-600.woff2',
		'/assets/fonts/ibm-plex-sans-400.woff2',
	);
	foreach ( $fonts as $font ) {
		if ( file_exists( JD_DIR . $font ) ) {
			printf(
				'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
				esc_url( JD_URI . $font )
			);
		}
	}
}
add_action( 'wp_head', 'jd_preload_fonts', 1 );

/**
 * Remove the block library CSS on the homepage.
 * The homepage uses no blocks, so this is roughly 30KB of dead weight.
 */
function jd_trim_block_css() {
	if ( is_front_page() ) {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'global-styles' );
		wp_dequeue_style( 'classic-theme-styles' );
	}
}
add_action( 'wp_enqueue_scripts', 'jd_trim_block_css', 100 );
