<?php
/**
 * The "At a glance" card beside a service's details. Args: facts, as
 * label => value.
 *
 * Each row is a <div> inside the <dl>, because .factrow:last-of-type matches
 * the last <div> in its parent, not the last .factrow.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;
?>
<aside class="factcard">
	<h2>At a glance</h2>
	<dl>
		<?php foreach ( $args['facts'] as $jd_label => $jd_value ) : ?>
			<div class="factrow"><dt><?php echo esc_html( $jd_label ); ?></dt><dd><?php echo esc_html( $jd_value ); ?></dd></div>
		<?php endforeach; ?>
	</dl>
	<a class="btn btn-solid" href="#contact">Get a quote</a>
</aside>
