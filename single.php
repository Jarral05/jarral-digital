<?php
/**
 * Single blog post. This is where your SEO articles live.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article class="band">
		<div class="wrap">
			<div class="sec-head">
				<h1><?php the_title(); ?></h1>
				<p class="post-meta">
					<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
					&middot; <?php echo esc_html( jd_reading_time() ); ?>
				</p>
			</div>

			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="post-hero"><?php the_post_thumbnail( 'large' ); ?></figure>
			<?php endif; ?>

			<div class="prose"><?php the_content(); ?></div>
		</div>
	</article>

	<section class="band band-dark">
		<div class="wrap">
			<div class="sec-head">
				<h2>Need this built properly?</h2>
				<p>Describe the problem and I will reply within twelve hours with scope and a price.</p>
			</div>
			<a class="btn btn-invert" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Start a project</a>
		</div>
	</section>
	<?php
endwhile;

get_footer();
