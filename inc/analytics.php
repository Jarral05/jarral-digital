<?php
/** Optional Cloudflare Web Analytics. No script or connection hints by default. */
defined( 'ABSPATH' ) || exit;

function jd_sanitize_analytics_token( $value ) {
	$value = is_string( $value ) ? strtolower( trim( $value ) ) : '';
	return preg_match( '/\A[a-f0-9]{32}\z/', $value ) ? $value : '';
}

function jd_validate_analytics_token( $validity, $value ) {
	if ( '' !== trim( (string) $value ) && '' === jd_sanitize_analytics_token( $value ) ) {
		$validity->add( 'invalid_token', __( 'Paste only the 32-character Cloudflare Web Analytics token, not the script tag.', 'jarral-digital' ) );
	}
	return $validity;
}
add_filter( 'customize_validate_jd_cloudflare_token', 'jd_validate_analytics_token', 10, 2 );

function jd_cloudflare_analytics() {
	$token = jd_sanitize_analytics_token( get_theme_mod( 'jd_cloudflare_token', '' ) );
	if ( ! $token || ! get_theme_mod( 'jd_analytics_policy_ready', false ) || is_admin() || is_user_logged_in() || is_customize_preview() || is_preview() || is_feed() || post_password_required() ) {
		return;
	}
	printf(
		'<script id="jd-cloudflare-analytics" defer src="https://static.cloudflareinsights.com/beacon.min.js" data-cf-beacon="%s"></script>' . "\n",
		esc_attr( wp_json_encode( array( 'token' => $token ) ) )
	);
}
add_action( 'wp_footer', 'jd_cloudflare_analytics', 30 );
