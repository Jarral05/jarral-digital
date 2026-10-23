# Changelog

All notable changes to this project.
Format: [Keep a Changelog](https://keepachangelog.com/). Versioning: [SemVer](https://semver.org/).

## [1.6.6] - 2026-10-23

### Added
- **Inner pages share the homepage's design.** About, Process, Contact, the
  three policies, the blog, `/work/`, project pages and the 404 open with a
  page hero: the homepage hero's pine band with breadcrumbs, the heading and
  an optional intro line. They close with a "Have a project in mind?" band
  (except Contact). The service and sub-service pages are unchanged: they
  print through page.php's pattern branch as before, and all seven render
  pixel-identical to 1.6.5 at 1440px and 390px. So does the homepage.
- **Pages have an Excerpt box.** A page's excerpt is the intro line under its
  heading. Leave it empty and the hero shows the heading only.
- **"On this page" list.** Pages and posts with three or more headings get a
  sticky list of them beside the content from 1024px.
  `jd_prepare_content()` gives each `<h2>` an id (an id the editor already
  set is kept). It also wraps tables in a box that scrolls sideways on a
  phone.
- **Contact page template** (`page-contact.php`, picked by the slug
  "contact"). The form sits beside the four promises from the homepage, now
  one list in `jd_get_promises()`. Below 900px the form comes first.
- **Project pages and `/work/`.** `archive-jd_project.php` and
  `taxonomy-jd_service_type.php` show the homepage's project cards and
  filter, with every project on one page (`jd_all_projects()`).
  `single-jd_project.php` puts the screenshot, the write-up and a Project
  facts card in the service pages' layout. Before this, `/work/` fell
  through to the blog list and project pages to the blog post template. A
  card's title links to the project page only when that page has content.
  The card markup lives in `template-parts/work-card.php`, shared with the
  homepage.

### Changed
- **The blog is a card grid.** index.php shows rounded cards for the blog,
  archives and search. A post without a featured image gets a blank tinted
  panel, so rows stay even. single.php uses the page hero (date and reading
  time) and an image cropped to 2:1.
- **Page content is set in the homepage's type.** A hairline separates
  sections, bullets are pine and tables sit in a rounded box. This is scoped
  to `.inner-page`, so the service pages' `.prose` is untouched.
- **`.promise` and `.contact-meta` are light by default.** The dark styling
  now applies only inside `.band-dark`, so the homepage section and the
  service pages' dark form bands look the same as before.
- **The homepage project swipe row is scoped to `.homepage`.** `/work/`
  keeps a stacked list on phones.

### Fixed
- **Visitors no longer see the admin note.** With no projects published,
  the homepage showed every visitor "Add your first project under Projects
  in the admin menu". Visitors now get a note with a link to get in touch,
  and the admin reminder shows only to logged-in editors.
- **Pagination shows on phones.** `the_posts_pagination()` wraps its links in
  `.nav-links`, the header menu's class, which is hidden below 1024px.
- **Pagination's heading is hidden again.** It is printed with
  `.screen-reader-text`, which the theme never defined, so "Posts
  pagination" showed on screen. The standard WordPress rule is now in
  main.css.

## [1.6.5] - 2026-10-23

### Changed
- **The homepage below the hero follows the hero's design.** Every section
  now has a small uppercase eyebrow over its heading. From 1024px the heading
  and its intro sit side by side. Section padding is 80/64/52px (was
  96/76/56). The page is 7,070px tall at 1440px (was 8,435) and 9,902px at
  390px (was 12,621).
- **The new styles apply to the homepage only.** front-page.php wraps the
  sections in `.homepage`, and the shared rules are scoped to it, because the
  service pages also use `.band`, `.sec-head`, `.steps`, `.svc` and `.faq`.
  The Services page renders pixel-identical before and after at 1440px and
  390px.
- **Each problem is paired with its fix.** The three problems are cards, each
  ending in its fix with a tick. `jd_get_problems()` gains a `fix` key, and
  the separate tinted box that listed the fixes is gone.
- **The estimator is a two-column panel.** It uses the same deep pine panel
  as the hero card: the choices on the left and the range on the right from
  1024px. The result panel is visible from the start with a prompt, and
  step 2 shows a hint until a type is picked, so the box is never half empty
  and nothing jumps on the first click. `.est-out.show` is no longer used,
  and main.js no longer adds it.
- **Projects show three across.** On desktop they are rounded white cards in
  a row of three, with excerpts clamped to three lines. On phones they are
  one swipe row, with the next card peeking in, instead of six stacked
  full-height cards. The row is keyboard-scrollable (`tabindex="0"`,
  labelled "Projects"). "View the site" gains an arrow to mark the external
  link.
- **Results come straight after the projects.** They now sit on the tint
  band, and Process moves to bone, so the bands still alternate. The three
  figures share one rounded card split by hairlines, the light-band twin of
  the hero's proof card.
- **Process is a numbered timeline.** It runs down the page below 1024px and
  across it above.
- **About puts a small portrait beside the heading on phones and tablets.**
  Before, a full-width photo pushed the heading most of a screen down. The
  four facts are a 2x2 grid instead of four rows.
- **The FAQ has an intro column.** On desktop a sticky intro sits beside the
  list, with a link to the form and the email address.
- **Service cards are compact rows on phones.** The icon sits beside the
  text and the price divider is dropped. Between 768px and 900px they show
  two across instead of one stretched column.

## [1.6.4] - 2026-10-23

### Changed
- **Homepage hero is two columns.** The six-row spec list under the buttons
  ran the full page width, each label about 1000px from its value, and made
  the hero 902px tall on desktop. Headline, intro and buttons now sit on the
  left with the three working terms as one line under the buttons; the three
  figures (120+, 14, 2020) sit large in a dark card on the right. Below 1024px
  the card drops under the buttons as a three-up strip. The hero is now 527px
  tall at 1440px and 696px at 375px (was 902px and 790px).
  `jd_get_spec()` is replaced by `jd_get_hero_stats()` and
  `jd_get_hero_terms()`, and the `.spec*` classes are gone. The card rises as
  one piece in the load animation, which now ends at 0.8s instead of 0.96s.

## [1.6.3] - 2026-10-23

### Changed
- **Homepage services are a card grid.** The six services were stacked rows;
  they are now white cards, three across (two at 901–1100px, one below
  900px), the same shape as the "What you get" cards on the service pages.
  `margin-top:auto` on the price pins it to the bottom of each card, so prices
  share one line across a row however long the description is. The 768px row
  layout and the hover arrow are gone. The Services page list and the 404 page
  use the same classes, so they change with it.
- **About facts are a panel.** The `.who-facts span` rules never matched,
  because `about.php` writes `<dt>` and `<dd>`: the labels never got their
  colour and the values never got their weight or alignment. The facts now sit
  in a bordered, rounded panel, labels in `#3C6B5C`, values bold, right-aligned
  and pine. `.spec,.who-facts{margin:0}` was also cancelling the list's top
  margin; it now applies to `.spec` only. The photo has rounded corners, and
  the section stacks below 900px instead of at 768px.
- **Homepage contact section has two columns.** Heading, reply-time line, four
  promises and an email line on the left, the form on the right; stacked below
  900px. The email address comes from `jd_contact_email()`.

### Fixed
- **The Services page could not be reached from the menu.** A top-level item
  with children renders as a button that opens the mega panel, so the URL set
  on it in Appearance > Menus was never used. The panel now ends with an
  "All services →" link to that URL, in the desktop panel and the mobile
  drawer. Any top-level item with children gets one, labelled from its title;
  a `#` placeholder gets none.
- **Mobile submenu links had lost their indent.** `.drawer a:not(.btn)`
  outranked `.drawer-list .jd-mega-link`, so the 38px indent never applied
  and sub-items sat flush with the top level. The selector now includes `a`.

## [1.6.2] - 2026-10-23

### Fixed
- **Sites could not see theme updates.** `.gitignore` had `vendor/`, which
  also matched the update library's own `lib/plugin-update-checker/vendor/`,
  so Parsedown and the readme parser were never committed and never reached a
  release zip. When the latest GitHub release has notes, the update check
  formats them with Parsedown, hit `Class "Parsedown" not found`, and stopped
  before recording the update. The rule is now `/vendor/`, top level only, and
  the library ships complete. Confirmed on the live site: `vendor/Parsedown.php`
  returned 404.
- **Theme releases no longer carry release notes.** Sites on 1.6.1 or earlier
  still have the incomplete library, and their check only survives a release
  with no notes. Without notes they find 1.6.2 and update themselves.
  `CHANGELOG.md` is the record instead.
- **Body text was never in IBM Plex Sans.** The files were named
  `ibm-plex-sans-regular.woff2` and `ibm-plex-sans-latin-600.woff2`, but
  `main.css` and the preload in `inc/enqueue.php` ask for
  `ibm-plex-sans-400.woff2` and `ibm-plex-sans-600.woff2`. Both returned 404
  on the live site, so regular and semibold text fell back to the system font.
  Renamed to match.

## [1.6.1] - 2026-10-22

### Updated
- **Block patterns for service pages**, under a new "Jarral Digital" category
  in the inserter: hero, details with fact card, what you get, steps, and
  enquiry form. Each is a single Custom HTML block rather than core blocks,
  because core blocks add their own wrappers and class names, and the
  stylesheet targets these sections by exact class. All copy is placeholder
  text. The enquiry form pattern's `service="Service name"` tags every enquiry
  it sends, so replace it on each page. 

## [1.6.0] - 2026-10-22

### Added
- **Block patterns for service pages**, under a new "Jarral Digital" category
  in the inserter: hero, details with fact card, what you get, steps, and
  enquiry form. Each is a single Custom HTML block rather than core blocks,
  because core blocks add their own wrappers and class names, and the
  stylesheet targets these sections by exact class. All copy is placeholder
  text. The enquiry form pattern's `service="Service name"` tags every enquiry
  it sends, so replace it on each page.
- **Pages built from those patterns now print full width.** `page.php`
  wrapped all content in a band, a `.wrap` and the 68ch `.prose` column under
  the page title. That squeezed every section into the text column, put a
  second `<h1>` above the hero's own, and let `.prose` styles leak in - the
  hero eyebrow rendered at about 1.3:1 on pine. `jd_is_pattern_page()` checks
  the content for a `<section>` with a `svc-hero` or `band` class. Matching
  pages print bare and plain pages keep the wrapper, for existing and future
  pages alike, with nothing to set in the editor.
- A "Service page" template that always prints the content bare, for pages
  the check misses. A page holding only the enquiry form is one: its band only
  exists once the shortcode renders, so the saved content has no `<section>`.
- Service page styles: `.svc-hero`, `.cols` with a sticky `.factcard`, and the
  `.gets` card grid, built from the existing colour tokens.
- A radius scale in `:root`: `--r-sm` 6px, `--r-md` 12px, `--r-lg` 16px
  (`--r-lg` is not used yet).

### Changed
- Buttons, chips, filters and form fields use `--r-sm` instead of 4px. Form
  notes and the estimate card use `--r-md`. The skip link and the top-level
  focus ring keep their own radii on purpose. `.burger` and `.jd-mega-link`
  are still 4px.
- The contact form sits on a card: white with a `--line` border on light
  pages, and a 5% white wash on the dark band. Not `--pine-deep`, because the
  dark fields are already that colour and would vanish into the panel. The
  card's padding comes out of the form's `max-width`, so fields are 58px
  narrower: 502px, or 662px inside a shortcode block.

### Verified this release
- `php -l` clean on PHP 8.2.27 for every changed file.
- Pattern code executed outside WordPress with stand-ins for the WP functions
  it calls. 39 checks passed: registration, one block per pattern,
  well-formed markup, six cards with icons, four numbered steps, and page
  detection true for the four section patterns and false for the form pattern
  and a plain page.
- Not yet seen in a browser or the block editor.


## [1.5.2] - 2026-10-22

### Fixed
- The theme never called `enableReleaseAssets()`, unlike both plugins, so
  sites downloaded GitHub's auto-generated source archive — carrying
  `.github/` and `.gitignore` onto production.
- Removed the branch fallback from update detection, so an untagged version
  bump on `main` is no longer served as an update. The theme filter name
  carries a `_theme` suffix the plugin names do not.

### Added
- `php -l` runs over every PHP file before the zip is built.

## [1.5.1] - 2026-10-22

### Fixed
- **The mobile submenu was permanently expanded and the arrow did nothing.**
  `.drawer-list .jd-mega[hidden]{display:block}` was overriding the browser's
  own `[hidden]` styling, so `panel.hidden = true` in the JavaScript had no
  visible effect. The rule existed to stop the panel being absolutely
  positioned inside the drawer; it took the toggle down with it. The drawer
  submenu now animates `grid-template-rows` from `0fr` to `1fr`, which reaches
  the panel's real height without guessing a max-height, and uses
  `visibility` to keep collapsed links out of the keyboard tab order.
  Verified at 390x667: 0px and hidden at rest, 112px and visible after a tap,
  back to 0px on a second tap.
- **The drawer could grow taller than the screen.** Six menu items, an open
  submenu, the button and the contact line come to roughly 740px, against a
  667px viewport on an iPhone SE - so the button at the bottom could not be
  reached. The drawer now scrolls itself, capped at `calc(100dvh - 66px)`,
  with `overscroll-behavior: contain` so a flick at the end of the list does
  not scroll the page behind it, and `scroll-behavior: smooth`.
- **The submenu stayed open after navigating away and back.** Closing the
  drawer now collapses every open panel, resets each trigger's
  `aria-expanded`, and returns the scroll position to the top.
- **The drawer's close handler missed taps on child elements.** It tested
  `e.target.tagName === 'A'`, which fails when the tap lands on a `<span>`
  inside the link - as it does on every submenu item. Now uses
  `e.target.closest('a')`.

### Changed
- GitHub username corrected from the `mohsinjarral` placeholder to `Jarral05`
  in `style.css` and `inc/updates.php`. With the placeholder in place the
  update checker queried a repository that does not exist, which fails
  silently: no update notice, no error.
- `jd_contact_email()` now falls back to the forms plugin's `JDF_FROM_EMAIL`
  before the WordPress admin email. On most installs the admin email is a
  personal address, and it was being printed in the site footer and the
  mobile menu - published to every visitor and every scraper.

### Accessibility
- `prefers-reduced-motion` now also covers the submenu transition and the
  drawer's smooth scrolling. The visibility delay is dropped too, or a
  collapsed panel would keep its links tabbable for a quarter of a second.

## [1.5.0] - 2026-10-22

### Fixed
- **The "Start a project" button was missing from the mobile menu.** The
  button lived inside `.nav-links`, and `.nav-links` is `display:none` below
  1024px. It was never hidden on purpose - it was hidden as a side effect of
  hiding the desktop navigation around it. The drawer now carries its own
  copy, plus the reply time and contact address.
- **`.drawer a` would have repainted that button.** The rule sets its own
  colour and bottom border, and at (0,0,1,1) it outranks `.btn-invert` at
  (0,0,1,0) - the same cascade bug that dropped the header button to 1.44:1
  in 1.3.0. Scoped to `.drawer a:not(.btn)`. Verified in a real browser at
  390px: 10.07:1, 47px tall, bone border on all four sides.

### Changed
- **Estimator labels now match the service names exactly.** `NAMES` in
  `main.js` wrote short labels ("Website", "Portal or members area") while
  `jd_get_services()` used full ones ("WordPress development", "Membership
  sites and client portals"). The same service therefore arrived in the
  admin under two different names depending on which page the visitor used.
  `NAMES` now matches `jd_get_services()` word for word. These are not the
  chip labels - those stay short and conversational.

### Added
- `jd_contact_email()` - the public contact address in one place, falling
  back to the WordPress admin email so the site never prints a `mailto:` to
  a mailbox that does not exist yet.

## [1.4.1] - 2026-10-22

### Fixed
- **The mega panel rendered as a narrow, distorted dropdown.** `.jd-mega` is
  `position:absolute`, so it anchors to its nearest positioned ancestor.
  `.jd-top` carried `position:relative`, which made that ancestor the `<li>` -
  so `left:0; right:0` resolved to the width of the word "Services", roughly
  70px, and the three-column grid collapsed into it. Every ancestor is now
  static, making `.nav` (already `position:sticky`, which counts as
  positioned) the containing block. Verified in a headless browser: the panel
  now measures exactly the same width as the header, with three equal columns.
- **The mobile drawer submenu was unstyled.** The drawer called
  `wp_nav_menu()` without the walker, so it emitted WordPress's default
  `.sub-menu` markup, which none of the theme's CSS or JS targeted. It now
  uses the same walker as the desktop menu, so the drawer renders the children
  as a nested list with its own expand toggle.
- Added a drop shadow under the panel so it reads as floating above the page.
- Drawer caret moved to the right edge of its row.

## [1.4.0] - 2026-10-21

### Added
- **Mega menu.** Drag pages under a parent item in Appearance > Menus and the
  theme renders them as a three-column panel with icon, description and price
  instead of a plain dropdown. The editing is done in WordPress's own menu
  screen; `inc/nav-walker.php` is only the renderer, so navigation never
  requires touching code.
- The icon, description and price are looked up from `jd_get_services()` by
  matching each menu item's URL, so a price changed in one place changes in
  the menu, on the homepage and in the footer together.
- A menu item with no matching service degrades cleanly to a plain link.
- Built as a disclosure, not a hover trick: the trigger is a real `<button>`
  with `aria-expanded` and `aria-haspopup`, it opens on hover with a pointer
  and on click or Enter with a keyboard, closes on Escape with focus returned
  to the trigger, and closes on outside click or focus leaving the item.
  A 180ms delay on mouseleave lets the pointer travel into the panel.
- On mobile the same menu renders as a nested list inside the drawer rather
  than a panel, with its own expand toggle.

## [1.3.1] - 2026-10-21

Three bugs found on the live site and fixed. All three were only visible
once the theme was actually rendering in a browser.

### Fixed
- **The logo rendered as an empty white square.** `jd_icon()` passes each SVG
  through `wp_kses()`, and the allowlist for `<path>` permitted only `d` and
  `fill`. The logo mark draws its J with `stroke`, `stroke-width`,
  `stroke-linecap` and `stroke-linejoin`, so all four were stripped, leaving
  a path with `fill="none"` and no stroke - which renders as nothing. The
  background `<rect>` kept its `fill`, hence the white square. The allowlist
  now covers stroke attributes on every shape element, plus `g`, `polygon`,
  `title`, `desc`, `role` and `aria-label`.
  The service icons were unaffected because they set `stroke` on the parent
  `<svg>`, which was already allowlisted, and the children inherit it.
- **The header button was unreadable at 1.44:1.** `.nav-links a` has
  specificity (0,0,1,1) and `.btn-invert` only (0,0,1,0), so the nav rule won
  and repainted the button's text in the muted on-pine colour over its own
  bone background. Both nav rules are now scoped with `:not(.btn)`, which
  restores the intended 10.07:1.
- **The contact form was styled for a dark background only.** Via
  `[jarral_contact_form]` on an ordinary light page, the labels rendered at
  1.44:1 and the submit button was bone-on-bone, i.e. invisible. The form now
  defaults to a light treatment and the dark styling is scoped to
  `.band-dark`, so both the homepage section and the Contact page are legible.
  Notices and inline errors got the same treatment.
- **Project-box placeholder label** moved from #5F6E67 (4.49:1) to #5A6861
  (4.90:1), clearing WCAG AA. All twenty colour pairs in the theme now pass.
- **Empty footer column.** With no Footer menu assigned, the Company heading
  rendered above nothing. It now falls back to Work, Process and About.

## [1.3.0] - 2026-10-21

### Added
- `screenshot.png` (1200x900) so the theme shows a branded preview on the
  Appearance > Themes screen instead of a grey placeholder.
- Horizontal logo lockups (`logo-lockup.svg`, `logo-lockup-light.svg`) for
  use anywhere a single-file logo is wanted.
- A restrained motion system: one orchestrated hero entrance on page load,
  a hover arrow on service rows as a click affordance, a flash on the
  estimator figure when the price changes, press feedback on buttons and
  chips, a rotating FAQ icon, and a shadow under the header once scrolled.
  Every one is disabled under `prefers-reduced-motion: reduce`.
- Deliberately NOT added: scroll-triggered fade-up on each section. It is
  the commonest tell of a templated site and it causes layout shift, which
  costs Core Web Vitals.

### Fixed
- **Font fallback.** The theme previously named only the self-hosted
  families, so a missing woff2 file left the page in the browser's default
  serif - which read as broken rather than unstyled. `--font-head` and
  `--font-body` now carry full stacks ending in the system UI face, so the
  site looks deliberate with zero font files present. The woff2 files are
  now an enhancement, not a prerequisite.
- **Contrast.** The placeholder label inside an empty project-screenshot box
  was #7C8F87 on #E4EDE8 = 2.86:1, failing WCAG AA. Now #5F6E67 = 5.40:1.
  Every other colour pair in the theme was measured and passes AA; buttons
  sit at 10.07:1.

## [1.2.0] - 2026-10-19

### Fixed
- SVG icons carried ~7.7 KB of embedded C2PA provenance metadata each, 65 KB
  across the eight files. `wp_kses()` stripped the tags at output so nothing
  was ever served to a visitor, but WordPress parsed 65 KB of dead weight on
  every page load. Icons regenerated clean: 65,153 bytes -> 2,835 bytes.

### Verified this release (PHP 8.3.6, executed not just inspected)
- All 35 project PHP files and all 129 bundled library files pass `php -l`.
- Theme loads and runs with no fatals; all hooks fire.
- Icon loader: 10 path-traversal payloads attempted, all 10 blocked.
- Both JSON-LD schema blocks emit valid JSON; FAQ schema count matches the
  rendered page exactly (7 = 7).
- Form handler attacked with honeypot, sub-3-second timing, missing nonce,
  malformed email, short and oversized messages, link spam, oversized name,
  forged dropdown values and stored XSS. Every guard held; nothing unwanted
  was written to the database.
- Rate limit fires on the 6th attempt against a cap of 5.
- Validation errors reach the user and submitted input survives the bounce.

## [1.1.0] - 2026-09-29

### Security
- `jd_icon()` now uses a strict `[a-z0-9-]` allowlist plus a `realpath()`
  containment check, rather than `sanitize_file_name()` alone. Closes a
  theoretical path-traversal surface in the icon loader.
- Added the `Update URI` header to the theme and both plugins. Without it,
  a plugin published on wordpress.org under the same folder name could be
  served to your sites as an "update".

### Added
- GitHub-based update checking (Plugin Update Checker 5.7, MIT).
- `uninstall.php` for both plugins. Enquiries and Projects are deliberately
  preserved; only transients and rewrite rules are cleared.
- `load_theme_textdomain()` and `index.php` silence files throughout.
- `readme.txt` for both plugins.

### Fixed
- `remove_action()` was called with four arguments; it accepts three.
- `wp_sprintf()` replaced with `sprintf()` where no list formatting was used.

## [1.0.0] - 2026-09-29

### Added
- First release: 25-file classic theme, Projects plugin, Forms plugin.
