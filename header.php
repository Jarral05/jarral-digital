<?php
/**
 * Site header.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="jd-skip" href="#main">Skip to content</a>

<nav class="nav" aria-label="<?php esc_attr_e( 'Primary', 'jarral-digital' ); ?>">
	<div class="wrap nav-in">

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
			<?php jd_icon( 'logo-mark-light' ); ?>
			<span><?php bloginfo( 'name' ); ?></span>
		</a>

		<div class="nav-links">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'nav-list',
					'depth'          => 2,          // depth 2 is what allows the mega panel
					// Falls back to WordPress's own renderer if the walker is absent,
					// so the navigation degrades to a plain menu rather than vanishing.
					'walker'         => class_exists( 'JD_Mega_Walker' ) ? new JD_Mega_Walker() : '',
					'fallback_cb'    => false,
				)
			);
			?>
			<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-invert btn-sm">Start a project</a>
		</div>

		<button class="burger" id="burger" aria-expanded="false" aria-controls="drawer">Menu</button>
	</div>

	<div class="drawer" id="drawer">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'drawer-list',
				'depth'          => 2,
				// Same walker as the desktop menu, so the drawer markup matches the
				// CSS and JS that style and expand it. Without this the drawer got
				// WordPress's default .sub-menu markup, which nothing targeted.
				'walker'         => class_exists( 'JD_Mega_Walker' ) ? new JD_Mega_Walker() : '',
				'fallback_cb'    => false,
			)
		);
		?>

		<?php
		/*
		 * The same call to action as the desktop header.
		 *
		 * It has to be repeated here rather than shared, because the desktop
		 * copy lives inside .nav-links, and .nav-links is display:none below
		 * 1024px. That is the whole reason the button was missing on phones:
		 * it was never hidden deliberately, it was hidden as a side effect.
		 */
		?>
		<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-invert drawer-cta">
			<?php esc_html_e( 'Start a project', 'jarral-digital' ); ?>
		</a>

		<p class="drawer-meta">
			<?php esc_html_e( 'Replies within 12 hours', 'jarral-digital' ); ?><br>
			<a href="mailto:<?php echo esc_attr( jd_contact_email() ); ?>"><?php echo esc_html( jd_contact_email() ); ?></a>
		</p>
	</div>
</nav>

<main id="main">
