<?php
/**
 * /work/: every project, and (through taxonomy-jd_service_type.php) the
 * projects of one service type. Same cards and filter as the homepage.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

get_header();

$jd_is_type = is_tax( 'jd_service_type' );
$jd_terms   = $jd_is_type ? array() : get_terms(
	array(
		'taxonomy'   => 'jd_service_type',
		'hide_empty' => true,
	)
);
?>

<div class="inner-page">
	<?php
	get_template_part(
		'template-parts/page-hero',
		null,
		array(
			'crumbs' => $jd_is_type
				? array( array( __( 'Work', 'jarral-digital' ), get_post_type_archive_link( 'jd_project' ) ), array( single_term_title( '', false ) ) )
				: array( array( __( 'Work', 'jarral-digital' ) ) ),
			'title'  => $jd_is_type ? single_term_title( '', false ) : __( 'Recent projects', 'jarral-digital' ),
			'lede'   => $jd_is_type ? wp_strip_all_tags( term_description() ) : __( 'Websites, portals and automation built for professional services firms across the US, UK, Europe and the Gulf.', 'jarral-digital' ),
		)
	);
	?>

	<section class="band">
		<div class="wrap">
			<?php if ( have_posts() ) : ?>
				<?php if ( ! is_wp_error( $jd_terms ) && ! empty( $jd_terms ) ) : ?>
					<div class="filters" id="filters" role="group" aria-label="Filter projects">
						<button type="button" class="filter" data-f="all" aria-pressed="true">All</button>
						<?php foreach ( $jd_terms as $jd_term ) : ?>
							<button type="button" class="filter" data-f="<?php echo esc_attr( $jd_term->slug ); ?>" aria-pressed="false"><?php echo esc_html( $jd_term->name ); ?></button>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<div class="work" id="workGrid">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/work-card' );
					endwhile;
					?>
				</div>
			<?php else : ?>
				<?php get_template_part( 'template-parts/work-empty' ); ?>
			<?php endif; ?>
		</div>
	</section>

	<?php get_template_part( 'template-parts/cta-band' ); ?>
</div>

<?php
get_footer();
