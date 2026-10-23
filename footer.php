<?php
/**
 * Site footer.
 *
 * The line under the name is the site Tagline (Settings > General), so it can
 * change without a theme release.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

$jd_tagline = get_bloginfo( 'description' );
$jd_legal   = has_nav_menu( 'legal' ) ? array() : jd_legal_pages();
$jd_sitemap = jd_published_page( 'sitemap' );
?>
</main>

<footer class="foot">
	<div class="wrap">
		<div class="foot-cols">

			<div class="foot-brand">
				<a class="foot-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php jd_icon( 'logo-mark-light' ); ?>
					<span class="foot-name">
						<?php bloginfo( 'name' ); ?>
						<?php if ( $jd_tagline ) : ?>
							<span class="foot-tag"><?php echo esc_html( $jd_tagline ); ?></span>
						<?php endif; ?>
					</span>
				</a>
				<p>An independent developer building websites, client portals and automation for professional services firms across the US, UK, Europe and the Gulf. You work with me directly, from the first message to launch.</p>
				<p class="foot-contact">
					<a href="mailto:<?php echo esc_attr( jd_contact_email() ); ?>"><?php echo esc_html( jd_contact_email() ); ?></a>
					<span>Replies within 12 hours</span>
				</p>
			</div>

			<div class="foot-services">
				<h2 class="foot-h">Services</h2>
				<ul>
				<?php foreach ( jd_get_services() as $s ) : ?>
					<li><a href="<?php echo esc_url( $s['url'] ); ?>"><?php echo esc_html( $s['name'] ); ?></a></li>
				<?php endforeach; ?>
				</ul>
			</div>

			<div>
				<h2 class="foot-h">Company</h2>
				<?php
				/*
				 * If no Footer menu has been assigned yet this column would render
				 * as a heading with nothing under it, which looks like a fault.
				 * Fall back to the pages the theme already knows exist.
				 */
				if ( has_nav_menu( 'footer' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'container'      => false,
							'menu_class'     => '',
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
				} else {
					$jd_fallback = array(
						'/work/'    => __( 'Work', 'jarral-digital' ),
						'/process/' => __( 'Process', 'jarral-digital' ),
						'/about/'   => __( 'About', 'jarral-digital' ),
						'/contact/' => __( 'Contact', 'jarral-digital' ),
					);
					echo '<ul>';
					foreach ( $jd_fallback as $jd_path => $jd_label ) {
						printf(
							'<li><a href="%1$s">%2$s</a></li>',
							esc_url( home_url( $jd_path ) ),
							esc_html( $jd_label )
						);
					}
					echo '</ul>';
				}
				?>
			</div>

			<?php if ( has_nav_menu( 'legal' ) || $jd_legal || $jd_sitemap ) : ?>
				<div>
					<h2 class="foot-h">Legal</h2>
					<?php if ( has_nav_menu( 'legal' ) ) : ?>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'legal',
								'container'      => false,
								'menu_class'     => '',
								'depth'          => 1,
								'fallback_cb'    => false,
							)
						);
						?>
					<?php else : ?>
						<ul>
							<?php foreach ( $jd_legal as $jd_page ) : ?>
								<li><a href="<?php echo esc_url( get_permalink( $jd_page ) ); ?>"><?php echo esc_html( get_the_title( $jd_page ) ); ?></a></li>
							<?php endforeach; ?>
							<?php if ( $jd_sitemap ) : ?>
								<li><a href="<?php echo esc_url( get_permalink( $jd_sitemap ) ); ?>"><?php echo esc_html( get_the_title( $jd_sitemap ) ); ?></a></li>
							<?php endif; ?>
						</ul>
					<?php endif; ?>
				</div>
			<?php endif; ?>

		</div>

		<div class="foot-base">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</p>
			<p>Based in Pakistan. Working across US, UK, European and Gulf time zones.</p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
