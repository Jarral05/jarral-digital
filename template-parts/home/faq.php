<?php
/**
 * Homepage: FAQ. Uses native details/summary, which needs no JavaScript at all.
 *
 * The intro column gives anyone whose question is missing a direct route to
 * an answer, and fills the width the list alone left empty.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="band" id="faq">
	<div class="wrap faq-cols">
		<div class="faq-intro">
			<p class="eyebrow">FAQ</p>
			<h2>Questions</h2>
			<p>Something not covered here? Ask in the <a href="#contact">form below</a> or email <a href="mailto:<?php echo esc_attr( jd_contact_email() ); ?>"><?php echo esc_html( jd_contact_email() ); ?></a>. You will have a reply within twelve hours.</p>
		</div>

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
