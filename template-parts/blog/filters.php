<?php
/**
 * Blog filters sidebar
 *
 * Outputs the filter UI for the blog index:
 * - Search field
 * - Category filters
 * - Tag filters
 * - Apply / Clear actions
 *
 * Expected $args:
 * - categories      (WP_Term[])
 * - tags            (WP_Term[])
 * - selected_cats   (int[]|string|array)  Accepts array (pl_cat[]) or comma string (pl_cat=1,2,3)
 * - selected_tags   (int[]|string|array)  Accepts array (pl_tag[]) or comma string (pl_tag=4,5,6)
 * - search_query    (string)
 * - clear_url       (string)
 * - posts_page_url  (string)
 *
 * Inputs:
 * - pl_cat[] or pl_cat=1,2,3
 * - pl_tag[] or pl_tag=4,5,6
 * - s (search query)
 *
 * Notes:
 * - This template renders UI only; it does not modify queries or redirect URLs.
 * - Selected state is derived from $args but can fall back to the current URL params.
 */

$posts_page_url = $args['posts_page_url'] ?? home_url( '/' );
$categories     = $args['categories'] ?? [];
$tags           = $args['tags'] ?? [];
$search_query   = $args['search_query'] ?? '';
$clear_url      = $args['clear_url'] ?? home_url( '/' );

// STATE: Selected filters may come from upstream ($args) or directly from URL params.
// Prefer $args, but normalize inputs so comma-strings still behave correctly.
$selected_cats = $args['selected_cats'] ?? [];
$selected_tags = $args['selected_tags'] ?? [];

/**
 * Parse IDs from either an array (pl_cat[]) or a comma string (pl_cat=1,2,3).
 *
 * @param mixed $value Raw input.
 *
 * @return int[] Sanitized IDs.
 */
$parse_id_list = static function ( $value ): array {
	if( is_string( $value ) ) {
		$value = preg_split( '/\s*,\s*/', $value, - 1, PREG_SPLIT_NO_EMPTY );
	}

	if( ! is_array( $value ) ) {
		return [];
	}

	return array_values( array_filter( array_map( 'absint', $value ) ) );
};

// If the canonical URL uses comma-strings, home.php may pass only the first value.
// Fall back to the URL param directly when present.
if( isset( $_GET['pl_cat'] ) ) {
	$selected_cats = $parse_id_list( wp_unslash( $_GET['pl_cat'] ) );
} else {
	$selected_cats = $parse_id_list( $selected_cats );
}

if( isset( $_GET['pl_tag'] ) ) {
	$selected_tags = $parse_id_list( wp_unslash( $_GET['pl_tag'] ) );
} else {
	$selected_tags = $parse_id_list( $selected_tags );
}
?>

<aside class="card">
	<div class="card__body">
		<form method="get" action="<?php echo esc_url( $posts_page_url ); ?>" class="grid gap-6">

			<?php // OUTPUT: Search input. ?>
			<div class="grid gap-2">
				<label class="text-sm font-semibold" for="pl-search">
					<?php esc_html_e( 'Search', 'prelaunch-wp' ); ?>
				</label>
				<input
					id="pl-search"
					type="search"
					name="s"
					value="<?php echo esc_attr( $search_query ); ?>"
					class="py-2 px-3 w-full rounded-lg border"
					placeholder="<?php echo esc_attr_x( 'Search posts…', 'placeholder', 'prelaunch-wp' ); ?>"
				/>
			</div>

			<?php // OUTPUT: Category checkboxes. ?>
			<?php if( ! empty( $categories ) ) : ?>
				<fieldset class="grid gap-3">
					<legend class="text-sm font-semibold">
						<?php esc_html_e( 'Categories', 'prelaunch-wp' ); ?>
					</legend>

					<div class="grid gap-2">
						<?php foreach( $categories as $cat ) : ?>
							<label class="grid gap-2 items-start text-sm grid-cols-[auto_1fr]">
								<input
									type="checkbox"
									name="pl_cat[]"
									value="<?php echo esc_attr( (int) $cat->term_id ); ?>"
									<?php checked( in_array( (int) $cat->term_id, $selected_cats, true ) ); ?>
									class="mt-1"
								/>
								<span><?php echo esc_html( $cat->name ); ?></span>
							</label>
						<?php endforeach; ?>
					</div>
				</fieldset>
			<?php endif; ?>

			<?php // OUTPUT: Tag checkboxes. ?>
			<?php if( ! empty( $tags ) ) : ?>
				<fieldset class="grid gap-3">
					<legend class="text-sm font-semibold">
						<?php esc_html_e( 'Tags', 'prelaunch-wp' ); ?>
					</legend>

					<div class="grid gap-2">
						<?php foreach( $tags as $tag ) : ?>
							<label class="grid gap-2 items-start text-sm grid-cols-[auto_1fr]">
								<input
									type="checkbox"
									name="pl_tag[]"
									value="<?php echo esc_attr( (int) $tag->term_id ); ?>"
									<?php checked( in_array( (int) $tag->term_id, $selected_tags, true ) ); ?>
									class="mt-1"
								/>
								<span><?php echo esc_html( $tag->name ); ?></span>
							</label>
						<?php endforeach; ?>
					</div>
				</fieldset>
			<?php endif; ?>

			<?php // OUTPUT: Actions. ?>
			<div class="grid gap-3">
				<button type="submit" class="justify-center w-full cursor-pointer btn_main">
					<?php esc_html_e( 'Apply filters', 'prelaunch-wp' ); ?>
				</button>

				<a class="justify-center w-full text-center btn_ghost_black"
				   href="<?php echo esc_url( $clear_url ); ?>">
					<?php esc_html_e( 'Clear', 'prelaunch-wp' ); ?>
				</a>
			</div>

		</form>
	</div>
</aside>
