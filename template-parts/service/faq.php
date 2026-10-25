<?php
/**
 * Questions on a service page, first one open. Args: faqs (array of q/a).
 * The same list feeds the page's FAQPage schema in inc/schema.php.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="band" id="faq">
	<div class="wrap">
		<div class="sec-head"><h2>Questions</h2></div>
		<div class="faq">
			<?php foreach ( $args['faqs'] as $jd_i => $jd_faq ) : ?>
				<details<?php echo 0 === $jd_i ? ' open' : ''; ?>>
					<summary><?php echo esc_html( $jd_faq['q'] ); ?></summary>
					<p><?php echo esc_html( $jd_faq['a'] ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
