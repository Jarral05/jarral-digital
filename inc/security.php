<?php
/**
 * Hardening.
 *
 * None of this makes the site unbreakable. What it does is remove the easy
 * wins that automated scanners look for, so an attacker has to actually work.
 * That alone filters out the overwhelming majority of attempts.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

/**
 * Stop announcing which WordPress version you run.
 * Scanners use it to pick a matching exploit.
 */
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );

/**
 * Remove the version string from CSS and JS URLs too,
 * otherwise the version leaks anyway through ?ver=6.x.
 */
function jd_strip_version( $src ) {
	if ( $src && strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) !== false ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'style_loader_src', 'jd_strip_version', 9999 );
add_filter( 'script_loader_src', 'jd_strip_version', 9999 );

/**
 * Remove head links nobody needs and attackers enumerate.
 */
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );

/**
 * Disable XML-RPC.
 * It is a legacy remote-posting interface. You do not use it, and it is
 * the single most common brute-force entry point on WordPress sites.
 */
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter(
	'wp_headers',
	function ( $headers ) {
		unset( $headers['X-Pingback'] );
		return $headers;
	}
);

/**
 * xmlrpc_enabled only switches off the methods that need a login. Pingbacks
 * stay open without one and let anyone make this server request other URLs,
 * which is used to attack third-party sites.
 */
function jd_remove_pingback_methods( $methods ) {
	unset( $methods['pingback.ping'], $methods['pingback.extensions.getPingbacks'] );
	return $methods;
}
add_filter( 'xmlrpc_methods', 'jd_remove_pingback_methods' );

/**
 * Block author enumeration (/?author=1 reveals your admin username).
 * An attacker who knows the username only needs the password.
 */
function jd_block_author_scan() {
	if ( is_admin() ) {
		return;
	}
	if ( isset( $_SERVER['QUERY_STRING'] ) && preg_match( '/author=([0-9]*)/i', sanitize_text_field( wp_unslash( $_SERVER['QUERY_STRING'] ) ) ) ) {
		wp_safe_redirect( home_url(), 301 );
		exit;
	}
}
// Priority 1: core's redirect_canonical() runs at 10 and would first turn
// ?author=2 into /author/<username>/, leaking the name anyway.
add_action( 'template_redirect', 'jd_block_author_scan', 1 );

/**
 * The owner's author archive has their login name in its URL
 * (/author/<username>/), and WordPress links to it from oEmbed data and
 * schema. Point those links at the About page and send the old address
 * there too. Guest authors keep their own archive.
 */
function jd_owner_author_link( $link, $author_id ) {
	$owner = (int) get_theme_mod( 'jd_author_user', 0 );
	return $owner && (int) $author_id === $owner ? home_url( '/about/' ) : $link;
}
add_filter( 'author_link', 'jd_owner_author_link', 10, 2 );

function jd_owner_author_archive() {
	$owner = (int) get_theme_mod( 'jd_author_user', 0 );
	if ( $owner && is_author() && (int) get_queried_object_id() === $owner ) {
		wp_safe_redirect( home_url( '/about/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'jd_owner_author_archive', 1 );

/**
 * Hide the REST API user list from logged-out visitors.
 * /wp-json/wp/v2/users leaks usernames by default.
 *
 * The routes are removed rather than matched by URL: WordPress matches
 * routes case-insensitively, so a string check on the URL was bypassed by
 * /wp-json/wp/v2/Users. Signed-in users (the block editor) keep them.
 */
function jd_hide_user_endpoints( $endpoints ) {
	if ( is_user_logged_in() ) {
		return $endpoints;
	}
	foreach ( array_keys( $endpoints ) as $route ) {
		if ( 0 === stripos( $route, '/wp/v2/users' ) ) {
			unset( $endpoints[ $route ] );
		}
	}
	return $endpoints;
}
add_filter( 'rest_endpoints', 'jd_hide_user_endpoints' );

/**
 * Generic login error text.
 * By default WordPress says "unknown username" vs "incorrect password",
 * which tells an attacker when they have guessed a real username.
 */
add_filter(
	'login_errors',
	function () {
		return __( 'Those details are not correct.', 'jarral-digital' );
	}
);

/**
 * Security headers.
 *
 * Note: no Content-Security-Policy here. A wrong CSP silently breaks your
 * admin screens and is hard to debug. Add one later, in report-only mode
 * first, once the site is finished.
 */
function jd_security_headers( $headers ) {
	$headers['X-Content-Type-Options'] = 'nosniff';
	$headers['X-Frame-Options']        = 'SAMEORIGIN';
	$headers['Referrer-Policy']        = 'strict-origin-when-cross-origin';
	$headers['Permissions-Policy']     = 'geolocation=(), microphone=(), camera=(), interest-cohort=()';
	// Browsers remember to use HTTPS for a year, so a first visit typed as
	// http:// cannot be intercepted before the redirect. No includeSubDomains:
	// other subdomains (mail, future tools) are not ours to commit.
	if ( is_ssl() ) {
		$headers['Strict-Transport-Security'] = 'max-age=31536000';
	}
	return $headers;
}
add_filter( 'wp_headers', 'jd_security_headers' );

/**
 * Strip oEmbed discovery and emoji scripts.
 * Fewer requests, fewer things to go wrong.
 */
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
