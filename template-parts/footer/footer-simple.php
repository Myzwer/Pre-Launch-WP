<?php
	/**
	 * Simple Footer
	 * --------------
	 * Displays footer logo only (baseline test).
	 */

?>

<div class="footer">
	<div class="footer-outer">
		<div class="footer-logo">
			<?php
				$image = get_field( 'footer_logo', 'option' );
				if ( ! empty( $image ) ): ?>
					<img src="<?php echo esc_url( $image['url'] ); ?>"
						 alt="<?php echo esc_attr( $image['alt'] ); ?>" />
				<?php endif; ?>
		</div>

		<?php
			if ( have_rows( 'footer_simple_links', 'option' ) ):
				while ( have_rows( 'footer_simple_links', 'option' ) ) : the_row();
					$link            = get_sub_field( 'link' );

					if ( $link ):
						$link_url = $link['url'];
						$link_title  = $link['title'];
						$link_target = $link['target'] ? $link['target'] : '_self';
						?>
						<div class="primary-link">
							<a href="<?php echo esc_url( $link_url ); ?>"
							   target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
						</div>
					<?php endif;
				endwhile;
			endif;
		?>


		<?php $socials = windpeak_get_social_items(); ?>

		<?php if ( ! empty( $socials ) ): ?>
			<div class="footer-socials">
				<?php foreach ( $socials as $item ): ?>
					<div class="footer-social">
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


		<div class="footer-legal">
			<p class="mx-auto text-center">
				<?php echo get_the_privacy_policy_link(); ?>
			</p>
			<p>
				<?php the_field( 'footer_simple_legal_text', 'option' ); ?>
			</p>
		</div>

	</div>
</div>
