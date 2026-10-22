<?php
/**
 * Homepage: outcome figures.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="band">
	<div class="wrap">
		<div class="sec-head"><h2>What clients get</h2></div>

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
