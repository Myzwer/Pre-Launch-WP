/**
 * Gutenberg Editor Controls (Editor Only)
 * ========================================
 *
 * Responsibility
 * --------------
 * Applies editor-level constraints to core Gutenberg blocks
 * to enforce alignment with the theme design system.
 *
 * Scope
 * -----
 * - Executes in the block editor only.
 * - Does not affect frontend rendering.
 *
 * Behavior
 * --------
 * 1) Button Style Restrictions
 *    - Removes core Button block default styles ("fill", "outline").
 *    - Ensures only theme-defined style variations are available.
 *
 * 2) Embed Provider Restrictions
 *    - Allows the core/embed block.
 *    - Removes all provider variations except YouTube and Vimeo.
 *
 * Rationale
 * ---------
 * - Prevents editors from selecting styles that conflict with the design system.
 * - Limits embed providers to a controlled, article-safe subset.
 * - Maintains a predictable authoring surface across all sites using this starter theme.
 *
 * Dependencies
 * ------------
 * - Custom button styles are registered server-side via register_block_style().
 * - Visual styling is handled by blocks.css (Gutenberg bridge layer).
 *
 * Related Files
 * -------------
 * - /includes/posts/editor.php     → block allowlist + style registration
 * - /assets/src/css/blocks.css     → Gutenberg-to-design-system mappings
 * - /assets/public/css/blocks.css  → compiled bridge stylesheet
 */
wp.domReady(() => {
	// ---------------------------------------------------------------------
	// Button: remove core default styles
	// ---------------------------------------------------------------------
	wp.blocks.unregisterBlockStyle("core/button", "fill");
	wp.blocks.unregisterBlockStyle("core/button", "outline");

	// ---------------------------------------------------------------------
	// Embed: restrict provider variations
	// ---------------------------------------------------------------------
	const allowed = new Set(["youtube", "vimeo"]);

	const variations = wp.blocks.getBlockVariations("core/embed") || [];

	variations.forEach((variation) => {
		if (variation?.name && !allowed.has(variation.name)) {
			wp.blocks.unregisterBlockVariation("core/embed", variation.name);
		}
	});
});
