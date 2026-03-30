# WordPress Pre-Launch 🚀

![Webpack 5](https://img.shields.io/badge/Webpack-5.x-brightgreen)
![Babel 7](https://img.shields.io/badge/Babel-7.x-brightgreen)
![Tailwind v4](https://img.shields.io/badge/Tailwind-4.x-brightgreen)
![PostCSS 8](https://img.shields.io/badge/PostCSS-8.x-brightgreen)
![BrowserSync 2](https://img.shields.io/badge/BrowserSync-2.x-brightgreen)

---

## What This Is

**WordPress Pre-Launch** is a production-ready **starter theme / blueprint** used as the foundation for all client
WordPress builds.

This is not really a demo theme or a playground, its meant to be a, well, launching pad.

It is a deliberately opinionated starting point that solves the same problems every time:

- A modern frontend toolchain
- A dual environment for dev and prod
- A predictable workflow that survives long gaps between projects
- A setup designed to scale across large and small sites

---

## Features & Benefits

### General

- **Webpack 5 build pipeline**  
  Modern asset bundling with a clear dev vs production split.

- **Clean source vs output separation**  
  Source files live in `/assets/src`.  
  Compiled assets are generated into `/assets/public` and are never committed.

- **Fast local development**  
  BrowserSync provides live reload and cross-device syncing during development.

- **Predictable production builds**  
  Minification, optimization, and cache-friendly output handled automatically.

### CSS

- **Tailwind CSS v4**  
  Utility-first styling with a fully migrated v4 setup.

- **Plain CSS only**  
  No Sass, no preprocessors.  
  CSS is authored directly and processed via PostCSS.

- **PostCSS pipeline**  
  Handles vendor prefixing and future-safe CSS features.

### JavaScript

- **Babel-powered JS & TypeScript support**  
  Modern JS/TS authored safely and transpiled for browser compatibility.

---

## Requirements

This project assumes the following are already installed and available:

General:

- **Node.js** (version pinned via `.nvmrc`)
- **Yarn (Berry)** — this project uses Yarn 3 with the node-modules linker
- **LocalWP** (assumed local WordPress environment)
- **Git**

Plugins:

- **ACF with flex content**
- **Gravity Forms**

---

<img src="https://i.imgflip.com/5gak9s.jpg" width="50%" alt="How do you do fellow coders?">

## If You’re Not Josh

You’re welcome to use this starter.

Just know what you’re getting into.

This theme:

- Assumes **ACF** (and is built around ACF Flexible Content blocks)
- Assumes but does not require a LocalWP-based workflow

If that sounds reasonable, go for it! It's super built out, its just kinda specific to me.

```bash
# 1-- Set up a local instance of Worpress in Local or something.
# 2-- Clone this into your themes folder (as a new theme)

$ git clone https://github.com/Myzwer/Pre-Launch-WP.git

# 2-- Edit the BrowserSync settings (you can find that below)

# 3-- Install yarn and all the project dependencies

$ yarn install

# 4-- Run a command and start making some magic.
yarn dev
yarn dev:watch
yarn prod
yarn prod:watch
```

---

# How To Add Fonts To Your Project

### Google Fonts

1. Go to https://fonts.google.com/
2. Pick a font family that you like, and select a few styles. (as a note, the more files you choose the slower the site
   will be. So only pick ones you need to use)
3. Under "use on the web" section, make sure < link > is selected, and look at the code that is generated. It should
   look _something_ like this:

```
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
```

4. Copy the link from the 3rd block, minus the &display=swap. In the example above, it would be this:

```html
https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400
```

5. Navigate to functions.php, specifically the fonts part.
6. Drop in this code:

```php
wp_register_style( 'FONTNAME_font', 'FONTLINK' );
wp_enqueue_style('FONTNAME_font');
```

7. Name it whatever where FONTNAME_font is (it doesn't matter what you call it, but it does make sense to name it the
   fontname for ease of reference later), and add the link to FONTLINK. So to complete our example:

```php
wp_register_style( 'roboto_font', 'https://fonts.googleapis.com/css2?familY=Roboto:ital,wght@0,400;0,500;0,700;1,400' );
wp_enqueue_style('roboto_font');
```

8. Go back to google, copy the font family section and you can begin using it in your CSS!
9. (optional) If you are still using tailwind, go into tailwind.config.js and update the fontFamily section. This is
   already done for you so you should be able to easily swap out my code for your new font code.

```css
fontFamily {
'myfontname': [ 'Roboto', 'sans-serif' ], / / text-roboto
}
```

---

### Custom Fonts

1. Purchase or download font files. They will most likely come as .otf or .ttf or something like that. It doesn't matter
   which you use.
2. Go to [Transfonter](https://transfonter.org/) and select the fontses you want to include. The more files you include
   the slower your website will be, so only get the ones you need. Bigger is not always better. Girls do care about
   the [size of your megapixel.](https://youtu.be/eg8u_Q1tNlo?t=22)
3. Upload the font files to the site.
4. You do not need to adjust any settings on the bottom section unless you want to.
5. Download your @font-face kit zip file with new fonts!
6. Upzip. 😉
7. You don't need demo.html, though can see what your fonts looks like on a page if you load it up.
8. Copy all .woff and .woff2 files into ./assets/src/webfonts in the wordpress project. You can delete any existing
   files that you no longer need including the gitkeep file.
9. Open up stylesheet.css, copy all the code out of it, and paste that into fonts.css. (.assets/src/sass/fonts/)
10. Lastly, you'll need to tell your fonts where they can find the woff files. This means adding `../../webfonts/` to
    the beginnging of all of your URL's.

```css
fontFamily {
	font-family: "MYFONT";
	src:
		url("../../webfonts/MYFONT.woff2") format("woff2"),
		url("../../webfonts/MYFONT.woff") format("woff");
	font-weight: 900;
	font-style: normal;
	font-display: swap;
}
```

11. Once added, if you have prettier and stylelint up and running, both of those will throw errors, so hop over to iterm
    and type `yarn stylelint` to get it fixed.
12. Once linked like this, you are free to use your new font families! The name is whatever fontfamily is called. In the
    above example (where I showed linking) MYFONT would be the name you'd use.
13. (optional) If you are still using tailwind, go into tailwind.config.js and update the fontFamily section. This is
    already done for you so you should be able to easily swap out my code for your new font code.

```css
fontFamily {
'myfontname': [ 'Bleeding Cowboy', 'serif' ], / / text-bleeding-cowboy
}
```

# Tailwind Theme System (Base Styles)

This project uses **Tailwind v4**, but not in a “raw utility soup everywhere” way.

Instead, there is a small, opinionated **theme layer** that sits on top of Tailwind and handles:

- colors & gradients
- typography defaults
- light vs inverted (dark) sections
- buttons
- a few layout helpers

The goal here is **consistency without rigidity**.
You should be able to spin up a new site quickly, update a few values, and move on.

---

## Quick Reference (Read This First)

```text
Theme helpers
-------------
theme-invert     → flips default text to white for a section
prose-theme      → WYSIWYG / rich text styling (no enforced width)
not-prose        → escape hatch for buttons / UI inside prose

Layout helpers
--------------
wrap             → centered container (max-w-6xl + padding)
wrap-wide        → wider container (max-w-screen-2xl + padding)
grid-12          → 12-column grid with standard gaps

Buttons
-------
btn_main
btn_secondary
btn_light
btn_dark
btn_ghost_white
btn_ghost_black

Color tokens
------------
black
white
primary
secondary
soft-1
soft-2

Gradient tokens
---------------
primary-gradient
secondary-gradient
impact-gradient
```

---

## Example: Helpers Working Together

```php
<div class="bg-primary">
  <div class="wrap-wide py-10">
    <div class="grid-12">
      <div class="col-span-12 prose-theme max-w-3xl">
        <!-- prose-theme restores typography, width is explicit -->
        <p>This is WYSIWYG content.</p>

        <div class="not-prose mt-6">
          <!-- not-prose prevents typography plugin from styling buttons -->
          <a class="btn_main" href="#">Book Now</a>
        </div>
      </div>
    </div>
  </div>
</div>
```

Key takeaways:

- Background is chosen with `bg-*`
- Width is controlled by layout helpers or `max-w-*`
- Typography is opt-in via `prose-theme`
- UI inside prose uses `not-prose`

---

## Step 1 – Update Theme Tokens (Always Do This)

All site-level design decisions live in one place:

```text
assets/src/css/tailwind.css
```

Inside the `@theme {}` block.

### Colors & Gradients

Colors are defined as **roles**, not names.

You are not defining “blue” or “green” — you are defining _how a color is used_.

Typical roles:

- `black` / `white` → global neutrals
- `primary` → main CTA color
- `secondary` → secondary emphasis
- `soft-*` → pastel tones used for gradients
- `*-gradient` → section backgrounds

Once defined, Tailwind automatically gives you utilities like:

- `bg-primary`
- `text-secondary`
- `bg-primary-gradient`

You never reference CSS variables directly in markup.

---

### Fonts

There are exactly **two font roles**:

- `--font-body` → most text
- `--font-display` → h1 / h2 by default

Default behavior:

- body text uses `--font-body`
- `h1` and `h2` use `--font-display`

If a site only uses one font, just point both variables to the same family.

You can override per-element using:

- `font-body`
- `font-display`

Fonts must still be **loaded via WordPress**.
Tailwind only references the font names.

---

## Step 2 – Theme Behavior (Read Once)

### Default vs Inverted Sections

The site has one global default:

- black text
- light background

For standout / impact sections, use:

```html
<section class="theme-invert"></section>
```

This flips the **default text color to white** inside that section.

Important:

- `theme-invert` does **not** set a background
- backgrounds are still chosen via `bg-*`
- this is not “dark mode” — it’s a per-section override

Typical usage:

```html
<section class="bg-impact-gradient theme-invert"></section>
```

---

## Step 3 – Typography & WYSIWYG

### `prose-theme`

All WYSIWYG / rich text should use:

```html
<div class="prose-theme"></div>
```

This:

1. enables Tailwind typography styles
2. maps text colors to theme tokens
3. removes enforced max-width

You control width explicitly:

```html
<div class="prose-theme max-w-3xl"></div>
```

---

### `theme-invert` + `prose-theme`

When `prose-theme` is nested inside `theme-invert`:

- text flips to white automatically
- headings, lists, and links stay consistent
- no `text-white` spam needed

Do **not** use `prose-invert` in this system.

---

### `not-prose`

Typography styles links as article content.

That’s great for paragraphs — bad for UI.

Wrap buttons, icons, and UI elements like this:

```html
<div class="not-prose">
	<a class="btn_main">Book Now</a>
</div>
```

Button shortcodes already do this automatically.

---

## Step 4 – Buttons

Buttons are **component classes**, not utility chains.

This keeps:

- shortcodes clean
- markup readable
- behavior consistent inside prose and inverted sections

Available buttons:

- `btn_main` – primary CTA
- `btn_secondary` – secondary emphasis
- `btn_light` – white background, black text
- `btn_dark` – black background, white text
- `btn_ghost_white` – white outline / text
- `btn_ghost_black` – black outline / text

---

## Step 5 – Layout Helpers

These exist purely to reduce repetition.

### `wrap`

```html
<div class="wrap"></div>
```

Centered container with max-width and horizontal padding.

---

### `wrap-wide`

```html
<div class="wrap-wide"></div>
```

Use for wider layouts or hero sections.

---

### `grid-12`

```html
<div class="grid-12"></div>
```

Equivalent to:

- `grid`
- `grid-cols-12`
- standard gaps

---

## Common Gotchas

- **Buttons underlined?** → missing `not-prose`
- **Text not turning white?** → forgot `theme-invert`
- **Prose width wrong?** → add `max-w-*` yourself
- **Colors not applying?** → check token names, not utilities

# Navbar

This project includes a **fully custom primary navigation system** designed to be reused across all client sites.

It is **not** a generic WordPress menu.
It is a **contract-based component** with strict assumptions shared between:

- PHP (markup generation)
- CSS (layout + visuals)
- JS/TS (interaction, accessibility, state)

If something looks a little “extra” in the walker, there is probably a reason.
If it works and is documented — **leave it alone**.

---

## High-Level Architecture

**Responsibility split:**

| Layer    | File                                   | Responsibility                           |
| -------- | -------------------------------------- | ---------------------------------------- |
| Markup   | `header.php`                           | Shell, brand, hamburger, menu mount      |
| Menu DOM | `nav_walker.php`                       | Exact HTML structure & classes           |
| Styles   | `assets/src/css/components/navbar.css` | Layout, hover, dropdowns, CTA styling    |
| Behavior | `assets/src/js/navbar.ts`              | Toggle logic, ARIA state, focus handling |

No layer should “fix” another layer’s problems.

---

## DOM Contract (Read This Before Touching Anything)

The navbar relies on a **stable HTML contract**.

### Header Structure

```html
<header class="site-header">
	<div class="nav-shell">
		<a class="nav-brand">...</a>

		<nav class="nav" aria-label="Primary">
			<button
				class="nav-hamburger"
				aria-controls="nav-panel"
				aria-expanded="false"
			></button>

			<div class="nav-panel" id="nav-panel">
				<ul class="nav-list" role="list">
					<!-- Menu items -->
				</ul>
			</div>
		</nav>
	</div>
</header>
```

This structure is assumed by both CSS and JS.

---

### Menu Item Rules

- Exactly **2 levels only**
    - Depth 0 → top-level
    - Depth 1 → submenu
- No third level support (by design)

#### Top-level item without children

```html
<li class="nav-item">
	<div class="nav-item-inner">
		<a class="nav-link">Label</a>
	</div>
</li>
```

#### Top-level item with children (not a link)

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

Key points:

- Dropdown parents are **buttons**, not links
- Submenus are controlled via:
    - `aria-expanded`
    - `aria-controls`
    - `[hidden]`
- JS depends on `data-nav-item`, `data-nav-toggle`, `data-nav-submenu`

---

## CTA Behavior

CTA items are **special-cased** and expected to be the **last menu item**.

### How to mark a CTA (WP Admin)

Use **one** of the following menu item classes:

```
nav-cta
is-cta
menu-cta
```

They are normalized to `.nav-cta` on the `<li>`.

### CTA Output Contract

```html
<li class="nav-item nav-cta">
	<div class="nav-item-inner">
		<a class="nav-link nav-cta-link">
			<span class="nav-label">Contact</span>
			<i class="fa-solid fa-arrow-right nav-cta-icon"></i>
		</a>
	</div>
</li>
```

CSS assumes:

- `.nav-cta` exists on the `<li>`
- `.nav-cta-link` exists on the `<a>`
- CTA is last (hover + spacing rules depend on this)

---

## Font Awesome Rules (FA6 / FA7)

Icons are defined **only** via menu item classes.

Examples:

```
is-cta fa-arrow-right
is-cta fa-brands fa-facebook
```

### README:CTA_ICON_PREFIX_DEFAULT

**What it does:**  
Sets the default FA style prefix if none is provided.

**Default:**

```
fa-solid
```

**Where to change:**  
Search for `README:CTA_ICON_PREFIX_DEFAULT` in `nav_walker.php`.

---

### README:FA_CLASSES_ON_LI

**What it does:**  
Explains why `fa-*` classes are **not rendered on `<li>` elements**.

**Why:**  
FA Kits may scan any element with `fa-*` and inject SVG markup, which can break layout.  
FA classes are read from admin but rendered **only on `<i>`**.

---

## Layout Toggles

### README:TOGGLE_CENTER_NAV

**Want to center the desktop navigation?**

**Search:**  
`README:TOGGLE_CENTER_NAV`

**File:**  
`header.php`

**What this does:**  
Centers the primary nav items on desktop while keeping the CTA aligned to the right edge.

**How to enable:**  
Add the following class to the `<header class="site-header">` element:

```
nav-center-desktop
```

**Notes:**

- Desktop-only behavior
- No JS changes required
- CTA positioning is preserved intentionally

---

### README:TOGGLE_FULL_HEIGHT_HOVER

**Want nav items to hover the full header height?**

**Search:**  
`README:TOGGLE_FULL_HEIGHT_HOVER`

**File:**  
`header.php`

**What this does:**  
Expands the hover and focus area of top-level nav items to match the full header height (desktop only).

**How to enable:**  
Add the following class to the `<header class="site-header">` element:

```
nav-hover-full
```

**Notes:**

- Improves usability on taller headers
- Does not affect mobile behavior
- No JS changes required

---

### README:CTA_ICON_POSITION

**Want the CTA icon on the left instead of the right?**

**Search:**  
`README:CTA_ICON_POSITION`

**File:**  
`nav_walker.php`

**What this controls:**  
The visual order of the label and icon inside the CTA button.

**Default output:**

```
[Label] [Icon]
```

**Alternate output:**

```
[Icon] [Label]
```

**How to change:**  
Inside the CTA `<a>` rendering block:

- Comment out the default output line
- Uncomment the alternate output line directly below it

**Notes:**

- This is a manual, documented swap by design
- No CSS or JS changes should be required

---

### README:CTA_ICON_PREFIX_DEFAULT

**Want to change the default Font Awesome style?**

**Search:**  
`README:CTA_ICON_PREFIX_DEFAULT`

**File:**  
`nav_walker.php`

**What this does:**  
Controls which Font Awesome style prefix is used when a CTA icon is provided **without** an explicit style.

**Default:**

```
fa-solid
```

**How to change:**  
Update the default value passed to the filter in the walker.

**Notes:**

- Only applies when no `fa-brands`, `fa-regular`, etc. is provided
- Prevents broken or missing icons

---

### README:FA_CLASSES_ON_LI

**Seeing weird layout issues with CTA icons?**

**Search:**  
`README:FA_CLASSES_ON_LI`

**File:**  
`nav_walker.php`

**What this explains:**  
Why `fa-*` classes are intentionally **not printed on `<li>` elements**.

**Why this matters:**  
Font Awesome Kits (FA6 / FA7) may scan _any_ element with `fa-*` and inject SVG markup.  
If `fa-*` appears on a `<li>`, this can break sizing and layout (especially CTAs).

**Important detail:**

- FA classes are still read from WP admin
- FA classes are rendered **only** on the `<i>` element

---

### README:BREAKPOINT_SYNC

**Navbar behaving differently between mobile and desktop?**

**Search:**  
`README:BREAKPOINT_SYNC`

**Files:**

- `assets/src/css/components/navbar.css`
- `assets/src/js/navbar.ts`

**What this means:**  
Navbar breakpoints must be kept in sync between CSS and JS.

**If you change one:**  
You must update the other.

**Notes:**

- Desync can cause scroll lock, stuck menus, or broken animations
- This is one of the easiest ways to accidentally break the navbar

---

## Common Gotchas

- **Dropdowns not opening?** → check `data-nav-item`, `data-nav-toggle`, `data-nav-submenu`
- **CTA layout broken?** → ensure CTA is last menu item
- **Icons rendering weirdly?** → make sure `fa-*` classes are NOT on `<li>`
- **Mobile menu scroll-lock broken?** → breakpoint mismatch between CSS and JS
- **Hover feels off on desktop?** → check `nav-hover-full` toggle
- **Centering not working?** → missing `nav-center-desktop` on header

If behavior is odd, verify the DOM contract before touching CSS or JS.

# Editor Tooling: Button & Social Shortcodes

This theme includes a small amount of **custom editor tooling** designed to make
working with WYSIWYG content safer and less frustrating for non-technical users.

The goal is **quality of life**, not feature expansion:

- Reduce shortcode syntax errors
- Avoid “code-y” experiences in the editor
- Keep frontend rendering logic simple and predictable

---

## TinyMCE Button Generator (ACF WYSIWYG)

A custom **TinyMCE toolbar button** labeled **“Button”** is available in all
ACF WYSIWYG fields (Classic editor engine).

### What this does

- Adds a toolbar button to the main formatting row
- Opens a modal UI to configure a button
- Inserts a properly formatted `[btn]` shortcode at the cursor
- Prevents common mistakes (missing attributes, malformed markup)

This tool **only inserts shortcodes**.  
It does _not_ control how buttons render on the frontend.

### Where this lives

- Logic: `assets/admin/tinymce-btn.js`
- Styling: `assets/admin/tinymce-btn.css`
- Registration / hooks: `includes/editor_tools.php`

If the button is missing or broken, check those files first.

---

## If the Editor Tool Looks Broken

Before debugging frontend code, check these common issues:

- **Dropdowns show no text**  
  → TinyMCE 4 requires listbox options to use `text`, not `label`.

- **Modal is too narrow / dropdowns clipped**  
  → Check `tinymce-btn.css` for modal width and menu overflow rules.

- **Button appears but does nothing**  
  → Check browser console for JS errors in `tinymce-btn.js`.

- **Styling looks “off”**  
  → Remember this is admin-only CSS. Frontend Tailwind styles do not apply here.

---

## Button Shortcode Reference

Buttons are rendered using a shortcode so they can be safely inserted into
WYSIWYG content and styled consistently.

### Basic Usage

[btn text="Contact Us" url="/contact"]

### Required Attributes

- `text` – Button label
- `url` – Destination URL (relative or absolute)

### Optional Attributes

#### Style / Variant

variant="main"

Available options:

- main (default)
- secondary
- light
- dark
- ghost_white
- ghost_black

Example:

[btn text="Learn More" url="/about" variant="secondary"]

---

#### Icon

icon="arrow"

Available options:

- none (default)
- arrow
- external
- download
- phone
- email

Icon position defaults to the right.

icon_pos="left" | "right"

Example:

[btn text="Email Us" url="mailto:hello@example.com" icon="email" icon_pos="left"]

---

#### New Tab

tab="Y"

Opens link in a new tab.

Example:

[btn text="External Site" url="https://example.com" tab="Y"]

---

#### Centering

center="Y"

Centers the button within its container.

Example:

[btn text="Book Now" url="/book" center="Y"]

---

### Notes

- Buttons automatically wrap themselves in `not-prose` to avoid
  Tailwind Typography side effects.
- Only non-default attributes are rendered to keep markup clean.

---

## Social Icon Shortcode Reference

Social icons are intentionally **opinionated and minimal**.

They are most often used in footers, headers, or global sections.

URLs are pulled from the **ACF Options page** by default.

### Basic Usage

[social network="facebook"]

### Required Attribute

- `network` – which social platform to render

Available networks:

- facebook
- instagram
- x
- youtube
- pinterest
- linkedin
- tiktok
- threads
- github
- website
- email
- phone

---

### Size

size="md"

Options:

- sm
- md (default)
- lg
- xl
- 2xl

---

### Shape & Color Rules (Important)

shape="none" | "circle" | "square"

#### If shape = none (default)

- Icon inherits text color
- Optional `color` applies

color="current" | "primary" | "black" | "white"

#### If shape = circle or square

- Background is **always** bg-primary
- Foreground controlled via:

fg="white" | "black"

This constraint is intentional.

Example:

[social network="instagram" shape="circle" fg="white"]

---

### New Tab

tab="Y"

Opens link in a new tab.

---

### Notes

- Social output is wrapped in `not-prose` automatically.
- URLs come from ACF Options (Globals) unless overridden.
- Designed for predictability, not infinite variation.

# Blog Setup & Maintenance Guide

This section covers the parts of the blog system you are most likely to
tweak per client build.\
It is not an explanation of how the blog works --- it is a future-you
survival guide.

---

## 1. Initial Blog Setup Checklist (Per Client)

Before launch, confirm the following:

### ✅ Confirm Posts Page

- Settings → Reading → "Posts page" is assigned correctly.
- Verify `/posts/` (or chosen slug) resolves properly.

### ✅ Confirm Permalinks

- Settings → Permalinks → Pretty permalinks enabled.
- Flush permalinks after any slug changes.

### ✅ Confirm Editor Restrictions

- Only approved blocks appear in the Post editor.
- Button styles show branded variants only.
- Custom colors & gradients are disabled.

If block restrictions fail, check:

    includes/posts/editor.php

---

## 2. Filter Logic Configuration (Inclusive vs Exclusive)

Blog filters are controlled in:

    includes/posts/queries.php

Search for:

    pre_get_posts

### Current Behavior (Default)

- Multiple categories = OR logic\
  (Posts matching _any_ selected category are shown.)

- Multiple tags = OR logic

- Category + Tag combined = AND relationship\
  (Posts must match selected categories AND selected tags.)

---

### Changing to Strict AND (Categories)

Inside the `tax_query` configuration, modify:

    'relation' => 'AND'

And inside category query:

    'operator' => 'AND'

This forces posts to match **all selected categories**.

---

### Making Tags Narrow Categories Differently

To make tags narrow categories more aggressively or override behavior,
adjust the `relation` value in the combined `tax_query` array.

Common patterns:

- `"AND"` → strict matching
- `"OR"` → broad matching

Always test: - Multiple categories - Multiple tags - Category + tag
together - Pagination with filters active

---

## 3. Relative Date Logic ("X Hours Ago")

Human-readable time output lives in:

    includes/posts/template-tags.php

Function:

    prelaunch_display_date()

If a client wants:

- Always show published date
- Show modified date instead
- Remove "hours ago" logic
- Adjust cutoff window (ex: switch to full date after 24h)

Update that function only.

No other template files need modification.

---

## 4. Card System (Design + Variants)

All blog preview markup lives in:

    template-parts/blog/card.php

All card styling lives in:

    assets/src/css/components/cards.css

This is the single source of truth for blog previews.

---

### BEM Naming System

Card classes follow this pattern:

    .card
    .card__media
    .card__image
    .card__body
    .card__header
    .card__meta
    .card__excerpt
    .card__footer
    .card__cta

Rules:

- `.card` = block
- `__element` = part of the block
- `--modifier` = variation of block

Never mix utility classes directly into markup unless necessary. Modify
structure in `card.php`, not in archives.

---

### Creating Card Variants (For CPTs)

If a CPT needs a slightly different layout:

1. Duplicate:

```{=html}
<!-- -->
```

    card.php

2. Rename to:

```{=html}
<!-- -->
```

    card-{posttype}.php

3. Update archive template to load dynamically:

```{=html}
<!-- -->
```

    get_template_part(
      'template-parts/blog/card',
      get_post_type()
    );

4. Add modifier classes in CSS:

```{=html}
<!-- -->
```

    .card--resource { ... }
    .card--case-study { ... }

Do NOT fork logic across templates.\
Variants belong in the card system.

---

## 5. Changing Excerpt Length

Default excerpt length is controlled in:

    includes/posts/content.php

Function:

    prelaunch_excerpt_length()

Override per site using:

    add_filter('prelaunch_excerpt_length', function() {
      return 32;
    });

---

## 6. Pagination Behavior

Pagination markup comes from:

    prelaunch_pagination()

Located in:

    includes/posts/content.php

To modify:

- Icon style
- mid_size / end_size
- aria label
- Replace icons with text

Edit that function only.

---

## 7. Common Client Tweaks

These are the most common per-build adjustments and where to modify
them.

- **Change excerpt length**\
  Update `prelaunch_excerpt_length()` in `includes/posts/content.php`.

- **Change card spacing**\
  Edit layout rules in `assets/src/css/components/cards.css`.

- **Adjust relative date format**\
  Modify `prelaunch_display_date()` in
  `includes/posts/template-tags.php`.

- **Tighten filter logic (AND vs OR)**\
  Adjust the `tax_query` logic inside `includes/posts/queries.php`.

- **Increase related posts count**\
  Update the `posts_per_page` value passed to
  `prelaunch_get_related_posts_query()` in `single.php`.

- **Remove reading time**\
  Remove or comment out `prelaunch_get_reading_time()` in
  `template-parts/blog/card.php` and/or `single.php`.

- **Change "Read more" text**\
  Update the string inside `template-parts/blog/card.php`.

- **Add CPT-specific card variant**\
  Duplicate `card.php`, create `card-{posttype}.php`, and load
  dynamically via `get_template_part()` in archive templates.

None of these require restructuring the blog.

---

## 8. Debug Checklist (When Something Feels Wrong)

### Filters not working?

- Confirm `pre_get_posts` logic.
- Confirm URL parameters (`pl_cat`, `pl_tag`) exist.
- Flush permalinks.

### Cards inconsistent?

- Confirm all templates use `card.php`.
- Confirm no inline markup was duplicated.

### Dates weird?

- Check `prelaunch_display_date()`.

### Pagination broken?

- Confirm query is paged.
- Confirm `prelaunch_pagination()` is being called.
- Confirm only one main query is active.

---

## Final Rule

If something looks wrong:

- Fix it in one place.
- Do not duplicate logic across templates.
- The card system and query system are single sources of truth.

Future you will thank present you.

# SEO Architecture & Launch Checklist

---

## 1. What SEO Is Handled Automatically (Theme + Code)

This starter theme ships with opinionated, production-safe SEO defaults
via **The SEO Framework (TSF)**.

### Meta Titles

- Uses WordPress native title support
  (`add_theme_support('title-tag')`)
- TSF automatically generates page and archive titles
- Site title is appended by default
- Manual TSF titles always override generated titles

### Meta Descriptions

- For ACF-first pages:
    - Scans Flexible Content (`body_sections`) for the first
      meaningful text block
    - Falls back to regular ACF text fields if no flex content exists
- For blog posts:
    - TSF uses Gutenberg content automatically
- Descriptions are trimmed to \~150 characters to satisfy SERP preview
  heuristics
- Manual TSF descriptions always override automation

### Social Sharing (Open Graph / Twitter)

- Priority order:
    1.  Manual TSF social image
    2.  Featured image
    3.  Global ACF option field: `fallback_image`
- Prevents broken or empty social previews
- No content image scraping (intentional)

### Sitemaps

- Automatically generated by TSF at: `/sitemap.xml`
- Updates dynamically with published content
- Respects noindex settings

### Canonicals & Schema

- Canonical tags handled by TSF
- Structured data (schema) handled by TSF
- Theme does not inject duplicate SEO meta or schema markup

---

## 2. Content Best Practices (Editorial Guidelines)

Technical SEO is only part of the equation. Content structure still
matters.

### Per Page

- Use exactly **one H1**
- Maintain logical heading hierarchy (H2 → H3 → H4)
- Avoid skipping heading levels
- Write descriptive, human-readable page titles
- Do not artificially pad titles for character count

### Meta Descriptions

- Write compelling summaries when needed
- Aim for \~140--160 characters
- Focus on clarity and click-through, not keyword stuffing

### Images

- Add meaningful `alt` text for content images
- Avoid uploading oversized images
- Use featured images intentionally when available

### Internal Linking

- Link between relevant service pages and blog posts
- Avoid orphaned pages

### General

- Do not duplicate content across pages
- Avoid excessive keyword repetition
- Write for users first, search engines second

---

## 3. New Site Launch Checklist (Before Going Live)

When spinning up a new site from this blueprint:

### Required Steps

- Follow the steps on this site:

```html
https://theseoframework.com/docs/seo-plugin-setup/
```

- Set Site Title and Tagline (Settings → General)
- Confirm permalink structure (Settings → Permalinks)
- Assign Posts page (if blog enabled)
- Upload global `fallback_image` in ACF Options
- Confirm `/sitemap.xml` resolves
- Verify site is not set to "Discourage search engines"

### After Going Live

- Verify domain in Google Search Console
- Submit: `https://yoursite.com/sitemap.xml`
- Add analytics (GA4 / other)
- Spot-check social previews (homepage + key service pages)
- Implement 301 redirects if replacing an old site

---

This theme provides safe, scalable SEO defaults. Content strategy and
authority determine the rest.

# Footer System

This theme includes a flexible footer system designed to support two layouts while keeping shared logic centralized.

The footer is controlled via the **ACF Globals Options Page** and rendered through a simple layout switch in
`footer.php`.

---

# Footer Architecture

The footer system is composed of:

| Layer          | File                                          | Responsibility                                    |
| -------------- | --------------------------------------------- | ------------------------------------------------- |
| Layout Router  | `footer.php`                                  | Chooses which footer layout to render             |
| Simple Footer  | `template-parts/footer/footer-simple.php`     | Lightweight layout for small sites                |
| Complex Footer | `template-parts/footer/footer-complex.php`    | Multi-column layout with additional content areas |
| Credit Bar     | `assets/src/css/components/footer-credit.css` | Shared legal / copyright section                  |
| Styling        | `assets/src/css/components/footer-*.css`      | Layout-specific styling                           |

The **credit bar always renders**, regardless of which footer layout is active.

---

# Layout Switching

Footer layout is determined by an ACF option field:

```
footer_layout
```

Possible values:

```
simple
complex
```

Routing occurs inside `footer.php`.

Example logic:

```
$layout = get_field('footer_layout','option') ?: 'simple';

switch ($layout) {
  case 'complex':
    get_template_part('template-parts/footer/footer','complex');
    break;

  default:
    get_template_part('template-parts/footer/footer','simple');
}
```

If the field is empty, the **simple footer loads by default**.

---

# Footer Credit Bar (Shared Section)

The footer credit bar sits below both layouts and contains:

- Copyright
- Privacy policy link
- Accessibility link
- Optional agency credit

This section is rendered directly inside `footer.php`.

Key option field:

```
show_site_credit_bar
```

When enabled, the footer displays:

```
Site by Windpeak Design
```

This can be safely removed or replaced if needed.

---

# Simple Footer

File:

```
template-parts/footer/footer-simple.php
```

Purpose:

A minimal footer for small sites or landing pages.

Structure:

- Logo
- Optional links repeater
- Social icons

Social icons are pulled from the **global social system**:

```
windpeak_get_social_items()
windpeak_render_social_icon()
```

CSS file:

```
assets/src/css/components/footer-simple.css
```

---

# Complex Footer

File:

```
template-parts/footer/footer-complex.php
```

Purpose:

A full multi-column footer intended for larger sites.

Typical elements:

- Logo and intro text
- Navigation link groups
- Contact information
- Social icons
- Affiliation logos

Affiliation logos are typically controlled via an **ACF repeater**.

CSS file:

```
assets/src/css/components/footer-complex.css
```

---

# Footer CSS Structure

Footer styling is intentionally separated into **three files**:

```
footer-simple.css
footer-complex.css
footer-credit.css
```

This separation prevents layout logic from bleeding between systems.

### Rule

Only load styles needed for the rendered layout.

Do **not** mix simple and complex footer classes.

---

# Common Tasks

## Change Footer Layout

Go to:

```
ACF Globals → Footer Layout
```

Select:

```
Simple
Complex
```

No code changes required.

---

## Add Footer Links (Simple Footer)

Edit the ACF repeater:

```
footer_simple_links
```

Each row expects a standard WordPress link field.

---

## Add Social Icons

Social icons come from the **global social settings**, not the footer.

Configure inside the global social fields used by:

```
windpeak_get_social_items()
```

The footer simply renders whatever networks are active.

---

## Edit Legal Links

Privacy policy is pulled from WordPress core:

```
get_privacy_policy_url()
```

Accessibility page is resolved automatically if the page slug exists:

```
/accessibility/
```

To change the slug or logic, update the URL generation in `footer.php`.

---

## Remove "Site by Windpeak"

Disable the ACF toggle:

```
show_site_credit_bar
```

Or remove the agency markup inside the credit section of `footer.php`.

---

# README Flags

### README:FOOTER_LAYOUT_SWITCH

Location:

```
footer.php
```

Controls which footer layout loads based on the ACF option field.

If new layouts are ever added, extend the `switch` statement here.

---

### README:FOOTER_CREDIT_BAR

Location:

```
footer.php
```

Shared legal section rendered under both footer layouts.

Handles:

- copyright text
- privacy policy link
- accessibility link
- optional agency credit

---

### README:FOOTER_SOCIAL_RENDER

Location:

```
footer-simple.php
footer-complex.php
```

Social icons are not hardcoded.

They render through:

```
windpeak_get_social_items()
windpeak_render_social_icon()
```

If icons appear missing, check the global social configuration.

---

# Debug Checklist

Footer not changing?

- Confirm `footer_layout` ACF value
- Clear cache
- Ensure the correct template part exists

Social icons missing?

- Confirm networks exist in global options
- Confirm helper functions are loaded

Credit bar missing?

- Confirm `show_site_credit_bar` toggle

---

# Design Philosophy

The footer system follows the same principles as the navbar:

- clear PHP responsibility
- layout-specific CSS
- minimal runtime logic
- centralized configuration through ACF

Future layouts should follow the same pattern rather than modifying existing ones.

---

# User Roles & Permissions System

The Prelaunch starter theme includes a modular system for controlling **user roles, admin feature access, and plugin
settings visibility**.

The goal of this system is to turn WordPress into a predictable client‑safe CMS while remaining compatible with plugins
and normal WordPress workflows.

The system works by:

1. Creating **Prelaunch‑managed roles**
2. Defining what those roles are allowed to access through a **central role policy**
3. Enforcing those rules through **feature modules** that modify the WordPress admin UI

---

# Architecture Overview

The permissions system is split into three layers.

## 1. Role Registration

File:

```
includes/users/register-role.php
```

Responsibilities:

- Creates Prelaunch‑managed roles (ex: `prelaunch_client_admin`, `prelaunch_posts_editor`)
- Clones capabilities from the WordPress **administrator** role
- Syncs developer‑only capabilities
- Provides helper functions for checking managed roles

Example managed role:

```
prelaunch_client_admin
Label: Site Administrator
```

Roles begin with Administrator‑level capabilities.  
Feature modules then remove or restrict access to specific areas of the admin interface.

This approach ensures:

- plugin compatibility
- predictable permissions
- centralized control of admin complexity

---

## 2. Role Policy (Central Configuration)

File:

```
includes/users/role-policy.php
```

The role policy defines **what each role can access**.

It is the **single source of truth** for permissions.

Example:

```
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

Each feature module reads from this policy rather than hardcoding logic.

---

## 3. Feature Modules

Directory:

```
includes/users/
```

Each module controls one area of the WordPress admin UI.

Examples:

```
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

Feature modules typically:

- remove admin menus
- restrict capabilities
- block direct URL access
- adjust admin UI elements

Modules determine access by reading the **role policy**.

---

# Feature Policy Reference

The role policy supports several types of feature controls.

## Binary Features

```
dashboard: true | false
posts: true | false
```

Used when a feature is either visible or completely hidden.

---

## Tiered Features

### Media

```
media: off | browse_only | full
```

Behavior:

| Value       | Behavior                             |
| ----------- | ------------------------------------ |
| off         | Media Library hidden                 |
| browse_only | Library visible but uploads disabled |
| full        | Full media access                    |

The `browse_only` mode removes the `upload_files` capability.

---

### Pages

```
pages: off | draft_only | full
```

Behavior:

| Value      | Behavior                               |
| ---------- | -------------------------------------- |
| off        | Pages hidden                           |
| draft_only | Pages editable but cannot be published |
| full       | Full page access                       |

This allows editorial roles to prepare content without publishing it.

---

### Gravity Forms

```
gravity_forms: off | manager | full
```

Controls access to forms and entries without exposing plugin settings.

---

### Appearance

```
appearance: off | menus_only | full
```

Allows sites to expose **navigation editing** while hiding theme configuration.

---

### Plugins

```
plugins: off | manage_installed | full
```

`manage_installed` allows enabling/disabling existing plugins but prevents installing new ones.

---

### Plugin Settings

```
plugin_settings: off | approved_only | full
```

Controls access to plugin settings pages using an allowlist registry.

---

### ACF

```
acf: off | options_only | full
```

Allows sites to expose **ACF Options pages** while hiding the ACF field editor.

---

## Partial Access Features

### Users

```
users: profile_only | full
```

`profile_only` allows users to edit their own profile but hides the Users management screen.

---

## Simple Toggles

```
tools: off | on
settings: off | full
```

Used for WordPress core admin areas.

---

# Admin Bar Behavior

The system also modifies the **WordPress Admin Bar**.

The **"+ New" menu** is filtered based on role policy.

| Item      | Behavior                       |
| --------- | ------------------------------ |
| New Post  | follows `posts` policy         |
| New Page  | follows `pages` policy         |
| New Form  | follows `gravity_forms` policy |
| New Media | always hidden                  |

### Why Media Is Hidden

The default **+ New → Media** shortcut allows uploads outside of the preferred **FileBird folder workflow**.

Uploads should instead occur through the Media Library interface.

---

# Plugin Settings Access

Plugin settings pages are controlled by:

```
includes/users/user-plugin-settings.php
```

This module maintains an **allowlist registry**.

Example registry:

```
function prelaunch_get_plugin_settings_registry(): array {
    return [
        'filebird' => [
            'label'       => 'FileBird',
            'parent_slug' => 'filebird-dashboard',
            'menu_slug'   => 'filebird-dashboard',
            'approved'    => true,
        ],
        'tsf' => [
            'label'       => 'The SEO Framework',
            'parent_slug' => 'theseoframework-settings',
            'menu_slug'   => 'theseoframework-settings',
            'approved'    => false,
        ],
    ];
}
```

Fields:

| Field       | Purpose                                     |
| ----------- | ------------------------------------------- |
| label       | Human‑readable plugin name                  |
| parent_slug | parent admin menu slug                      |
| menu_slug   | plugin page slug                            |
| approved    | visible when `approved_only` policy is used |

---

# Approving Plugin Settings Pages

1. Navigate to the plugin settings page in the WordPress admin.
2. Inspect the URL.

Example:

```
wp-admin/admin.php?page=my-plugin-settings
```

The slug is:

```
my-plugin-settings
```

3. Add an entry to the registry:

```
'myplugin' => [
    'label' => 'My Plugin',
    'parent_slug' => 'my-plugin-settings',
    'menu_slug' => 'my-plugin-settings',
    'approved' => true,
]
```

Refresh the admin panel to apply the change.

---

# Troubleshooting Plugin Settings Visibility

If a plugin settings page still appears unexpectedly, check the following.

### Incorrect Menu Slug

Example URL:

```
wp-admin/options-general.php?page=example-settings
```

Correct configuration:

```
'parent_slug' => 'options-general.php',
'menu_slug' => 'example-settings',
```

---

### Plugin Registers Multiple Pages

Some plugins create multiple admin screens (dashboard, settings, tools).

Each page may require its own registry entry.

---

### Plugin Uses a Custom Admin Screen

Some plugins do not use `admin.php?page=` URLs.

Use browser devtools to inspect the admin menu and locate the `menu_slug`.

---

### Plugin Loads After Removal Hook

The module runs at:

```
admin_menu priority 1000
```

This ensures plugin menus exist before removal occurs.

---

# Debugging Permission Issues

If an admin area appears or disappears unexpectedly, check the following areas.

### Role Policy

```
includes/users/role-policy.php
```

Confirm the feature flag is correct.

---

### Feature Module Logic

Verify the correct module is enforcing the feature.

Examples:

```
user-posts.php
user-plugins.php
user-settings.php
user-tools.php
user-acf.php
user-plugin-settings.php
```

---

### Role Capability Sync

File:

```
register-role.php
```

Roles are cloned from Administrator capabilities and then adjusted.

Confirm the role has the expected capability.

---

### Developer‑Only Capabilities

Some features rely on custom capabilities.

Example:

```
prelaunch_manage_tokens
```

Only the real **administrator** role should retain this capability.

Managed roles intentionally lose it during role sync.

---

# Adding a New User Role

1. Register the role.

Edit:

```
includes/users/register-role.php
```

Add the role to:

```
prelaunch_get_managed_user_roles()
```

Example:

```
return [
    PRELAUNCH_CLIENT_ADMIN_ROLE,
    PRELAUNCH_POSTS_EDITOR_ROLE,
];
```

2. Define its policy.

Edit:

```
includes/users/role-policy.php
```

Example:

```
PRELAUNCH_POSTS_EDITOR_ROLE => [
    'dashboard' => false,
    'media' => 'off',
    'posts' => true,
    'pages' => 'off',
    'users' => 'profile_only',
]
```

3. Assign the role to a user through WordPress admin or WP‑CLI.

---

# Adding a New Feature Module

Create a module file:

```
includes/users/user-example-feature.php
```

Example structure:

```
function prelaunch_customize_example_feature(): void {

    if ( ! prelaunch_current_user_has_feature_access('example_feature') ) {

        remove_menu_page('example-page');

    }

}

add_action('admin_menu', 'prelaunch_customize_example_feature', 1000);
```

Then load the module in:

```
includes/users/users.php
```

Add a policy key to:

```
role-policy.php
```

Example:

```
'example_feature' => 'off'
```

---

# Design Philosophy

The Prelaunch permissions architecture intentionally:

- begins with **Administrator capability parity**
- removes features through modular rules
- centralizes permissions inside a role policy
- hides unnecessary WordPress complexity from clients

The result is a **predictable, client‑friendly CMS experience** without sacrificing plugin compatibility or developer
control.
