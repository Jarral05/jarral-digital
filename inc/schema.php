<?php
/**
 * Extend Rank Math's graph; metadata and sitemaps stay with the plugin.
 * @package JarralDigital
 */
defined( 'ABSPATH' ) || exit;

function jd_profile_links() {
	return array( 'https://www.linkedin.com/in/mohsin-zubair-b83998151/' );
}

function jd_schema_markets() {
	return array(
		array( '@type' => 'Country', 'name' => 'United States' ),
		array( '@type' => 'Country', 'name' => 'United Kingdom' ),
		array( '@type' => 'Place', 'name' => 'European Union' ),
		array( '@type' => 'Place', 'name' => 'Middle East' ),
	);
}

/** The person and business have separate, stable identities. */
function jd_founder_schema() {
	$person = array(
		'@type' => 'Person', '@id' => home_url( '/#person' ),
		'name' => 'Mohsin Jarral', 'jobTitle' => 'Web developer',
		'url' => home_url( '/about/' ), 'sameAs' => jd_profile_links(),
	);
	$image = wp_get_attachment_image_url( (int) get_theme_mod( 'jd_portrait' ), 'full' );
	if ( $image ) {
		$person['image'] = $image;
	}
	return $person;
}

/** The owner selects their WP account; do not attribute guest posts to them. */
function jd_post_author( $post = null ) {
	$post = get_post( $post );
	$user = $post ? get_userdata( (int) $post->post_author ) : false;
	if ( ! $user ) {
		return array();
	}
	if ( $user->ID === (int) get_theme_mod( 'jd_author_user', 0 ) ) {
		return jd_founder_schema();
	}
	return array(
		'@type' => 'Person', '@id' => home_url( '/#author-' . $user->ID ),
		'name' => $user->display_name, 'url' => get_author_posts_url( $user->ID ),
	);
}

/** A "from" price is a minimum, not a fixed total. */
function jd_service_offer( $service, $url ) {
	$price = array(
		'@type' => $service['per'] ? 'UnitPriceSpecification' : 'PriceSpecification',
		'minPrice' => (float) $service['from'], 'priceCurrency' => 'USD',
	);
	if ( '/mo' === $service['per'] ) {
		$price['billingDuration'] = 'P1M';
		$price['unitText'] = 'month';
	}
	return array( '@type' => 'Offer', 'url' => $url, 'priceSpecification' => $price );
}

/** Match the existing visible trails. Service pages do not render breadcrumbs. */
function jd_schema_breadcrumb_items() {
	if ( is_front_page() || is_404() || is_search() || ( is_page() && jd_service_for_page( get_queried_object_id() ) ) ) {
		return array();
	}
	if ( is_page() ) {
		$trail = jd_page_trail( get_queried_object_id() );
	} elseif ( is_singular( 'post' ) ) {
		$blog = (int) get_option( 'page_for_posts' );
		$trail = $blog ? array( array( get_the_title( $blog ), get_permalink( $blog ) ) ) : array();
	} elseif ( is_singular( 'jd_project' ) ) {
		$trail = array( array( __( 'Work', 'jarral-digital' ), get_post_type_archive_link( 'jd_project' ) ) );
	} elseif ( is_tax( 'jd_service_type' ) ) {
		$trail = array( array( __( 'Work', 'jarral-digital' ), get_post_type_archive_link( 'jd_project' ) ), array( single_term_title( '', false ) ) );
	} elseif ( is_post_type_archive( 'jd_project' ) ) {
		$trail = array( array( __( 'Work', 'jarral-digital' ) ) );
	} else {
		$trail = array( array( jd_archive_heading()['crumb'] ) );
	}
	if ( ! $trail ) {
		return array();
	}
	$items = array( array( '@type' => 'ListItem', 'position' => 1, 'name' => __( 'Home', 'jarral-digital' ), 'item' => home_url( '/' ) ) );
	foreach ( $trail as $crumb ) {
		$item = array( '@type' => 'ListItem', 'position' => count( $items ) + 1, 'name' => wp_strip_all_tags( $crumb[0] ) );
		if ( ! empty( $crumb[1] ) ) {
			$item['item'] = $crumb[1];
		}
		$items[] = $item;
	}
	return $items;
}

