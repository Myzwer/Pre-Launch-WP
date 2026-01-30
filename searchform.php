<?php
/**
 * Search form template.
 *
 * WordPress will use this file automatically when calling get_search_form().
 *
 * @link https://developer.wordpress.org/reference/functions/get_search_form/
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
	<label class="search-form__label">
		<span class="screen-reader-text">
			<?php esc_html_e('Search for:', 'prelaunch-wp'); ?>
		</span>

		<input
			type="search"
			class="search-form__input"
			placeholder="<?php echo esc_attr_x('Search…', 'placeholder', 'prelaunch-wp'); ?>"
			value="<?php echo get_search_query(); ?>"
			name="s"
		/>
	</label>

	<button type="submit" class="search-form__submit">
		<?php echo esc_html_x('Search', 'submit button', 'prelaunch-wp'); ?>
	</button>
</form>
