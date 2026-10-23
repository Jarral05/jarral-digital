<?php
/**
 * The Contact page (WordPress picks this file for the page with the slug
 * "contact"). The page content, the [jarral_contact_form] shortcode, sits
 * beside the same four promises the homepage contact section makes.
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
				'lede'   => has_excerpt() ? get_the_excerpt() : 'You will have a reply within twelve hours with scope, a price and a timeline. From me, not an assistant.',
				'meta'   => jd_get_hero_terms(),
			)
		);
		?>

		<section class="band" id="contact">
			<div class="wrap contact-cols">
				<div class="contact-copy">
					<p class="eyebrow">What happens next</p>
					<ul class="promise">
						<?php foreach ( jd_get_promises() as $jd_promise ) : ?>
							<li><strong><?php echo esc_html( $jd_promise['h'] ); ?></strong> <?php echo esc_html( $jd_promise['p'] ); ?></li>
						<?php endforeach; ?>
					</ul>
					<p class="contact-meta">
						Prefer email? <a href="mailto:<?php echo esc_attr( jd_contact_email() ); ?>"><?php echo esc_html( jd_contact_email() ); ?></a><br>
						Working across US, UK, European and Gulf time zones.
					</p>
				</div>

				<div class="contact-form">
					<?php the_content(); ?>
				</div>
			</div>
		</section>
	</div>
	<?php
endwhile;

get_footer();
