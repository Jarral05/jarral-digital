<?php
/**
 * Service hero: the pine band at the top of every service page and the
 * Services page.
 *
 * Args: eyebrow, title, lede, price, note, time, and more = array( label,
 * href ) for the second button. The first button always asks for a quote.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="svc-hero">
	<div class="wrap">
		<p class="svc-eyebrow"><?php echo esc_html( $args['eyebrow'] ); ?></p>
		<h1><?php echo esc_html( $args['title'] ); ?></h1>
		<p class="lede"><?php echo esc_html( $args['lede'] ); ?></p>
		<div class="svc-hero-meta">
			<div class="svc-hero-price"><?php echo esc_html( $args['price'] ); ?> <span><?php echo esc_html( $args['note'] ); ?></span></div>
			<div class="svc-hero-time"><?php echo esc_html( $args['time'] ); ?></div>
		</div>
		<div class="svc-hero-actions">
			<a class="btn btn-invert" href="#contact">Get a quote</a>
			<a class="btn btn-ghost-light" href="<?php echo esc_attr( $args['more'][1] ); ?>"><?php echo esc_html( $args['more'][0] ); ?></a>
		</div>
	</div>
</section>
