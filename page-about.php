<?php
/**
 * The About page (WordPress picks this file for the page with the slug
 * "about"). page.php's layout, with the portrait from Customise > Jarral
 * Digital in the hero, so the page shows who it is about before a word of it.
 *
 * Rename the page's slug and it falls back to page.php, which still works.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<div class="inner-page">
		<?php
		get_template_part(
			'template-parts/page-hero',
			null,
			array(
				'crumbs'   => jd_page_trail(),
				'title'    => get_the_title(),
				'lede'     => has_excerpt() ? get_the_excerpt() : '',
				'meta'     => array( 'Based in Pakistan', 'Hours overlap US, UK, EU and Gulf', 'Building since 2020' ),
				'portrait' => (int) get_theme_mod( 'jd_portrait' ),
			)
		);
		get_template_part( 'template-parts/doc', null, array( 'doc' => jd_prepare_content( get_the_content() ) ) );
		get_template_part( 'template-parts/cta-band' );
		?>
	</div>
	<?php
endwhile;

get_footer();
