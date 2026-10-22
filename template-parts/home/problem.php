<?php
/**
 * Homepage: the three failure modes.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="band">
	<div class="wrap">
		<div class="sec-head"><h2>Most web projects fail the same three ways</h2></div>

		<div class="prob">
			<?php foreach ( jd_get_problems() as $p ) : ?>
				<div class="prob-item">
					<h3><?php echo esc_html( $p['h'] ); ?></h3>
					<p><?php echo esc_html( $p['p'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>

		<p class="prob-close">Fixed scope agreed in writing before anything starts. A reply within twelve hours, every working day. And a care plan so the site keeps working after launch.</p>
	</div>
</section>
