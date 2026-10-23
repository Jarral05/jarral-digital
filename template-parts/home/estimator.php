<?php
/**
 * Homepage: the price estimator. Prices come from assets/js/main.js.
 *
 * The result panel is visible from the start with a prompt in it, so the
 * box is never half empty and nothing jumps when the first chip is picked.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="band band-dark" id="estimator">
	<div class="wrap">
		<div class="sec-head">
			<div class="sec-title">
				<p class="eyebrow">Pricing</p>
				<h2>What will it cost?</h2>
			</div>
			<p>Pick what you need and see a real range before you speak to anyone. Two taps, no email required.</p>
		</div>

		<div class="est">
			<div class="est-steps">
				<div class="est-step">
					<div class="est-label">1. What are you building?</div>
					<div class="chips" id="jdSvc">
						<button type="button" class="chip" data-k="wp"     aria-pressed="false">A website</button>
						<button type="button" class="chip" data-k="app"    aria-pressed="false">A web application</button>
						<button type="button" class="chip" data-k="forms"  aria-pressed="false">Forms and PDFs</button>
						<button type="button" class="chip" data-k="portal" aria-pressed="false">A portal or members area</button>
						<button type="button" class="chip" data-k="ai"     aria-pressed="false">AI or automation</button>
					</div>
				</div>

				<?php // main.js replaces the hint with the extras for the chosen type. ?>
				<div class="est-step" id="jdOptStep">
					<div class="est-label">2. Anything else? (optional)</div>
					<div class="chips" id="jdOpt"><p class="est-hint">Extras for your project type appear here once you pick one.</p></div>
				</div>
			</div>

			<div class="est-out" id="jdOut" aria-live="polite">
				<div class="est-k">Indicative range</div>
				<div class="est-fig" id="jdFig">&mdash;</div>
				<div class="est-meta" id="jdMeta">Pick what you are building to see a typical range and timeline.</div>
				<a class="btn btn-invert" id="jdCta" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Get an exact quote</a>
				<div class="est-note">Based on similar past projects. Your exact price comes back within twelve hours of sending the form.</div>
			</div>
		</div>
	</div>
</section>
