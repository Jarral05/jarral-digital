<?php
/** Run only against the synthetic local WordPress test site, never production. */
$root = getenv( 'JD_TEST_WP_ROOT' );
if ( ! $root || ! is_file( $root . '/wp-load.php' ) ) {
	fwrite( STDERR, "Set JD_TEST_WP_ROOT to the isolated WordPress fixture directory.\n" );
	exit( 1 );
}
$_SERVER['HTTP_HOST'] = '127.0.0.1:8181';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['PHP_SELF'] = '/index.php';
require $root . '/wp-load.php';
if ( 'local' !== wp_get_environment_type() || '127.0.0.1' !== wp_parse_url( home_url(), PHP_URL_HOST ) ) {
	throw new RuntimeException( 'Tests require the isolated local fixture site.' );
}
$passed = 0;
function check( $condition, $message ) {
	global $passed;
	if ( ! $condition ) {
		throw new RuntimeException( $message );
	}
	++$passed;
}
function visit_post( $id ) {
	$type = get_post_type( $id );
	$GLOBALS['wp_query'] = new WP_Query( array( 'page' === $type ? 'page_id' : 'p' => $id, 'post_type' => $type ) );
	$GLOBALS['wp_the_query'] = $GLOBALS['wp_query'];
	$GLOBALS['post'] = get_post( $id );
	setup_postdata( $GLOBALS['post'] );
}
function nodes_of_type( $graph, $type ) {
	return array_values( array_filter( $graph, static function ( $node ) use ( $type ) { return jd_schema_is( $node, $type ); } ) );
}
function analytics_html() {
	ob_start();
	jd_cloudflare_analytics();
	return ob_get_clean();
}
$ids = json_decode( file_get_contents( dirname( $root ) . '/fixture-ids.json' ), true );
$mods = get_theme_mods();
$blog_name = get_option( 'blogname' );
try {
	foreach ( jd_service_catalog() as $slug => $service ) {
		visit_post( $ids[$slug] );
		$graph = jd_schema_graph();
		$nodes = nodes_of_type( $graph, 'Service' );
		check( 1 === count( $nodes ), "$slug has exactly one Service entity" );
		check( $nodes[0]['name'] === $service['name'], "$slug name matches visible service" );
		check( (float) $service['from'] === $nodes[0]['offers']['priceSpecification']['minPrice'], "$slug minimum price matches catalog" );
		check( 'USD' === $nodes[0]['offers']['priceSpecification']['priceCurrency'], "$slug currency" );
		check( home_url( '/#organization' ) === $nodes[0]['provider']['@id'], "$slug provider" );
		check( empty( nodes_of_type( $graph, 'BreadcrumbList' ) ), "$slug has no invisible breadcrumbs" );
		$faq = nodes_of_type( $graph, 'FAQPage' );
		check( 1 === count( $faq ) && count( $service['faqs'] ) === count( $faq[0]['mainEntity'] ), "$slug FAQ count" );
		check( $service['faqs'][0]['a'] === $faq[0]['mainEntity'][0]['acceptedAnswer']['text'], "$slug FAQ text" );
		$content = jd_service_analysis_content( $ids[$slug] );
		check( str_contains( html_entity_decode( $content ), $service['hero']['title'] ), "$slug editor content contains rendered heading" );
		check( ! str_contains( $content, 'Service editor placeholder' ), "$slug stale editor text excluded" );
		check( ! preg_match( '/<(form|input|svg|script)\b/i', $content ), "$slug analyzer contains no live form, nonce or script" );
		check( str_contains( $content, $service['form']['h'] ), "$slug analyzer includes visible form heading" );
	}
	visit_post( $ids['care-plans'] );
	$care = nodes_of_type( jd_schema_graph(), 'Service' )[0];
	check( 'P1M' === $care['offers']['priceSpecification']['billingDuration'], 'Care plan is a monthly minimum' );
	visit_post( $ids['services'] );
	check( 0 === count( nodes_of_type( jd_schema_graph(), 'Service' ) ), 'Overview is not a seventh priced service' );
	check( str_contains( jd_service_analysis_content(), 'All services' ), 'Overview editor analysis uses template' );
	visit_post( $ids['about'] );
	$about = jd_schema_graph();
	check( home_url( '/#person' ) === nodes_of_type( $about, 'AboutPage' )[0]['mainEntity']['@id'], 'About references founder' );
	check( jd_profile_links() === nodes_of_type( $about, 'Person' )[0]['sameAs'], 'About uses supplied profile' );
	$crumbs = nodes_of_type( $about, 'BreadcrumbList' )[0]['itemListElement'];
	check( array( 'Home', 'About' ) === array_column( $crumbs, 'name' ), 'About breadcrumb matches visible trail' );
	check( '' === jd_service_analysis_content(), 'Ordinary page editor analysis is untouched' );
	visit_post( $ids['wordpress-development'] );
	$url = get_permalink();
	$legacy = array(
		'publisher' => array( '@type' => 'Organization', '@id' => home_url('/#organization'), 'name' => 'Jarral Digital', 'logo' => array('@id' => home_url('/logo.png')) ),
		'duplicate' => array( '@type' => 'ProfessionalService', '@id' => home_url('/#business'), 'url' => home_url('/') ),
		'WebSite' => array( '@type' => 'WebSite', '@id' => home_url('/#website'), 'publisher' => array('@id' => home_url('/#business')) ),
		'WebPage' => array( '@type' => 'WebPage', '@id' => $url.'#webpage', 'url' => $url, 'breadcrumb' => array('@id' => $url.'#oldcrumb') ),
		'BreadcrumbList' => array( '@type' => 'BreadcrumbList', '@id' => $url.'#oldcrumb' ),
		'old-service' => array( '@type' => 'Service', '@id' => $url.'#oldservice' ),
		'old-faq' => array( '@type' => 'FAQPage', '@id' => $url.'#oldfaq' ),
		'old-article' => array( '@type' => 'Article', '@id' => $url.'#oldarticle' ),
	);
	$merged = jd_schema_graph( $legacy );
	check( 1 === count( nodes_of_type( $merged, 'ProfessionalService' ) ), 'Business duplicates merged' );
	check( isset($merged['publisher']['logo']), 'Configured logo retained' );
	check( home_url('/#organization') === $merged['WebSite']['publisher']['@id'], 'Publisher references stay connected' );
	check( 1 === count(nodes_of_type($merged,'FAQPage')) && 1 === count(nodes_of_type($merged,'Service')), 'No duplicate service or FAQ nodes' );
	check( 0 === count(nodes_of_type($merged,'Article')), 'Service pages are not articles' );
	check( ! isset($merged['WebPage']['breadcrumb']), 'No stale breadcrumb reference' );
	$legacy['WebPage']['url'] = home_url('/canonical-override/');
	$legacy['WebPage']['@id'] = home_url('/canonical-override/#webpage');
	$merged = jd_schema_graph($legacy);
	check( 1 === count(nodes_of_type($merged,'WebPage')), 'Canonical override does not create a duplicate WebPage' );
	check( home_url('/canonical-override/') === $merged['jd_service']['url'], 'Schema respects Rank Math canonical URL' );
	$legacy['publisher']['@type'] = array('Person','Organization');
	$legacy['publisher']['@id'] = home_url('/#person');
	$merged = jd_schema_graph($legacy);
	check( home_url('/#organization') === $merged['WebSite']['publisher']['@id'], 'Personal publisher settings still yield one business publisher' );
	check( isset($merged['publisher']['logo']), 'Mixed Person/Organization publisher retains its configured logo' );
	visit_post($ids['qa-article']);
	set_theme_mod('jd_author_user',1);
	$article = nodes_of_type(jd_schema_graph(),'Article')[0];
	check( home_url('/#person') === $article['author']['@id'], 'Owner Article connects to About Person' );
	check( get_the_modified_date(DATE_W3C) === $article['dateModified'], 'Article uses actual modified date' );
	set_theme_mod('jd_author_user',0);
	check( home_url('/#person') !== jd_post_author()['@id'], 'Unconfigured account is not guessed to be the founder' );
	set_theme_mod('jd_author_user',1);
	visit_post($ids['qa-guest']);
	check( 'Guest Writer' === jd_post_author()['name'], 'Guest authors retain their identity' );
	visit_post($ids['home']);
	wp_set_current_user(0);
	remove_theme_mod('jd_cloudflare_token');
	remove_theme_mod('jd_analytics_policy_ready');
	check( '' === analytics_html(), 'Analytics off by default' );
	set_theme_mod('jd_cloudflare_token',str_repeat('a',32));
	check( '' === analytics_html(), 'Token alone cannot enable analytics before policy confirmation' );
	set_theme_mod('jd_analytics_policy_ready',true);
	check( 1 === substr_count(analytics_html(),'beacon.min.js'), 'One beacon for an eligible anonymous visit' );
	wp_set_current_user(1);
	check( '' === analytics_html(), 'Logged-in visits excluded' );
	wp_set_current_user(0);
	$GLOBALS['wp_query']->is_preview = true;
	check( '' === analytics_html(), 'Preview excluded' );
	$GLOBALS['wp_query']->is_preview = false;
	check( '' === jd_sanitize_analytics_token('<script>bad</script>'), 'Token rejects executable markup' );
	check( str_repeat('a',32) === jd_sanitize_analytics_token(' '.str_repeat('A',32).' '), 'Token whitespace and case normalized' );
	check( jd_validate_analytics_token(new WP_Error(), 'bad')->has_errors(), 'Invalid token produces a Customizer error' );
	$GLOBALS['jd_rank_math_schema_handled'] = true;
	ob_start(); jd_schema_fallback(); $fallback = ob_get_clean();
	check( '' === $fallback, 'No second graph when Rank Math handled it' );
	$GLOBALS['jd_rank_math_schema_handled'] = false;
	update_option('blogname','Example </script><script>alert(1)</script>');
	ob_start(); jd_schema_fallback(); $fallback = ob_get_clean();
	check( 1 === substr_count($fallback,'</script>'), 'Fallback JSON cannot break out of its script element' );
	$GLOBALS['wp_query']->is_404 = true;
	check( array() === jd_schema_graph(), 'No fallback business graph on a 404' );
	$GLOBALS['wp_query']->is_404 = false;
	echo wp_json_encode(array('passed'=>$passed,'wordpress'=>$GLOBALS['wp_version'],'rank_math'=>RANK_MATH_VERSION,'php'=>PHP_VERSION), JSON_PRETTY_PRINT) . "\n";
} finally {
	update_option('theme_mods_' . get_option('stylesheet'), $mods);
	update_option('blogname',$blog_name);
}
