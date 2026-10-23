<?php
/**
 * The services, and everything the site says about each one.
 *
 * Every service page under /services/, the Services page itself, the
 * homepage cards, the footer, the menu, the 404 and the estimator's names and
 * starting prices all read from here, so a price or a name changes in one
 * place. Until 1.7.0 the service pages were Custom HTML blocks pasted into
 * each page, with every fact repeated by hand.
 *
 * Each service is keyed by its page slug under /services/:
 *   name, icon, desc  The card: name, icon (assets/icons/icon-*.svg), one line.
 *   from, per         Starting price, and '/mo' for a monthly service.
 *   est               Its key in the homepage estimator (assets/js/main.js), or ''.
 *   hero              Eyebrow, heading, intro, price note and timeline line.
 *   covers, includes  The details section: what it covers, and the list of
 *   for, not_for      what is included; who it is for, and who it is not for.
 *   facts             The "At a glance" card, after the price.
 *   gets              "What you get": an intro and six cards (icon in
 *                     assets/icons/, heading, text).
 *   steps             Heading and intro. 'items' only where the steps differ
 *                     from the homepage process, jd_get_process().
 *   faqs              Questions. They also feed the page's FAQPage schema.
 *   form              Heading and intro of the enquiry form. Every enquiry
 *                     from the page is tagged with the service name.
 *   problem           Its card in the Services page's "Not sure which you need?".
 *
 * A page's title and SEO settings still come from WordPress. Its content in
 * the editor is not used; the editor says so (jd_service_editor_notice()).
 *
 * @package JarralDigital
 */

defined( 'ABSPATH' ) || exit;

/**
 * Every service, keyed by page slug, in the order the site lists them.
 *
 * @return array<string,array<string,mixed>>
 */
