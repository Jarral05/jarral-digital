<?php
/**
 * Block patterns for service pages.
 *
 * Each pattern is one Custom HTML block rather than a stack of core blocks.
 * Core blocks add their own wrappers and class names, and main.css styles
 * these sections by exact class (.svc-hero, .cols, .factcard, .gets, .steps),
 * so the markup has to reach the page untouched. All text is placeholder
 * copy, meant to be replaced in the editor.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the Jarral Digital pattern category and the service page patterns.
 */
function jd_register_patterns() {

	register_block_pattern_category(
		'jarral',
		array( 'label' => __( 'Jarral Digital', 'jarral-digital' ) )
	);

	register_block_pattern(
		'jarral/service-hero',
		array(
			'title'       => __( 'Service: hero', 'jarral-digital' ),
			'description' => __( 'Pine band with eyebrow, heading, intro, price, timeline and two buttons.', 'jarral-digital' ),
			'categories'  => array( 'jarral' ),
			'blockTypes'  => array( 'core/html' ),
			'content'     => jd_pattern_service_hero(),
		)
	);

	register_block_pattern(
		'jarral/service-two-col',
		array(
			'title'       => __( 'Service: details and fact card', 'jarral-digital' ),
			'description' => __( 'Body copy beside a sticky card of key facts and a quote button.', 'jarral-digital' ),
			'categories'  => array( 'jarral' ),
			'blockTypes'  => array( 'core/html' ),
			'content'     => jd_pattern_service_two_col(),
		)
	);

	register_block_pattern(
		'jarral/service-gets',
		array(
			'title'       => __( 'Service: what you get', 'jarral-digital' ),
			'description' => __( 'Tinted band with a grid of six deliverable cards.', 'jarral-digital' ),
			'categories'  => array( 'jarral' ),
			'blockTypes'  => array( 'core/html' ),
			'content'     => jd_pattern_service_gets(),
		)
	);

	register_block_pattern(
		'jarral/service-steps',
		array(
			'title'       => __( 'Service: steps', 'jarral-digital' ),
			'description' => __( 'Four numbered steps.', 'jarral-digital' ),
			'categories'  => array( 'jarral' ),
			'blockTypes'  => array( 'core/html' ),
			'content'     => jd_pattern_service_steps(),
		)
	);

	register_block_pattern(
		'jarral/service-form',
		array(
			'title'       => __( 'Service: enquiry form', 'jarral-digital' ),
			'description' => __( 'Dark band with the Jarral Forms contact form, tagged with the service.', 'jarral-digital' ),
			'categories'  => array( 'jarral' ),
			'blockTypes'  => array( 'core/shortcode' ),
			'content'     => "<!-- wp:shortcode -->\n" .
				'[jarral_contact_form heading="Section heading" intro="One sentence inviting the visitor to get in touch." service="Service name" style="dark"]' .
				"\n<!-- /wp:shortcode -->",
		)
	);
}
add_action( 'init', 'jd_register_patterns' );

/**
 * Pine hero band: eyebrow, heading, intro, price, timeline and two buttons.
 *
 * The primary button links to #contact, the id the enquiry form shortcode
 * uses by default. The secondary one links to the details section below.
 *
 * @return string
 */
function jd_pattern_service_hero() {
	ob_start();
	?>
	<!-- wp:html -->
	<section class="svc-hero">
		<div class="wrap">
			<p class="svc-eyebrow">Service category</p>
			<h1>Service name in a few words</h1>
			<p class="lede">One or two sentences on who this service is for and the problem it solves.</p>
			<div class="svc-hero-meta">
				<div class="svc-hero-price">From $000 <span>fixed price</span></div>
				<div class="svc-hero-time">Typical timeline: 0 to 0 weeks</div>
			</div>
			<div class="svc-hero-actions">
				<a class="btn btn-invert" href="#contact">Primary button</a>
				<a class="btn btn-ghost-light" href="#details">Secondary button</a>
			</div>
		</div>
	</section>
	<!-- /wp:html -->
	<?php
	return trim( (string) ob_get_clean() );
}

/**
 * Body copy beside a sticky fact card.
 *
 * Each .factrow is a <div> inside the <dl>, because .factrow:last-of-type
 * matches the last <div> in its parent, not the last .factrow.
 *
 * @return string
 */
function jd_pattern_service_two_col() {
	ob_start();
	?>
	<!-- wp:html -->
	<section class="band" id="details">
		<div class="wrap">
			<div class="cols">
				<div class="prose">
					<h2>What this service covers</h2>
					<p>An opening paragraph that explains the service in plain terms.</p>
					<ul>
						<li>First thing that is included</li>
						<li>Second thing that is included</li>
						<li>Third thing that is included</li>
					</ul>
					<h2>Who it is for</h2>
					<p>A paragraph on the kind of client this suits, and when it is not the right fit.</p>
				</div>
				<aside class="factcard">
					<h2>At a glance</h2>
					<dl>
						<div class="factrow"><dt>Price</dt><dd>From $000</dd></div>
						<div class="factrow"><dt>Timeline</dt><dd>0 to 0 weeks</dd></div>
						<div class="factrow"><dt>Fact label</dt><dd>Fact value</dd></div>
						<div class="factrow"><dt>Fact label</dt><dd>Fact value</dd></div>
					</dl>
					<a class="btn btn-solid" href="#contact">Get a quote</a>
				</aside>
			</div>
		</div>
	</section>
	<!-- /wp:html -->
	<?php
	return trim( (string) ob_get_clean() );
}

/**
 * Tinted band with six deliverable cards.
 *
 * The six service icons stand in as placeholders. They are pasted in as
 * inline SVG, so swap or delete them in the block's HTML.
 *
 * @return string
 */
function jd_pattern_service_gets() {
	$icons = array( 'wordpress', 'webapps', 'forms', 'portals', 'ai', 'care' );

	ob_start();
	?>
	<!-- wp:html -->
	<section class="band band-tint">
		<div class="wrap">
			<div class="sec-head">
				<h2>What you get</h2>
				<p>One sentence introducing the deliverables below.</p>
			</div>
			<div class="gets">
				<?php foreach ( $icons as $i => $icon ) : ?>
				<div class="get">
					<div class="get-ico"><?php jd_icon( 'icon-' . $icon ); ?></div>
					<h3>Deliverable <?php echo esc_html( (string) ( $i + 1 ) ); ?></h3>
					<p>One or two sentences on what this is and why it matters.</p>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<!-- /wp:html -->
	<?php
	return trim( (string) ob_get_clean() );
}

/**
 * Four numbered steps, same markup as the homepage process section.
 *
 * @return string
 */
function jd_pattern_service_steps() {
	ob_start();
	?>
	<!-- wp:html -->
	<section class="band">
		<div class="wrap">
			<div class="sec-head">
				<h2>How it works</h2>
				<p>One sentence on what the client can expect from start to finish.</p>
			</div>
			<ol class="steps">
				<?php for ( $n = 1; $n <= 4; $n++ ) : ?>
				<li class="step">
					<span class="step-n"><?php echo esc_html( str_pad( (string) $n, 2, '0', STR_PAD_LEFT ) ); ?></span>
					<div>
						<h3>Step heading</h3>
						<p>What happens at this stage and what the client needs to do.</p>
					</div>
				</li>
				<?php endfor; ?>
			</ol>
		</div>
	</section>
	<!-- /wp:html -->
	<?php
	return trim( (string) ob_get_clean() );
}
