/* Analyze what visitors see. The saved editor content is deliberately untouched. */
(function () {
  'use strict';
  if (!window.wp || !wp.hooks || typeof window.jdSeoContent !== 'string') return;
  wp.hooks.addFilter('rank_math_content', 'jarral-digital/service-content', function () {
    return window.jdSeoContent;
  }, 99);
  function refresh() {
    if (window.rankMathEditor && typeof window.rankMathEditor.refresh === 'function') {
      window.rankMathEditor.refresh('content');
    }
  }
  wp.hooks.addAction('rank_math_loaded', 'jarral-digital/service-content', refresh);
  wp.domReady(refresh);
  window.addEventListener('load', refresh, { once: true });
}());
