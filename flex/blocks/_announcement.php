<?php
	/**
	 * Announcement block.
	 *
	 * Renders a highlighted announcement or important notice.
	 *
	 * Used in:
	 * - temporary announcements
	 * - alerts or updates
	 * - promotional messages
	 *
	 * Content is sourced from ACF Flexible Content fields.
	 *
	 * Notes:
	 * - Announcement text uses a WYSIWYG editor.
	 * - Optional button may link to additional information.
	 * - This block may visually override default section backgrounds.
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}


	$announcement = get_sub_field( 'announcement' );
	$link         = get_sub_field( 'link' );
?>
<section class="bg-secondary">
	<div class="wrap">
		<div class="py-10 grid-12 theme-invert">
			<div class="col-span-12">
				<?php if ( $announcement ) : ?>
					<div class="prose-theme"><?php echo wp_kses_post( $announcement ); ?></div>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $link['url'] ) ) : ?>
				<div class="col-span-12 mx-auto mt-5 text-center">
					<a
						class="btn_main"
						href="<?php echo esc_url( $link['url'] ); ?>"
						<?php echo ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"' : ''; ?>
					>
						<span><?php echo esc_html( $link['title'] ?: 'Learn More' ); ?></span>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
