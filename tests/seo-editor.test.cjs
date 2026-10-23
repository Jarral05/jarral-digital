// Exercise the Rank Math content hook and both early/late editor initialization.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const source = fs.readFileSync(require('node:path').join(__dirname, '../assets/js/seo-editor.js'), 'utf8');
const callbacks = {};
let filter, refreshes = 0;
const context = { wp: {
  hooks: {
    addFilter(name, namespace, callback) { assert.equal(name, 'rank_math_content'); filter = callback; },
    addAction(name, namespace, callback) { callbacks[name] = callback; }
  },
  domReady(callback) { callbacks.domReady = callback; }
}, jdSeoContent: '<h1>Rendered service</h1><p>Actual visitor content</p>',
addEventListener(name, callback) { callbacks[name] = callback; } };
context.window = context;
vm.runInNewContext(source, context);
assert.equal(filter('<p>Stale editor content</p>'), context.jdSeoContent);
callbacks.domReady(); // The editor may not have initialized yet.
context.rankMathEditor = { refresh(subject) { assert.equal(subject, 'content'); refreshes++; } };
callbacks.rank_math_loaded();
callbacks.load();
assert.equal(refreshes, 2);
vm.runInNewContext(source, {window:{}}); // Harmless outside its editor context.
console.log('Rank Math JS content and initialization checks passed.');
