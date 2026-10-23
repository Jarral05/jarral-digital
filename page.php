<?php
/**
 * Single page.
 *
 * Pages built from the service patterns print bare, as they always have.
 * Every other page (About, Process, the policies) gets the inner page
 * layout: the page hero, the content with its "On this page" list, and the
 * closing call to action. .inner-page scopes that layout's styles, so the
 * service pages are untouched by it.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	if ( jd_is_pattern_page() ) :
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
