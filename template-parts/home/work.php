<?php
/**
 * Homepage: filterable project grid, driven by the jd_project post type.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;
?>

<?php
$jd_projects = new WP_Query(
	array(
		'post_type'      => 'jd_project',
		'posts_per_page' => 6,
		'no_found_rows'  => true,
	)
);

$jd_terms = get_terms(
	array(
		'taxonomy'   => 'jd_service_type',
		'hide_empty' => true,
	)
);
?>

<section class="band" id="work">
	<div class="wrap">
		<div class="sec-head"><h2>Recent projects</h2></div>

		<?php if ( ! is_wp_error( $jd_terms ) && ! empty( $jd_terms ) ) : ?>
			<div class="filters" id="filters" role="group" aria-label="Filter projects">
				<button type="button" class="filter" data-f="all" aria-pressed="true">All</button>
				<?php foreach ( $jd_terms as $t ) : ?>
					<button type="button" class="filter" data-f="<?php echo esc_attr( $t->slug ); ?>" aria-pressed="false"><?php echo esc_html( $t->name ); ?></button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="work" id="workGrid">
			<?php
			if ( $jd_projects->have_posts() ) :
				while ( $jd_projects->have_posts() ) :
					$jd_projects->the_post();

					$jd_slugs = wp_get_post_terms( get_the_ID(), 'jd_service_type', array( 'fields' => 'slugs' ) );
					$jd_slugs = is_wp_error( $jd_slugs ) ? array() : $jd_slugs;
					$jd_type  = get_post_meta( get_the_ID(), '_jd_client_type', true );
					$jd_url   = get_post_meta( get_the_ID(), '_jd_live_url', true );
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

							<h3><?php the_title(); ?></h3>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 34 ) ); ?></p>

							<?php if ( $jd_url ) : ?>
								<a class="work-link" href="<?php echo esc_url( $jd_url ); ?>" rel="noopener nofollow" target="_blank">View the site</a>
							<?php endif; ?>
						</div>
					</article>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				echo '<p>Add your first project under Projects in the admin menu.</p>';
			endif;
			?>
		</div>
	</div>
</section>
