<?php
/** Byline uses the same author identity as Article schema, without Gravatar. */
defined( 'ABSPATH' ) || exit;
$jd_author = jd_post_author();
if ( ! $jd_author ) {
	return;
}
$jd_bio = get_the_author_meta( 'description' );
?>
<aside class="post-author wrap" aria-label="<?php esc_attr_e( 'About the author', 'jarral-digital' ); ?>">
	<p class="eyebrow"><?php esc_html_e( 'Written by', 'jarral-digital' ); ?></p>
	<h2><a href="<?php echo esc_url( $jd_author['url'] ); ?>" rel="author"><?php echo esc_html( $jd_author['name'] ); ?></a></h2>
	<?php if ( $jd_bio ) : ?>
		<p><?php echo esc_html( $jd_bio ); ?></p>
	<?php endif; ?>
</aside>
