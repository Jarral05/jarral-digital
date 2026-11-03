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
		// This section says these are builds for firms, and demo apps are not.
		// They stay on /work/, under their own filter.
		'tax_query'      => array(
			array(
				'taxonomy' => 'jd_service_type',
				'field'    => 'slug',
				'terms'    => 'demo-apps',
				'operator' => 'NOT IN',
			),
		),
	)
);

// Only the types among the cards shown. A button for any other type would
// empty the grid, and 'include' with no IDs would list every type.
$jd_term_ids = array();
foreach ( $jd_projects->posts as $jd_project ) {
	$jd_ids      = wp_get_post_terms( $jd_project->ID, 'jd_service_type', array( 'fields' => 'ids' ) );
	$jd_term_ids = is_wp_error( $jd_ids ) ? $jd_term_ids : array_merge( $jd_term_ids, $jd_ids );
}

$jd_terms = $jd_term_ids ? get_terms(
	array(
		'taxonomy'   => 'jd_service_type',
		'include'    => array_unique( $jd_term_ids ),
		'hide_empty' => true,
	)
) : array();

$jd_has_more = (int) wp_count_posts( 'jd_project' )->publish > $jd_projects->post_count;
?>

<section class="band" id="work">
	<div class="wrap">
		<div class="sec-head">
			<div class="sec-title">
				<p class="eyebrow">Work</p>
				<h2>Recent projects</h2>
			</div>
			<p>A selection of recent builds for professional services firms.</p>
		</div>

		<?php if ( ! is_wp_error( $jd_terms ) && ! empty( $jd_terms ) ) : ?>
			<div class="filters" id="filters" role="group" aria-label="Filter projects">
				<button type="button" class="filter" data-f="all" aria-pressed="true">All</button>
				<?php foreach ( $jd_terms as $t ) : ?>
					<button type="button" class="filter" data-f="<?php echo esc_attr( $t->slug ); ?>" aria-pressed="false"><?php echo esc_html( $t->name ); ?></button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( $jd_projects->have_posts() ) : ?>
			<?php
			// Below 768px the grid becomes a swipe row. tabindex lets a keyboard
			// scroll it too, since cards without a live link have nothing to focus.
			?>
			<div class="work" id="workGrid" role="region" aria-label="Projects" tabindex="0">
				<?php
				while ( $jd_projects->have_posts() ) :
					$jd_projects->the_post();
					get_template_part( 'template-parts/work-card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>

			<?php if ( $jd_has_more ) : ?>
				<p class="work-more">
					<a class="btn btn-solid" href="<?php echo esc_url( get_post_type_archive_link( 'jd_project' ) ); ?>"><?php esc_html_e( 'View all projects', 'jarral-digital' ); ?><span aria-hidden="true"> &rarr;</span></a>
				</p>
			<?php endif; ?>
		<?php else : ?>
			<?php get_template_part( 'template-parts/work-empty' ); ?>
		<?php endif; ?>
	</div>
</section>
