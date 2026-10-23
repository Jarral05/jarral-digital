<?php
/** Exercise the actual WordPress control markup and saved account selection. */
$root = getenv( 'JD_TEST_WP_ROOT' );
if ( ! $root || ! is_file( $root . '/wp-load.php' ) ) {
	fwrite( STDERR, "Set JD_TEST_WP_ROOT to a disposable local WordPress installation.\n" );
	exit( 1 );
}
define( 'WP_ADMIN', true );
$_SERVER['HTTP_HOST'] = '127.0.0.1:8181';
$_SERVER['REQUEST_URI'] = '/wp-admin/post.php';
$_SERVER['PHP_SELF'] = '/wp-admin/post.php';
require $root . '/wp-load.php';
if ( 'local' !== wp_get_environment_type() || '127.0.0.1' !== wp_parse_url( home_url(), PHP_URL_HOST ) ) {
	throw new RuntimeException( 'Tests require the isolated local fixture site.' );
}
require_once ABSPATH . 'wp-admin/includes/admin.php';
wp_set_current_user( 1 );
set_current_screen( 'page' );
require_once ABSPATH . WPINC . '/class-wp-customize-manager.php';
$manager = new WP_Customize_Manager();
jd_customize( $manager );
$control = $manager->get_control( 'jd_author_user' );
$mods = get_theme_mods();
$checks = 0;
function verify_author_control( $condition, $message ) {
	global $checks;
	if ( ! $condition ) {
		throw new RuntimeException( $message );
	}
	++$checks;
}
function author_control_dom( $control ) {
	$dom = new DOMDocument();
	$dom->loadHTML( '<?xml encoding="utf-8" ?>' . $control->get_content() );
	return new DOMXPath( $dom );
}
try {
	remove_theme_mod( 'jd_author_user' );
	$xpath = author_control_dom( $control );
	verify_author_control( 1 === $xpath->query( '//select' )->length, 'Author account must render a real dropdown.' );
	verify_author_control( 0 === $xpath->query( '//input' )->length, 'No free-text account-ID input.' );
	verify_author_control( 1 === $xpath->query( '//option[@value="0"][@selected]' )->length, 'Unconfigured account has an explicit unselected choice.' );
	verify_author_control( 1 === $xpath->query( '//option[@value="1"]' )->length, 'Actual owner account is selectable.' );
	verify_author_control( str_contains( $xpath->query( '//option[@value="1"]' )->item( 0 )->textContent, get_userdata( 1 )->display_name ), 'Account label includes its display name.' );
	verify_author_control( 1 === $xpath->query( '//select[@data-customize-setting-link="jd_author_user"]' )->length, 'Dropdown is bound to the saved setting.' );
	$manager->set_post_value( 'jd_author_user', '1' );
	verify_author_control( false !== $manager->get_setting( 'jd_author_user' )->save(), 'Customizer can save the selected account.' );
	verify_author_control( 1 === get_theme_mod( 'jd_author_user' ), 'Selected account persists as an integer ID.' );
	$xpath = author_control_dom( $control );
	verify_author_control( 1 === $xpath->query( '//option[@value="1"][@selected]' )->length, 'Saved account remains selected.' );
	echo wp_json_encode( array( 'passed' => $checks, 'rank_math_loaded' => defined( 'RANK_MATH_VERSION' ) ) ) . "\n";
} catch ( Throwable $error ) {
	$failure = $error;
} finally {
	update_option( 'theme_mods_' . get_option( 'stylesheet' ), $mods );
}
if ( isset( $failure ) ) {
	fwrite( STDERR, $failure->getMessage() . "\n" );
	exit( 1 );
}
