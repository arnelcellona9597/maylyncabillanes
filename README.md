# maylyncabillanes.com

One-page portfolio for Maylyn Cabillanes. HTML, CSS, vanilla JS, PHP 8.5 (contact form via SMTP).

## Run locally
    cp .env.example .env   # fill SMTP_PASS
    php8.5 -S localhost:8000

## Branching
- `main` production, `develop` integration, `feature/*` merged into `develop` via PR, then `develop` -> `main`.

## Secrets
`.env` is git-ignored. Never commit credentials.
