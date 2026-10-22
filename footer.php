<?php
/**
 * Site footer.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;
?>
</main>

<footer class="foot">
	<div class="wrap">
		<div class="foot-cols">

			<div>
				<h4><?php bloginfo( 'name' ); ?></h4>
				<p>Mohsin Jarral. Custom WordPress, web applications and automation for professional services firms.</p>
			</div>

			<div>
				<h4>Services</h4>
				<ul>
				<?php foreach ( jd_get_services() as $s ) : ?>
					<li><a href="<?php echo esc_url( $s['url'] ); ?>"><?php echo esc_html( $s['name'] ); ?></a></li>
				<?php endforeach; ?>
				</ul>
			</div>

			<div>
				<h4>Company</h4>
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

			<div>
				<h4>Contact</h4>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Start a project</a></li>
					<li><a href="mailto:hello@jarraldigital.com">hello@jarraldigital.com</a></li>
				</ul>
			</div>

		</div>

		<div class="foot-base">
			&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
