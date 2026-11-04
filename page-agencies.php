<?php
/**
 * The page for agencies (WordPress picks this file for the page with the slug
 * "agencies"). Its text comes from jd_get_agency_offer(), so the page's editor
 * content can stay empty. Enquiries from it are tagged "Agency partnership".
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

get_header();

$jd_offer = jd_get_agency_offer();

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
				'lede'   => $jd_offer['lede'],
				'meta'   => $jd_offer['meta'],
			)
		);
		?>

		<section class="band">
			<div class="wrap">
				<div class="sec-head">
					<div class="sec-title">
						<p class="eyebrow">What we take on</p>
						<h2><?php echo esc_html( $jd_offer['heading'] ); ?></h2>
					</div>
					<p><?php echo esc_html( $jd_offer['intro'] ); ?></p>
				</div>

				<ul class="agency-grid">
					<?php foreach ( $jd_offer['services'] as $jd_service ) : ?>
						<li>
							<h3><?php echo esc_html( $jd_service['h'] ); ?></h3>
							<p><?php echo esc_html( $jd_service['p'] ); ?></p>
						</li>
					<?php endforeach; ?>
				</ul>

				<p class="agency-more"><a href="<?php echo esc_url( home_url( '/work/' ) ); ?>">See recent work</a></p>
			</div>
		</section>

		<section class="band band-tint" id="contact">
			<div class="wrap contact-cols">
				<div class="contact-copy">
					<p class="eyebrow">How it works</p>
					<ul class="promise">
						<?php foreach ( $jd_offer['terms'] as $jd_term ) : ?>
							<li><strong><?php echo esc_html( $jd_term['h'] ); ?></strong> <?php echo esc_html( $jd_term['p'] ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>

				<div class="contact-form">
					<?php
					// The form alone, not the shortcode, whose own band padding would push it below the left column.
					if ( function_exists( 'jd_render_contact_form' ) ) :
						?>
						<h2 class="agency-form-h"><?php echo esc_html( $jd_offer['form']['h'] ); ?></h2>
						<p class="agency-form-p"><?php echo esc_html( $jd_offer['form']['p'] ); ?></p>
						<?php
						jd_render_contact_form( array( 'service' => 'Agency partnership' ) );
					endif;
					?>
				</div>
			</div>
		</section>
	</div>
	<?php
endwhile;

get_footer();
