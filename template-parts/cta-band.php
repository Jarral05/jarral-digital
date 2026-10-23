<?php
/**
 * The closing band on inner pages: one line of invitation and two routes in,
 * the same two the homepage hero offers.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="band band-dark cta-band">
	<div class="wrap cta-in">
		<div>
			<p class="eyebrow">Start a project</p>
			<h2>Have a project in mind?</h2>
			<p>Tell me what you are building. You will have a reply within twelve hours with scope, a price and a timeline.</p>
		</div>
		<div class="cta-actions">
			<a class="btn btn-invert" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Start a project</a>
			<a class="btn btn-ghost-light" href="<?php echo esc_url( home_url( '/#estimator' ) ); ?>">Estimate the cost</a>
		</div>
	</div>
</section>
