# maylyncabillanes.com

One-page portfolio for **Maylyn Cabillanes**, Human Resource Management Staff at the Philippine Postal Corporation (Davao City).
Built with HTML, CSS, vanilla JavaScript and PHP 8.5 only. No frameworks, no Composer.

Live: https://maylyncabillanes.com

## Features
- Premium one-page design: animated hero canvas, grain/vignette/light-sweep overlays, smooth scrolling, scroll progress, reveal and parallax effects, custom cursor, magnetic buttons, gallery lightbox.
- Light/dark mode toggle. The choice is stored in a cookie and `localStorage`, so it survives refreshes and PHP renders the right theme on first paint.
- Responsive from 320px to desktop (burger menu below 1100px).
- Contact form (`api/contact.php`): CSRF token, honeypot, per-session rate limit, validation, and delivery through IONOS SMTP (STARTTLS on port 587) to both inboxes.
- Analytics and consent: Google Analytics 4 (`G-ZTC7HK73VF`) loads only on the live domain, behind a cookie consent banner using Google Consent Mode v2. Analytics stays denied until the visitor accepts; the choice is stored for 12 months and can be changed from "Cookie settings" in the footer. A privacy notice dialog explains what is collected.
- SEO and sharing: JSON-LD schema graph (WebSite, ProfilePage, Person, ImageObject), Open Graph and Twitter Card tags, 1200x630 share image, canonical URL, `robots.txt`, `sitemap.xml`, web manifest, face-crop favicons.

## Project structure
```
index.php               page template, meta tags and JSON-LD
api/contact.php         contact form endpoint (JSON)
src/Env.php             .env loader
src/Mailer.php          minimal SMTP client
assets/css/             base, layout, components, effects, premium
assets/js/              theme, scroll, effects, hearts, gallery, contact, consent, main
assets/img/             optimized WebP + JPG images, favicons, og-image.jpg
robots.txt, sitemap.xml, site.webmanifest, favicon.ico
router.php              local dev router only (not deployed)
.env.example            configuration template
```

## Run locally (PHP 8.5)
```bash
cp .env.example .env        # then fill in SMTP_PASS
php8.5 -S localhost:8765 router.php
```
Open http://localhost:8765. `router.php` mirrors the `.htaccess` rules that hide `.env` and `src/`.

## Configuration
All secrets live in `.env`, which is git-ignored. See `.env.example` for the keys:
`SMTP_HOST`, `SMTP_PORT`, `SMTP_USER`, `SMTP_PASS`, `MAIL_FROM`, `MAIL_FROM_NAME`, `MAIL_TO` (comma-separated recipients).
On the live server the `.env` sits one level above the web root (`/.env`, with the site in `/public`). `api/contact.php` reads it from there first.

## Branching
- `main`: production. Only receives merges from `develop`.
- `develop`: integration.
- `feature/*`, `hotfix/*`: short-lived branches merged into `develop` with `--no-ff`.

## Deploy (SFTP)
Host `access-5021806789.webspace-host.com`, port 22, user `su680035`. The web root is `/public`.
1. Export a clean copy of `main` without dev-only files:
   ```bash
   git archive main | tar -x -C /tmp/stage
   rm /tmp/stage/README.md /tmp/stage/router.php /tmp/stage/.env.example /tmp/stage/.gitignore
   ```
2. Upload the contents of the staging folder to `/public` over SFTP. Upload `.env` to `/.env` (above the web root) with `chmod 600`.
3. Check that `/.env` is not reachable on the web, and send a test message through the form.
Never commit credentials. Rotate the SMTP and SFTP passwords if they have been shared.

## SEO and social sharing checklist
- Submit `https://maylyncabillanes.com/sitemap.xml` in Google Search Console.
- Validate structured data: https://search.google.com/test/rich-results and https://validator.schema.org
- Refresh share previews after changes: Facebook Sharing Debugger (https://developers.facebook.com/tools/debug/), LinkedIn Post Inspector.
- Favicon: `favicon.ico` (16/32/48) plus PNGs at 32, 48, 96 and 192 px, all cropped from `portrait-3`. Google needs a square icon in multiples of 48 px and can take days to weeks to refresh it in search results; use URL Inspection → Request indexing in Search Console to speed that up.
- The share image is `assets/img/og-image.jpg`. When it changes, bump the `?v=` value in `index.php` (`$ogImage`) so platforms re-fetch it.

## Content notes
Only professional information is published. Personal identifiers from the Personal Data Sheet (government IDs, family details, street address, phone) are intentionally not used.
