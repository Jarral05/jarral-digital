<?php
/**
 * Four numbered steps on a service page. Args: h, p, and items (array of
 * h/p); without items, the homepage process, jd_get_process().
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

$jd_steps = ! empty( $args['items'] ) ? $args['items'] : jd_get_process();
?>
<section class="band">
	<div class="wrap">
		<div class="sec-head">
			<h2><?php echo esc_html( $args['h'] ); ?></h2>
			<p><?php echo esc_html( $args['p'] ); ?></p>
		</div>
		<ol class="steps">
			<?php foreach ( $jd_steps as $jd_i => $jd_step ) : ?>
				<li class="step">
					<span class="step-n"><?php echo esc_html( str_pad( (string) ( $jd_i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
					<div>
						<h3><?php echo esc_html( $jd_step['h'] ); ?></h3>
						<p><?php echo esc_html( $jd_step['p'] ); ?></p>
					</div>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
