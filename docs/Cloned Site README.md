# Client Site

This site was built using the **Pre-Launch WP** starter theme.

This repository is for the client site itself. It is not the source documentation for the starter theme.

For full theme documentation, setup notes, system references, and maintenance details, use the main Pre-Launch WP repository:

[Pre-Launch WP Documentation](https://github.com/Myzwer/Pre-Launch-WP)

---

## What This Site Uses

This project was built from the Pre-Launch WP Local blueprint and generally assumes:

- WordPress
- ACF Flexible Content
- ACF Globals / Options pages
- Gravity Forms
- Tailwind CSS v4
- Webpack
- BrowserSync
- Yarn

Most page layouts are managed through ACF Flexible Content sections.

Global site content, such as logos, social links, footer content, contact information, and fallback images, usually lives in **ACF Globals**.

---

## Common Commands

Run these from the theme/project directory.

```bash
yarn dev
```

```bash
yarn dev:watch
```

```bash
yarn prod
```

```bash
yarn prod:watch
```

---

## Common Edit Points

### BrowserSync

Update the local proxy URL in the Webpack config when working locally.

### Theme Tokens

Frontend design tokens live in:

```text
assets/src/css/tailwind.css
```

This is where colors, gradients, font roles, buttons, typography helpers, and layout helpers are defined.

### Backend / Admin Tokens

Backend/admin token colors live in:

```text
includes/theme/tokens.php
```

These help keep WordPress UI contexts aligned with the frontend brand system.

### Font Loading

Google Fonts are loaded from:

```text
includes/theme/fonts.php
```

Font usage is controlled separately in the Tailwind font tokens.

### ACF Globals

Site-wide content usually lives in ACF Globals, including:

- Logos
- Social links
- Contact information
- Footer content
- 404 text
- Global fallback image

---

## Full Documentation

For the full starter theme documentation, use the main Pre-Launch WP repo:

[https://github.com/Myzwer/Pre-Launch-WP](https://github.com/Myzwer/Pre-Launch-WP)

That documentation covers:

- New site setup workflow
- Launch workflow
- Theme tokens
- Fonts
- Buttons
- Typography and WYSIWYG helpers
- Layout helpers
- Navbar system
- Footer system
- Editor tooling and shortcodes
- Blog system
- SEO architecture
- User roles and permissions

---

## Note for Future Developers

This client site may not match the starter theme exactly. It began from Pre-Launch WP, but project-specific changes may have been made during development.

Use this repo as the source of truth for this client site. Use the Pre-Launch WP repo as the source of truth for the starter theme.
