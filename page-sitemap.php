<?php
/**
 * The Sitemap page (WordPress picks this file for the page with the slug
 * "sitemap"). Every page, service, project and article, listed from the
 * site itself, so it never needs editing. The page's own content is not
 * used; its excerpt, if any, is the intro line.
 *
 * Search engines read the XML sitemap instead, linked at the foot of this
 * page: Rank Math's when it is active, WordPress's own otherwise.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

get_header();

$jd_services_page = jd_published_page( 'services' );
$jd_legal         = jd_legal_pages();

// Pages: everything top level except the ones listed in their own group.
$jd_skip = array_merge(
	wp_list_pluck( $jd_legal, 'ID' ),
	array( get_queried_object_id(), (int) get_option( 'page_on_front' ) ),
	$jd_services_page ? array( $jd_services_page->ID ) : array()
);
$jd_groups = array();

$jd_groups['Pages'] = array( array( __( 'Home', 'jarral-digital' ), home_url( '/' ) ) );
foreach ( get_pages( array( 'parent' => 0, 'hierarchical' => false, 'exclude' => $jd_skip, 'sort_column' => 'menu_order,post_title' ) ) as $jd_p ) {
	$jd_groups['Pages'][] = array( get_the_title( $jd_p ), get_permalink( $jd_p ) );
}

// Services: the Services page and its children, or the theme's own list.
$jd_groups['Services'] = array();
if ( $jd_services_page ) {
	$jd_groups['Services'][] = array( get_the_title( $jd_services_page ), get_permalink( $jd_services_page ) );
	foreach ( get_pages( array( 'child_of' => $jd_services_page->ID, 'sort_column' => 'menu_order,post_title' ) ) as $jd_p ) {
		$jd_groups['Services'][] = array( get_the_title( $jd_p ), get_permalink( $jd_p ) );
	}
} else {
	foreach ( jd_get_services() as $jd_s ) {
		$jd_groups['Services'][] = array( $jd_s['name'], home_url( $jd_s['url'] ) );
	}
}

if ( post_type_exists( 'jd_project' ) ) {
	$jd_groups['Work'] = array( array( __( 'All projects', 'jarral-digital' ), get_post_type_archive_link( 'jd_project' ) ) );
	foreach ( get_posts( array( 'post_type' => 'jd_project', 'numberposts' => 100 ) ) as $jd_p ) {
		$jd_groups['Work'][] = array( get_the_title( $jd_p ), get_permalink( $jd_p ) );
	}
}

$jd_articles = get_posts( array( 'numberposts' => 100 ) );
if ( $jd_articles ) {
	$jd_groups['Articles'] = array();
	foreach ( $jd_articles as $jd_p ) {
		$jd_groups['Articles'][] = array( get_the_title( $jd_p ), get_permalink( $jd_p ) );
	}
}

if ( $jd_legal ) {
	$jd_groups['Legal'] = array();
	foreach ( $jd_legal as $jd_p ) {
		$jd_groups['Legal'][] = array( get_the_title( $jd_p ), get_permalink( $jd_p ) );
	}
}

$jd_xml = defined( 'RANK_MATH_VERSION' ) ? home_url( '/sitemap_index.xml' ) : home_url( '/wp-sitemap.xml' );

while ( have_posts() ) :
	the_post();
	?>
	<div class="inner-page">
		<?php
		get_template_part(
			'template-parts/page-hero',
			null,
			array(
				'crumbs' => jd_page_trail(),
				'title'  => get_the_title(),
				'lede'   => has_excerpt() ? get_the_excerpt() : __( 'Every page on the site, in one place.', 'jarral-digital' ),
			)
		);
		?>

		<section class="band">
			<div class="wrap">
				<div class="sitemap">
					<?php foreach ( $jd_groups as $jd_label => $jd_links ) : ?>
						<div class="sitemap-group">
							<h2 class="eyebrow"><?php echo esc_html( $jd_label ); ?></h2>
							<ul>
								<?php foreach ( $jd_links as $jd_link ) : ?>
									<li><a href="<?php echo esc_url( $jd_link[1] ); ?>"><?php echo esc_html( $jd_link[0] ); ?></a></li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endforeach; ?>
				</div>
				<p class="sitemap-xml">For search engines: <a href="<?php echo esc_url( $jd_xml ); ?>">XML sitemap</a></p>
			</div>
		</section>

		<?php get_template_part( 'template-parts/cta-band' ); ?>
	</div>
	<?php
endwhile;

get_footer();
