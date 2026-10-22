<?php
/**
 * Content arrays and small helpers.
 *
 * Homepage copy lives here rather than hard-coded in the templates, so the
 * page markup and the schema output read from the same source.
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

/**
 * Hero specification rows.
 *
 * @return array<int,array{k:string,v:string}>
 */
function jd_get_spec() {
	return array(
		array( 'k' => 'Projects delivered', 'v' => '120+' ),
		array( 'k' => 'Client countries',   'v' => '14' ),
		array( 'k' => 'Building since',     'v' => '2020' ),
		array( 'k' => 'You work with',      'v' => 'Me, directly' ),
		array( 'k' => 'Reply time',         'v' => 'Within 12 hours' ),
		array( 'k' => 'Calls',              'v' => 'Optional, on request' ),
	);
}

/**
 * The six services. 'icon' matches a file in assets/icons/.
 *
 * @return array<int,array<string,string>>
 */
function jd_get_services() {
	return array(
		array(
			'icon'  => 'wordpress',
			'name'  => 'WordPress development',
			'desc'  => 'Custom themes, plugins and builds. Not a template with your logo dropped on it.',
			'price' => 'From $450',
			'url'   => '/services/wordpress-development/',
		),
		array(
			'icon'  => 'webapps',
			'name'  => 'Headless WordPress and web apps',
			'desc'  => 'React and Node front ends on a WordPress or custom back end, for teams who have outgrown a standard site.',
			'price' => 'From $900',
			'url'   => '/services/web-applications/',
		),
		array(
			'icon'  => 'forms',
			'name'  => 'Forms, PDFs and document automation',
			'desc'  => 'Multi-step forms that generate contracts, quotes and certificates automatically.',
			'price' => 'From $180',
			'url'   => '/services/forms-and-pdfs/',
		),
		array(
			'icon'  => 'portals',
			'name'  => 'Membership sites and client portals',
			'desc'  => 'Logins, gated content, member dashboards and role-based access.',
			'price' => 'From $300',
			'url'   => '/services/portals-and-memberships/',
		),
		array(
			'icon'  => 'ai',
			'name'  => 'AI agents and automation',
			'desc'  => 'Custom GPTs, support agents trained on your documents, and workflows that remove repetitive admin.',
			'price' => 'From $600',
			'url'   => '/services/ai-agents/',
		),
		array(
			'icon'  => 'care',
			'name'  => 'Website care plans',
			'desc'  => 'Updates, backups, security monitoring, speed and technical SEO. Ongoing, so nothing breaks quietly.',
			'price' => 'From $129/mo',
			'url'   => '/services/care-plans/',
		),
	);
}

/**
 * The three failure modes.
 *
 * @return array<int,array{h:string,p:string}>
 */
function jd_get_problems() {
	return array(
		array(
			'h' => 'Quotes that grow',
			'p' => 'You agree a price, then every change becomes a variation. The final invoice looks nothing like the estimate.',
		),
		array(
			'h' => 'Developers who go quiet',
			'p' => 'Work starts well. Then replies slow down, deadlines slip, and you are chasing someone who has moved on to a better-paying job.',
		),
		array(
			'h' => 'Sites that break on update',
			'p' => 'A plugin updates, the contact form stops sending, and nobody notices until a client mentions it three weeks later.',
		),
	);
}

/**
 * The four project stages.
 *
 * @return array<int,array{h:string,p:string}>
 */
function jd_get_process() {
	return array(
		array( 'h' => 'Scope',              'p' => 'You describe the problem. I write back what I would build, what it costs, and what is excluded.' ),
		array( 'h' => 'Build',              'p' => 'Work happens on a staging site you can watch. You see progress, not promises.' ),
		array( 'h' => 'Review',             'p' => 'I record a screen walkthrough of the finished build. You watch it when it suits you and send changes in writing.' ),
		array( 'h' => 'Launch and support', 'p' => 'The site goes live. Thirty days of fixes are included. A care plan is optional after that.' ),
	);
}

/**
 * Outcome figures. Replace the placeholders with real numbers before launch.
 *
 * @return array<int,array{big:string,p:string}>
 */
function jd_get_results() {
	return array(
		array( 'big' => '12 hrs', 'p' => 'of monthly admin removed for a training provider, after manual enrolment emails were replaced with an automated portal.' ),
		array( 'big' => '1.4s',   'p' => 'mobile load time for a consultancy, down from 6.2 seconds, with enquiries rising over the following quarter.' ),
		array( 'big' => '0',      'p' => 'manual steps in a clinic intake process. The form now generates a completed PDF and emails it before the patient leaves the page.' ),
	);
}

/**
 * FAQs. Also feeds the FAQPage schema in inc/seo.php.
 *
 * @return array<int,array{q:string,a:string}>
 */
function jd_get_faqs() {
	return array(
		array( 'q' => 'Where are you based?',                  'a' => 'Pakistan. I work with clients in the US, UK, Europe and the Gulf, with working hours that overlap all four.' ),
		array( 'q' => 'How long does a project take?',         'a' => 'A standard site is two to three weeks. Applications and portals run four to eight, depending on scope.' ),
		array( 'q' => 'What if I need changes after launch?',  'a' => 'Thirty days of fixes are included with every project. After that, a care plan covers ongoing changes.' ),
		array( 'q' => 'How do we communicate?',                'a' => 'Email and a shared project board. I send recorded walkthroughs so you can watch progress whenever it suits you rather than working around time zones. If you would rather talk it through, I am happy to jump on a call.' ),
		array( 'q' => 'Can we get on a call before I commit?', 'a' => 'Yes. Send your details through the form and ask for a call, and I will send times that work across your time zone.' ),
		array( 'q' => 'How do payments work?',                 'a' => 'Fifty percent to begin, fifty on completion. Larger projects split into milestones.' ),
		array( 'q' => 'What if it does not work out?',         'a' => 'If you are not happy after the first milestone, you keep the work completed and we stop there.' ),
	);
}

