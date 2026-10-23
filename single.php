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

	// The crumb back to the blog only exists if a Posts page is set.
	$jd_blog = (int) get_option( 'page_for_posts' );
	$jd_updated = get_post_modified_time( 'U', true ) > get_post_time( 'U', true );
	?>
	<div class="inner-page">
		<article>
			<?php
			get_template_part(
				'template-parts/page-hero',
				null,
				array(
					'crumbs' => $jd_blog ? array( array( get_the_title( $jd_blog ), get_permalink( $jd_blog ) ) ) : array(),
					'title'  => get_the_title(),
					'lede'   => has_excerpt() ? get_the_excerpt() : '',
					'time'   => array( get_the_date( 'c' ), get_the_date() ),
					'updated' => $jd_updated ? array( get_the_modified_date( 'c' ), get_the_modified_date() ) : '',
					'meta'   => array( jd_reading_time() ),
				)
			);
			get_template_part(
				'template-parts/doc',
				null,
				array(
					'doc'   => jd_prepare_content( get_the_content() ),
					'image' => true,
				)
			);
			get_template_part( 'template-parts/post-author' );
			?>
		</article>
		<?php get_template_part( 'template-parts/cta-band' ); ?>
	</div>
	<?php
endwhile;

get_footer();
