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
add_action( 'template_redirect', 'jd_block_author_scan' );

/**
 * Hide the REST API user list from logged-out visitors.
 * /wp-json/wp/v2/users leaks usernames by default.
 */
function jd_restrict_user_endpoint( $result ) {
	if ( ! empty( $result ) ) {
		return $result;
	}
	if ( ! is_user_logged_in() ) {
		$route = isset( $GLOBALS['wp']->query_vars['rest_route'] ) ? $GLOBALS['wp']->query_vars['rest_route'] : '';
		if ( false !== strpos( $route, '/wp/v2/users' ) ) {
			return new WP_Error( 'rest_forbidden', __( 'Not available.', 'jarral-digital' ), array( 'status' => 401 ) );
		}
	}
	return $result;
}
add_filter( 'rest_authentication_errors', 'jd_restrict_user_endpoint' );

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
