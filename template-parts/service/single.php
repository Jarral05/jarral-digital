<?php
/**
 * One service page, e.g. /services/wordpress-development/, drawn from its
 * entry in jd_service_catalog(). Args: service.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

$jd_s = $args['service'];

get_template_part(
	'template-parts/service/hero',
	null,
	array(
		'eyebrow' => $jd_s['hero']['eyebrow'],
		'title'   => $jd_s['hero']['title'],
		'lede'    => $jd_s['hero']['lede'],
		'price'   => 'From $' . number_format( $jd_s['from'] ),
		'note'    => $jd_s['hero']['note'],
		'time'    => $jd_s['hero']['time'],
		'more'    => array( 'What is included', '#details' ),
	)
);
?>

<section class="band" id="details">
	<div class="wrap">
		<div class="cols">
			<div class="prose">
				<h2>What this covers</h2>
				<p><?php echo esc_html( $jd_s['covers'] ); ?></p>
				<ul>
					<?php foreach ( $jd_s['includes'] as $jd_item ) : ?>
						<li><?php echo esc_html( $jd_item ); ?></li>
					<?php endforeach; ?>
				</ul>
				<h2>Who it is for</h2>
				<p><?php echo esc_html( $jd_s['for'] ); ?></p>
				<h2>Not the right fit if</h2>
				<p><?php echo esc_html( $jd_s['not_for'] ); ?></p>
			</div>
			<?php get_template_part( 'template-parts/service/factcard', null, array( 'facts' => array( 'Price' => jd_service_price( $jd_s ) ) + $jd_s['facts'] ) ); ?>
		</div>
	</div>
</section>

<section class="band band-tint">
	<div class="wrap">
		<div class="sec-head">
			<h2>What you get</h2>
			<p><?php echo esc_html( $jd_s['gets']['p'] ); ?></p>
		</div>
		<div class="gets">
			<?php foreach ( $jd_s['gets']['items'] as $jd_get ) : ?>
				<div class="get">
					<div class="get-ico"><?php jd_icon( $jd_get['icon'] ); ?></div>
					<h3><?php echo esc_html( $jd_get['h'] ); ?></h3>
					<p><?php echo esc_html( $jd_get['p'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/service/steps', null, $jd_s['steps'] );
get_template_part( 'template-parts/service/faq', null, array( 'faqs' => $jd_s['faqs'] ) );
get_template_part(
	'template-parts/service/form',
	null,
	array(
		'h'       => $jd_s['form']['h'],
		'p'       => $jd_s['form']['p'],
		'service' => $jd_s['name'],
	)
);
