<?php
/**
 * Jarral Digital - theme bootstrap.
 *
 * Every file this loads lives in /inc. Keeping functions.php almost empty
 * means you always know where to look when something breaks.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit; // Block direct access to this file.

define( 'JD_VERSION', '1.8.3' );
define( 'JD_DIR', get_template_directory() );
define( 'JD_URI', get_template_directory_uri() );

require_once JD_DIR . '/inc/setup.php';
require_once JD_DIR . '/inc/enqueue.php';
require_once JD_DIR . '/inc/security.php';
require_once JD_DIR . '/inc/schema.php';
require_once JD_DIR . '/inc/seo-editor.php';
require_once JD_DIR . '/inc/analytics.php';
require_once JD_DIR . '/inc/template-tags.php';
require_once JD_DIR . '/inc/services.php';
require_once JD_DIR . '/inc/nav-walker.php';
require_once JD_DIR . '/inc/updates.php';
