<?php
/**
 * The enquiry form band at the foot of a service page, printed by the Jarral
 * Forms plugin exactly as its [jarral_contact_form] shortcode would.
 *
 * Args: h, p, and service, the name every enquiry from the page is tagged
 * with ('' on the Services page).
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'jdf_form_shortcode' ) ) {
	return;
}

// The editor analyzer needs the visible copy, not a live form or fresh nonces.
if ( ! empty( $args['analysis'] ) ) {
	echo '<h2>' . esc_html( $args['h'] ) . '</h2><p>' . esc_html( $args['p'] ) . '</p>';
	return;
}

// The shortcode's own handler, called directly rather than through
// do_shortcode(), so no heading or intro text has to survive being written
// into a shortcode string and parsed back out.
echo jdf_form_shortcode( // phpcs:ignore WordPress.Security.EscapeOutput -- the plugin escapes its own output.
	array(
		'heading' => $args['h'],
		'intro'   => $args['p'],
		'service' => $args['service'],
		'style'   => 'dark',
	)
);
