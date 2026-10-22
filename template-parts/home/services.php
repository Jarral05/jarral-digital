<?php
/**
 * Homepage: the six services.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="band band-tint" id="services">
	<div class="wrap">
		<div class="sec-head">
			<h2>What I build</h2>
			<p>Six things I do properly, rather than everything done adequately. You work with me directly on all of them.</p>
		</div>

		<div class="svc">
			<?php foreach ( jd_get_services() as $s ) : ?>
				<a class="svc-row" href="<?php echo esc_url( $s['url'] ); ?>">
					<span class="svc-ico"><?php jd_icon( 'icon-' . $s['icon'] ); ?></span>
					<div class="svc-name"><?php echo esc_html( $s['name'] ); ?></div>
					<div class="svc-desc"><?php echo esc_html( $s['desc'] ); ?></div>
					<div class="svc-price"><?php echo esc_html( $s['price'] ); ?></div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
