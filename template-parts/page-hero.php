<?php
/**
 * Inner page hero: the homepage hero's pine band, cut down to a breadcrumb,
 * a heading, an optional intro and an optional row of facts.
 *
 * Args:
 *   crumbs    Breadcrumb items after Home. See jd_crumbs().
 *   title     The page heading.
 *   lede      Optional intro line.
 *   time      Optional array( ISO date, label ), printed first in the facts row as a <time>.
 *   meta      Optional list of short facts, printed as a dotted row.
 *   portrait  Optional attachment ID. Printed beside the heading from 768px,
 *             as a small square above it on phones.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

$jd_hero = wp_parse_args(
	$args,
	array(
		'crumbs'   => array(),
		'title'    => '',
		'lede'     => '',
		'time'     => '',
		'meta'     => array(),
		'portrait' => 0,
	)
);
?>

<header class="page-hero<?php echo $jd_hero['portrait'] ? ' has-portrait' : ''; ?>">
	<div class="wrap page-hero-in">
		<div class="page-hero-copy">
			<?php jd_crumbs( $jd_hero['crumbs'] ); ?>
			<h1><?php echo esc_html( $jd_hero['title'] ); ?></h1>

			<?php if ( $jd_hero['lede'] ) : ?>
				<p class="lede"><?php echo esc_html( $jd_hero['lede'] ); ?></p>
			<?php endif; ?>

			<?php if ( $jd_hero['time'] || $jd_hero['meta'] ) : ?>
				<ul class="page-meta">
					<?php if ( $jd_hero['time'] ) : ?>
						<li><time datetime="<?php echo esc_attr( $jd_hero['time'][0] ); ?>"><?php echo esc_html( $jd_hero['time'][1] ); ?></time></li>
					<?php endif; ?>
					<?php foreach ( $jd_hero['meta'] as $jd_fact ) : ?>
						<li><?php echo esc_html( $jd_fact ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		<?php if ( $jd_hero['portrait'] ) : ?>
			<figure class="page-hero-portrait">
				<?php
				echo wp_get_attachment_image(
					(int) $jd_hero['portrait'],
					'jd-portrait',
					false,
					array( 'alt' => 'Mohsin Jarral', 'decoding' => 'async' )
				);
				?>
			</figure>
		<?php endif; ?>
	</div>
</header>
