<?php
/**
 * Homepage: service outcomes, without unverified numerical client claims.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="band band-tint" id="results">
	<div class="wrap">
		<div class="sec-head">
			<div class="sec-title">
				<p class="eyebrow">What I build</p>
				<h2>Built around your workflow</h2>
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
