<?php
/**
 * Fallback template. WordPress requires this file to exist.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<section class="band">
	<div class="wrap">
		<div class="sec-head">
			<h1><?php echo esc_html( get_the_archive_title() ? wp_strip_all_tags( get_the_archive_title() ) : get_bloginfo( 'name' ) ); ?></h1>
		</div>

		<?php if ( have_posts() ) : ?>
			<div class="post-list">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article class="post-row">
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p class="post-meta"><?php echo esc_html( get_the_date() ); ?></p>
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 32 ) ); ?></p>
					</article>
				<?php endwhile; ?>
			</div>
			<?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?>
		<?php else : ?>
			<p>Nothing here yet.</p>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
