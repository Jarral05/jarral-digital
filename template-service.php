<?php
/**
 * Template Name: Service page
 *
 * Prints the page content with no wrapper, because the section patterns in
 * inc/patterns.php bring their own full-width bands. page.php already does
 * this for any page that contains one of those sections; pick this template
 * to force it on a page the check misses.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	the_content();
endwhile;

get_footer();
