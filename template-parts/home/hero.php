<?php
/**
 * Homepage: hero and specification bar.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;
?>

<header class="hero">
	<div class="wrap">
		<h1>Websites and web apps that actually do the work</h1>
		<p class="lede">Custom WordPress, headless builds, client portals and AI automation for professional services firms across the US, UK, Europe and the Gulf.</p>

		<div class="hero-actions">
			<a href="#estimator" class="btn btn-invert">Estimate your project</a>
			<a href="#work" class="btn btn-ghost-light">See the work</a>
		</div>

		<dl class="spec">
			<?php foreach ( jd_get_spec() as $row ) : ?>
				<div class="spec-row">
					<dt class="spec-key"><?php echo esc_html( $row['k'] ); ?></dt>
					<dd class="spec-val"><?php echo esc_html( $row['v'] ); ?></dd>
				</div>
			<?php endforeach; ?>
		</dl>
	</div>
</header>
