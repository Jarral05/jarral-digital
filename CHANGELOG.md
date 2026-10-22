# Changelog

All notable changes to this project.
Format: [Keep a Changelog](https://keepachangelog.com/). Versioning: [SemVer](https://semver.org/).

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
