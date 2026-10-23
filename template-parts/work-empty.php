<?php
/**
 * What the work grid shows before any project is published.
 *
 * Visitors get a way forward. The admin reminder is printed only for people
 * who can add projects; it used to be shown to every visitor.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="empty-note">
	<p>Case studies are being written up. Ask for examples close to what you are building and I will send them over: <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">get in touch</a>.</p>
	<?php if ( current_user_can( 'edit_posts' ) ) : ?>
		<p class="empty-admin">Only you can see this: add a project under Projects in the admin menu and it appears here.</p>
	<?php endif; ?>
</div>
