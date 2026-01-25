<?php
/**
 * Site header.
 *
 * This template outputs the full <head> section and the primary site navbar.
 *
 * Navbar architecture (separation of concerns):
 * - Markup shell: this file (header.php)
 * - Menu item DOM contract: nav_walker.php (PreLaunch_Walker)
 * - Styles: assets/src/css/components/navbar.css (built via Tailwind pipeline)
 * - Behavior / a11y: assets/src/js/navbar.ts
 *
 * IMPORTANT:
 * - Treat the markup contract (classes / nesting / data attrs) as stable.
 * - Do not change navbar markup here unless you are intentionally updating the contract.
 *
 * Reference: https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<!-- Meta Info -->
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php
    /**
     * WP standard: prefer theme support for title-tag (outputs via wp_head()).
     * If theme support is not enabled, provide a safe fallback <title>.
     */
    if (!current_theme_supports('title-tag')) : ?>
		<title><?php echo esc_html(wp_get_document_title()); ?></title>
	<?php endif; ?>

	<!-- WordPress Required Hook -->
	<?php wp_head(); ?>
</head>

<!--
	Open Body.
	- Put global Tailwind classes here.
	- Leave WordPress hooks/attributes alone.
	NOTE: body_class() must own the class attribute; pass custom classes as an argument.
-->
<body <?php body_class('tracking-normal leading-normal'); ?>>
<?php wp_body_open(); ?>


<!--
	Start Navbar

	Optional layout toggles:
	- README:TOGGLE_FULL_HEIGHT_HOVER
	  Add class 'nav-hover-full' to <header class="site-header"> to enable full-height desktop hover area.
	- README:TOGGLE_CENTER_NAV
	  Add class 'nav-center-desktop' to <header class="site-header"> to center desktop nav items (CTA remains right-aligned).
-->
<header class="site-header">
	<div class="nav-shell">
		<a class="nav-brand" href="<?php echo esc_url(home_url('/')); ?>">
			<?php
            $logo = function_exists('get_field') ? get_field('site_nav_logo', 'option') : null;

if (is_array($logo) && !empty($logo['url'])) : ?>
				<img
					class="nav-brand-logo"
					src="<?php echo esc_url($logo['url']); ?>"
					alt="<?php echo esc_attr(!empty($logo['alt']) ? $logo['alt'] : get_bloginfo('name')); ?>"
					loading="eager"
					decoding="async"
				/>
			<?php else : ?>
				<span class="nav-brand-text"><?php echo esc_html(get_bloginfo('name')); ?></span>
			<?php endif; ?>
		</a>



		<nav class="nav" aria-label="Primary">
			<button
				class="nav-hamburger"
				type="button"
				aria-expanded="false"
				aria-controls="nav-panel"
			>
				<span class="sr-only">Menu</span>
				<span class="nav-hamburger-icon" aria-hidden="true">
					<span class="nav-hamburger-bar"></span>
				</span>
			</button>

			<div class="nav-panel" id="nav-panel">
				<?php
    wp_nav_menu([
        'theme_location' => 'header-menu',
        'depth' => 2,
        'container' => false,
        'fallback_cb' => false,
        'walker' => new PreLaunch_Walker(),
        'items_wrap' => '<ul class="nav-list" role="list">%3$s</ul>',
    ]);
?>
			</div>
		</nav>
	</div>
</header>
<!-- End Navbar -->

<!--Start Body-->
