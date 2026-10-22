<?php
/**
 * Homepage: the four project stages.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="band band-tint" id="process">
	<div class="wrap">
		<div class="sec-head">
			<h2>How a project runs</h2>
			<p>The same four steps every time, so you always know what happens next.</p>
		</div>

		<ol class="steps">
			<?php foreach ( jd_get_process() as $i => $step ) : ?>
				<li class="step">
					<span class="step-n"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
					<div>
						<h3><?php echo esc_html( $step['h'] ); ?></h3>
						<p><?php echo esc_html( $step['p'] ); ?></p>
					</div>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