/** JSON-LD @type accepts a string or list. */
function jd_schema_is( $node, $types ) {
	return is_array( $node ) && (bool) array_intersect( (array) ( $node['@type'] ?? array() ), (array) $types );
}

/** Preserve references when duplicate representations merge. */
function jd_schema_remap( $value, $aliases ) {
	if ( ! is_array( $value ) ) {
		return $value;
	}
	foreach ( $value as $key => $child ) {
		$value[ $key ] = '@id' === $key && is_string( $child ) && isset( $aliases[ $child ] )
			? $aliases[ $child ] : jd_schema_remap( $child, $aliases );
	}
	return $value;
}

/** Build the graph with or without Rank Math. */
function jd_schema_graph( $data = array() ) {
	if ( is_admin() || is_feed() || is_404() || is_search() || ( is_singular() && post_password_required() ) ) {
		return $data;
	}
	$url = is_singular() ? get_permalink( get_queried_object_id() ) : get_pagenum_link( max( 1, get_query_var( 'paged' ) ), false );
	$business_id = home_url( '/#organization' );
	$person = jd_founder_schema();
	$aliases = array();
	$business = array();
	$page_key = null;
	$service = is_page() ? jd_service_for_page( get_queried_object_id() ) : null;
	if ( isset( $data['publisher'] ) && jd_schema_is( $data['publisher'], array( 'Organization', 'LocalBusiness', 'ProfessionalService' ) ) ) {
		$business = $data['publisher'];
	}
	foreach ( $data as $key => $node ) {
		$id = $node['@id'] ?? '';
		$is_business = 'publisher' === $key || in_array( $id, array( home_url( '/#organization' ), home_url( '/#business' ) ), true )
			|| ( jd_schema_is( $node, array( 'Organization', 'LocalBusiness', 'ProfessionalService' ) ) && untrailingslashit( $node['url'] ?? '' ) === untrailingslashit( home_url( '/' ) ) );
		if ( $is_business ) {
			if ( $id ) {
				$aliases[ $id ] = jd_schema_is( $node, 'Person' ) ? $person['@id'] : $business_id;
			}
			if ( ! jd_schema_is( $node, 'Person' ) || jd_schema_is( $node, 'Organization' ) ) {
				$business += $node;
			}
			unset( $data[ $key ] );
		} elseif ( jd_schema_is( $node, array( 'WebPage', 'AboutPage', 'CollectionPage' ) ) && null === $page_key ) {
			$page_key = $key;
		}
	}
	if ( null !== $page_key && ! empty( $data[ $page_key ]['url'] ) ) {
		// Respect a custom canonical already used by Rank Math's page entity.
		$url = $data[ $page_key ]['url'];
	}
	$page_author = is_singular( 'post' ) ? jd_post_author( get_queried_object_id() ) : ( ( $service || is_front_page() || is_page( 'about' ) ) ? $person : array() );
	if ( $page_author && isset( $data['ProfilePage'] ) && jd_schema_is( $data['ProfilePage'], 'Person' ) ) {
		if ( ! empty( $data['ProfilePage']['@id'] ) ) {
			$aliases[ $data['ProfilePage']['@id'] ] = $page_author['@id'];
		}
		unset( $data['ProfilePage'] );
	}
	$business = array_merge( $business, array(
		'@type' => 'ProfessionalService', '@id' => $business_id,
		'name' => get_bloginfo( 'name' ), 'url' => home_url( '/' ),
		'description' => get_bloginfo( 'description' ),
		'founder' => array( '@id' => $person['@id'] ), 'areaServed' => jd_schema_markets(),
	) );
	if ( empty( $business['address'] ) ) {
		$business['address'] = array( '@type' => 'PostalAddress', 'addressCountry' => 'PK' );
	}
	// Keep only public business profiles; the founder's supplied LinkedIn is on Person.
	if ( isset( $business['sameAs'] ) ) {
		$business['sameAs'] = array_values( array_filter( (array) $business['sameAs'], static function ( $link ) {
			$host = strtolower( (string) wp_parse_url( $link, PHP_URL_HOST ) );
			return $host && 'fiverr.com' !== $host && ! str_ends_with( $host, '.fiverr.com' );
		} ) );
	}
	if ( is_front_page() ) {
		$offers = array();
		foreach ( jd_service_catalog() as $slug => $entry ) {
			$service_url = home_url( '/services/' . $slug . '/' );
			$offers[] = jd_service_offer( $entry, $service_url ) + array( 'itemOffered' => array( '@type' => 'Service', 'name' => $entry['name'], 'url' => $service_url ) );
		}
		$business['hasOfferCatalog'] = array( '@type' => 'OfferCatalog', 'name' => 'Services', 'itemListElement' => $offers );
	}
	$data['publisher'] = $business;
	$data['jd_person'] = $person;
	if ( null === $page_key ) {
		$page_key = 'jd_webpage';
		$data[ $page_key ] = array( '@type' => 'WebPage', '@id' => $url . '#webpage', 'url' => $url, 'name' => wp_get_document_title() );
	}
	$page_id = $data[ $page_key ]['@id'];
	if ( is_front_page() ) {
		$data[ $page_key ]['about'] = array( '@id' => $business_id );
	}
	foreach ( $data as &$node ) {
		if ( jd_schema_is( $node, array( 'WebSite', 'WebPage', 'AboutPage', 'Article', 'BlogPosting', 'NewsArticle' ) ) ) {
			$node['publisher'] = array( '@id' => $business_id );
		}
	}
	unset( $node );

	$crumbs = jd_schema_breadcrumb_items();
	foreach ( $data as $key => $node ) {
		if ( jd_schema_is( $node, 'BreadcrumbList' ) ) {
			if ( ! empty( $node['@id'] ) && $crumbs ) {
				$aliases[ $node['@id'] ] = $url . '#breadcrumb';
			}
			unset( $data[ $key ] );
		}
	}
	unset( $data[ $page_key ]['breadcrumb'] );
	if ( $crumbs ) {
		$data['jd_breadcrumb'] = array( '@type' => 'BreadcrumbList', '@id' => $url . '#breadcrumb', 'itemListElement' => $crumbs );
		$data[ $page_key ]['breadcrumb'] = array( '@id' => $url . '#breadcrumb' );
	}
	if ( $service && empty( $service['overview'] ) ) {
		foreach ( $data as $key => $node ) {
			if ( jd_schema_is( $node, 'Service' ) ) {
				if ( ! empty( $node['@id'] ) ) {
					$aliases[ $node['@id'] ] = $url . '#service';
				}
				unset( $data[ $key ] );
			}
		}
		$data['jd_service'] = array(
			'@type' => 'Service', '@id' => $url . '#service', 'url' => $url,
			'name' => $service['name'], 'description' => $service['hero']['lede'],
			'provider' => array( '@id' => $business_id ), 'areaServed' => jd_schema_markets(),
			'offers' => jd_service_offer( $service, $url ), 'mainEntityOfPage' => array( '@id' => $page_id ),
		);
		$data[ $page_key ]['about'] = array( '@id' => $url . '#service' );
	}
	$faqs = is_front_page() ? jd_get_faqs() : ( $service ? ( empty( $service['overview'] ) ? $service['faqs'] : jd_services_overview()['faqs'] ) : array() );
	if ( $faqs ) {
		foreach ( $data as $key => $node ) {
			if ( $key !== $page_key && jd_schema_is( $node, 'FAQPage' ) ) {
				if ( ! empty( $node['@id'] ) ) {
					$aliases[ $node['@id'] ] = $page_id;
				}
				unset( $data[ $key ] );
			}
		}
		$data[ $page_key ]['@type'] = array_values( array_unique( array_merge( (array) $data[ $page_key ]['@type'], array( 'FAQPage' ) ) ) );
		$data[ $page_key ]['mainEntity'] = array_map( static function ( $faq ) {
			return array( '@type' => 'Question', 'name' => $faq['q'], 'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $faq['a'] ) );
		}, $faqs );
	}
	if ( is_page( 'about' ) ) {
		$data[ $page_key ]['@type'] = 'AboutPage';
		$data[ $page_key ]['mainEntity'] = array( '@id' => $person['@id'] );
	}
	$article_types = array( 'Article', 'BlogPosting', 'NewsArticle' );
	if ( $service || is_front_page() || is_page( 'about' ) ) {
		foreach ( $data as $key => $node ) {
			if ( jd_schema_is( $node, $article_types ) ) {
				if ( ! empty( $node['@id'] ) ) {
					$aliases[ $node['@id'] ] = $page_id;
				}
				unset( $data[ $key ] );
			}
		}
	}
	if ( is_singular( 'post' ) ) {
		$post = get_post( get_queried_object_id() );
		$author = jd_post_author( $post );
		$article = array();
		$old_authors = array();
		foreach ( $data as $key => $node ) {
			if ( jd_schema_is( $node, $article_types ) ) {
				$article += $node;
				if ( ! empty( $node['@id'] ) ) {
					$aliases[ $node['@id'] ] = $url . '#article';
				}
				if ( ! empty( $node['author']['@id'] ) ) {
					$old_authors[] = $node['author']['@id'];
				}
				unset( $data[ $key ] );
			}
		}
		if ( $author ) {
			foreach ( $data as $key => $node ) {
				if ( in_array( $node['@id'] ?? '', $old_authors, true ) && jd_schema_is( $node, 'Person' ) && 'jd_person' !== $key ) {
					$aliases[ $node['@id'] ] = $author['@id'];
					unset( $data[ $key ] );
				}
			}
			$data[ $author['@id'] === $person['@id'] ? 'jd_person' : 'jd_author' ] = $author;
			$article['author'] = array( '@id' => $author['@id'] );
		}
		$data['jd_article'] = array_merge( $article, array(
			'@type' => 'Article', '@id' => $url . '#article', 'headline' => get_the_title( $post ), 'url' => $url,
			'datePublished' => get_the_date( DATE_W3C, $post ), 'dateModified' => get_the_modified_date( DATE_W3C, $post ),
			'publisher' => array( '@id' => $business_id ), 'mainEntityOfPage' => array( '@id' => $page_id ),
		) );
		$image = get_the_post_thumbnail_url( $post, 'full' );
		if ( $image ) {
			$data['jd_article']['image'] = $image;
		}
	}
	return jd_schema_remap( $data, $aliases );
}

function jd_rank_math_schema( $data ) {
	$GLOBALS['jd_rank_math_schema_handled'] = true;
	return jd_schema_graph( $data );
}
add_filter( 'rank_math/json_ld', 'jd_rank_math_schema', 99 );

/** Fallback only when Rank Math has not handled this request's graph. */
function jd_schema_fallback() {
	if ( ! empty( $GLOBALS['jd_rank_math_schema_handled'] ) ) {
		return;
	}
	$graph = jd_schema_graph();
	if ( $graph ) {
		echo '<script type="application/ld+json" class="jd-schema">' . wp_json_encode(
			array( '@context' => 'https://schema.org', '@graph' => array_values( $graph ) ),
			JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
		) . '</script>' . "\n";
	}
}
add_action( 'wp_head', 'jd_schema_fallback', 99 );
