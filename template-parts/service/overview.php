<?php
/**
 * The Services page, /services/: every service as a row, the problem cards
 * that point to them, the process and the questions. Everything comes from
 * jd_services_overview() and jd_service_catalog().
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

$jd_o = jd_services_overview();

get_template_part( 'template-parts/service/hero', null, $jd_o['hero'] + array( 'more' => array( 'See all services', '#services' ) ) );
?>

<section class="band" id="services">
	<div class="wrap">
		<div class="cols">
			<div>
				<div class="sec-head">
					<h2><?php echo esc_html( $jd_o['list']['h'] ); ?></h2>
					<p><?php echo esc_html( $jd_o['list']['p'] ); ?></p>
				</div>
				<div class="svc">
					<?php foreach ( jd_get_services() as $jd_s ) : ?>
						<a class="svc-row" href="<?php echo esc_url( $jd_s['url'] ); ?>">
							<span class="svc-ico"><?php jd_icon( 'icon-' . $jd_s['icon'] ); ?></span>
							<div>
								<div class="svc-name"><?php echo esc_html( $jd_s['name'] ); ?></div>
								<div class="svc-desc"><?php echo esc_html( $jd_s['desc'] ); ?></div>
							</div>
							<div class="svc-price"><?php echo esc_html( $jd_s['price'] ); ?></div>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
			<?php get_template_part( 'template-parts/service/factcard', null, array( 'facts' => $jd_o['facts'] ) ); ?>
		</div>
	</div>
</section>

<section class="band band-tint">
	<div class="wrap">
		<div class="sec-head">
			<h2><?php echo esc_html( $jd_o['problems']['h'] ); ?></h2>
			<p><?php echo esc_html( $jd_o['problems']['p'] ); ?></p>
		</div>
		<div class="gets">
			<?php foreach ( jd_service_catalog() as $jd_slug => $jd_s ) : ?>
				<div class="get">
					<div class="get-ico"><?php jd_icon( $jd_s['problem']['icon'] ); ?></div>
					<h3><?php echo esc_html( $jd_s['problem']['h'] ); ?></h3>
					<p><?php echo esc_html( $jd_s['problem']['p'] ); ?></p>
					<p><a href="<?php echo esc_url( '/services/' . $jd_slug . '/' ); ?>"><strong><?php echo esc_html( $jd_s['name'] ); ?> &rarr;</strong></a></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/service/steps', null, $jd_o['steps'] );
get_template_part( 'template-parts/service/faq', null, array( 'faqs' => $jd_o['faqs'] ) );
get_template_part(
	'template-parts/service/form',
	null,
	array(
		'h'       => $jd_o['form']['h'],
		'p'       => $jd_o['form']['p'],
		'service' => '',
	)
);
