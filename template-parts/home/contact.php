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
					<li><strong>Nothing is committed by sending this</strong> No call is booked, no invoice raised, nobody added to a list.</li>
					<li><strong>A fixed price before work starts</strong> The number you accept is the number you pay.</li>
					<li><strong>You own the result</strong> Design, code and content transfer to you on final payment.</li>
					<li><strong>Thirty days of fixes included</strong> Anything not working as described is fixed at no cost.</li>
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
