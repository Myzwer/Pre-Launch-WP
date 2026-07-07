# WordPress Pre-Launch 🚀

![Webpack 5](https://img.shields.io/badge/Webpack-5.x-brightgreen)
![Babel 7](https://img.shields.io/badge/Babel-7.x-brightgreen)
![Tailwind v4](https://img.shields.io/badge/Tailwind-4.x-brightgreen)
![PostCSS 8](https://img.shields.io/badge/PostCSS-8.x-brightgreen)
![BrowserSync 2](https://img.shields.io/badge/BrowserSync-2.x-brightgreen)

---

## What This Is

**WordPress Pre-Launch** is a production-ready starter theme / LocalWP blueprint used as the foundation for client
WordPress builds.

This is not a demo theme or a playground. It is a launching pad.

It is deliberately opinionated and built to solve the same problems every time:

- A modern frontend toolchain.
- A predictable dev/prod workflow.
- A reusable ACF Flexible Content structure.
- A client-safe WordPress admin experience.
- A setup that can survive long gaps between projects.

---

## If You’re Not Josh

You are welcome to use this starter.

Just know what you are getting into.

This theme assumes:

- WordPress.
- ACF, especially Flexible Content.
- Gravity Forms.
- LocalWP as the primary local workflow.
- Tailwind v4.
- A fairly opinionated PHP/CSS/JS structure.

If that sounds reasonable, go for it. It is super built out; it is also very specific to how I build sites.

---

## Site Workflow SOP

The step-by-step workflow for cloning a new site, configuring it, and prepping it for launch lives in a separate SOP
file:

```text
/docs/site-workflow-sop.md
```

Use that file when you are actively spinning up or launching a site.
Use this README when you need to understand how the theme works.

---

## Table of Contents

### Start Here

- [What This Is](#what-this-is)
- [If You’re Not Josh](#if-youre-not-josh)
- [Site Workflow SOP](#site-workflow-sop)
- [Requirements](#requirements)
- [Core Commands](#core-commands)
- [Project Structure](#project-structure)

### Theme Configuration

- [Theme System Overview](#theme-system-overview)
- [Theme Tokens](#theme-tokens)
- [Colors & Gradients](#colors--gradients)
- [Fonts](#fonts)
- [Typography System](#typography-system)
- [WYSIWYG / Prose Styling](#wysiwyg--prose-styling)
- [Buttons](#buttons)
- [Layout Helpers](#layout-helpers)
- [Alternating Section Backgrounds](#alternating-section-backgrounds)

### WordPress Systems

- [ACF Globals](#acf-globals)
- [Navbar System](#navbar-system)
- [Footer System](#footer-system)
- [Editor Tooling & Shortcodes](#editor-tooling--shortcodes)
- [Blog System](#blog-system)
- [SEO Architecture](#seo-architecture)
- [User Roles & Permissions System](#user-roles--permissions-system)

### Reference

- [Reference Flag Index](#reference-flag-index)
- [Troubleshooting Index](#troubleshooting-index)

---

## Requirements

This project assumes the following are already installed and available.

### General

- Node.js, pinned via `.nvmrc`.
- Yarn Berry, using the node-modules linker.
- LocalWP.
- Git.

### WordPress Plugins

- ACF with Flexible Content.
- Gravity Forms.
- The SEO Framework.

---

## Core Commands

Install dependencies if needed:

```bash
yarn install
```

Run a development build:

```bash
yarn dev
```

Run development watch mode:

```bash
yarn dev:watch
```

Run a production build:

```bash
yarn prod
```

Run production watch mode:

```bash
yarn prod:watch
```

Common maintenance commands may also exist in `package.json`, including linting, formatting, PHP fixing, typechecking,
and build cleanup.

---

## Project Structure

Important paths:

```text
assets/src/                 Source assets
assets/public/              Compiled assets; do not edit directly
assets/src/css/tailwind.css Theme tokens, helpers, typography, buttons
assets/src/js/              Frontend JS/TS
assets/admin/               Admin/editor tooling assets
includes/theme/fonts.php    Google Fonts enqueue + resource hints
includes/theme/tokens.php   PHP-injected theme/admin tokens
includes/users/             User roles and permissions system
template-parts/             Reusable PHP template parts
```

Compiled assets are generated into `assets/public` and should not be edited by hand.

---

# Theme Configuration

---

## Theme System Overview

This project uses **Tailwind v4**, but not in a raw utility soup everywhere way.

The theme has a small, opinionated layer that handles:

- colors and gradients,
- fonts,
- typography defaults,
- WYSIWYG/prose styling,
- light vs inverted sections,
- buttons,
- layout helpers,
- alternating section backgrounds.

The goal is consistency without rigidity. You should be able to spin up a new site, update the brand tokens, test the
sample page, and move on.

---

## Theme Tokens

All major frontend design tokens live here:

```text
assets/src/css/tailwind.css
```

Specifically, update the `@theme {}` block.

Primary token groups:

- colors,
- gradients,
- fonts,
- max-width/container scale.

Do not reference CSS variables directly in markup. Define tokens once, then use Tailwind utilities or theme component
classes.

---

## Colors & Gradients

Colors are defined as roles, not literal color names.

Typical roles:

```text
black
white
primary
secondary
soft-1
soft-2
primary-gradient-to
secondary-gradient-to
impact-gradient-to
```

Once defined, Tailwind exposes utilities like:

```text
bg-primary
text-secondary
bg-primary-gradient
bg-impact-gradient
```

Typical usage:

```html
<section class="bg-impact-gradient theme-invert">
	<div class="wrap py-16">
		<div class="prose-theme max-w-3xl">
			<h2>Section heading</h2>
			<p>Section copy.</p>
		</div>
	</div>
</section>
```

### Backend/Admin Tokens

Admin-side branded colors are driven by PHP-injected tokens:

```text
includes/theme/tokens.php
```

These are used by admin/login contexts that do not automatically inherit the compiled frontend Tailwind file.

---

## Fonts

Fonts have two parts:

- loading the font files through WordPress,
- assigning font roles in Tailwind tokens.

### Google Fonts

Google Fonts are loaded here:

```text
includes/theme/fonts.php
```

To update Google Fonts:

- Choose fonts at Google Fonts.
- Copy the full stylesheet URL from the generated `href` value.
- Replace the URL in `prelaunch_get_google_fonts_url()`.
- Keep the Google Fonts URL intact.

Example:

```php
function prelaunch_get_google_fonts_url(): string {
	return 'https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap';
}
```

The file also adds Google Fonts preconnect resource hints.

Load the file from the theme include stack:

```php
require_once get_template_directory() . '/includes/theme/fonts.php';
```

### Tailwind Font Tokens

After loading the fonts, assign them here:

```text
assets/src/css/tailwind.css
```

Inside `@theme {}`:

```css
--font-body:
	"Inter", ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, Arial,
	"Apple Color Emoji", "Segoe UI Emoji";

--font-display:
	"DM Serif Display", Georgia, Cambria, "Times New Roman", Times, serif;
```

Rules:

- `--font-body` is for most text.
- `--font-display` is for major headings.
- If a site uses one font, point both roles to the same family.
- Do not update `tailwind.config.js` for fonts in this Tailwind v4 setup.
- Do not copy Google’s generated `.font-class-name` snippets into the theme.

Google Fonts variable syntax like `100..900` means a range of weights. The `..` means “through.”

---

## Typography System

The theme includes reusable visual heading classes:

```text
heading-1
heading-2
heading-3
heading-4
```

Philosophy:

- HTML headings handle document structure.
- `.heading-*` classes handle visual style.
- `.prose-theme` maps WYSIWYG headings to the same baseline styles.

Typical usage:

```html
<h1 class="heading-1">Page heading</h1>
<h2 class="heading-2">Section heading</h2>
<h3 class="heading-3">Card heading</h3>
```

Do not `@apply heading-1` inside another selector. Tailwind may treat custom component classes as unknown. If a
component needs the same visual style, group the class and selector together in CSS instead.

---

## WYSIWYG / Prose Styling

Use `prose-theme` for WYSIWYG/editor content.

```html
<div class="prose-theme"><?php echo wp_kses_post( $content ); ?></div>
```

House rule:

> Do not put `.prose-theme` on grid, wrap, or layout wrappers. Put `.prose-theme` directly around actual editor/content
> output.

### Prose Helpers

Available helpers:

```text
prose-theme       Default editor content
prose-compact     Cards, FAQs, process steps, accordions, repeaters
prose-tight       Denser WYSIWYG areas
prose-no-spacing  Rare escape hatch for almost plain template text
```

Examples:

```html
<div class="prose-theme prose-compact">
	<?php echo wp_kses_post( $card_text ); ?>
</div>
```

```html
<div class="prose-theme prose-tight">
	<?php echo wp_kses_post( $sidebar_text ); ?>
</div>
```

### Inverted Prose

When `prose-theme` is inside a `theme-invert` section, prose colors flip automatically.

```html
<section class="bg-impact-gradient theme-invert">
	<div class="wrap py-16">
		<div class="prose-theme max-w-3xl">
			<h2>White heading</h2>
			<p>White body copy.</p>
		</div>
	</div>
</section>
```

Do not use `prose-invert` in this system.

### `not-prose`

Use `not-prose` to protect buttons and UI from Tailwind Typography link styling.

```html
<div class="not-prose mt-6">
	<a class="btn_main" href="/contact/">Contact Us</a>
</div>
```

Button shortcodes wrap themselves in `not-prose` automatically.

### Common Gotchas

- Buttons underlined? Missing `not-prose`.
- Text not turning white? Missing `theme-invert`.
- Prose width wrong? Add an explicit `max-w-*`.
- WYSIWYG spacing weird? Use the correct prose helper and make sure `prose-theme` is only wrapping content output.

---

## Buttons

Buttons are component classes, not long utility chains.

Available classes:

```text
btn_main
btn_secondary
btn_light
btn_dark
btn_ghost_white
btn_ghost_black
```

Button styles live in:

```text
assets/src/css/tailwind.css
```

Buttons are intentionally stable inside normal and inverted sections.

Example:

```html
<a class="btn_main" href="/contact/">Contact Us</a>
<a class="btn_ghost_black" href="/about/">Learn More</a>
```

Use the sample page to check the full button spread after brand token changes.

---

## Layout Helpers

Available layout helpers:

```text
section      Full-width section wrapper
wrap         Standard centered inner container
wrap-wide    Wider inner container
grid-12      12-column grid with safe mobile gap
```

Examples:

```html
<section class="section">
	<div class="wrap py-16">
		<div class="grid-12 md:gap-8">
			<div class="col-span-12 md:col-span-6">...</div>
		</div>
	</div>
</section>
```

Notes:

- `.grid-12` includes `gap-4` by default.
- Add `md:gap-8` where a section needs more desktop breathing room.
- Prefer grid-first layout for major components.

---

## Alternating Section Backgrounds

Flexible Content sections can use automatic alternating backgrounds.

Implementation summary:

- `page.php` wraps body sections in `.alt-bg-wrap`.
- Background-eligible blocks are wrapped in `.bg-alternating-gradient`.
- `page.php` assigns `.bg-alternating-odd` or `.bg-alternating-even`.
- CSS maps those odd/even classes to gradient tokens.

This is PHP-controlled, not pure `nth-child`.

Why this matters:

- Certain blocks, such as announcements, can be excluded from the alternating count.
- Excluded blocks can have their own backgrounds without disrupting the stripe pattern.
- Background logic stays centralized instead of hardcoded into every block.

If a new block has its own full-section background, consider excluding that layout slug from the alternating count in
`page.php`.

---

# WordPress Systems

---

## ACF Globals

ACF Globals hold site-wide options used across the theme.

Common globals include:

- header/nav logo,
- footer logo,
- social links,
- basic contact information,
- 404 page text,
- global fallback image,
- footer layout,
- footer content,
- footer credit settings.

Update these during new site setup before building out final nav/footer content.

---

## Navbar System

The theme includes a custom primary navigation system.

It is not a generic WordPress menu. It is a contract-based component with responsibilities split between PHP, CSS, and
JS/TS.

### Architecture

| Layer    | File                                   | Responsibility                           |
| -------- | -------------------------------------- | ---------------------------------------- |
| Markup   | `header.php`                           | Shell, brand, hamburger, menu mount      |
| Menu DOM | `nav_walker.php`                       | Exact HTML structure and classes         |
| Styles   | `assets/src/css/components/navbar.css` | Layout, hover, dropdowns, CTA styling    |
| Behavior | `assets/src/js/navbar.ts`              | Toggle logic, ARIA state, focus handling |

No layer should fix another layer’s problems.

### DOM Contract

The navbar relies on stable markup.

Top-level item without children:

```html
<li class="nav-item">
	<div class="nav-item-inner">
		<a class="nav-link">Label</a>
	</div>
</li>
```

Top-level item with children:

```html
<li class="nav-item has-submenu" data-nav-item>
	<div class="nav-item-inner">
		<button
			class="nav-disclosure"
			aria-expanded="false"
			aria-controls="submenu-123"
			data-nav-toggle
		>
			<span class="nav-label">Label</span>
			<i class="fa-solid fa-caret-down nav-caret"></i>
		</button>
	</div>

	<div class="nav-submenu" id="submenu-123" hidden data-nav-submenu>
		<ul class="nav-submenu-list" role="list">
			<li class="nav-subitem">
				<a class="nav-sublink">Sub Item</a>
			</li>
		</ul>
	</div>
</li>
```

Rules:

- Two levels only.
- Dropdown parents are buttons, not links.
- JS depends on `data-nav-item`, `data-nav-toggle`, and `data-nav-submenu`.

### CTA Behavior

CTA items are expected to be the last menu item.

In WP Admin, mark the CTA menu item with one of these classes:

```text
nav-cta
is-cta
menu-cta
```

They normalize to `.nav-cta` on the `<li>`.

### Font Awesome Rules

Icons are defined through menu item classes.

Examples:

```text
is-cta fa-arrow-right
is-cta fa-brands fa-facebook
```

Font Awesome classes are read from the WP admin classes field, but rendered only on `<i>` elements.

### Navbar README Flags

#### `README:TOGGLE_CENTER_NAV`

Use this when you want to center desktop nav items while keeping the CTA aligned right.

File:

```text
header.php
```

Add this class to `<header class="site-header">`:

```text
nav-center-desktop
```

#### `README:TOGGLE_FULL_HEIGHT_HOVER`

Use this when top-level desktop nav items should hover/focus for the full header height.

File:

```text
header.php
```

Add this class to `<header class="site-header">`:

```text
nav-hover-full
```

#### `README:CTA_ICON_POSITION`

Use this when the CTA icon should render before the label instead of after it.

File:

```text
nav_walker.php
```

Swap the documented output order inside the CTA render block.

#### `README:CTA_ICON_PREFIX_DEFAULT`

Controls the default Font Awesome style prefix when no explicit prefix is provided.

File:

```text
nav_walker.php
```

Default:

```text
fa-solid
```

#### `README:FA_CLASSES_ON_LI`

Explains why `fa-*` classes are not printed on `<li>` elements.

File:

```text
nav_walker.php
```

Reason: Font Awesome kits may scan any element with `fa-*` and inject SVG markup, which can break layout.

#### `README:BREAKPOINT_SYNC`

Navbar breakpoints must stay synced between CSS and JS.

Files:

```text
assets/src/css/components/navbar.css
assets/src/js/navbar.ts
```

If you change one breakpoint, update the other.

### Navbar Troubleshooting

- Dropdowns not opening? Check `data-nav-item`, `data-nav-toggle`, and `data-nav-submenu`.
- CTA layout broken? Confirm the CTA is the last menu item.
- Icons rendering weirdly? Confirm `fa-*` classes are not printed on `<li>`.
- Mobile menu scroll lock broken? Check breakpoint sync.
- Desktop hover feels off? Check `nav-hover-full`.
- Centering not working? Check `nav-center-desktop`.

---

## Footer System

The footer system supports two layouts while keeping shared logic centralized.

Footer configuration is controlled through ACF Globals and rendered through a layout switch in:

```text
footer.php
```

### Architecture

| Layer          | File                                          | Responsibility              |
| -------------- | --------------------------------------------- | --------------------------- |
| Layout router  | `footer.php`                                  | Chooses the footer layout   |
| Simple footer  | `template-parts/footer/footer-simple.php`     | Lightweight footer          |
| Complex footer | `template-parts/footer/footer-complex.php`    | Multi-column footer         |
| Credit bar     | `assets/src/css/components/footer-credit.css` | Shared legal/credit section |
| Styling        | `assets/src/css/components/footer-*.css`      | Layout-specific styles      |

### Layout Switching

Footer layout is determined by the ACF option field:

```text
footer_layout
```

Possible values:

```text
simple
complex
```

If the field is empty, the simple footer loads by default.

### Footer Credit Bar

The footer credit bar sits below both layouts and can include:

- copyright,
- privacy policy link,
- accessibility link,
- optional agency credit.

Key option field:

```text
show_site_credit_bar
```

### Social Icons

Social icons come from the global social system, not hardcoded footer markup.

Helpers:

```text
windpeak_get_social_items()
windpeak_render_social_icon()
```

### Footer README Flags

#### `README:FOOTER_LAYOUT_SWITCH`

Location:

```text
footer.php
```

Controls which footer layout loads based on the ACF option field.

#### `README:FOOTER_CREDIT_BAR`

Location:

```text
footer.php
```

Shared legal section rendered under both footer layouts.

#### `README:FOOTER_SOCIAL_RENDER`

Locations:

```text
template-parts/footer/footer-simple.php
template-parts/footer/footer-complex.php
```

Social icons render through the global social helper functions.

### Footer Troubleshooting

- Footer not changing? Confirm `footer_layout` ACF value.
- Footer still wrong? Clear cache and confirm the template part exists.
- Social icons missing? Confirm networks exist in ACF Globals and helper functions are loaded.
- Credit bar missing? Confirm `show_site_credit_bar`.

---

## Editor Tooling & Shortcodes

The theme includes custom editor tooling to make WYSIWYG content safer for non-technical users.

### TinyMCE Button Generator

A custom TinyMCE toolbar button labeled **Button** is available in ACF WYSIWYG fields.

Files:

```text
assets/admin/tinymce-btn.js
assets/admin/tinymce-btn.css
includes/editor_tools.php
```

What it does:

- Adds a toolbar button.
- Opens a modal UI.
- Inserts a valid `[btn]` shortcode.
- Prevents common shortcode formatting mistakes.

This tool only inserts shortcodes. It does not control frontend button styling.

### Button Shortcode

Basic usage:

```text
[btn text="Contact Us" url="/contact"]
```

Required attributes:

```text
text
url
```

Optional attributes:

```text
variant="main|secondary|light|dark|ghost_white|ghost_black"
icon="none|arrow|external|download|phone|email"
icon_pos="left|right"
tab="Y"
center="Y"
```

Examples:

```text
[btn text="Learn More" url="/about" variant="secondary"]
[btn text="Email Us" url="mailto:hello@example.com" icon="email" icon_pos="left"]
[btn text="External Site" url="https://example.com" tab="Y"]
[btn text="Book Now" url="/book" center="Y"]
```

Notes:

- Buttons automatically wrap themselves in `not-prose`.
- Only non-default attributes are rendered.

### Social Icon Shortcode

Basic usage:

```text
[social network="facebook"]
```

Available networks:

```text
facebook
instagram
x
youtube
pinterest
linkedin
tiktok
threads
github
website
email
phone
```

Optional attributes:

```text
size="sm|md|lg|xl|2xl"
shape="none|circle|square"
color="current|primary|black|white"
fg="white|black"
tab="Y"
```

Shape rules:

- `shape="none"`: icon inherits text color unless `color` is set.
- `shape="circle"` or `shape="square"`: background is `bg-primary`; foreground is controlled by `fg`.

### Editor Tooling Troubleshooting

- Dropdowns show no text? TinyMCE 4 needs `text`, not `label`.
- Modal too narrow or clipped? Check `assets/admin/tinymce-btn.css`.
- Button appears but does nothing? Check console errors in `assets/admin/tinymce-btn.js`.
- Frontend button styling wrong? Check the shortcode output and button CSS, not the TinyMCE tool.

---

## Blog System

This section covers the blog pieces most likely to need client-specific tweaks.

### Initial Blog Setup

Before launch, confirm:

- Settings → Reading → Posts page is assigned if blog is enabled.
- Settings → Permalinks → pretty permalinks are enabled.
- Approved editor blocks/styles are working.
- Custom colors and gradients are disabled where expected.

If editor restrictions fail, check:

```text
includes/posts/editor.php
```

### Filter Logic

Blog filters are controlled in:

```text
includes/posts/queries.php
```

Search for:

```text
pre_get_posts
```

Default behavior:

- Multiple categories use OR logic.
- Multiple tags use OR logic.
- Category + tag together use an AND relationship.

To make category filtering stricter, adjust the `tax_query` relation/operator to `AND`.

Always test:

- multiple categories,
- multiple tags,
- category + tag together,
- pagination with filters active.

### Date Logic

Human-readable time output lives in:

```text
includes/posts/template-tags.php
```

Function:

```text
prelaunch_display_date()
```

Update that function if a client wants different date behavior.

### Card System

Blog preview markup lives in:

```text
template-parts/blog/card.php
```

Card styling lives in:

```text
assets/src/css/components/cards.css
```

Card classes follow a BEM-style pattern:

```text
.card
.card__media
.card__image
.card__body
.card__header
.card__meta
.card__excerpt
.card__footer
.card__cta
```

Rules:

- Keep card structure in `card.php`.
- Avoid duplicating archive card markup across templates.
- Add variants as modifiers or CPT-specific card template parts only when needed.

### Common Blog Tweaks

| Task                         | File                                               |
| ---------------------------- | -------------------------------------------------- |
| Change excerpt length        | `includes/posts/content.php`                       |
| Change card spacing          | `assets/src/css/components/cards.css`              |
| Adjust relative date format  | `includes/posts/template-tags.php`                 |
| Tighten filter logic         | `includes/posts/queries.php`                       |
| Increase related posts count | `single.php`                                       |
| Remove reading time          | `template-parts/blog/card.php` and/or `single.php` |
| Change “Read more” text      | `template-parts/blog/card.php`                     |

### Blog Troubleshooting

- Filters not working? Confirm `pre_get_posts` logic and URL parameters.
- Cards inconsistent? Confirm all templates use the card system.
- Dates weird? Check `prelaunch_display_date()`.
- Pagination broken? Confirm the query is paged and `prelaunch_pagination()` is called.

---

## SEO Architecture

This starter theme uses The SEO Framework for opinionated, production-safe SEO defaults.

### Meta Titles

- Uses WordPress native title support.
- TSF generates page/archive titles.
- Manual TSF titles override generated titles.

### Meta Descriptions

For ACF-first pages, the theme scans Flexible Content for the first meaningful text block and falls back to regular ACF
fields if needed.

For blog posts, TSF uses Gutenberg content automatically.

Manual TSF descriptions always override automation.

### Social Sharing

Social image priority:

- manual TSF social image,
- featured image,
- global ACF `fallback_image`.

No content image scraping is used.

### Sitemaps

TSF generates the sitemap at:

```text
/sitemap.xml
```

### Editorial SEO Guidelines

- Use exactly one H1 per page.
- Keep heading hierarchy logical.
- Write human-readable page titles.
- Write clear meta descriptions for important pages.
- Add meaningful alt text for content images.
- Avoid orphaned pages.
- Avoid keyword stuffing.

### SEO Launch Checks

- Confirm site title and tagline.
- Confirm permalink structure.
- Assign Posts page if blog is enabled.
- Upload global `fallback_image`.
- Confirm `/sitemap.xml` resolves.
- Confirm search visibility before launch.
- Verify domain in Google Search Console.
- Submit sitemap after launch.
- Add analytics if needed.
- Spot-check social previews.
- Add redirects if replacing an old site.

---

## User Roles & Permissions System

The Pre-Launch starter includes a modular system for controlling user roles, admin feature access, and plugin settings
visibility.

The goal is a predictable, client-safe CMS without breaking plugin compatibility.

The system works by:

- creating Pre-Launch-managed roles,
- defining access through a central role policy,
- enforcing those rules through feature modules.

### Role Registration

File:

```text
includes/users/register-role.php
```

Responsibilities:

- Creates managed roles.
- Clones capabilities from Administrator.
- Syncs developer-only capabilities.
- Provides helper functions for checking managed roles.

Example role:

```text
prelaunch_client_admin
Label: Site Administrator
```

### Role Policy

File:

```text
includes/users/role-policy.php
```

This is the single source of truth for what each role can access.

Example:

```php
PRELAUNCH_CLIENT_ADMIN_ROLE => [
	'dashboard'       => true,
	'media'           => 'full',
	'posts'           => false,
	'pages'           => 'off',
	'gravity_forms'   => 'manager',
	'appearance'      => 'menus_only',
	'plugins'         => 'off',
	'plugin_settings' => 'approved_only',
	'users'           => 'profile_only',
	'tools'           => 'off',
	'settings'        => 'off',
	'acf'             => 'options_only',
]
```

### Feature Modules

Directory:

```text
includes/users/
```

Examples:

```text
user-dashboard.php
user-media.php
user-posts.php
user-pages.php
user-gravity-forms.php
user-appearance.php
user-plugins.php
user-users.php
user-tools.php
user-settings.php
user-acf.php
user-plugin-settings.php
```

Feature modules read from the role policy instead of hardcoding access rules.

### Feature Policy Reference

Common policy values:

```text
dashboard: true | false
posts: true | false
media: off | browse_only | full
pages: off | draft_only | full
gravity_forms: off | manager | full
appearance: off | menus_only | full
plugins: off | manage_installed | full
plugin_settings: off | approved_only | full
acf: off | options_only | full
users: profile_only | full
tools: off | on
settings: off | full
```

### Admin Bar Behavior

The `+ New` admin bar menu is filtered based on role policy.

| Item      | Behavior                       |
| --------- | ------------------------------ |
| New Post  | follows `posts` policy         |
| New Page  | follows `pages` policy         |
| New Form  | follows `gravity_forms` policy |
| New Media | always hidden                  |

New Media is hidden to keep uploads inside the preferred media library/folder workflow.

### Plugin Settings Access

Plugin settings pages are controlled by:

```text
includes/users/user-plugin-settings.php
```

This module maintains an allowlist registry.

Example:

```php
function prelaunch_get_plugin_settings_registry(): array {
	return [
		'filebird' => [
			'label'       => 'FileBird',
			'parent_slug' => 'filebird-dashboard',
			'menu_slug'   => 'filebird-dashboard',
			'approved'    => true,
		],
	];
}
```

To approve a plugin settings page:

- Open the plugin settings page in WP Admin.
- Inspect the URL.
- Add the correct parent/menu slug to the registry.
- Refresh admin.

### Permissions Troubleshooting

- Admin area appears/disappears unexpectedly? Check `includes/users/role-policy.php`.
- A feature is not enforcing correctly? Check the matching feature module.
- Role has weird capabilities? Check `includes/users/register-role.php`.
- Plugin settings page still visible? Confirm the parent slug and menu slug.
- Plugin registers multiple pages? Add each needed page to the registry.
- Plugin loads late? Confirm menu removal priority.

---

# Reference

---

## Reference Flag Index

Navbar:

- `README:TOGGLE_CENTER_NAV` — center desktop nav items.
- `README:TOGGLE_FULL_HEIGHT_HOVER` — full-height desktop nav hover/focus.
- `README:CTA_ICON_POSITION` — CTA icon before/after label.
- `README:CTA_ICON_PREFIX_DEFAULT` — default Font Awesome icon style.
- `README:FA_CLASSES_ON_LI` — why FA classes are not rendered on `<li>`.
- `README:BREAKPOINT_SYNC` — navbar CSS/JS breakpoint sync.

Footer:

- `README:FOOTER_LAYOUT_SWITCH` — footer layout routing.
- `README:FOOTER_CREDIT_BAR` — shared legal/credit section.
- `README:FOOTER_SOCIAL_RENDER` — global social icon render helpers.

---

## Troubleshooting Index

- Navbar issues: see [Navbar Troubleshooting](#navbar-troubleshooting).
- Footer issues: see [Footer Troubleshooting](#footer-troubleshooting).
- Editor/shortcode issues: see [Editor Tooling Troubleshooting](#editor-tooling-troubleshooting).
- Blog issues: see [Blog Troubleshooting](#blog-troubleshooting).
- Permission issues: see [Permissions Troubleshooting](#permissions-troubleshooting).
