<?php
/**
 * Theme support and menus.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

/**
 * Tell WordPress which features this theme supports.
 */
function jd_setup() {

	// Load translations. Needed for the __() calls throughout the theme.
	load_theme_textdomain( 'jarral-digital', JD_DIR . '/languages' );

	// Let WordPress manage the <title> tag.
	add_theme_support( 'title-tag' );

	// Enable featured images (used for project screenshots).
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'jd-project', 1200, 750, true );
	add_image_size( 'jd-portrait', 800, 1000, true );

	// Output clean HTML5 markup instead of WordPress defaults.
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);

	// Let the block editor use the theme palette on blog posts.
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/main.css' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );

	// Menus.
	register_nav_menus(
		array(
			'primary' => __( 'Primary menu', 'jarral-digital' ),
			'footer'  => __( 'Footer menu', 'jarral-digital' ),
		)
	);
}
add_action( 'after_setup_theme', 'jd_setup' );

/**
 * Content width used by embeds.
 */
function jd_content_width() {
	$GLOBALS['content_width'] = 1120;
}
add_action( 'after_setup_theme', 'jd_content_width', 0 );

/**
 * Give pages an Excerpt box. A page's excerpt is the intro line under its
 * heading in the page hero; leave it empty and the hero shows the heading only.
 */
function jd_page_excerpts() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'jd_page_excerpts' );

/**
 * Show every project on /work/ and on the service type pages. The filter
 * buttons work in the browser, so a second page would put projects out of
 * their reach.
 *
 * @param WP_Query $query The query being prepared.
 */
function jd_all_projects( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_post_type_archive( 'jd_project' ) || $query->is_tax( 'jd_service_type' ) ) {
		$query->set( 'posts_per_page', -1 );
	}
}
add_action( 'pre_get_posts', 'jd_all_projects' );

/**
 * One Customizer setting: your portrait on the About section.
 * Everything else is content, and content belongs in the editor.
 */
function jd_customize( $wp_customize ) {

	$wp_customize->add_section(
		'jd_section',
		array(
			'title'    => __( 'Jarral Digital', 'jarral-digital' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'jd_portrait',
		array(
			'default'           => '',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'jd_portrait',
			array(
				'label'       => __( 'Your photo', 'jarral-digital' ),
				'description' => __( 'Shown on the homepage About section. 800 x 1000 works best.', 'jarral-digital' ),
				'section'     => 'jd_section',
				'mime_type'   => 'image',
			)
		)
	);
}
add_action( 'customize_register', 'jd_customize' );
