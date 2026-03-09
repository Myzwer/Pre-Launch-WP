<?php
	/**
	 * Simple Footer
	 *
	 * Lightweight footer layout used on sites that do not need the full
	 * complex footer system. Displays the footer logo, optional link list,
	 * social icons, and legal text.
	 *
	 * This footer is toggled via the ACF "Globals" options page.
	 *
	 * Related files:
	 * - /assets/src/css/components/footer-simple.css
	 */
?>

<div class="s-footer">
	<div class="s-footer-outer">

		<div class="s-footer-logo">
			<?php
				$image = get_field( 'footer_logo', 'option' );
				if ( ! empty( $image ) ): ?>
					<img src="<?php echo esc_url( $image['url'] ); ?>"
						 alt="<?php echo esc_attr( $image['alt'] ); ?>" />
				<?php endif; ?>
		</div>


		<?php if ( have_rows( 'footer_simple_links', 'option' ) ): ?>
			<div class="s-footer-links">
				<?php
					while ( have_rows( 'footer_simple_links', 'option' ) ) : the_row();
						$link            = get_sub_field( 'link' );

						if ( $link ):
							$link_url = $link['url'];
							$link_title  = $link['title'];
							$link_target = $link['target'] ? $link['target'] : '_self';
							?>
							<div class="s-footer-link">
								<a href="<?php echo esc_url( $link_url ); ?>"
								   target="<?php echo esc_attr( $link_target ); ?>">
									<?php echo esc_html( $link_title ); ?>
								</a>
							</div>
						<?php
						endif;
					endwhile;
				?>
			</div>
		<?php endif; ?>


		<?php $socials = windpeak_get_social_items(); ?>

		<?php if ( ! empty( $socials ) ): ?>
			<div class="s-footer-socials">
				<?php foreach ( $socials as $item ): ?>
					<div class="s-footer-social">
						<?php
							echo windpeak_render_social_icon( $item['network'], [
								'size'  => 'sm',
								'shape' => 'circle',
								'tab'   => 'Y',
								'color' => 'current',
							] );
						?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</div>
