<?php
	/**
	 * List content block.
	 *
	 * Renders a repeating list of titled items with optional descriptive text.
	 *
	 * Used in:
	 * - service lists
	 * - feature highlights
	 * - informational bullet sections
	 *
	 * Content is sourced from ACF Flexible Content fields.
	 *
	 * Notes:
	 * - Items are generated from a repeater field.
	 * - Item descriptions use WYSIWYG editors for light formatting.
	 * - Optional button may appear after the list.
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}


	$intro = get_sub_field( 'intro' );
	$link  = get_sub_field( 'link' );
?>

<section class="wrap">
	<div class="py-8 grid-12 prose-theme">
		<div class="col-span-12">
			<?php if ( $intro ) : ?>
				<div><?php echo wp_kses_post( $intro ); ?></div>
			<?php endif; ?>
		</div>

		<div class="col-span-12">
			<div class="grid-12 prose-theme">
				<?php if ( have_rows( 'list_items' ) ) : ?>
					<?php while ( have_rows( 'list_items' ) ) : the_row(); ?>
						<div class="col-span-12 md:col-span-6">
							<?php $title = get_sub_field( 'list_item_title' ); ?>
							<?php $subtext = get_sub_field( 'list_item_subtext' ); ?>
							<?php if ( $title ) : ?>
								<h3><?php echo esc_html( $title ); ?></h3>
							<?php endif; ?>
							<?php if ( $subtext ) : ?>
								<div><?php echo wp_kses_post( $subtext ); ?></div>
							<?php endif; ?>
						</div>
					<?php endwhile; ?>

				<?php endif; ?>
			</div>
			
			<div class="grid-12">
				<?php if ( ! empty( $link['url'] ) ) : ?>
					<div class="col-span-12 mx-auto text-center">
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
	</div>

</section>


