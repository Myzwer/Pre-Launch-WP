# WordPress Pre-Launch 🚀

![Webpack 5](https://img.shields.io/badge/Webpack-5.x-brightgreen)
![Babel 7](https://img.shields.io/badge/Babel-7.x-brightgreen)
![Tailwind v4](https://img.shields.io/badge/Tailwind-4.x-brightgreen)
![PostCSS 8](https://img.shields.io/badge/PostCSS-8.x-brightgreen)
![BrowserSync 2](https://img.shields.io/badge/BrowserSync-2.x-brightgreen)

---

## What This Is

**WordPress Pre-Launch** is a production-ready **starter theme / blueprint** used as the foundation for all client WordPress builds.

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
2. Pick a font family that you like, and select a few styles. (as a note, the more files you choose the slower the site will be. So only pick ones you need to use)
3. Under "use on the web" section, make sure < link > is selected, and look at the code that is generated. It should look _something_ like this:

```
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
```

4. Copy the link from the 3rd block, minus the &display=swap. In the example above, it would be this:

```css
https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400
```

5. Navigate to functions.php, specifically the fonts part.
6. Drop in this code:

```php
wp_register_style( 'FONTNAME_font', 'FONTLINK' );
wp_enqueue_style('FONTNAME_font');
```

7. Name it whatever where FONTNAME_font is (it doesn't matter what you call it, but it does make sense to name it the fontname for ease of reference later), and add the link to FONTLINK. So to complete our example:

```php
wp_register_style( 'roboto_font', 'https://fonts.googleapis.com/css2?familY=Roboto:ital,wght@0,400;0,500;0,700;1,400' );
wp_enqueue_style('roboto_font');
```

8. Go back to google, copy the font family section and you can begin using it in your CSS!
9. (optional) If you are still using tailwind, go into tailwind.config.js and update the fontFamily section. This is already done for you so you should be able to easily swap out my code for your new font code.

```css
fontFamily: {
       'myfontname': ['Roboto', 'sans-serif'], // text-roboto
      }
```

---

### Custom Fonts

1. Purchase or download font files. They will most likely come as .otf or .ttf or something like that. It doesn't matter which you use.
2. Go to [Transfonter](https://transfonter.org/) and select the fontses you want to include. The more files you include the slower your website will be, so only get the ones you need. Bigger is not always better. Girls do care about the [size of your megapixel.](https://youtu.be/eg8u_Q1tNlo?t=22)
3. Upload the font files to the site.
4. You do not need to adjust any settings on the bottom section unless you want to.
5. Download your @font-face kit zip file with new fonts!
6. Upzip. 😉
7. You don't need demo.html, though can see what your fonts looks like on a page if you load it up.
8. Copy all .woff and .woff2 files into ./assets/src/webfonts in the wordpress project. You can delete any existing files that you no longer need including the gitkeep file.
9. Open up stylesheet.css, copy all the code out of it, and paste that into fonts.css. (.assets/src/sass/fonts/)
10. Lastly, you'll need to tell your fonts where they can find the woff files. This means adding `../../webfonts/` to the beginnging of all of your URL's.

```css
font-family: "MYFONT";
src:
	url("../../webfonts/MYFONT.woff2") format("woff2"),
	url("../../webfonts/MYFONT.woff") format("woff");
font-weight: 900;
font-style: normal;
font-display: swap;
```

11. Once added, if you have prettier and stylelint up and running, both of those will throw errors, so hop over to iterm and type `yarn stylelint` to get it fixed.
12. Once linked like this, you are free to use your new font families! The name is whatever fontfamily is called. In the above example (where I showed linking) MYFONT would be the name you'd use.
13. (optional) If you are still using tailwind, go into tailwind.config.js and update the fontFamily section. This is already done for you so you should be able to easily swap out my code for your new font code.

```css
fontFamily: {
       'myfontname': ['Bleeding Cowboy', 'serif'], // text-bleeding-cowboy
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

# Navbar - Header.php

<img src = "https://i.imgflip.com/5ku7z5.jpg" width= 50%; alt = "What the hell happened here?">

So if you've never had the pleasure of creating a navbar before, it's a tossup between creating one and getting waterboarded for me. They are miserable to deal with for a couple reasons. They are already finicky enough without introducing wordpress into the mixture.

Wait, what do you mean "in wordpress"? I mean that your navbar isn't much good if the URL's are only work on local or production, but not both. Or if the user can't go in and edit a link like they wanted to. So we build it In wordpress, meaning we use php to generate the navbar code on the server side, rather than a whole bunch of HTML. However, wordpress has a very specific way of outputing code, and it is without fail NEVER the code you needed it to be. So we use a custom navwalker to fix this.

That sounds complicated. It was, luckily it's done for you. The navbar is plug and play as is, right now.

**_ IMPORTANT NOTE: THIS NAVBAR DOES NOT USE TAILWIND SO REMOVING TAILWIND FROM THE PROJECT WILL NOT EFFECT IT. _**

### **I just want to use the navbar as is.**

Great! You can swap the logo out in `header.php` and edit the links in WP admin. Happy coding!

### **Ok so I like it, but I wanna tweak some things.**

Well, head over to `/assets/src/sass/components/_navbar.scss`. Notice at the top there's some SCSS variables with comments. These are some "hotfix" style things you can edit such as width, height, breakpoint, colors, etc. If you can't accomplish what you are looking to do via those, you'll need to jump into the code to make your changes. I've commented as well as I can for you. Happy Coding!

### **Nah I've got my own navbar, can I use that?**

Sure. It's your project and I didn't include malware with this install to tell me whether you tampered with the navbar or not. To get rid of it and add your own:

1. Delete everything out of `/assets/src/sass/components/_navbar.scss`. I don't see a reason why you wouldn't just replace it with your new css, but if you want to delete the file you can.
2. Delete all the code in `header.php` FROM `<section class="navigation">` through `</section>`. Leave the rest alone.
3. You might need to edit functions.php as well, depending on to what extext you are pruging the navbar.

Good luck with your own navbar! I'd recommend you follow this pattern but it really up to you. Again, malware free over here.

1. Get the navbar working independent of your project, in codepen or something. Eliminates a lot of "is this not working because the code is wrong or because the project is messing it up?"
2. Import it in, and get it working static. meaning no php, none of that. Once you see that the navbar is working perfectly...
3. Convert it to wordpress. How to do that is beyond the scope of this readme, but there are plenty of resources online to help. Don't fall into the trap of saying you don't need to convert it. You do. It'll save you and your clients a headache in the future.

- https://www.wpbeginner.com/beginners-guide/how-to-add-navigation-menu-in-wordpress-beginners-guide/
- https://css-tricks.com/the-wordpress-nav-walker-class-a-guided-var_dump/
  Happy coding!

# Footer - Footer.php

Footers. Are they as bad as navbars? No. Are they at least easy to work with? Also no. Much like headers, they are already finicky enough without creating them in wordpress.

Wait, what do you mean "in wordpress"? I mean instead of a bunch of HTML that probably consists of `<footer>` and `<ul>` and such, you have a block of php that renders out some of the footer. Unlike the navbar, only part of the footer will be generated by Wordpress, namely because there is more to a footer than links. However, the links will be generated from Wordpress. We do it this way for a few reasons:

1. Your footer isn't much good if the URL's are only work on local or production, but not both. When PHP can't change them dynamically, you have to pick one or the other.
2. Ideally your end user (client) would be able to change thier own footer and not need you to update it for them right? And even if they don't want to do that, it'll be a quick change. Like that magic act.

So when we build this in wordpress, it is giong to generate some classes. However, unlike the navbar, we can use the CSS to work with these, as I've done here. The footer is set up and ready to go. It will need edited to make sure it looks the way you like, and adjustments for size will need to be made.

**IMPORTANT NOTE: THIS NAVBAR DOES NOT USE TAILWIND SO REMOVING TAILWIND FROM THE PROJECT WILL NOT EFFECT IT.**

### **I just want to use the footer as is.**

Good. She's a beaut, Clark. You'll need to make a few adjustments.

1. Go to footer.php.
2. Update the logo, then adjust the scss to make the image look good and feel spaced right.
3. Update the phone number and name.
4. Change the links in WP admin.
5. Update the company text and copyright
6. Change the socials and add / remove any ones you do / don't need.
7. Don't change anything else, you'll break stuff you don't mean to.

### **Ok so I like it, but I wanna tweak some things.**

Doesn't surprise me. The nature of the way it was built means that you'll probably have to do some light editing even if you want to keep it the same. Anyway to edit it just navigate to `/assets/src/sass/components/_footer.scss` and start changing things. I've commented as well as I can. Good luck and Happy Coding!

### **Nah I've got my own footer, can I use that?**

Figures 🙄. Do what you must.

1. Delete everything out of `/assets/src/sass/components/_navbar.scss`. I don't see a reason why you wouldn't just replace it with your new css, but if you want to delete the file you can.
2. Delete all the code in `footer.php` FROM the end of the opening php on line 12 to `<?php wp_footer(); ?>`. MAKE SURE YOU DON'T DELETE THAT, WORDPRESS NEEDS IT TO WORK.
3. You might need to edit functions.php as well (the menus section), depending on to what extent you are purging the navbar.

Good luck with your own footer! I'd recommend you follow this pattern but it really up to you.

1. Get the footer working independent of your project, in codepen or something. Eliminates a lot of "is this not working because the code is wrong or because the project is messing it up?"
2. Import it in, and get it working static. meaning no php, none of that. Once you see that the navbar is working perfectly...
3. Convert it to wordpress. How to do that is beyond the scope of this readme, but there are plenty of resources online to help. Don't fall into the trap of saying you don't need to convert it. You do. It'll save you and your clients a headache in the future.

Happy coding!
