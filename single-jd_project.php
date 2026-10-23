<?php
/**
 * One project's own page, /work/project-name/. The screenshot, then the
 * write-up beside a card of project facts, in the same shape as the service
 * pages' details section.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	$jd_type  = get_post_meta( get_the_ID(), '_jd_client_type', true );
	$jd_url   = get_post_meta( get_the_ID(), '_jd_live_url', true );
	$jd_terms = get_the_terms( get_the_ID(), 'jd_service_type' );
	$jd_terms = is_array( $jd_terms ) ? wp_list_pluck( $jd_terms, 'name' ) : array();
	?>
	<div class="inner-page">
		<article>
			<?php
			get_template_part(
				'template-parts/page-hero',
				null,
				array(
					'crumbs' => array( array( __( 'Work', 'jarral-digital' ), get_post_type_archive_link( 'jd_project' ) ) ),
					'title'  => get_the_title(),
					'lede'   => has_excerpt() ? get_the_excerpt() : '',
					'meta'   => array_filter( array_merge( array( $jd_type ), $jd_terms ) ),
				)
			);
			?>

			<section class="band">
				<div class="wrap">
					<?php if ( has_post_thumbnail() ) : ?>
						<figure class="doc-figure"><?php the_post_thumbnail( 'jd-project' ); ?></figure>
					<?php endif; ?>

					<div class="cols">
						<div class="prose">
							<?php the_content(); ?>
						</div>

						<aside class="factcard">
							<h2><?php esc_html_e( 'Project facts', 'jarral-digital' ); ?></h2>
							<dl>
								<?php if ( $jd_type ) : ?>
									<div class="factrow"><dt>Client</dt><dd><?php echo esc_html( $jd_type ); ?></dd></div>
								<?php endif; ?>
								<?php if ( $jd_terms ) : ?>
									<div class="factrow"><dt>Work</dt><dd><?php echo esc_html( implode( ', ', $jd_terms ) ); ?></dd></div>
								<?php endif; ?>
								<?php if ( $jd_url ) : ?>
									<div class="factrow"><dt>Live site</dt><dd><a href="<?php echo esc_url( $jd_url ); ?>" rel="noopener nofollow" target="_blank"><?php echo esc_html( wp_parse_url( $jd_url, PHP_URL_HOST ) ); ?><span aria-hidden="true"> &#8599;</span></a></dd></div>
								<?php endif; ?>
							</dl>
							<a class="btn btn-solid" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Start a similar project</a>
						</aside>
					</div>
				</div>
			</section>
		</article>

		<?php get_template_part( 'template-parts/cta-band' ); ?>
	</div>
	<?php
endwhile;

get_footer();
