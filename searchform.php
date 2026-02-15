<?php
/**
 * Search form template.
 *
 * Used in header, archives, and search result fallbacks.
 *
 * @link https://developer.wordpress.org/reference/functions/get_search_form/
 */
?>

<form role="search"
	  method="get"
	  class="search-form"
	  action="<?php echo esc_url(home_url('/')); ?>">

	<label class="sr-only" for="search-field">
		<?php esc_html_e('Search for:', 'prelaunch-wp'); ?>
	</label>

	<input
		type="search"
		id="search-field"
		class="search-field"
		placeholder="<?php echo esc_attr_x('Search…', 'placeholder', 'prelaunch-wp'); ?>"
		value="<?php echo esc_attr(get_search_query()); ?>"
		name="s"
	/>

	<button type="submit" class="search-submit">
		<span class="sr-only"><?php esc_html_e('Submit search', 'prelaunch-wp'); ?></span>
		<i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
	</button>
</form>
