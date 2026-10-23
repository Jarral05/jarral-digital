<?php
/**
 * The About page (WordPress picks this file for the page with the slug
 * "about"). The portrait and the four facts sit beside the page's text, as
 * they do in the homepage About section, from the same photo
 * (Customise > Jarral Digital) and the same facts (jd_get_about_facts()).
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
				'crumbs' => jd_page_trail(),
				'title'  => get_the_title(),
				// The page's Excerpt, if one is set, replaces this line.
				'lede'   => has_excerpt() ? get_the_excerpt() : 'The person who builds your project, how I work, and what I will tell you before you commit.',
			)
		);
		?>

		<section class="band">
			<div class="wrap about-cols">
				<aside class="about-profile">
					<?php get_template_part( 'template-parts/portrait', null, array( 'class' => 'about-photo', 'loading' => 'eager' ) ); ?>
					<dl class="who-facts">
						<?php foreach ( jd_get_about_facts() as $jd_label => $jd_value ) : ?>
							<div><dt><?php echo esc_html( $jd_label ); ?></dt><dd><?php echo esc_html( $jd_value ); ?></dd></div>
						<?php endforeach; ?>
					</dl>
				</aside>

				<div class="prose">
					<?php echo jd_prepare_content( get_the_content() )['html']; // phpcs:ignore WordPress.Security.EscapeOutput -- the_content output, as the_content() prints it. ?>
					<p><a href="<?php echo esc_url( jd_profile_links()[0] ); ?>">Connect with me on LinkedIn</a>.</p>
				</div>
			</div>
		</section>

		<?php get_template_part( 'template-parts/cta-band' ); ?>
	</div>
	<?php
endwhile;

get_footer();
