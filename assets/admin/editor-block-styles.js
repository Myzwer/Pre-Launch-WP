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
 * Dependencies
 * ------------
 * - Custom button styles are registered server-side via register_block_style().
 * - Visual styling is handled by blocks.css (Gutenberg bridge layer).
 *
 * Related Files
 * -------------
 * - /includes/posts/editor.php     → block allowlist + style registration
 * - /assets/src/css/blocks.css     → Gutenberg-to-design-system mappings
 */

(function () {
	// Guard: only run in Gutenberg with required APIs available.
	if (!window.wp?.domReady || !window.wp?.blocks) return;

	const { domReady } = window.wp;
	const { unregisterBlockStyle, unregisterBlockVariation, getBlockVariations } = window.wp.blocks;

	/**
	 * Safe unregister for block styles (won't throw if missing).
	 *
	 * @param {string} blockName
	 * @param {string} styleName
	 */
	const unregisterStyleSafe = (blockName, styleName) => {
		try {
			unregisterBlockStyle?.(blockName, styleName);
		} catch (e) {
			// No-op: style may not exist or WP version differs.
		}
	};

	/**
	 * Safe unregister for block variations (won't throw if missing).
	 *
	 * @param {string} blockName
	 * @param {string} variationName
	 */
	const unregisterVariationSafe = (blockName, variationName) => {
		try {
			unregisterBlockVariation?.(blockName, variationName);
		} catch (e) {
			// No-op: variation may not exist or WP version differs.
		}
	};

	domReady(() => {
		// Button: remove core default styles
		unregisterStyleSafe("core/button", "fill");
		unregisterStyleSafe("core/button", "outline");

		// Embed: restrict provider variations
		const allowed = new Set(["youtube", "vimeo"]);
		const variations = getBlockVariations?.("core/embed") || [];

		variations.forEach((variation) => {
			if (variation?.name && !allowed.has(variation.name)) {
				unregisterVariationSafe("core/embed", variation.name);
			}
		});
	});
})();
