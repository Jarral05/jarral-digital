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
	?>
	<section class="band">
		<div class="wrap">
			<div class="sec-head"><h1><?php the_title(); ?></h1></div>
			<div class="prose"><?php the_content(); ?></div>
		</div>
	</section>
	<?php
endwhile;

get_footer();
