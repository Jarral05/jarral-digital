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
 * Hero proof figures, set large in the card beside the headline.
 *
 * @return array<int,array{k:string,v:string}>
 */
function jd_get_hero_stats() {
	return array(
		array( 'k' => 'Projects delivered', 'v' => '120+' ),
		array( 'k' => 'Client countries',   'v' => '14' ),
		array( 'k' => 'Building since',     'v' => '2020' ),
	);
}

/**
 * Hero working terms, set as one line under the buttons.
 *
 * @return array<int,string>
 */
function jd_get_hero_terms() {
	return array(
		'Reply within 12 hours',
		'You work with me directly',
		'Calls optional',
	);
}

/**
 * The three failure modes, each with the fix that answers it.
 *
 * @return array<int,array{h:string,p:string,fix:string}>
 */
function jd_get_problems() {
	return array(
		array(
			'h'   => 'Quotes that grow',
			'p'   => 'You agree a price, then every change becomes a variation. The final invoice looks nothing like the estimate.',
			'fix' => 'Fixed scope, agreed in writing before work starts.',
		),
		array(
			'h'   => 'Developers who go quiet',
			'p'   => 'Work starts well. Then replies slow down, deadlines slip, and you are chasing someone who has moved on to a better-paying job.',
			'fix' => 'A reply within twelve hours, every working day.',
		),
		array(
			'h'   => 'Sites that break on update',
			'p'   => 'A plugin updates, the contact form stops sending, and nobody notices until a client mentions it three weeks later.',
			'fix' => 'A care plan keeps the site working after launch.',
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
 * The four promises beside the contact form, on the homepage and the
 * Contact page.
 *
 * @return array<int,array{h:string,p:string}>
 */
function jd_get_promises() {
	return array(
		array( 'h' => 'Nothing is committed by sending this', 'p' => 'No call is booked, no invoice raised, nobody added to a list.' ),
		array( 'h' => 'A fixed price before work starts',     'p' => 'The number you accept is the number you pay.' ),
		array( 'h' => 'You own the result',                   'p' => 'Design, code and content transfer to you on final payment.' ),
		array( 'h' => 'Thirty days of fixes included',        'p' => 'Anything not working as described is fixed at no cost.' ),
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
 * Print the breadcrumb trail shown above an inner page's heading.
 *
 * Home is always first. Each item is array( label, url ); an item with no
 * url is the current page and is marked aria-current.
 *
 * @param array<int,array{0:string,1?:string}> $items Trail after Home.
 */
function jd_crumbs( $items ) {
	?>
	<nav class="crumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'jarral-digital' ); ?>">
		<ol>
			<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'jarral-digital' ); ?></a></li>
			<?php foreach ( $items as $item ) : ?>
				<li>
					<?php if ( ! empty( $item[1] ) ) : ?>
						<a href="<?php echo esc_url( $item[1] ); ?>"><?php echo esc_html( $item[0] ); ?></a>
					<?php else : ?>
						<span aria-current="page"><?php echo esc_html( $item[0] ); ?></span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ol>
	</nav>
	<?php
}

/**
 * A published page by its path, or null. For the few pages the theme links
 * to on its own: the policies and the sitemap.
 *
 * @param string $path Page path, e.g. "cookie-policy".
 * @return WP_Post|null
 */
function jd_published_page( $path ) {
	$page = get_page_by_path( $path );
	return ( $page && 'publish' === $page->post_status ) ? $page : null;
}

/**
 * The legal pages that exist, in the order privacy, terms, cookies.
 *
 * Found with no menu set up: the privacy page from Settings > Privacy, the
 * others by their usual slugs. Assign a menu to "Footer legal links" to pick
 * them by hand instead.
 *
 * @return WP_Post[]
 */
function jd_legal_pages() {
	$kinds = array(
		array( 'privacy-policy', 'privacy-policy-2', 'privacy' ),
		array( 'terms-of-service', 'terms-and-conditions', 'terms' ),
		array( 'cookie-policy', 'cookies' ),
	);
	$pages = array();

	$privacy = (int) get_option( 'wp_page_for_privacy_policy' );
	if ( $privacy && 'publish' === get_post_status( $privacy ) ) {
		$pages[] = get_post( $privacy );
		array_shift( $kinds );
	}

	foreach ( $kinds as $slugs ) {
		foreach ( $slugs as $slug ) {
			$page = jd_published_page( $slug );
			if ( $page ) {
				$pages[] = $page;
				break;
			}
		}
	}

	return $pages;
}

/**
 * Breadcrumb items for a page: its ancestors, then the page itself.
 *
 * @param int|WP_Post|null $post Page. Defaults to the current post.
 * @return array<int,array{0:string,1:string}>
 */
function jd_page_trail( $post = null ) {
	$post  = get_post( $post );
	$trail = array();
	foreach ( array_reverse( get_post_ancestors( $post ) ) as $id ) {
		$trail[] = array( get_the_title( $id ), get_permalink( $id ) );
	}
	$trail[] = array( get_the_title( $post ), '' );
	return $trail;
}

/**
 * Run post content through the_content and prepare it for an inner page.
 *
 * Gives every <h2> an id so the "On this page" list can link to it, collects
 * those headings, and wraps each table in a scroll box so a wide table scrolls
 * on a phone instead of stretching the page.
 *
 * @param string $content Raw post content, from get_the_content().
 * @return array{html:string,toc:array<string,string>} Content, and heading text keyed by id.
 */
function jd_prepare_content( $content ) {
	$html = str_replace( ']]>', ']]&gt;', apply_filters( 'the_content', $content ) );
	$toc  = array();

	$html = preg_replace_callback(
		'#<h2([^>]*)>(.*?)</h2>#is',
		static function ( $m ) use ( &$toc ) {
			$text = trim( wp_strip_all_tags( $m[2] ) );
			if ( '' === $text ) {
				return $m[0];
			}

			// Keep an id the editor already set, so existing links still work.
			if ( preg_match( '/\sid=(["\'])(.*?)\1/i', $m[1], $set ) ) {
				$toc[ $set[2] ] = $text;
				return $m[0];
			}

			$base = sanitize_title( $text );
			$base = '' === $base ? 'section' : $base;
			$id   = $base;
			for ( $n = 2; isset( $toc[ $id ] ); $n++ ) {
				$id = $base . '-' . $n;
			}
			$toc[ $id ] = $text;

			return '<h2 id="' . esc_attr( $id ) . '"' . $m[1] . '>' . $m[2] . '</h2>';
		},
		$html
	);

	$html = preg_replace( '#<table\b(.*?)</table>#is', '<div class="table-wrap"><table$1</table></div>', $html );

	return array(
		'html' => (string) $html,
		'toc'  => $toc,
	);
}

/**
 * Heading for index.php, which serves the blog, every archive and search.
 *
 * @return array{crumb:string,title:string,desc:string}
 */
function jd_archive_heading() {
	if ( is_search() ) {
		return array(
			'crumb' => __( 'Search', 'jarral-digital' ),
			/* translators: %s: the search terms */
			'title' => sprintf( __( 'Results for “%s”', 'jarral-digital' ), get_search_query( false ) ),
			'desc'  => '',
		);
	}

	if ( is_home() ) {
		$blog  = (int) get_option( 'page_for_posts' );
		$title = $blog ? get_the_title( $blog ) : __( 'Blog', 'jarral-digital' );
		return array(
			'crumb' => $title,
			'title' => $title,
			'desc'  => $blog && has_excerpt( $blog ) ? get_the_excerpt( $blog ) : '',
		);
	}

	if ( is_archive() ) {
		// "Category: News" reads like a database label. Drop the prefix.
		add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );
		$title = wp_strip_all_tags( get_the_archive_title() );
		remove_filter( 'get_the_archive_title_prefix', '__return_empty_string' );
		return array(
			'crumb' => $title,
			'title' => $title,
			'desc'  => wp_strip_all_tags( get_the_archive_description() ),
		);
	}

	return array(
		'crumb' => get_bloginfo( 'name' ),
		'title' => get_bloginfo( 'name' ),
		'desc'  => '',
	);
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
