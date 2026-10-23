<?php
/**
 * Inner page hero: the homepage hero's pine band, cut down to a breadcrumb,
 * a heading, an optional intro and an optional row of facts.
 *
 * Args:
 *   crumbs  Breadcrumb items after Home. See jd_crumbs().
 *   title   The page heading.
 *   lede    Optional intro line.
 *   time    Optional array( ISO date, label ), printed first in the facts row as a <time>.
 *   meta    Optional list of short facts, printed as a dotted row.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

$jd_hero = wp_parse_args(
	$args,
	array(
		'crumbs' => array(),
		'title'  => '',
		'lede'   => '',
		'time'   => '',
		'meta'   => array(),
	)
);
?>

<header class="page-hero">
	<div class="wrap">
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
</header>
