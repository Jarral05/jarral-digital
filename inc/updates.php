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

	$checker = $factory::buildUpdateChecker(
		'https://github.com/Jarral05/jarral-digital/',
		JD_DIR . '/style.css',
		'jarral-digital'
	);

	// Use the zip attached to a GitHub release rather than the auto-generated
	// source zip (falling back to the source zip if a release has none). This
	// only changes which file is downloaded, not which version is offered.
	$api = $checker->getVcsApi();
	if ( $api && method_exists( $api, 'enableReleaseAssets' ) ) {
		$api->enableReleaseAssets();
	}

	// The library tries the latest release, then the latest tag, then falls
	// back to the branch. Dropping the branch step means only releases and
	// tags are ever offered, so untagged work never reaches client sites.
	// Themes get "_theme" in the filter name; plugins do not.
	add_filter(
		'puc_vcs_update_detection_strategies_theme-jarral-digital',
		static function ( $strategies ) {
			unset( $strategies['branch'] );
			return $strategies;
		}
	);
}
add_action( 'init', 'jd_updates' );
