# SEO regression checks

`node tests/seo-editor.test.cjs` checks the Rank Math content filter and delayed
editor initialization. It requires only Node's built-in modules.

`seo-integration.php` requires a disposable WordPress installation. Never run it
on production. It refuses to run unless `WP_ENVIRONMENT_TYPE` is `local` and
the site hostname is `127.0.0.1`.

Set `JD_TEST_WP_ROOT` to that installation and run `php tests/seo-integration.php`.
Activate this theme, Rank Math and Jarral Forms first. In the parent directory
of WordPress, provide `fixture-ids.json`, mapping these fixture names to their
post IDs:

- `home`, `about`, `services`, `privacy-policy` (published pages)
- Each of the six slugs from `jd_service_catalog()` (published children of Services)
- `qa-article` (post by user ID 1), `qa-guest` (post by a different user with
  display name `Guest Writer`)

Set the static front page to Home, create and select a separate Blog posts
page, and use pretty permalinks. The test uses synthetic dates and temporarily
changes theme mods and the site title, restoring them in a `finally` block.
Block outbound HTTP/mail in the disposable installation. Theme test files are
excluded from release ZIPs.

`php tests/customizer-author.php` uses the same disposable installation and
environment guard. It checks the actual author dropdown HTML and saves/restores
a selection. User ID 1 must be an administrator. Rank Math is optional for this
test; run it with the plugin active and inactive.