function jd_service_catalog() {
	return array(

		'wordpress-development' => array(
			'name'     => 'WordPress development',
			'icon'     => 'wordpress',
			'desc'     => 'Custom themes, plugins and builds. Not a template with your logo dropped on it.',
			'from'     => 450,
			'per'      => '',
			'est'      => 'wp',
			'hero'     => array(
				'eyebrow' => 'WordPress',
				'title'   => 'WordPress development',
				'lede'    => 'Custom themes, plugins and builds. Not a template with your logo dropped on it. You get a fast site your team can edit without calling a developer.',
				'note'    => 'written quote up front',
				'time'    => 'Typical timeline: 2–3 weeks',
			),
			'covers'   => 'A WordPress site designed around your content and the way your firm works, with nothing installed that you do not need.',
			'includes' => array(
				'A custom theme, hand-built rather than a page builder template',
				'Custom plugins where an off-the-shelf one does not fit',
				'Pages you edit yourself in the WordPress block editor',
				'Contact forms that store every enquiry and email you',
				'Launch, plus 30 days of fixes',
			),
			'for'      => 'Professional services firms that need a site which looks like them, loads quickly, and does not fall apart when a plugin updates.',
			'not_for'  => 'You need a shop with thousands of products, or a site live in two days. A ready-made template is the faster, cheaper choice there.',
			'facts'    => array(
				'Timeline'     => '2–3 weeks',
				'Payment'      => '50% to start, 50% at launch',
				'After launch' => '30 days of fixes',
				'Replies'      => 'Within 12 hours',
			),
			'gets'     => array(
				'p'     => 'Everything below is part of the price, agreed in writing before work starts.',
				'items' => array(
					array( 'icon' => 'get-a-custom-theme', 'h' => 'A custom theme', 'p' => 'Designed around your content and brand, not adapted from a template.' ),
					array( 'icon' => 'get-easy-editing', 'h' => 'Easy editing', 'p' => 'Change text, images and pages yourself in the block editor.' ),
					array( 'icon' => 'get-fast-on-mobile', 'h' => 'Fast on mobile', 'p' => 'Lean code and no page builder, so pages load quickly on phones.' ),
					array( 'icon' => 'get-fewer-moving-parts', 'h' => 'Fewer moving parts', 'p' => 'Less to update, so updates are less likely to break things.' ),
					array( 'icon' => 'get-enquiries-that-arrive', 'h' => 'Enquiries that arrive', 'p' => 'Forms that store every message and email you, so nothing gets lost.' ),
					array( 'icon' => 'get-30-days-of-fixes', 'h' => '30 days of fixes', 'p' => 'Anything that is not right after launch is fixed at no extra cost.' ),
				),
			),
			'steps'    => array(
				'h' => 'How it works',
				'p' => 'The same four steps every time, so you always know what happens next.',
			),
			'faqs'     => array(
				array( 'q' => 'How long does a WordPress site take?', 'a' => 'A standard site is two to three weeks from an agreed scope. Larger builds are split into milestones.' ),
				array( 'q' => 'Can I edit the site myself?', 'a' => 'Yes. Pages are built for the WordPress block editor, so you can change text and images without touching code.' ),
				array( 'q' => 'Do you use page builders?', 'a' => 'No. The theme is hand-built, which keeps pages fast and leaves fewer plugins to update.' ),
				array( 'q' => 'What if I need changes after launch?', 'a' => 'Thirty days of fixes are included with every project. After that, a care plan covers ongoing changes.' ),
			),
			'form'     => array(
				'h' => 'Start your WordPress project',
				'p' => 'Describe what you need and I will reply within twelve hours with scope and a price.',
			),
			'problem'  => array(
				'icon' => 'get-a-custom-theme',
				'h'    => 'I need a new website',
				'p'    => 'A fast site that looks like your firm and that your team can edit.',
			),
		),

		'web-applications' => array(
			'name'     => 'Headless WordPress and web apps',
			'icon'     => 'webapps',
			'desc'     => 'React and Node front ends on a WordPress or custom back end, for teams who have outgrown a standard site.',
			'from'     => 900,
			'per'      => '',
			'est'      => 'app',
			'hero'     => array(
				'eyebrow' => 'Web applications',
				'title'   => 'Headless WordPress and web apps',
				'lede'    => 'React and Node front ends on a WordPress or custom back end, for teams who have outgrown a standard site.',
				'note'    => 'written quote up front',
				'time'    => 'Typical timeline: 4–8 weeks',
			),
			'covers'   => 'Software for work a normal website cannot do: logged-in tools, live data, and front ends that have to stay fast as they grow.',
			'includes' => array(
				'A React front end on WordPress or a custom back end',
				'Node APIs and integrations with the tools you already use',
				'User accounts, roles and permissions',
				'A staging site you can watch as it is built',
				'Written handover notes, so you are never locked in',
			),
			'for'      => 'Teams whose website has become part of how they deliver: client dashboards, booking tools, calculators, or content that has to load instantly.',
			'not_for'  => 'A brochure site with a contact form will do. That is a WordPress build, and it costs less.',
			'facts'    => array(
				'Timeline'     => '4–8 weeks',
				'Payment'      => 'Split into milestones',
				'After launch' => '30 days of fixes',
				'Replies'      => 'Within 12 hours',
			),
			'gets'     => array(
				'p'     => 'Everything below is part of the price, agreed in writing before work starts.',
				'items' => array(
					array( 'icon' => 'get-react-front-end', 'h' => 'React front end', 'p' => 'A fast interface that feels like an app, not a page reload.' ),
					array( 'icon' => 'get-apis-and-integrations', 'h' => 'APIs and integrations', 'p' => 'Your site connected to the CRM, payments or internal tools you rely on.' ),
					array( 'icon' => 'get-accounts-and-roles', 'h' => 'Accounts and roles', 'p' => 'Logins with the right access for clients, staff and admins.' ),
					array( 'icon' => 'get-dashboards', 'h' => 'Dashboards', 'p' => 'Live data shown clearly, for your team or your clients.' ),
					array( 'icon' => 'get-staging-you-can-watch', 'h' => 'Staging you can watch', 'p' => 'Progress on a private staging site, not just promises.' ),
					array( 'icon' => 'get-handover-notes', 'h' => 'Handover notes', 'p' => 'Written notes on how it works, so another developer can pick it up.' ),
				),
			),
			'steps'    => array(
				'h' => 'How it works',
				'p' => 'The same four steps every time, so you always know what happens next.',
			),
			'faqs'     => array(
				array( 'q' => 'What does headless mean?', 'a' => 'WordPress manages the content and a separate React front end displays it. You keep the familiar editor, and visitors get a faster site.' ),
				array( 'q' => 'Do I actually need a web app?', 'a' => 'Often not. If a standard WordPress site does the job, the written scope will say so.' ),
				array( 'q' => 'How long does a web app take?', 'a' => 'Applications run four to eight weeks, depending on scope. Larger projects are split into milestones.' ),
				array( 'q' => 'What if it does not work out?', 'a' => 'If you are not happy after the first milestone, you keep the work completed and we stop there.' ),
			),
			'form'     => array(
				'h' => 'Tell me what you are building',
				'p' => 'Describe the problem and I will reply within twelve hours with scope and a price.',
			),
			'problem'  => array(
				'icon' => 'get-react-front-end',
				'h'    => 'My site needs to do more',
				'p'    => 'Logins, dashboards, live data or tools a normal site cannot run.',
			),
		),

		'forms-and-pdfs' => array(
			'name'     => 'Forms, PDFs and document automation',
			'icon'     => 'forms',
			'desc'     => 'Multi-step forms that generate contracts, quotes and certificates automatically.',
			'from'     => 180,
			'per'      => '',
			'est'      => 'forms',
			'hero'     => array(
				'eyebrow' => 'Automation',
				'title'   => 'Forms, PDFs and document automation',
				'lede'    => 'Multi-step forms that generate contracts, quotes and certificates automatically.',
				'note'    => 'written quote up front',
				'time'    => 'Timeline agreed in your written scope',
			),
			'covers'   => 'The forms and documents your team fills in by hand, turned into something that runs on its own.',
			'includes' => array(
				'Multi-step forms with questions that adapt to earlier answers',
				'PDFs generated from the answers, in your branding',
				'Finished documents emailed to you and your client',
				'Every submission stored, so nothing depends on one inbox',
			),
			'for'      => 'Firms that send the same contract, quote or certificate many times a week, and copy details between systems to do it.',
			'not_for'  => 'You only need a simple contact form. That comes with any website build.',
			'facts'    => array(
				'Timeline'     => 'Agreed in your scope',
				'Payment'      => '50% to start, 50% at launch',
				'After launch' => '30 days of fixes',
				'Replies'      => 'Within 12 hours',
			),
			'gets'     => array(
				'p'     => 'Everything below is part of the price, agreed in writing before work starts.',
				'items' => array(
					array( 'icon' => 'get-multi-step-forms', 'h' => 'Multi-step forms', 'p' => 'One step at a time, so long forms feel short.' ),
					array( 'icon' => 'get-generated-pdfs', 'h' => 'Generated PDFs', 'p' => 'Contracts, quotes and certificates filled in from the answers.' ),
					array( 'icon' => 'get-enquiries-that-arrive', 'h' => 'Sent automatically', 'p' => 'The finished document reaches the right inboxes in seconds.' ),
					array( 'icon' => 'get-stored-safely', 'h' => 'Stored safely', 'p' => 'Every submission kept on record and protected from spam.' ),
					array( 'icon' => 'get-fewer-manual-steps', 'h' => 'Fewer manual steps', 'p' => 'No retyping details from one system into another.' ),
					array( 'icon' => 'get-30-days-of-fixes', 'h' => '30 days of fixes', 'p' => 'Anything that is not right after launch is fixed at no extra cost.' ),
				),
			),
			'steps'    => array(
				'h' => 'How it works',
				'p' => 'The same four steps every time, so you always know what happens next.',
			),
			'faqs'     => array(
				array( 'q' => 'Can the PDFs use my branding?', 'a' => 'Yes. Your logo, colours and wording go into the template, so every document looks like it came from you.' ),
				array( 'q' => 'How long does it take?', 'a' => 'It depends on how many forms and documents are involved. You get the timeline in writing with the scope, before any work starts.' ),
				array( 'q' => 'How do payments work?', 'a' => 'Fifty percent to begin, fifty on completion. Larger projects split into milestones.' ),
				array( 'q' => 'What if I need changes after launch?', 'a' => 'Thirty days of fixes are included with every project. After that, a care plan covers ongoing changes.' ),
			),
			'form'     => array(
				'h' => 'Tell me about the paperwork',
				'p' => 'Describe the forms and documents involved and I will reply within twelve hours with scope and a price.',
			),
			'problem'  => array(
				'icon' => 'get-multi-step-forms',
				'h'    => 'We keep filling in the same documents',
				'p'    => 'Contracts, quotes and certificates generated from one form.',
			),
		),

		'portals-and-memberships' => array(
			'name'     => 'Membership sites and client portals',
			'icon'     => 'portals',
			'desc'     => 'Logins, gated content, member dashboards and role-based access.',
			'from'     => 300,
			'per'      => '',
			'est'      => 'portal',
			'hero'     => array(
				'eyebrow' => 'Portals',
				'title'   => 'Membership sites and client portals',
				'lede'    => 'Logins, gated content, member dashboards and role-based access.',
				'note'    => 'written quote up front',
				'time'    => 'Typical timeline: 4–8 weeks',
			),
			'covers'   => 'A private area of your site where clients or members log in and find exactly what is theirs.',
			'includes' => array(
				'Secure logins and password resets',
				'Pages and files visible only to the right people',
				'Member dashboards with their own documents and updates',
				'Roles for clients, staff and admins',
				'Members managed from the WordPress dashboard',
			),
			'for'      => 'Training providers, consultancies and clinics that share reports, courses or documents with specific clients.',
			'not_for'  => 'Everything you publish is meant to be public. Then you do not need logins at all.',
			'facts'    => array(
				'Timeline'     => '4–8 weeks',
				'Payment'      => '50% to start, 50% at launch',
				'After launch' => '30 days of fixes',
				'Replies'      => 'Within 12 hours',
			),
			'gets'     => array(
				'p'     => 'Everything below is part of the price, agreed in writing before work starts.',
				'items' => array(
					array( 'icon' => 'get-stored-safely', 'h' => 'Secure logins', 'p' => 'Sign-in and password resets that just work.' ),
					array( 'icon' => 'get-accounts-and-roles', 'h' => 'Roles and access', 'p' => 'Each client, member or staff role sees only what it should.' ),
					array( 'icon' => 'get-dashboards', 'h' => 'Member dashboards', 'p' => 'One place for each member’s documents, courses and updates.' ),
					array( 'icon' => 'get-multi-step-forms', 'h' => 'Private files', 'p' => 'Reports and downloads kept behind the login.' ),
					array( 'icon' => 'get-enquiries-that-arrive', 'h' => 'Automatic emails', 'p' => 'Welcome and update emails sent without you lifting a finger.' ),
					array( 'icon' => 'get-30-days-of-fixes', 'h' => '30 days of fixes', 'p' => 'Anything that is not right after launch is fixed at no extra cost.' ),
				),
			),
			'steps'    => array(
				'h' => 'How it works',
				'p' => 'The same four steps every time, so you always know what happens next.',
			),
			'faqs'     => array(
				array( 'q' => 'Can I control who sees what?', 'a' => 'Yes. Each role sees only its own pages and files, and you change access from the WordPress dashboard.' ),
				array( 'q' => 'Can my team manage members?', 'a' => 'Yes. Adding, removing and changing members happens in the WordPress dashboard, with no developer needed.' ),
				array( 'q' => 'How long does a portal take?', 'a' => 'Portals run four to eight weeks, depending on scope. Larger projects are split into milestones.' ),
				array( 'q' => 'What if it does not work out?', 'a' => 'If you are not happy after the first milestone, you keep the work completed and we stop there.' ),
			),
			'form'     => array(
				'h' => 'Tell me who needs to log in',
				'p' => 'Describe your members or clients and I will reply within twelve hours with scope and a price.',
			),
			'problem'  => array(
				'icon' => 'get-stored-safely',
				'h'    => 'Clients need to log in',
				'p'    => 'A private area with each client’s own files and updates.',
			),
		),

		'ai-agents' => array(
			'name'     => 'AI agents and automation',
			'icon'     => 'ai',
			'desc'     => 'Custom GPTs, support agents trained on your documents, and workflows that remove repetitive admin.',
			'from'     => 600,
			'per'      => '',
			'est'      => 'ai',
			'hero'     => array(
				'eyebrow' => 'AI',
				'title'   => 'AI agents and automation',
				'lede'    => 'Custom GPTs, support agents trained on your documents, and workflows that remove repetitive admin.',
				'note'    => 'written quote up front',
				'time'    => 'Timeline agreed in your written scope',
			),
			'covers'   => 'Practical AI that takes repetitive work off your team, built around your own documents and tools.',
			'includes' => array(
				'Support agents that answer from your own documents',
				'Custom GPTs for internal tasks',
				'Workflows that move information between your tools',
				'Clear limits on what the agent can and cannot do',
			),
			'for'      => 'Teams answering the same questions every day, or copying information between systems by hand.',
			'not_for'  => 'The work changes every time and needs judgement. AI is best at repeated, well-defined tasks.',
			'facts'    => array(
				'Timeline'     => 'Agreed in your scope',
				'Payment'      => '50% to start, 50% at launch',
				'After launch' => '30 days of fixes',
				'Replies'      => 'Within 12 hours',
			),
			'gets'     => array(
				'p'     => 'Everything below is part of the price, agreed in writing before work starts.',
				'items' => array(
					array( 'icon' => 'get-a-support-agent', 'h' => 'A support agent', 'p' => 'Answers common questions from your own documents.' ),
					array( 'icon' => 'get-handover-notes', 'h' => 'Trained on your content', 'p' => 'Your policies, guides and FAQs, not generic internet answers.' ),
					array( 'icon' => 'get-fewer-manual-steps', 'h' => 'Automated workflows', 'p' => 'Forms, emails and records updated without manual steps.' ),
					array( 'icon' => 'get-hands-over-to-a-person', 'h' => 'Hands over to a person', 'p' => 'Questions it cannot answer are passed to your team.' ),
					array( 'icon' => 'get-fewer-moving-parts', 'h' => 'Clear guardrails', 'p' => 'Limits on what it can say and do, agreed before launch.' ),
					array( 'icon' => 'get-30-days-of-fixes', 'h' => '30 days of fixes', 'p' => 'Anything that is not right after launch is fixed at no extra cost.' ),
				),
			),
			'steps'    => array(
				'h' => 'How it works',
				'p' => 'The same four steps every time, so you always know what happens next.',
			),
			'faqs'     => array(
				array( 'q' => 'Will it make things up?', 'a' => 'Answers are limited to your own documents, and it is tested against your real questions before it goes live.' ),
				array( 'q' => 'What does it cost to run?', 'a' => 'AI services charge by usage, separately from the build. You get an estimate of the monthly running cost with the scope.' ),
				array( 'q' => 'How long does it take?', 'a' => 'It depends on the documents and tools involved. You get the timeline in writing with the scope, before any work starts.' ),
				array( 'q' => 'How do payments work?', 'a' => 'Fifty percent to begin, fifty on completion. Larger projects split into milestones.' ),
			),
			'form'     => array(
				'h' => 'Tell me what eats your team’s time',
				'p' => 'Describe the repetitive work and I will reply within twelve hours with scope and a price.',
			),
			'problem'  => array(
				'icon' => 'get-a-support-agent',
				'h'    => 'My team repeats the same tasks',
				'p'    => 'Agents and workflows that take the repetitive admin away.',
			),
		),

		'care-plans' => array(
			'name'     => 'Website care plans',
			'icon'     => 'care',
			'desc'     => 'Updates, backups, security monitoring, speed and technical SEO. Ongoing, so nothing breaks quietly.',
			'from'     => 129,
			'per'      => '/mo',
			'est'      => '',
			'hero'     => array(
				'eyebrow' => 'Care plans',
				'title'   => 'Website care plans',
				'lede'    => 'Updates, backups, security monitoring, speed and technical SEO. Ongoing, so nothing breaks quietly.',
				'note'    => 'per month',
				'time'    => 'Ongoing care for your live site',
			),
			'covers'   => 'Someone looking after your site every month, so problems are caught before your clients notice them.',
			'includes' => array(
				'WordPress, theme and plugin updates',
				'Regular backups you can restore from',
				'Security monitoring',
				'Speed checks',
				'Technical SEO checks',
			),
			'for'      => 'Firms whose website brings in enquiries, and who cannot afford a contact form that quietly stops working.',
			'not_for'  => 'Your site rarely changes and you are happy to run updates and backups yourself.',
			'facts'    => array(
				'Billing' => 'Monthly',
				'Covers'  => 'Updates, backups, security',
				'Replies' => 'Within 12 hours',
			),
			'gets'     => array(
				'p'     => 'Everything below is part of the price, agreed in writing before work starts.',
				'items' => array(
					array( 'icon' => 'get-updates', 'h' => 'Updates', 'p' => 'WordPress, your theme and plugins kept current.' ),
					array( 'icon' => 'get-backups', 'h' => 'Backups', 'p' => 'Regular copies of your site, ready to restore.' ),
					array( 'icon' => 'get-fewer-moving-parts', 'h' => 'Security monitoring', 'p' => 'Problems spotted and dealt with early.' ),
					array( 'icon' => 'get-fast-on-mobile', 'h' => 'Speed', 'p' => 'Pages kept quick as your content grows.' ),
					array( 'icon' => 'get-technical-seo', 'h' => 'Technical SEO', 'p' => 'Broken links and indexing problems found and fixed.' ),
					array( 'icon' => 'get-enquiries-that-arrive', 'h' => 'Forms that keep working', 'p' => 'Contact forms checked, so enquiries keep arriving.' ),
				),
			),
			'steps'    => array(
				'h'     => 'How a care plan runs',
				'p'     => 'The same routine every month, so nothing is forgotten.',
				'items' => array(
					array( 'h' => 'Check-up', 'p' => 'I review your site and note anything that needs attention before the plan starts.' ),
					array( 'h' => 'Set-up', 'p' => 'Backups and monitoring are switched on, so nothing is left to chance.' ),
					array( 'h' => 'Every month', 'p' => 'Updates, backups and checks run on schedule.' ),
					array( 'h' => 'When something breaks', 'p' => 'You email me, and I reply within twelve hours.' ),
				),
			),
			'faqs'     => array(
				array( 'q' => 'Do I need a care plan after launch?', 'a' => 'No. Every project includes thirty days of fixes, and a care plan is optional after that.' ),
				array( 'q' => 'What does the plan cover?', 'a' => 'Updates, backups, security monitoring, speed and technical SEO.' ),
				array( 'q' => 'What happens if something breaks?', 'a' => 'Email me. I reply within twelve hours.' ),
				array( 'q' => 'How do we communicate?', 'a' => 'Email and a shared project board. Calls are optional, on request.' ),
			),
			'form'     => array(
				'h' => 'Ask about a care plan',
				'p' => 'Tell me about your site and I will reply within twelve hours with a plan and a price.',
			),
			'problem'  => array(
				'icon' => 'get-fewer-moving-parts',
				'h'    => 'My site needs looking after',
				'p'    => 'Updates, backups and security checks, every month.',
			),
		),

	);
}

