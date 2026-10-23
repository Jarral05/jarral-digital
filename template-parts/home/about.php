<?php
/**
 * Homepage: who builds it. The photo is the highest-converting element on the page.
 *
 * The heading sits in its own block so that on a phone it can stand beside a
 * small portrait, instead of a full-width photo pushing it a screen down.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="band band-tint" id="about">
	<div class="wrap who">

		<div class="who-photo">
			<?php
			$jd_photo = get_theme_mod( 'jd_portrait' );
			if ( $jd_photo ) {
				echo wp_get_attachment_image(
					(int) $jd_photo,
					'jd-portrait',
					false,
					array( 'alt' => 'Mohsin Jarral', 'loading' => 'lazy', 'decoding' => 'async' )
				);
			} else {
				echo '<span>Add your photo in Customise &rarr; Jarral Digital</span>';
			}
			?>
		</div>

		<div class="who-head">
			<p class="eyebrow">About</p>
			<h2>Who actually builds it</h2>
		</div>

		<div class="who-body">
			<p>I am Mohsin Jarral. I have been building websites and web applications since 2020, for professional services firms in the US, UK, Europe and Asia. There is no account manager and no junior handed your project. You work with the person writing the code.</p>
			<p>Before development I trained as a mechanical engineer, which is probably why I care more about whether a system holds up than whether it looks clever.</p>

			<dl class="who-facts">
				<div><dt>Based in</dt><dd>Pakistan</dd></div>
				<div><dt>Working hours</dt><dd>Overlap US, UK, EU, Gulf</dd></div>
				<div><dt>Written in</dt><dd>English</dd></div>
				<div><dt>Reply time</dt><dd>Within 12 hours</dd></div>
			</dl>
		</div>
	</div>
</section>
