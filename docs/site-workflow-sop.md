# Site Workflow SOP

Use this file when creating a new client site from the Pre-Launch WP Local blueprint and when prepping a finished site
for launch.

The README is the technical reference. This file is the checklist.

---

## Table of Contents

- [Initial Site Setup SOP](#initial-site-setup-sop)
- [Development](#development)
- [Prep for Launch SOP](#prep-for-launch-sop)
- [Final Live Smoke Test](#final-live-smoke-test)

---

# Initial Site Setup SOP

Use this checklist when creating a new client site from the Pre-Launch WP Local blueprint.

The goal is to get from:

> “I cloned the template”

To:

> “This site is clean, connected to Git, locally running, lightly branded, and ready for normal development.”

This SOP stops before actual page/block development.

---

## Clone the Local Blueprint

- Clone the Pre-Launch WP blueprint in Local.
- Rename the new Local site/client folder as needed.
- Rename the theme folder so it is easy to identify in terminal/iTerm.

The theme display name does not need to be changed in `style.css`.

---

## Detach the Old Git History

Because this site was cloned from the blueprint, remove the existing Git history before creating the new repo.

From the project/theme root:

```bash
rm -rf .git
```

---

## Re-Activate the Theme

Renaming the theme folder will break WordPress’s active theme reference.

In WP Admin:

- Go to Appearance → Themes.
- Re-activate the Pre-Launch/client theme.
- Confirm the frontend loads.

---

## Configure BrowserSync

Update the BrowserSync/local proxy URL in the Webpack config.

Then confirm local dev works:

```bash
yarn dev
```

or:

```bash
yarn dev:watch
```

This should happen early so frontend checks work during the rest of setup.

---

## Initialize Git

Create a fresh Git repo for the new site before making client-specific code changes.

```bash
git init
git add .
git commit -m ":tada: Initial commit"
```

Push to the new remote repo.

After this point, make normal setup changes in commits as needed.

---

## Run Initial Build Checks

Before changing tokens, fonts, or other code, confirm the cloned project builds.

```bash
yarn dev
yarn prod
```

Fix obvious build errors before continuing setup.

---

## Basic WordPress Setup

In WP Admin, update the basic site settings.

Appearance → Customize:

- Set the site name.
- Set the tagline.
- Set the favicon/site icon if available.

Settings → Permalinks:

- Confirm pretty permalinks are enabled.
- Save once to flush permalinks.

Settings → Reading:

- Confirm the homepage.
- Confirm the posts page if the site will use a blog.
- Confirm search engine visibility behavior.

---

## Create the Page List

If the copywriter/content plan has the page list ready, create the site’s main pages now.

This makes the rest of setup easier because real page links exist for:

- navigation,
- footer links,
- buttons,
- internal links,
- early smoke testing.

Common examples:

- Home
- About
- Services
- Contact
- Blog / Articles
- Privacy Policy
- Accessibility

After creating pages, revisit:

- Settings → Reading
- Menus
- Footer links
- Global buttons or CTAs

---

## Clean Starter Content

Remove leftover blueprint/test content that should not ship with the new client site.

Check:

- Test posts
- Test pages
- Test SEO page
- Test media/images
- Placeholder content
- Old footer/nav test items

Starter posts should be removed whether or not the final site will use a blog.

---

## Upload Early Client Assets

If available, upload early client assets now.

Examples:

- Logo
- Favicon
- Brand images
- Starter photography
- Fallback/social image

---

## Update Theme Tokens

Update the site brand tokens.

Main frontend token file:

```text
assets/src/css/tailwind.css
```

Update the `@theme {}` section as needed:

- colors,
- gradients,
- fonts,
- brand roles.

Backend/admin token source:

```text
includes/theme/tokens.php
```

Update this so backend/login/editor token colors match the new brand.

---

## Update Fonts

Update the Google Fonts enqueue file:

```text
includes/theme/fonts.php
```

Then update the Tailwind font tokens in:

```text
assets/src/css/tailwind.css
```

Confirm:

- body font is assigned to `--font-body`,
- display/headline font is assigned to `--font-display`,
- fonts load on the frontend,
- headings and body copy use the expected fonts.

---

## Update Buttons

Button styles are controlled in:

```text
assets/src/css/tailwind.css
```

Check/update:

- `btn_main`
- `btn_secondary`
- `btn_light`
- `btn_dark`
- `btn_ghost_white`
- `btn_ghost_black`

Then smoke test a button inside WYSIWYG content.

---

## Configure ACF Globals

Go to ACF Globals and update the site-wide options.

Check/update:

- Header/nav logo
- Footer logo
- Social links
- Basic contact information
- 404 page text
- Global fallback image
- Footer layout
- Footer content
- Footer credit/site credit settings

---

## Configure Navigation

Update the primary nav menu.

Check:

- Correct pages are linked.
- Placeholder/test links are removed.
- CTA item is last.
- CTA menu item has the correct class.
- Dropdowns are structured correctly if used.

---

## Configure Footer

Confirm the footer setup before normal development begins.

Check:

- Correct footer layout is selected.
- Footer logo is set.
- Footer links are correct.
- Social icons are pulling from Globals.
- Privacy policy link works.
- Accessibility page/link works if used.
- Site credit behavior is correct.

---

## Decide Blog Status

Decide whether the site will use the blog.

Starter posts should already be removed either way.

If yes:

- Confirm Posts page is assigned.
- Confirm blog/archive page resolves.
- Confirm blog links exist where needed.
- Confirm editor restrictions are working.
- Confirm branded button styles are available after tokens/buttons are updated.
- Confirm custom colors/gradients are locked down as expected.

If no:

- Confirm starter posts are removed.
- Remove blog links from nav/footer.
- Do not assign/build blog pages unless needed.

---

## Check User Roles & Permissions

Before sending admin access or client instructions, confirm the user role setup.

Check:

- Client/admin role exists as expected.
- Client role has the right level of access.
- Unneeded admin menus are hidden.
- Posts access matches whether the site has a blog.
- Pages access is appropriate.
- Gravity Forms access is appropriate.
- ACF access is appropriate.
- Plugin/settings access is appropriate.

This is especially important before sending any “you can log in now” email.

---

## Run Final Setup Build Checks

After setup changes are made, confirm the build still works.

```bash
yarn dev
yarn prod
```

Commit setup changes:

```bash
git add .
git commit -m ":wrench: Configure starter site"
```

---

## Setup Smoke Test

Before starting real page/block development, confirm the cloned site is stable.

Check:

- Frontend loads.
- WP Admin loads.
- Correct theme is active.
- BrowserSync works.
- Production build completes.
- Homepage renders.
- A normal page renders.
- ACF Flexible Content appears on pages.
- Nav menu renders.
- Mobile nav opens.
- Dropdowns work if used.
- Footer renders with the selected layout.
- Login screen uses branded styling.
- WYSIWYG Button tool appears.
- A test shortcode button renders correctly.
- Blog archive works if blog is enabled.
- User role permissions are sane.
- No obvious PHP warnings/errors.

Once these pass, the site is ready for normal development.

---

# Development

Build the site.

This SOP does not try to document normal page/block development. Once the site is built and has had at least one desktop
QC pass, move to Prep for Launch.

---

# Prep for Launch SOP

Use this after development is done and the site has already had at least one normal desktop QC pass.

This is not the full dev checklist. This is the final “make sure you did not forget the obvious stuff” pass before
pushing live.

---

## Final Content Check

- Check every main page.
- Check the homepage.
- Check the contact page.
- Check the 404 page.
- Check the privacy policy page.
- Check the accessibility page.
- Remove placeholder copy.
- Remove placeholder images.
- Remove test buttons/links.
- Remove unused draft pages.
- Confirm all nav links go somewhere real.
- Confirm all footer links go somewhere real.
- Confirm major CTAs go to the right page/form.

---

## Mobile Check

Do one focused mobile pass.

Check:

- Homepage
- Main interior page
- Contact page
- Blog/archive page if used
- Single post if blog is used
- Mobile nav / burger menu
- Dropdowns if used
- Footer
- Buttons
- Forms

Fix anything obviously broken before launch.

---

## Forms Check

- Confirm all forms are final.
- Send a test submission for each public form.
- Confirm notifications go to the right people.
- Confirm confirmation messages/pages work.
- Remove test entries if needed.

---

## Globals Check

Review ACF Globals one more time.

Check:

- Logo
- Footer logo
- Social links
- Contact info
- 404 text
- Fallback image
- Footer layout
- Footer credit setting

---

## SEO Check

- Set site title.
- Set tagline.
- Check page titles.
- Check meta descriptions on key pages.
- Confirm exactly one H1 per main page.
- Check heading order on key pages.
- Confirm featured/social images where needed.
- Confirm global fallback image is set.
- Confirm `/sitemap.xml` works.
- Confirm search visibility is not discouraged before launch.

---

## Blog Check

If the site has a blog:

- Confirm Posts page is assigned.
- Remove starter posts.
- Check blog archive.
- Check single post template.
- Check categories/tags if used.
- Check pagination if enough posts exist.
- Check related posts if used.

If the site does not have a blog:

- Remove starter posts.
- Remove blog links.
- Confirm no unnecessary blog page is in the nav/footer.

---

## Media Check

- Remove unused test images.
- Check obvious oversized images.
- Confirm important images have alt text.
- Confirm favicon/site icon is set.
- Confirm logo looks good on frontend and login screen.

---

## User / Admin Check

Before sending login info:

- Confirm client user exists.
- Confirm client role/permissions are correct.
- Confirm admin menus look sane for the client.
- Confirm Gravity Forms access if needed.
- Confirm Posts access matches blog status.
- Confirm ACF/settings access is not exposing anything weird.

---

## Technical Check

Run production build:

```bash
yarn prod
```

Then check:

- Frontend after build.
- WP admin after build.
- No obvious PHP warnings.
- BrowserSync/dev leftovers are not relevant to production.
- Final pre-launch changes are committed.

---

## Flywheel / Push Live

- Push from Local to Flywheel.
- Check the live site after push.
- Confirm homepage loads.
- Confirm interior page loads.
- Confirm forms still work.
- Confirm SSL is active.
- Confirm redirects if replacing an old site.
- Confirm search visibility is correct on live.

---

# Final Live Smoke Test

After the site is live:

- Check homepage.
- Check nav.
- Check footer.
- Check contact form.
- Check mobile nav.
- Check 404 page.
- Check sitemap.
- Check favicon.
- Check key CTAs.
- Check social preview if needed.
- Submit sitemap in Google Search Console if ready.
- Add analytics if needed.

Once this pass is done, the site is launched.
