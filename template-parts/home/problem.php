<?php
/**
 * Homepage: the three failure modes, each paired with its fix.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="band">
	<div class="wrap">
		<div class="sec-head">
			<div class="sec-title">
				<p class="eyebrow">Why projects fail</p>
				<h2>Most web projects fail the same three ways</h2>
			</div>
			<p>Each one has a fix built into how I work.</p>
		</div>

		<div class="prob">
			<?php foreach ( jd_get_problems() as $p ) : ?>
				<div class="prob-item">
					<h3><?php echo esc_html( $p['h'] ); ?></h3>
					<p><?php echo esc_html( $p['p'] ); ?></p>
					<p class="prob-fix"><?php echo esc_html( $p['fix'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
