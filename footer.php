<?php
	/**
	 * Theme Footer Loader
	 * -------------------
	 * Loads the appropriate footer template
	 * based on the ACF "footer_layout" option.
	 */

	$layout = get_field( 'footer_layout', 'option' ) ?: 'simple';

	switch ( $layout ) {
		case 'complex':
			get_template_part( 'template-parts/footer/footer', 'complex' );
			break;

		case 'simple':
		default:
			get_template_part( 'template-parts/footer/footer', 'simple' );
			break;
	}

	wp_footer();
?>
</body>
</html>
