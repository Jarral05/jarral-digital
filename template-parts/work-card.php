<?php
/**
 * One project card, for use inside the loop. The homepage work section and
 * the /work/ archive both print this, so the two can never drift apart.
 *
 * The title links to the project's own page only when that page has
 * something on it. An empty case study is a dead end.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

$jd_slugs = wp_get_post_terms( get_the_ID(), 'jd_service_type', array( 'fields' => 'slugs' ) );
$jd_slugs = is_wp_error( $jd_slugs ) ? array() : $jd_slugs;
$jd_type  = get_post_meta( get_the_ID(), '_jd_client_type', true );
$jd_url   = get_post_meta( get_the_ID(), '_jd_live_url', true );
$jd_story = '' !== trim( (string) get_the_content() );
?>
<article class="work-card" data-tags="<?php echo esc_attr( implode( ' ', $jd_slugs ) ); ?>">

	<div class="work-shot">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'jd-project', array( 'loading' => 'lazy', 'decoding' => 'async' ) );
		}
		?>
	</div>

	<div class="work-body">
		<?php if ( $jd_type ) : ?>
			<div class="work-type"><?php echo esc_html( $jd_type ); ?></div>
		<?php endif; ?>

		<?php if ( $jd_story ) : ?>
			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php else : ?>
			<h3><?php the_title(); ?></h3>
		<?php endif; ?>
		<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 34 ) ); ?></p>

		<?php if ( $jd_url ) : ?>
			<a class="work-link" href="<?php echo esc_url( $jd_url ); ?>" rel="noopener nofollow" target="_blank">View the site<span aria-hidden="true"> &#8599;</span></a>
		<?php endif; ?>
	</div>
</article>
