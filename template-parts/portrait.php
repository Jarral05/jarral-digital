<?php
/**
 * The portrait from Customise > Jarral Digital, as the homepage About section
 * and the About page show it. Until one is uploaded, visitors see a monogram
 * and only the site owner sees how to add the photo.
 *
 * Args:
 *   class    The wrapper's class: who-photo on the homepage, about-photo on
 *            the About page.
 *   loading  'lazy' (default) or 'eager' where the photo is near the top.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

$jd_photo = (int) get_theme_mod( 'jd_portrait' );
?>
<div class="<?php echo esc_attr( $args['class'] ?? 'who-photo' ); ?>">
	<?php
	if ( $jd_photo ) {
		echo wp_get_attachment_image(
			$jd_photo,
			'jd-portrait',
			false,
			array( 'alt' => 'Mohsin Jarral', 'loading' => $args['loading'] ?? 'lazy', 'decoding' => 'async' )
		);
	} elseif ( current_user_can( 'edit_theme_options' ) ) {
		// Only the site owner sees the instruction.
		echo '<span>Add your photo in Customise &rarr; Jarral Digital</span>';
	} else {
		echo '<span class="who-initials" aria-hidden="true">MJ</span>';
	}
	?>
</div>
