<?php
/**
 * Homepage: FAQ. Uses native details/summary, which needs no JavaScript at all.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="band" id="faq">
	<div class="wrap">
		<div class="sec-head"><h2>Questions</h2></div>

		<div class="faq">
			<?php foreach ( jd_get_faqs() as $i => $faq ) : ?>
				<details<?php echo 0 === $i ? ' open' : ''; ?>>
					<summary><?php echo esc_html( $faq['q'] ); ?></summary>
					<p><?php echo esc_html( $faq['a'] ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
