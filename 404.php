<?php
/**
 * Not found.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<section class="band">
	<div class="wrap">
		<div class="sec-head">
			<h1>That page does not exist</h1>
			<p>It may have moved. Try the services below, or tell me what you were looking for.</p>
		</div>
		<div class="svc">
			<?php foreach ( jd_get_services() as $s ) : ?>
				<a class="svc-row" href="<?php echo esc_url( $s['url'] ); ?>">
					<span class="svc-ico"><?php jd_icon( 'icon-' . $s['icon'] ); ?></span>
					<div><div class="svc-name"><?php echo esc_html( $s['name'] ); ?></div></div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php
get_footer();
