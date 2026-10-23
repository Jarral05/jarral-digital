<?php
/**
 * Fallback template. WordPress requires this file to exist.
 *
 * In practice it serves the blog, every post archive and search results, so
 * it prints those as a grid of cards under the inner page hero.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

get_header();

$jd_head = jd_archive_heading();
?>

<div class="inner-page">
	<?php
	get_template_part(
		'template-parts/page-hero',
		null,
		array(
			'crumbs' => array( array( $jd_head['crumb'] ) ),
			'title'  => $jd_head['title'],
			'lede'   => $jd_head['desc'],
		)
	);
	?>

	<section class="band">
		<div class="wrap">
			<?php if ( have_posts() ) : ?>
				<div class="post-grid">
					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<article class="post-card">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="post-card-shot"><?php the_post_thumbnail( 'jd-project', array( 'loading' => 'lazy', 'decoding' => 'async' ) ); ?></div>
							<?php else : ?>
								<?php // A blank panel keeps cards in a row the same shape when one post has no image. ?>
								<div class="post-card-shot is-blank" aria-hidden="true"></div>
							<?php endif; ?>
							<div class="post-card-body">
								<p class="post-meta"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></p>
								<?php // The title link covers the whole card; see .post-card h2 a::after. ?>
								<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 26 ) ); ?></p>
								<span class="post-card-more" aria-hidden="true">Read more &rarr;</span>
							</div>
						</article>
					<?php endwhile; ?>
				</div>
				<?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?>
			<?php else : ?>
				<div class="empty-note">
					<p>Nothing here yet. Try the <a href="<?php echo esc_url( home_url( '/' ) ); ?>">homepage</a>, or <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">tell me what you were looking for</a>.</p>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<?php get_template_part( 'template-parts/cta-band' ); ?>
</div>

<?php
get_footer();
