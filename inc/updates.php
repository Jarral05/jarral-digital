<?php
/**
 * Theme updates from GitHub.
 *
 * A custom theme receives nothing from wordpress.org. This connects the normal
 * WordPress update screen to your own repository instead, so a site you built
 * two years ago still tells you when the theme has moved on.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the theme update checker.
 */
function jd_updates() {

	$lib = JD_DIR . '/lib/plugin-update-checker/plugin-update-checker.php';

	if ( ! file_exists( $lib ) ) {
		return;
	}

	require_once $lib;

	$factory = '\\YahnisElsts\\PluginUpdateChecker\\v5\\PucFactory';

	if ( ! class_exists( $factory ) ) {
		return;
	}

	$factory::buildUpdateChecker(
		'https://github.com/Jarral05/jarral-digital/',
		JD_DIR . '/style.css',
		'jarral-digital'
	);
}
add_action( 'init', 'jd_updates' );