/**
 * "From $450", or "From $129/mo" for a monthly service.
 *
 * @param array<string,mixed> $service One entry of jd_service_catalog().
 * @return string
 */
function jd_service_price( $service ) {
	return 'From $' . number_format( $service['from'] ) . $service['per'];
}

/**
 * The services as the homepage cards, footer, menu and 404 list them.
 *
 * @return array<int,array<string,string>>
 */
function jd_get_services() {
	$out = array();
	foreach ( jd_service_catalog() as $slug => $s ) {
		$out[] = array(
			'icon'  => $s['icon'],
			'name'  => $s['name'],
			'desc'  => $s['desc'],
			'price' => jd_service_price( $s ),
			'url'   => '/services/' . $slug . '/',
		);
	}
	return $out;
}

/**
 * The /services/ page. Its list, its problem cards and the figures in its
 * fact card are all worked out from jd_service_catalog().
 *
 * @return array<string,mixed>
 */
function jd_services_overview() {
	$catalog = jd_service_catalog();
	$once    = wp_list_pluck( wp_list_filter( $catalog, array( 'per' => '' ) ), 'from' );
	$monthly = wp_list_pluck( wp_list_filter( $catalog, array( 'per' => '/mo' ) ), 'from' );

	$facts = array( 'Services' => (string) count( $catalog ) );
	if ( $once ) {
		$facts['Projects from'] = '$' . number_format( min( $once ) );
	}
	if ( $monthly ) {
		$facts['Care plans from'] = '$' . number_format( min( $monthly ) ) . '/mo';
	}
	$facts += array(
		'Payment'      => '50% to start, 50% at launch',
		'After launch' => '30 days of fixes',
		'Replies'      => 'Within 12 hours',
	);

	return array(
		'hero'     => array(
			'eyebrow' => 'Services',
			'title'   => 'What I build',
			'lede'    => 'Six things I do properly, rather than everything done adequately. You work with me directly on all of them.',
			'price'   => count( $catalog ) . ' services',
			'note'    => 'one developer, start to finish',
			'time'    => 'Replies within 12 hours',
		),
		'list'     => array( 'h' => 'All services', 'p' => 'Choose a service for the full details: what is included, the timeline and the price.' ),
		'facts'    => $facts,
		'problems' => array( 'h' => 'Not sure which you need?', 'p' => 'Start from the problem. Each card points to the service that solves it.' ),
		'steps'    => array( 'h' => 'How every project runs', 'p' => 'The same four steps every time, so you always know what happens next.' ),
		// The homepage FAQs, less the one only a signed-up client needs.
		'faqs'     => array_values( wp_list_filter( jd_get_faqs(), array( 'q' => 'What if I need changes after launch?' ), 'NOT' ) ),
		'form'     => array( 'h' => 'Tell me what you are building', 'p' => 'Describe the problem and I will reply within twelve hours with scope and a price.' ),
	);
}

