<?php
/** Rank Math analysis for service pages whose editor content is not rendered. */
defined( 'ABSPATH' ) || exit;

/** Render the actual templates, omitting interactive form fields and SVG icons. */
function jd_service_analysis_content( $post = null ) {
	$service = jd_service_for_page( $post );
	if ( ! $service ) {
		return '';
	}
	ob_start();
	get_template_part(
		empty( $service['overview'] ) ? 'template-parts/service/single' : 'template-parts/service/overview',
		null,
		array( 'service' => $service, 'analysis' => true )
	);
	$html = ob_get_clean();
	return preg_replace( '#<(svg|script|style)\b[^>]*>.*?</\1>#is', '', $html );
}

function jd_rank_math_editor_assets( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) || ! defined( 'RANK_MATH_VERSION' ) || ! wp_script_is( 'rank-math-analyzer', 'registered' ) ) {
		return;
	}
	$content = jd_service_analysis_content();
	if ( '' === $content ) {
		return;
	}
	wp_enqueue_script( 'jd-seo-editor', JD_URI . '/assets/js/seo-editor.js', array( 'wp-hooks', 'wp-dom-ready', 'rank-math-analyzer' ), JD_VERSION, true );
	wp_add_inline_script( 'jd-seo-editor', 'window.jdSeoContent=' . wp_json_encode( $content, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT ) . ';', 'before' );
}
add_action( 'admin_enqueue_scripts', 'jd_rank_math_editor_assets', 99 );
