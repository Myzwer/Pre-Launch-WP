/**
 * Gutenberg Button Style Controls (Editor Only)
 * ----------------------------------------------
 * This script modifies the core Button block style options
 * inside the block editor.
 *
 * Purpose:
 * - Remove WordPress default button styles ("Fill" and "Outline").
 * - Prevent editors from selecting unstyled core variants.
 * - Keep only theme-defined button style variations available.
 *
 * What it does:
 * - Runs on wp.domReady.
 * - Unregisters core/button styles: "fill" and "outline".
 *
 * Important notes:
 * - This affects the block editor UI only.
 * - It does not change frontend rendering.
 * - Custom button styles are registered in PHP via register_block_style().
 *
 * Related files:
 * - /includes/posts/editor.php → registers custom block styles
 * - /assets/src/css/tailwind.css → defines frontend button styling
 */
wp.domReady(() => {
	// Remove core defaults so editors can't choose them.
	wp.blocks.unregisterBlockStyle('core/button', 'fill');
	wp.blocks.unregisterBlockStyle('core/button', 'outline');
});
