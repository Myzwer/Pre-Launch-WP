<?php
	/**
	 * Template Name: Template - Form Success
	 */

	get_header();

	$success_title = get_field( 'success_title' );
	$success_body  = get_field( 'success_body' );

	$cta_layout   = get_field( 'success_cta_layout' );
	$primary_cta  = get_field( 'success_primary_cta' );
	$ghost_cta    = get_field( 'success_secondary_cta' );
	$download_cta = get_field( 'success_download_cta' );

	$download_url   = '';
	$download_title = 'Download';
	if ( is_array( $download_cta ) ) {
		$download_url   = (string) ( $download_cta['url'] ?? '' );
		$download_title = (string) ( $download_cta['title'] ?? '' );
		if ( $download_title === '' ) {
			$download_title = (string) ( $download_cta['filename'] ?? 'Download' );
		}
	} elseif ( is_string( $download_cta ) ) {
		$download_url = $download_cta;
	}

	$follow_up = get_field( 'follow_up_statement' );

	/**
	 * CTA layout is the single source of truth.
	 *
	 * Supported layouts:
	 * - primary
	 * - primary_ghost
	 * - primary_download
	 * - primary_download_ghost
	 *
	 * This prevents hidden/stale ACF values from rendering after editors
	 * switch layout options.
	 */
	$show_primary_regular  = in_array( $cta_layout, array( 'primary', 'primary_ghost' ), true );
	$show_primary_download = in_array( $cta_layout, array( 'primary_download', 'primary_download_ghost' ), true );
	$show_ghost            = in_array( $cta_layout, array( 'primary_ghost', 'primary_download_ghost' ), true );

	$has_ctas = ( $show_primary_regular && $primary_cta ) || ( $show_primary_download && $download_url !== '' ) || ( $show_ghost && $ghost_cta );
?>

<main id="main-content">
<section class="overflow-hidden relative min-h-screen bg-primary-gradient">
	<div aria-hidden="true" class="absolute inset-0 pointer-events-none">
		<div
			class="absolute left-1/2 top-[42%] h-[32rem] w-[32rem] -translate-x-1/2 -translate-y-1/2 rounded-full bg-primary/35 blur-3xl md:h-[42rem] md:w-[42rem]">
		</div>
	</div>

	<div class="relative wrap">
			<div class="items-center grid-12 min-h-[calc(100vh-70px)]">
				<div class="col-span-12 md:-translate-y-10">
					<div
						class="overflow-hidden relative p-8 mx-auto max-w-5xl rounded-2xl ring-1 shadow-xl md:p-12 bg-white/95 ring-black/5">
						<div class="relative gap-y-8 text-center grid-12">
							<div class="col-span-12">
								<div
									class="grid place-items-center mx-auto mb-4 w-24 h-24 rounded-full ring-8 md:w-28 md:h-28 bg-primary/10 ring-primary/5">
									<i class="text-6xl md:text-7xl fa-solid fa-badge-check text-primary"
									   aria-hidden="true"></i>
								</div>

								<?php if ( $success_title ) : ?>
									<h1 class="text-3xl font-bold md:text-5xl text-balance">
										<?php echo esc_html( $success_title ); ?>
									</h1>
								<?php endif; ?>
							</div>

							<?php if ( $success_body ) : ?>
								<div class="col-span-12 md:col-span-10 md:col-start-2">
									<div class="mx-auto prose-theme">
										<?php echo wp_kses_post( $success_body ); ?>
									</div>
								</div>
							<?php endif; ?>

							<?php if ( $has_ctas ) : ?>
								<div class="col-span-12">
									<div class="grid gap-4 sm:inline-grid sm:grid-flow-col sm:justify-center">
										<?php if ( $show_primary_regular && $primary_cta ) : ?>
											<span class="inline-block not-prose">
											<a
												class="btn_main"
												href="<?php echo esc_url( $primary_cta['url'] ); ?>"
												target="<?php echo esc_attr( $primary_cta['target'] ?: '_self' ); ?>"
											>
												<span><?php echo esc_html( $primary_cta['title'] ); ?></span>
											</a>
										</span>
										<?php endif; ?>

										<?php if ( $show_primary_download && $download_url !== '' ) : ?>
											<span class="inline-block not-prose">
											<a
												class="btn_main"
												href="<?php echo esc_url( $download_url ); ?>"
												download
											>
												<span><?php echo esc_html( $download_title ); ?></span>
												<i class="fa-solid fa-download" aria-hidden="true"></i>
											</a>
										</span>
										<?php endif; ?>

										<?php if ( $show_ghost && $ghost_cta ) : ?>
											<span class="inline-block not-prose">
											<a
												class="btn_ghost_black"
												href="<?php echo esc_url( $ghost_cta['url'] ); ?>"
												target="<?php echo esc_attr( $ghost_cta['target'] ?: '_self' ); ?>"
											>
												<span><?php echo esc_html( $ghost_cta['title'] ); ?></span>
											</a>
										</span>
										<?php endif; ?>
									</div>
								</div>
							<?php endif; ?>

							<?php if ( $follow_up ) : ?>
								<div class="col-span-12 md:col-span-8 md:col-start-3">
									<p class="text-sm md:text-base text-black/70">
										<?php echo esc_html( $follow_up ); ?>
									</p>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
</section>
</main>

<?php get_footer(); ?>
