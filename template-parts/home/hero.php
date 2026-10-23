<?php
/**
 * Homepage: hero, with the proof card beside it.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;
?>

<header class="hero">
	<div class="wrap hero-grid">
		<div class="hero-copy">
			<h1>Websites and web apps that actually do the work</h1>
			<p class="lede">Custom WordPress, headless builds, client portals and AI automation for professional services firms across the US, UK, Europe and the Gulf.</p>

			<div class="hero-actions">
				<a href="#estimator" class="btn btn-invert">Estimate your project</a>
				<a href="#work" class="btn btn-ghost-light">See the work</a>
			</div>

			<ul class="hero-terms">
				<?php foreach ( jd_get_hero_terms() as $term ) : ?>
					<li><?php echo esc_html( $term ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<dl class="hero-stats">
			<?php foreach ( jd_get_hero_stats() as $stat ) : ?>
				<div class="hero-stat">
					<dt><?php echo esc_html( $stat['k'] ); ?></dt>
					<dd><?php echo esc_html( $stat['v'] ); ?></dd>
				</div>
			<?php endforeach; ?>
		</dl>
	</div>
</header>
