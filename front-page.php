<?php
/**
 * Homepage.
 *
 * Each section is its own file in /template-parts/home/ so you can edit one
 * without scrolling past the other nine.
 *
 * .homepage scopes the homepage's own spacing and layouts. The service pages
 * reuse .band, .sec-head, .steps and .faq, and keep their own look.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="homepage">
	<?php
	get_template_part( 'template-parts/home/hero' );
	get_template_part( 'template-parts/home/problem' );
	get_template_part( 'template-parts/home/services' );
	get_template_part( 'template-parts/home/estimator' );
	get_template_part( 'template-parts/home/work' );
	get_template_part( 'template-parts/home/results' );
	get_template_part( 'template-parts/home/process' );
	get_template_part( 'template-parts/home/about' );
	get_template_part( 'template-parts/home/faq' );
	get_template_part( 'template-parts/home/contact' );
	?>
</div>

<?php
get_footer();
