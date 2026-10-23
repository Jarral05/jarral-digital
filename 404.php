<?php
/**
 * Not found.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="inner-page">
	<?php
	get_template_part(
		'template-parts/page-hero',
		null,
		array(
			'crumbs' => array( array( __( 'Not found', 'jarral-digital' ) ) ),
			'title'  => __( 'That page does not exist', 'jarral-digital' ),
			'lede'   => __( 'It may have moved, or the link may be out of date. One of the services below may be what you were after, or tell me what you were looking for.', 'jarral-digital' ),
		)
	);
	?>

	<section class="band band-tint">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-title">
					<p class="eyebrow">Services</p>
					<h2>Try one of these</h2>
				</div>
				<p>Or go to the <a href="<?php echo esc_url( home_url( '/' ) ); ?>">homepage</a>, <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About</a>, <a href="<?php echo esc_url( home_url( '/process/' ) ); ?>">Process</a> or <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a>.</p>
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

	<?php get_template_part( 'template-parts/cta-band' ); ?>
</div>

<?php
get_footer();
