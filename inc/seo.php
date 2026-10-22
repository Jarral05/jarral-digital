<?php
/**
 * Structured data.
 *
 * Rank Math handles titles, descriptions, canonicals, Open Graph and the
 * sitemap. Do not rebuild those. What Rank Math does NOT do well is describe
 * a one-person service business, so that part lives here.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

/**
 * ProfessionalService schema on the homepage.
 *
 * This is what tells Google you are a real business, what you sell, and
 * where you sell it. On a new domain with no authority, being machine-readable
 * is one of the few levers you actually control.
 */
function jd_business_schema() {

	if ( ! is_front_page() ) {
		return;
	}

	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'ProfessionalService',
		'@id'         => home_url( '/#business' ),
		'name'        => get_bloginfo( 'name' ),
		'url'         => home_url( '/' ),
		'description' => get_bloginfo( 'description' ),
		'founder'     => array(
			'@type' => 'Person',
			'name'  => 'Mohsin Jarral',
		),
		'address'     => array(
			'@type'          => 'PostalAddress',
			'addressCountry' => 'PK',
		),
		// Where your clients are, not where you sit.
		'areaServed'  => array(
			array( '@type' => 'Country', 'name' => 'United States' ),
			array( '@type' => 'Country', 'name' => 'United Kingdom' ),
			array( '@type' => 'Place',   'name' => 'European Union' ),
			array( '@type' => 'Place',   'name' => 'Middle East' ),
		),
		'knowsLanguage' => array( 'en', 'ur' ),
		'hasOfferCatalog' => array(
			'@type'           => 'OfferCatalog',
			'name'            => 'Services',
			'itemListElement' => array(),
		),
	);

	$services = array(
		'WordPress development',
		'Headless WordPress and web applications',
		'Forms, PDFs and document automation',
		'Membership sites and client portals',
		'AI agents and automation',
		'Website care plans',
	);

	foreach ( $services as $service ) {
		$schema['hasOfferCatalog']['itemListElement'][] = array(
			'@type'       => 'Offer',
			'itemOffered' => array(
				'@type' => 'Service',
				'name'  => $service,
			),
		);
	}

	echo '<script type="application/ld+json">' .
		wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) .
		'</script>' . "\n";
}
add_action( 'wp_head', 'jd_business_schema', 20 );

/**
 * FAQPage schema, built from the same array the homepage renders.
 * One source of truth means the page and the schema can never disagree,
 * which is exactly the mismatch Google penalises.
 */
function jd_faq_schema() {

	if ( ! is_front_page() || ! function_exists( 'jd_get_faqs' ) ) {
		return;
	}

	$items = array();
	foreach ( jd_get_faqs() as $faq ) {
		$items[] = array(
			'@type'          => 'Question',
			'name'           => $faq['q'],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $faq['a'],
			),
		);
	}

	if ( empty( $items ) ) {
		return;
	}

	echo '<script type="application/ld+json">' . wp_json_encode(
		array(
			'@context'   => 'https://schema.org',
			'@type'      => 'FAQPage',
			'mainEntity' => $items,
		),
		JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
	) . '</script>' . "\n";
}
add_action( 'wp_head', 'jd_faq_schema', 21 );
