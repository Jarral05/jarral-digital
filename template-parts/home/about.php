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

		<?php get_template_part( 'template-parts/portrait', null, array( 'class' => 'who-photo' ) ); ?>

		<div class="who-head">
			<p class="eyebrow">About</p>
			<h2>Who actually builds it</h2>
		</div>

		<div class="who-body">
			<p>I am Mohsin Jarral. I have been building websites and web applications since 2020, for professional services firms in the US, UK, Europe and Asia. There is no account manager and no junior handed your project. You work with the person writing the code.</p>
			<p>Before development I trained as a mechanical engineer, which is probably why I care more about whether a system holds up than whether it looks clever.</p>

			<dl class="who-facts">
				<?php foreach ( jd_get_about_facts() as $jd_label => $jd_value ) : ?>
					<div><dt><?php echo esc_html( $jd_label ); ?></dt><dd><?php echo esc_html( $jd_value ); ?></dd></div>
				<?php endforeach; ?>
			</dl>
		</div>
	</div>
</section>
