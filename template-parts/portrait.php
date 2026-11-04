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
 *   mod      The Customizer setting holding the photo. Default jd_portrait.
 *   alt      The photo's alt text. Default Mohsin Jarral.
 *   initials The monogram shown until a photo is uploaded. Default MJ.
 *   hint     What the site owner sees until a photo is uploaded.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

$jd_photo = (int) get_theme_mod( $args['mod'] ?? 'jd_portrait' );
?>
<div class="<?php echo esc_attr( $args['class'] ?? 'who-photo' ); ?>">
	<?php
	if ( $jd_photo ) {
		echo wp_get_attachment_image(
			$jd_photo,
			'jd-portrait',
			false,
			array( 'alt' => $args['alt'] ?? 'Mohsin Jarral', 'loading' => $args['loading'] ?? 'lazy', 'decoding' => 'async' )
		);
	} elseif ( current_user_can( 'edit_theme_options' ) ) {
		// Only the site owner sees the instruction.
		echo '<span>' . esc_html( $args['hint'] ?? 'Add your photo in Customise → Jarral Digital' ) . '</span>';
	} else {
		echo '<span class="who-initials" aria-hidden="true">' . esc_html( $args['initials'] ?? 'MJ' ) . '</span>';
	}
	?>
</div>