/**
 * Print an inline SVG icon from assets/icons/.
 *
 * Inline rather than <img> so the icon inherits currentColor and costs
 * no extra HTTP request.
 *
 * @param string $name Icon filename without extension.
 */
function jd_icon( $name ) {

	/*
	 * Strict allowlist, not sanitisation.
	 *
	 * sanitize_file_name() cleans a name but still permits characters that
	 * can be assembled into a path. Since this value ends up in a filesystem
	 * read, the safe approach is to reject anything that is not plain
	 * lowercase letters, digits and hyphens, then confirm the resolved path
	 * really sits inside the icons folder.
	 */
	if ( ! is_string( $name ) || ! preg_match( '/^[a-z0-9\-]{1,64}$/', $name ) ) {
		return;
	}

	$dir  = realpath( JD_DIR . '/assets/icons' );
	$file = realpath( $dir . '/' . $name . '.svg' );

	// realpath() returns false for a missing file, and resolves any traversal
	// attempt to its real location, so this check catches both.
	if ( false === $dir || false === $file || 0 !== strpos( $file, $dir . DIRECTORY_SEPARATOR ) ) {
		return;
	}

	$svg = file_get_contents( $file ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	echo wp_kses(
		$svg,
		array(
			/*
			 * Every shape needs the stroke attributes in this list. wp_kses()
			 * removes any attribute that is not named here, and a <path> with
			 * fill="none" and no stroke renders as nothing at all - which is
			 * how the logo mark became an empty white square.
			 */
			'svg'      => array( 'xmlns' => array(), 'viewbox' => array(), 'width' => array(), 'height' => array(), 'fill' => array(), 'stroke' => array(), 'stroke-width' => array(), 'stroke-linecap' => array(), 'stroke-linejoin' => array(), 'aria-hidden' => array(), 'aria-label' => array(), 'role' => array(), 'class' => array() ),
			'title'    => array(),
			'desc'     => array(),
			'g'        => array( 'fill' => array(), 'stroke' => array(), 'stroke-width' => array(), 'transform' => array(), 'class' => array() ),
			'path'     => array( 'd' => array(), 'fill' => array(), 'stroke' => array(), 'stroke-width' => array(), 'stroke-linecap' => array(), 'stroke-linejoin' => array(), 'fill-rule' => array(), 'clip-rule' => array() ),
			'rect'     => array( 'x' => array(), 'y' => array(), 'width' => array(), 'height' => array(), 'rx' => array(), 'ry' => array(), 'fill' => array(), 'stroke' => array(), 'stroke-width' => array() ),
			'circle'   => array( 'cx' => array(), 'cy' => array(), 'r' => array(), 'fill' => array(), 'stroke' => array(), 'stroke-width' => array() ),
			'line'     => array( 'x1' => array(), 'y1' => array(), 'x2' => array(), 'y2' => array(), 'stroke' => array(), 'stroke-width' => array(), 'stroke-linecap' => array() ),
			'polyline' => array( 'points' => array(), 'fill' => array(), 'stroke' => array(), 'stroke-width' => array(), 'stroke-linecap' => array(), 'stroke-linejoin' => array() ),
			'polygon'  => array( 'points' => array(), 'fill' => array(), 'stroke' => array(), 'stroke-width' => array() ),
		)
	);
}

/**
 * Estimated reading time for a blog post.
 *
 * @return string
 */
function jd_reading_time() {
	$words = str_word_count( wp_strip_all_tags( get_the_content() ) );
	$mins  = max( 1, (int) ceil( $words / 220 ) );
	return $mins . ' min read';
}

/**
 * The public contact address.
 *
 * Kept in one function so changing it later means editing one line instead of
 * hunting through templates. Falls back to the WordPress admin address, so the
 * site never prints a mailto: link to a mailbox that does not exist yet.
 *
 * @return string
 */
function jd_contact_email() {
	$set = get_option( 'jd_contact_email' );
	if ( is_string( $set ) && is_email( $set ) ) {
		return $set;
	}

	/*
	 * Then the forms plugin's own From address.
	 *
	 * The WordPress admin email is the LAST resort, not the first, because on
	 * most installs that is a personal address - and printing it in the site
	 * footer and the mobile menu would publish it to every visitor and every
	 * scraper. Falling back to the public mailbox instead is the safe default.
	 */
	if ( defined( 'JDF_FROM_EMAIL' ) && is_email( JDF_FROM_EMAIL ) ) {
		return (string) JDF_FROM_EMAIL;
	}

	return (string) get_option( 'admin_email' );
}

/**
 * Whether a page is built from the full-width section patterns.
 *
 * The patterns in inc/patterns.php bring their own bands and .wrap, so a page
 * made from them has to be printed bare. Inside page.php's band, wrap and
 * .prose, every section is squeezed into the 68ch text column and picks up the
 * prose type styles. A plain page has no such section and keeps the wrapper.
 *
 * @param int|WP_Post|null $post Page to check. Defaults to the current post.
 * @return bool
 */
function jd_is_pattern_page( $post = null ) {
	$content = (string) get_post_field( 'post_content', $post );
	return 1 === preg_match( '/<section\b[^>]*\bclass="[^"]*\b(?:svc-hero|band)\b/', $content );
}
