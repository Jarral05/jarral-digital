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
		<?php else : ?>
			<?php get_template_part( 'template-parts/work-empty' ); ?>
		<?php endif; ?>
	</div>
</section>
