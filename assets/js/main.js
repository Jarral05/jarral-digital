/**
 * Jarral Digital - front-end behaviour.
 *
 * Three things only: the mobile drawer, the estimator, the work filter.
 * No framework, no dependencies, no build step. Roughly 3KB.
 */
(function () {
	'use strict';

	/* ------------------------------------------------------------------
	   Mobile drawer
	   ------------------------------------------------------------------ */
	var burger = document.getElementById('burger');
	var drawer = document.getElementById('drawer');

	if (burger && drawer) {

		/* Closing the drawer also collapses any open submenu and returns the
		   scroll position to the top, so the menu always opens in the same
		   state it did the first time. Without this, tapping Services, then
		   navigating, then reopening the menu shows it already expanded and
		   scrolled halfway down. */
		var closeDrawer = function (returnFocus) {
			drawer.classList.remove('open');
			burger.textContent = 'Menu';
			burger.setAttribute('aria-expanded', 'false');

			[].forEach.call(drawer.querySelectorAll('.jd-mega.is-open'), function (p) {
				p.classList.remove('is-open');
			});
			[].forEach.call(drawer.querySelectorAll('.jd-mega-toggle'), function (t) {
				t.setAttribute('aria-expanded', 'false');
			});

			drawer.scrollTop = 0;

			if (returnFocus) { burger.focus(); }
		};

		burger.addEventListener('click', function () {
			if (drawer.classList.contains('open')) {
				closeDrawer(false);
				return;
			}
			drawer.classList.add('open');
			burger.setAttribute('aria-expanded', 'true');
			burger.textContent = 'Close';
		});

		drawer.addEventListener('click', function (e) {
			// Only real links close the drawer. The submenu trigger is a
			// <button>, so tapping it expands in place as it should.
			if (e.target.closest('a')) {
				closeDrawer(false);
			}
		});

		// Escape closes it. Small thing, but keyboard users expect it.
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && drawer.classList.contains('open')) {
				closeDrawer(true);
			}
		});
	}

	/* ------------------------------------------------------------------
	   Estimator

	   The lowest figure and the service name come from the theme's service
	   list (inc/services.php), printed as window.jdServices, so they always
	   match the service pages. The low figures and names below are only the
	   fallback if that is missing. Edit the rest here:
	     base  : [lowest, highest] before extras
	     weeks : timeline text
	     opts  : ['Button label', amount added to the low figure]
	             the high figure rises by 1.6x that amount
	   ------------------------------------------------------------------ */
	var DATA = {
		wp: {
			base: [450, 1400], weeks: '2\u20133 weeks',
			opts: [['More than 8 pages', 350], ['Online payments or shop', 500], ['Move from another platform', 250], ['Copywriting help', 300]]
		},
		app: {
			base: [900, 4500], weeks: '4\u20138 weeks',
			opts: [['User accounts and roles', 600], ['Payments or subscriptions', 700], ['Connects to another system', 500], ['Admin dashboard', 600]]
		},
		forms: {
			base: [180, 700], weeks: '3\u20137 days',
			opts: [['Generates a PDF', 180], ['Multi-step with logic', 150], ['Sends to a CRM', 180], ['E-signature', 250]]
		},
		portal: {
			base: [300, 1600], weeks: '2\u20134 weeks',
			opts: [['Paid memberships', 450], ['Courses or lessons', 500], ['Document downloads per user', 300], ['Tiered access levels', 250]]
		},
		ai: {
			base: [600, 2500], weeks: '2\u20134 weeks',
			opts: [['Trained on your documents', 500], ['Lives on your website', 300], ['Connects to email or CRM', 450], ['Multiple languages', 300]]
		}
	};

	/* The label written into the URL, and from there into the database, the
	   Enquiries list and the email subject.

	   These are NOT the chip labels the visitor reads - the chips stay short
	   and conversational. They are the service names from the theme, so an
	   enquiry from the estimator and an enquiry from a service page land
	   under the same name in the admin instead of under two names for the
	   same thing. */
	var NAMES = {
		wp:     'WordPress development',
		app:    'Headless WordPress and web apps',
		forms:  'Forms, PDFs and document automation',
		portal: 'Membership sites and client portals',
		ai:     'AI agents and automation'
	};

	var SERVICES = window.jdServices || {};
	Object.keys(DATA).forEach(function (k) {
		if (SERVICES[k]) {
			DATA[k].base[0] = SERVICES[k].from;
			NAMES[k] = SERVICES[k].name;
		}
	});

	var elSvc  = document.getElementById('jdSvc');
	var elOpt  = document.getElementById('jdOpt');
	var elStep = document.getElementById('jdOptStep');
	var elOut  = document.getElementById('jdOut');
	var elFig  = document.getElementById('jdFig');
	var elMeta = document.getElementById('jdMeta');
	var elCta  = document.getElementById('jdCta');

	if (elSvc && elOpt && elOut) {
		var svc = null;
		var picked = [];
		var baseHref = elCta ? elCta.getAttribute('href') : '/contact/';

		elSvc.addEventListener('click', function (e) {
			var b = e.target.closest('.chip');
			if (!b || !DATA[b.dataset.k]) { return; }

			svc = b.dataset.k;
			picked = [];

			Array.prototype.forEach.call(elSvc.children, function (c) {
				c.setAttribute('aria-pressed', c === b ? 'true' : 'false');
			});

			elOpt.innerHTML = '';
			DATA[svc].opts.forEach(function (o, i) {
				var el = document.createElement('button');
				el.type = 'button';
				el.className = 'chip';
				el.dataset.i = i;
				el.setAttribute('aria-pressed', 'false');
				el.textContent = o[0];
				elOpt.appendChild(el);
			});

			elStep.hidden = false;
			render();
		});

		elOpt.addEventListener('click', function (e) {
			var b = e.target.closest('.chip');
			if (!b) { return; }

			var i = parseInt(b.dataset.i, 10);
			var at = picked.indexOf(i);

			if (at > -1) {
				picked.splice(at, 1);
				b.setAttribute('aria-pressed', 'false');
			} else {
				picked.push(i);
				b.setAttribute('aria-pressed', 'true');
			}
			render();
		});

		var render = function () {
			var d = DATA[svc];
			var lo = d.base[0];
			var hi = d.base[1];
			var labels = [];

			picked.forEach(function (i) {
				lo += d.opts[i][1];
				hi += Math.round(d.opts[i][1] * 1.6);
				labels.push(d.opts[i][0]);
			});

			var next = '$' + lo.toLocaleString() + ' \u2013 $' + hi.toLocaleString();
			if (elFig.textContent !== next) {
				elFig.textContent = next;
				// Re-trigger the CSS animation by removing and re-adding the class.
				elFig.classList.remove('jd-changed');
				void elFig.offsetWidth;
				elFig.classList.add('jd-changed');
			}
			elMeta.textContent = 'Typical timeline: ' + d.weeks +
				(picked.length ? '. ' + picked.length + ' extra' + (picked.length > 1 ? 's' : '') + ' included.' : '.');

			// Hand the selection to the contact form through the URL.
			if (elCta) {
				elCta.href = baseHref +
					'?est_service=' + encodeURIComponent(NAMES[svc]) +
					'&est_range=' + encodeURIComponent('$' + lo + ' - $' + hi) +
					(labels.length ? '&est_extras=' + encodeURIComponent(labels.join(', ')) : '');
			}
		};
	}

	/* ------------------------------------------------------------------
	   Work filter
	   ------------------------------------------------------------------ */
	var filters = document.getElementById('filters');
	var grid = document.getElementById('workGrid');

	if (filters && grid) {
		var cards = grid.querySelectorAll('.work-card');

		filters.addEventListener('click', function (e) {
			var b = e.target.closest('.filter');
			if (!b) { return; }

			var f = b.dataset.f;

			Array.prototype.forEach.call(filters.children, function (c) {
				c.setAttribute('aria-pressed', c === b ? 'true' : 'false');
			});

			Array.prototype.forEach.call(cards, function (card) {
				var tags = (card.dataset.tags || '').split(' ');
				card.hidden = !(f === 'all' || tags.indexOf(f) > -1);
			});
		});
	}

	/* ------------------------------------------------------------------
	   Small visual touches. Both are progressive: if this script fails
	   to load, the page still works exactly as before.
	   ------------------------------------------------------------------ */

	// Shadow under the header once the page has scrolled, so the sticky bar
	// reads as floating above the content rather than painted onto it.
	var navEl = document.querySelector('.nav');
	if (navEl) {
		var onScroll = function () {
			if (window.scrollY > 8) { navEl.classList.add('jd-stuck'); }
			else { navEl.classList.remove('jd-stuck'); }
		};
		window.addEventListener('scroll', onScroll, { passive: true });
		onScroll();
	}

	/* ------------------------------------------------------------------
	   Mega menu

	   Opens on hover for a mouse, on click or Enter for a keyboard, and
	   closes on Escape with focus returned to the trigger. Hover alone is
	   not an interface: it is invisible to keyboards and unusable on touch.
	   ------------------------------------------------------------------ */
	var megas = [].slice.call(document.querySelectorAll('.nav-list .jd-has-mega'));

	if (megas.length) {
		var closeAll = function (except) {
			megas.forEach(function (li) {
				if (li === except) { return; }
				var t = li.querySelector('.jd-mega-toggle');
				var p = li.querySelector('.jd-mega');
				if (t) { t.setAttribute('aria-expanded', 'false'); }
				if (p) { p.hidden = true; }
			});
		};

		var setOpen = function (li, open) {
			var t = li.querySelector('.jd-mega-toggle');
			var p = li.querySelector('.jd-mega');
			if (!t || !p) { return; }
			if (open) { closeAll(li); }
			t.setAttribute('aria-expanded', open ? 'true' : 'false');
			p.hidden = !open;
		};

		megas.forEach(function (li) {
			var toggle = li.querySelector('.jd-mega-toggle');
			var panel  = li.querySelector('.jd-mega');
			if (!toggle || !panel) { return; }

			var hoverTimer = null;

			toggle.addEventListener('click', function () {
				setOpen(li, toggle.getAttribute('aria-expanded') !== 'true');
			});

			// Hover, with a short delay on leaving so the pointer can travel
			// from the trigger down into the panel without it snapping shut.
			li.addEventListener('mouseenter', function () {
				if (window.matchMedia('(hover: hover)').matches) {
					clearTimeout(hoverTimer);
					setOpen(li, true);
				}
			});
			li.addEventListener('mouseleave', function () {
				if (window.matchMedia('(hover: hover)').matches) {
					hoverTimer = setTimeout(function () { setOpen(li, false); }, 180);
				}
			});

			// Leaving the whole item by keyboard closes it.
			li.addEventListener('focusout', function (e) {
				if (!li.contains(e.relatedTarget)) { setOpen(li, false); }
			});
		});

		document.addEventListener('keydown', function (e) {
			if (e.key !== 'Escape') { return; }
			var open = document.querySelector('.jd-mega-toggle[aria-expanded="true"]');
			if (open) {
				closeAll(null);
				open.focus();
			}
		});

		document.addEventListener('click', function (e) {
			if (!e.target.closest('.jd-has-mega')) { closeAll(null); }
		});
	}

	/* Mobile drawer: the mega panel is a plain nested list, so its trigger
	   just expands it in place. */
	var drawerToggles = [].slice.call(document.querySelectorAll('.drawer-list .jd-mega-toggle'));
	drawerToggles.forEach(function (t) {
		var panel = t.parentNode.querySelector('.jd-mega');
		if (!panel) { return; }

		/* A class, not the hidden attribute.
		   `hidden` means display:none, and display cannot be transitioned,
		   so using it here made the submenu snap open and shut. The CSS
		   animates grid-template-rows on .is-open instead. The panel also
		   must NOT carry `hidden` at rest - the collapsed state is the
		   class's job now, and leaving both in place would hide the panel
		   in a way the transition could never undo. */
		panel.hidden = false;
		panel.classList.remove('is-open');
		t.setAttribute('aria-expanded', 'false');

		t.addEventListener('click', function () {
			var open = t.getAttribute('aria-expanded') === 'true';
			t.setAttribute('aria-expanded', open ? 'false' : 'true');
			panel.classList.toggle('is-open', !open);
		});
	});
})();
