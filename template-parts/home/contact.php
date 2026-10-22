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
		<div class="sec-head">
			<h2>Tell me what you are building</h2>
			<p>Describe the problem and I will reply within twelve hours with scope and a price. No call needed to get started, though I am happy to jump on one if you would rather talk it through.</p>
		</div>

		<?php
		if ( function_exists( 'jd_render_contact_form' ) ) {
			jd_render_contact_form();
		} else {
			echo '<p>Activate the Jarral Forms plugin to show the contact form.</p>';
		}
		?>
	</div>
</section>
