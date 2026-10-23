<?php
/**
 * Homepage: contact form, rendered by the Jarral Forms plugin.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="band band-dark" id="contact">
	<div class="wrap">
		<div class="contact-cols">

			<div class="contact-copy">
				<p class="eyebrow">Contact</p>
				<h2>Tell me what you are building</h2>
				<p class="lede">You will have a reply within twelve hours with scope, a price and a timeline. From me, not an assistant.</p>

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

			<div>
				<?php
				if ( function_exists( 'jd_render_contact_form' ) ) {
					jd_render_contact_form();
				} else {
					echo '<p>Activate the Jarral Forms plugin to show the contact form.</p>';
				}
				?>
			</div>

		</div>
	</div>
</section>
