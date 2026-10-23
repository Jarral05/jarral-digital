<?php
/**
 * The body of a page or post: the content, and beside it from 1024px an
 * "On this page" list of its headings.
 *
 * Args:
 *   doc    The result of jd_prepare_content().
 *   image  True to print the featured image above the content.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

$jd_doc = $args['doc'];

// Three headings is where a list of them starts to save scrolling.
$jd_toc = count( $jd_doc['toc'] ) >= 3 ? $jd_doc['toc'] : array();
?>

<section class="band">
	<div class="wrap">
		<?php if ( ! empty( $args['image'] ) && has_post_thumbnail() ) : ?>
			<figure class="doc-figure"><?php the_post_thumbnail( 'large' ); ?></figure>
		<?php endif; ?>

		<div class="doc<?php echo $jd_toc ? ' has-toc' : ''; ?>">
			<?php if ( $jd_toc ) : ?>
				<nav class="toc" aria-label="<?php esc_attr_e( 'On this page', 'jarral-digital' ); ?>">
					<p class="eyebrow"><?php esc_html_e( 'On this page', 'jarral-digital' ); ?></p>
					<ol>
						<?php foreach ( $jd_toc as $jd_id => $jd_text ) : ?>
							<li><a href="#<?php echo esc_attr( $jd_id ); ?>"><?php echo esc_html( $jd_text ); ?></a></li>
						<?php endforeach; ?>
					</ol>
				</nav>
			<?php endif; ?>

			<div class="prose">
				<?php echo $jd_doc['html']; // phpcs:ignore WordPress.Security.EscapeOutput -- the_content output, as the_content() prints it. ?>
			</div>
		</div>
	</div>
</section>
