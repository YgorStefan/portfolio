# Hostinger Deployment Guide

**Project:** Portfólio Ygor Stefankowski
**Target:** Hostinger Shared Hosting
**Created:** Phase 1 Foundation
**Last verified:** (update each time you deploy)

---

## Prerequisites

Before starting any deploy:

- [ ] Node.js and npm available on your LOCAL machine (Hostinger does not have Node.js)
- [ ] FTP client installed (FileZilla, Cyberduck) OR access to Hostinger hPanel File Manager
- [ ] Hostinger hPanel credentials
- [ ] Domain pointed to Hostinger nameservers

**PHP version check:** Open hPanel → Hosting → Manage → PHP Configuration. Verify PHP 8.2.x is selected. If PHP 8.3 is now available, you may bump `composer.json` from `^8.2` to `^8.3`, but this is optional — `^8.2` works on both.

---

## Step 1: Build Assets Locally

Node.js is NOT available on Hostinger shared hosting. You MUST build assets on your local machine before every deploy.

```bash
npm run build
```

Verify the build succeeded:
- Terminal exits with code 0 (no errors)
- `public/build/manifest.json` exists
- `public/build/` contains at least one `.css` file and one `.js` file with version hashes

**Important:** `public/build/` is not committed to git. You must FTP it to the server on every deploy. If you skip this, the production site will have no styling or JavaScript.

---

## Deploy Strategy A: index.php Path Rewrite (All Hostinger Plans)

Use this strategy if you do not have SSH access or Business plan hPanel document root settings.

### File Structure on Hostinger

```
~ (home directory)
├── laravel/                   ← Upload FULL Laravel project here
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── data/
│   ├── public/                ← Source of truth for public files
│   ├── resources/
│   ├── routes/
│   ├── vendor/
│   ├── .env                   ← Production .env goes here (NEVER in public_html/)
│   └── ...
└── domains/
    └── yourdomain.com/
        └── public_html/       ← Web root — only public/ contents land here
            ├── build/         ← Copied from laravel/public/build/
            ├── index.php      ← Copied from laravel/public/index.php (then modified)
            ├── .htaccess      ← Copied from laravel/public/.htaccess
            └── ...
```

### Steps

1. **Upload the full Laravel project** via FTP to `~/laravel/` (create this directory first)

2. **Upload `public/` contents** to `public_html/` — copy everything INSIDE `laravel/public/` into `public_html/` (not the `public/` folder itself, its contents)

3. **Edit `public_html/index.php`** — update the two path constants:

```php
// BEFORE (default Laravel install):
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

// AFTER (path rewrite for Hostinger):
require __DIR__.'/../laravel/vendor/autoload.php';
$app = require_once __DIR__.'/../laravel/bootstrap/app.php';
```

4. **Copy `.htaccess`** from `laravel/public/.htaccess` to `public_html/.htaccess`

5. **Configure production .env** — see Step 3 below

---

## Deploy Strategy B: hPanel Document Root (Business Plan Only)

Use this strategy if your Hostinger plan includes SSH access and the hPanel Advanced settings.

### Steps

1. **Upload the full Laravel project** via FTP or SSH to `~/laravel/`

2. **In hPanel:** Navigate to Hosting → Manage → Advanced → Document Root

3. **Set Document Root** to: `/home/yourusername/domains/yourdomain.com/laravel/public`
   (replace `yourusername` with your actual Hostinger username)

4. **Configure production .env** — see Step 3 below

**Advantage over Strategy A:** No index.php modification needed. The web server points directly at `laravel/public/`, so Laravel's `.htaccess` works exactly as designed.

---

## Step 3: Production .env Configuration

On the Hostinger server, in `~/laravel/.env` (NOT in `public_html/`), set these three overrides:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

**Why these matter:**
- `APP_DEBUG=false` — prevents Laravel's Ignition error page from exposing stack traces, file paths, and environment variables to visitors
- `APP_URL=https://yourdomain.com` — ensures Vite asset URLs point to your domain, not localhost
- `APP_ENV=production` — enables production caching and disables development helpers

**Generate APP_KEY** if deploying for the first time (via Hostinger SSH or hPanel terminal):
```bash
php artisan key:generate
```
Or generate locally and copy the value: `php artisan key:generate --show`

---

## Step 4: Security Verification Checklist

After every deploy, verify these six items. If any fail, do NOT proceed with Phase 4 launch.

- [ ] `https://yourdomain.com/.env` returns **403 or 404** — NOT file contents
- [ ] `https://yourdomain.com/vendor/` returns **403 or 404**
- [ ] `https://yourdomain.com/composer.json` returns **403 or 404**
- [ ] `https://yourdomain.com/nonexistent-route` returns a plain error page (NOT Laravel Ignition with stack trace — confirms APP_DEBUG=false)
- [ ] Page loads with full CSS styling (no bare HTML — confirms public/build/ was uploaded)
- [ ] Browser console shows no 404 errors for asset files (confirms manifest.json and build/ contents are complete)

**If `.env` returns file contents:** Your document root is wrong. The entire Laravel project landed in `public_html/` instead of only `public/` contents. Re-read Strategy A and verify the index.php path rewrite.

---

## Repeated Deploy Workflow

Every subsequent deploy (after the first) follows this workflow:

```
1. Make your changes locally
2. npm run build                             ← Always. Every deploy. No exceptions.
3. FTP: upload public/build/ to public_html/build/ (replace existing contents)
4. FTP: upload changed PHP/Blade/config files to ~/laravel/ (preserving directory structure)
5. If composer.json changed: run composer install --no-dev on server (via SSH or hPanel terminal)
6. Run: php artisan config:cache (if available via SSH/hPanel terminal)
7. Verify security checklist items 4, 5, 6 above
```

**What NOT to do:**
- Never run `npm run dev` and upload the dev server output — dev output is not the same as `npm run build`
- Never skip uploading `public/build/` — assets are not in git and will be stale if not re-uploaded
- Never run `npm run build` on the Hostinger server — Node.js is not available

---

## Troubleshooting

### Problem: Page loads with no CSS or JavaScript

**Cause:** `public/build/` was not uploaded, or build output is from `npm run dev` instead of `npm run build`.
**Fix:** Run `npm run build` locally, then FTP the entire `public/build/` directory to `public_html/build/`, replacing all existing files.

### Problem: `yourdomain.com/.env` returns file contents

**Cause:** Full Laravel project was uploaded into `public_html/` instead of only `public/` contents.
**Fix:** Remove all non-public files from `public_html/`. Upload only the contents of `laravel/public/` to `public_html/`. Apply the index.php path rewrite from Strategy A.

### Problem: Site shows Ignition error page (Laravel debug screen)

**Cause:** `APP_DEBUG=true` is set in the production `.env`.
**Fix:** Edit `~/laravel/.env` on the server. Set `APP_DEBUG=false`. Run `php artisan config:cache` if available.

### Problem: All assets 404 with URL `http://localhost/build/...`

**Cause:** `APP_URL=http://localhost` in production `.env` — Vite generates asset URLs based on this value.
**Fix:** Edit `~/laravel/.env` on the server. Set `APP_URL=https://yourdomain.com`. Run `php artisan config:cache`.

---

*Guide created: Phase 1 Foundation*
*Next update: Phase 4 Polish and Deploy — verify all checklist items against live domain*
