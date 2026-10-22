<?php
/**
 * Single page.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	if ( jd_is_pattern_page() ) :
		// Built from the section patterns, which bring their own bands and
		// heading. See jd_is_pattern_page() in inc/template-tags.php.
		the_content();
	else :
		?>
		<section class="band">
			<div class="wrap">
				<div class="sec-head"><h1><?php the_title(); ?></h1></div>
				<div class="prose"><?php the_content(); ?></div>
			</div>
		</section>
		<?php
	endif;
endwhile;

get_footer();
