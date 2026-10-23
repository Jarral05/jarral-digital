<?php
/**
 * Homepage: outcome figures. Sits straight after the work grid, so the
 * numbers read as proof of the projects above them.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="band band-tint" id="results">
	<div class="wrap">
		<div class="sec-head">
			<div class="sec-title">
				<p class="eyebrow">Results</p>
				<h2>What clients get</h2>
			</div>
		</div>

		<div class="results">
			<?php foreach ( jd_get_results() as $r ) : ?>
				<div class="result">
					<div class="big"><?php echo esc_html( $r['big'] ); ?></div>
					<p><?php echo esc_html( $r['p'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
