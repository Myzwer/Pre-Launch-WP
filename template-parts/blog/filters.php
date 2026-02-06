<?php
/**
 * Blog filters sidebar.
 *
 * Outputs the filter UI for the blog index, including:
 * - search field
 * - category filters
 * - tag filters
 * - apply / clear actions
 *
 * Expected $args:
 * - categories      (WP_Term[])
 * - tags            (WP_Term[])
 * - selected_cats   (int[])
 * - selected_tags   (int[])
 * - search_query    (string)
 * - clear_url       (string)
 * - posts_page_url  (string)
 *
 * Notes:
 * - This template assumes filter/query logic is prepared upstream.
 * - No query manipulation should occur here.
 */
?>

<?php

$posts_page_url = $args['posts_page_url'] ?? home_url( '/' );
$categories     = $args['categories'] ?? [];
$tags           = $args['tags'] ?? [];
$selected_cats  = $args['selected_cats'] ?? [];
$selected_tags  = $args['selected_tags'] ?? [];
$search_query   = $args['search_query'] ?? '';
$clear_url      = $args['clear_url'] ?? home_url( '/' );

?>

<aside class="card">
	<div class="card__body">
		<form method="get" action="<?php echo esc_url( $posts_page_url ); ?>" class="grid gap-6">
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
