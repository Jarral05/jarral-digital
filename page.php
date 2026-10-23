<?php
/**
 * Single page.
 *
 * The Services page and the services under it are drawn from
 * inc/services.php. Any other page built from the old service patterns
 * prints bare, as it always has. Every other page (About, Process, the
 * policies) gets the inner page layout: the page hero, the content with its
 * "On this page" list, and the closing call to action. .inner-page scopes
 * that layout's styles, so the service pages are untouched by it.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	$jd_service = jd_service_for_page();

	if ( $jd_service ) :
		// The page's own content is not used. See jd_service_for_page().
		if ( empty( $jd_service['overview'] ) ) {
			get_template_part( 'template-parts/service/single', null, array( 'service' => $jd_service ) );
		} else {
			get_template_part( 'template-parts/service/overview' );
		}
	elseif ( jd_is_pattern_page() ) :
		// Built from the section patterns, which bring their own bands and
		// heading. See jd_is_pattern_page() in inc/template-tags.php.
		the_content();
	else :
		?>
		<div class="inner-page">
			<?php
			get_template_part(
				'template-parts/page-hero',
				null,
				array(
					'crumbs' => jd_page_trail(),
					'title'  => get_the_title(),
					'lede'   => has_excerpt() ? get_the_excerpt() : '',
				)
			);
			get_template_part( 'template-parts/doc', null, array( 'doc' => jd_prepare_content( get_the_content() ) ) );
			get_template_part( 'template-parts/cta-band' );
			?>
		</div>
		<?php
	endif;
endwhile;

get_footer();