/**
 * Names and starting prices for the homepage estimator, keyed by its own
 * service keys. Printed as window.jdServices before assets/js/main.js.
 *
 * @return array<string,array{name:string,from:int}>
 */
function jd_estimator_services() {
	$out = array();
	foreach ( jd_service_catalog() as $s ) {
		if ( $s['est'] ) {
			$out[ $s['est'] ] = array(
				'name' => $s['name'],
				'from' => $s['from'],
			);
		}
	}
	return $out;
}

/**
 * What a page shows, if it is the Services page or a service under it.
 *
 * A page counts when its slug is a key of jd_service_catalog() and its parent
 * is the page with the slug "services". Any other page, including a service
 * page pasted in as HTML, is not matched and prints as it always has.
 *
 * @param int|WP_Post|null $post Page. Defaults to the current post.
 * @return array<string,mixed>|null The catalog entry plus its 'slug';
 *                                  array( 'overview' => true ) for the Services page; or null.
 */
function jd_service_for_page( $post = null ) {
	$post = get_post( $post );
	if ( ! $post || 'page' !== $post->post_type ) {
		return null;
	}

	if ( 'services' === $post->post_name && ! $post->post_parent ) {
		return array( 'overview' => true );
	}

	$parent  = $post->post_parent ? get_post( $post->post_parent ) : null;
	$catalog = jd_service_catalog();
	if ( $parent && 'services' === $parent->post_name && isset( $catalog[ $post->post_name ] ) ) {
		return array( 'slug' => $post->post_name ) + $catalog[ $post->post_name ];
	}

	return null;
}

/**
 * Tell anyone opening a service page in the block editor that the page is
 * drawn from this file, so an edit that never appears is not a mystery.
 */
function jd_service_editor_notice() {
	if ( ! jd_service_for_page() ) {
		return;
	}

	$message = __( 'This page is drawn from the theme (inc/services.php), so changes to its content here will not show on the site. Its title and SEO settings still apply.', 'jarral-digital' );

	// A handle with no file, so the notice can wait for the editor's own scripts.
	wp_register_script( 'jd-service-notice', false, array( 'wp-data', 'wp-notices', 'wp-dom-ready' ), JD_VERSION, true );
	wp_enqueue_script( 'jd-service-notice' );
	wp_add_inline_script(
		'jd-service-notice',
		'wp.domReady(function(){wp.data.dispatch("core/notices").createNotice("warning",' . wp_json_encode( $message ) . ',{isDismissible:false});});'
	);
}
add_action( 'enqueue_block_editor_assets', 'jd_service_editor_notice' );
