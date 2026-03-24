# Pitfalls Research

**Domain:** Laravel Portfolio Site on Shared Hosting (Hostinger)
**Researched:** 2026-03-24
**Confidence:** HIGH (shared hosting + Laravel deployment) / MEDIUM (Vite/Tailwind v4 specifics)

---

## Critical Pitfalls

### Pitfall 1: Vite Manifest Not Found in Production

**What goes wrong:**
The application throws `Vite manifest not found at: public/build/manifest.json` and serves a blank/broken page after deployment. All CSS and JS are missing from production.

**Why it happens:**
`public/build/` is generated locally by `npm run build` but is not committed to version control (it is in `.gitignore` by default). Developers upload Laravel source files via FTP but forget to include the compiled `public/build/` folder entirely — or they build on the server but do not have Node.js available on shared hosting.

**How to avoid:**
Build assets locally before every deployment: run `npm run build`, then upload the entire `public/build/` directory to the server via FTP/SFTP. Because Hostinger shared hosting does not have Node.js available in all plans, treat asset compilation as a local step that is always part of the deploy checklist. Never rely on being able to run `npm` on the host.

**Warning signs:**
- Page loads but has no styling whatsoever
- Browser console shows 404 for `/build/app-[hash].css` and `/build/app-[hash].js`
- Server file manager shows `public/build/` is empty or absent

**Phase to address:** Infrastructure/Deployment phase (before any feature work goes live)

---

### Pitfall 2: Laravel Source Files Exposed Through Wrong Document Root

**What goes wrong:**
The entire Laravel project (including `.env`, `vendor/`, `config/`, `database/`) is accessible via the browser. Visiting `yourdomain.com/.env` returns the raw environment file with database credentials, APP_KEY, and SMTP passwords.

**Why it happens:**
On Hostinger shared hosting, the web root defaults to `public_html/`. Developers upload the full Laravel project into `public_html/` instead of setting document root to `public_html/laravel-app/public/`. This exposes everything outside `public/` to the internet.

**How to avoid:**
Use one of two approaches — pick one before starting deployment, do not change later:
1. **Recommended:** Upload the full project to a non-web-accessible folder (e.g., `~/laravel/`), then copy only the contents of `laravel/public/` into `public_html/`. Update `public_html/index.php` to point `__DIR__.'/../laravel'` for the app path.
2. **Alternative:** On Hostinger Business plan or above, configure the domain's document root to point directly at `laravel/public/` via hPanel's "Advanced" domain settings.

Never place `.env` or `vendor/` inside `public_html/` at the same level as `index.php`.

**Warning signs:**
- Visiting `yourdomain.com/vendor/` returns a directory listing or file contents
- Visiting `yourdomain.com/.env` returns readable text
- `yourdomain.com/composer.json` is accessible

**Phase to address:** Infrastructure/Deployment phase (must be resolved before any other feature deployment)

---

### Pitfall 3: APP_DEBUG=true Left Enabled in Production

**What goes wrong:**
Laravel shows full stack traces, file paths, environment variable values, and database query details to any visitor who triggers an error. A malformed contact form submission or a missing file can expose the entire server configuration.

**Why it happens:**
`.env` from local development is copied to the server without modification. `APP_DEBUG=true` and `APP_ENV=local` are often the defaults in the local `.env`.

**How to avoid:**
Production `.env` must have `APP_DEBUG=false` and `APP_ENV=production`. Keep a separate `.env.production` template that is never checked into version control but is documented in a secure note. After uploading `.env` to the server, verify `APP_DEBUG` is false before testing anything. Also set `APP_URL` to the actual domain — leaving it as `http://localhost` causes asset URL generation failures.

**Warning signs:**
- Any error page shows a full Ignition stack trace with file contents
- The `storage/logs/laravel.log` grows rapidly with verbose output
- Response headers include `X-Debug-Token` or similar Laravel debug identifiers

**Phase to address:** Infrastructure/Deployment phase (required before public launch)

---

### Pitfall 4: SMTP Mail Sending Blocks the Page Response (No Queue)

**What goes wrong:**
Submitting the contact form causes a 5-30 second spinner before the page responds. In the worst case, the SMTP connection times out and the user sees a 500 error — even though the form data was valid. The user assumes the form is broken and submits multiple times.

**Why it happens:**
Without a queue, `Mail::send()` is synchronous — the HTTP request waits for the entire SMTP handshake, authentication, and mail transfer to complete before returning a response. On shared hosting, SMTP latency is higher and connections are rate-limited. Hostinger's shared plans do not support queue workers (no persistent processes), so proper async queuing is not available.

**How to avoid:**
Since queues are not available on shared hosting, mitigate the UX impact by:
1. Using a transactional mail service (Mailtrap, Brevo/Sendinblue, Mailgun) over their SMTP API rather than direct SMTP to Gmail or Outlook — their servers respond faster and have higher deliverability.
2. Setting a reasonable SMTP timeout in `config/mail.php` (`stream` options: `timeout` 10 seconds) so failures fail fast rather than hanging.
3. On the frontend, immediately show a "Sending..." disabled state and display a success/error message via the redirect response — never leave the button clickable during submission.
4. Add a honeypot field to prevent spam submissions from consuming SMTP quota.

**Warning signs:**
- Contact form submission takes more than 3 seconds to redirect
- Multiple duplicate emails arriving (user submitted several times)
- SMTP connection timeout errors in `storage/logs/laravel.log`

**Phase to address:** Contact Form feature phase

---

### Pitfall 5: Dynamic Tailwind Classes Purged in Production Build

**What goes wrong:**
Skill badges, project category tags, or status indicators that use dynamically constructed class names (e.g., `'text-' + color + '-500'`) render without styles in production. Everything looks fine in development (`npm run dev`) but breaks after `npm run build`.

**Why it happens:**
Tailwind's JIT/purge engine performs static analysis of source files. It cannot evaluate JavaScript string concatenation at build time. Any class not found as a complete literal string in scanned files gets removed from the production CSS bundle. This is the single most common Tailwind production bug.

**How to avoid:**
Never construct Tailwind class names dynamically. Instead, use a lookup map with full class name strings:
```js
// WRONG
const cls = `bg-${color}-500`

// CORRECT
const colorMap = { blue: 'bg-blue-500', green: 'bg-green-500', red: 'bg-red-500' }
const cls = colorMap[color]
```
In `projects.json`, store full class names rather than color tokens. In Tailwind v4, use `@source inline()` in your CSS for any truly unavoidable dynamic cases. Review every use of template literals containing Tailwind class fragments before production build.

**Warning signs:**
- Skills carousel or project cards have no color/background in production but look correct in `npm run dev`
- Running `npm run build` produces a CSS file noticeably smaller than expected
- Inspecting elements in production shows classes are present in HTML but not in stylesheet

**Phase to address:** Frontend UI/Components phase (establish the pattern before building any dynamic components)

---

### Pitfall 6: php artisan Commands Cannot Run on Shared Hosting

**What goes wrong:**
After deploying, the developer needs to run `php artisan config:cache`, `php artisan storage:link`, or `php artisan migrate` (if ever needed) — but Hostinger's basic shared hosting does not provide SSH terminal access on entry-level plans.

**Why it happens:**
Laravel's artisan CLI requires terminal access. Developers assume they can SSH in, but Hostinger's Web Hosting plans (Starter/Premium) do not include SSH. Business plan and above includes SSH/terminal access via hPanel.

**How to avoid:**
Run all necessary artisan commands locally before deployment, then upload the generated cache files:
- Run `php artisan config:cache` → upload `bootstrap/cache/config.php`
- Run `php artisan route:cache` → upload `bootstrap/cache/routes-v7.php`
- Run `php artisan view:cache` → upload `storage/framework/views/`
- For `storage:link`: manually create the symlink via cPanel's File Manager, or use an HTTP route protected behind a secret token that calls `Artisan::call('storage:link')` and deletes itself after one use.

Avoid creating permanent artisan-calling web routes — they are a security risk. If the project grows, upgrade to a plan with SSH.

**Warning signs:**
- Attempting to SSH and getting "connection refused"
- `bootstrap/cache/config.php` is absent on the server after deployment
- Storage/public assets return 404 because the symlink was never created

**Phase to address:** Infrastructure/Deployment phase

---

### Pitfall 7: Contact Emails Land in Spam or Never Arrive

**What goes wrong:**
The contact form submits successfully (no errors in Laravel), but the email never arrives in the owner's inbox — or lands in spam. The portfolio owner assumes the form is working and misses client/recruiter messages.

**Why it happens:**
Three layered causes: (1) Using a generic MAIL_FROM_ADDRESS like `noreply@gmail.com` while sending through a different SMTP host breaks DMARC alignment. (2) Hostinger's shared IP ranges may be on spam blocklists. (3) Missing or misconfigured SPF/DKIM records for the sending domain cause spam filters to reject the message.

**How to avoid:**
- Use `MAIL_FROM_ADDRESS` matching the domain where SPF/DKIM records are configured (e.g., `contato@yourdomain.com`)
- Use a transactional mail service (Brevo free tier: 300/day, Mailgun, or Resend) instead of raw SMTP — they handle deliverability, provide SPF/DKIM automatically, and include a delivery dashboard
- Test with both Gmail and Outlook inboxes before launch — they use different spam scoring
- Add `MAIL_FROM_NAME` in `.env` — emails without a proper From Name score poorly with spam filters
- Verify SPF record in domain DNS: `v=spf1 include:transactional-provider.com ~all`

**Warning signs:**
- Test email sent during development arrives, but production emails do not
- Mail provider dashboard shows 0 delivered messages despite form submissions
- `storage/logs/laravel.log` shows no mail errors (Laravel thinks it succeeded)

**Phase to address:** Contact Form feature phase (set up mail service before writing any form code)

---

## Technical Debt Patterns

| Shortcut | Immediate Benefit | Long-term Cost | When Acceptable |
|----------|-------------------|----------------|-----------------|
| Commit `public/build/` to git | Simplifies deploy — just push and pull | Bloats git history with binary-like assets; conflicts on every rebuild | Acceptable for v1 solo project with no CI pipeline |
| Inline styles for one-off overrides | Faster than adding utility classes | Bypasses Tailwind; inconsistent with design system; hard to maintain | Never — use a Tailwind arbitrary value instead (`text-[#1a1a1a]`) |
| Keep `APP_DEBUG=true` in production temporarily | Easier to debug post-deploy issues | Exposes full stack trace, credentials, and file paths to any visitor | Never |
| Hardcode projects array in Blade instead of JSON | Skip JSON parsing logic | Projects become unmaintainable; defeats the JSON architecture decision | Never — JSON is already the stated architecture |
| Use `Mail::to()->send()` without error handling | Simpler code | Silent failures — user thinks form worked, email never sent | Never — always wrap in try/catch with user feedback |
| Skip `php artisan config:cache` locally before deploy | Saves one step | Stale config values in production; env changes not applied | Never — make it part of the deploy checklist |

---

## Integration Gotchas

| Integration | Common Mistake | Correct Approach |
|-------------|----------------|------------------|
| Hostinger SMTP (built-in) | Using Hostinger's own SMTP with Gmail-style `MAIL_FROM` | Use MAIL_FROM matching the Hostinger email account; set MAIL_ENCRYPTION=ssl and MAIL_PORT=465 |
| Brevo/Mailgun SMTP | Copying credentials from docs without setting MAIL_FROM_NAME | Always set both MAIL_FROM_ADDRESS and MAIL_FROM_NAME in .env |
| Swiper.js with Alpine.js | Initializing Swiper before Alpine has mounted the DOM | Initialize Swiper inside Alpine's `x-init` or in a `document.addEventListener('alpine:init')` callback |
| Vite + Laravel on shared host | Running `npm run dev` (dev server) on production | Always use `npm run build` for production; dev server requires a persistent Node process |
| `projects.json` file path | Using `public_path()` to read the JSON file | Use `base_path('resources/data/projects.json')` or `storage_path()` — never put data files in `public/` |

---

## Performance Traps

| Trap | Symptoms | Prevention | When It Breaks |
|------|----------|------------|----------------|
| Unoptimized hero image | High LCP score; slow first paint on mobile | Serve WebP, max 1200px wide, use `loading="eager"` + `fetchpriority="high"` on LCP image | Immediately on mobile 4G |
| All JS loaded blocking in `<head>` | Visible content delayed until JS parses | Use `@vite` directive which adds `type="module"` (deferred by default); avoid manual `<script>` in `<head>` | On any page load |
| Scroll animations firing on every scroll event | Janky, stuttering animations | Use IntersectionObserver instead of `addEventListener('scroll')` | On low-end mobile immediately |
| Missing `config:cache` and `route:cache` | Slightly slower response times on every request | Run and upload cache files as part of deploy | Not severe for a portfolio, but measurable |
| Swiper carousel loading all slide images eagerly | Unnecessary network requests on first load | Use `loading="lazy"` on non-visible slide images | On slow connections / mobile data |

---

## Security Mistakes

| Mistake | Risk | Prevention |
|---------|------|------------|
| `.env` accessible from browser | Exposes APP_KEY, SMTP password, any future DB credentials | Correct document root configuration (see Pitfall 2); add `deny from all` in `.htaccess` at project root |
| Contact form with no rate limiting | Spam flood consumes SMTP quota and fills owner's inbox | Add `throttle:3,1` middleware to the contact route (3 submissions per minute per IP) |
| Contact form with no CSRF protection | Cross-site request forgery can submit forms from external sites | Always include `@csrf` in the form — Laravel's VerifyCsrfToken middleware handles rejection automatically |
| XSS via unsanitized contact form input in emails | Malicious HTML/JS injected into email body | Use `strip_tags()` or Blade's `{{ }}` (auto-escaped) when rendering user input in emails |
| `storage/` directory browsable via URL | Log files, cached views, and uploaded files are publicly readable | Verify `storage/` is NOT inside the web root; if using storage:link, only `storage/app/public` should be linked |

---

## UX Pitfalls

| Pitfall | User Impact | Better Approach |
|---------|-------------|-----------------|
| Contact form gives no feedback during submission | User double-submits thinking the first click did nothing; 2+ duplicate emails received | Disable submit button immediately on click, show spinner, re-enable only on error |
| Contact form shows generic "Something went wrong" on validation failure | User does not know which field is wrong and gives up | Return `withErrors()` from the controller and display field-level errors next to each input |
| Animations run immediately on page load for all sections | Overwhelming; content below the fold animates before user scrolls to it | Trigger animations with IntersectionObserver only when element enters viewport |
| Skills carousel (Swiper) autoplays and cannot be paused | Accessibility violation; disorienting for users with vestibular disorders | Respect `prefers-reduced-motion` media query — disable autoplay and animations when it is set |
| No "back to top" feedback after smooth scroll | User scrolls fast on mobile and loses orientation | Back-to-top button should only appear after user has scrolled past the hero section (use IntersectionObserver) |
| Project cards show all detail on load | Information overload; no visual hierarchy | Use hover overlay (as in the reference design) — title/description on hover, thumbnail always visible |

---

## "Looks Done But Isn't" Checklist

- [ ] **Contact form:** Submitted with an invalid email address — does Laravel validation reject it and show a field-level error (not a 500)?
- [ ] **Contact form:** Opened the tab, waited 2+ hours, then submitted — does the 419 CSRF error show a helpful message rather than a blank error page?
- [ ] **Contact form:** Email actually arrived in the owner's inbox (not spam) from a real external test — not just Mailtrap
- [ ] **Vite assets:** After running `npm run build` and clearing browser cache, does the site render correctly with no console 404 errors?
- [ ] **Tailwind purge:** Opened `public/build/app-[hash].css` and confirmed that the classes used in dynamic components (skill badges, project tags) are present in the minified output
- [ ] **APP_DEBUG:** Triggering a deliberate 404 shows the production 404 page, not the Ignition stack trace
- [ ] **Document root:** Visiting `yourdomain.com/.env` returns 403 or 404, NOT file contents
- [ ] **Mobile layout:** Tested on a real device (not just browser DevTools) — especially nav, hero section text, and project card grid
- [ ] **Responsive images:** Hero image is not causing horizontal scroll on 375px viewport (check for `overflow-x`)
- [ ] **projects.json:** File path works in production (not just localhost) — `file_exists()` check passes

---

## Recovery Strategies

| Pitfall | Recovery Cost | Recovery Steps |
|---------|---------------|----------------|
| Vite manifest missing in production | LOW | Run `npm run build` locally, re-upload `public/build/` via FTP |
| `.env` exposed publicly | HIGH | Rotate APP_KEY (`php artisan key:generate`), change all SMTP passwords, fix document root immediately |
| APP_DEBUG=true in production | MEDIUM | Update `.env` on server to `APP_DEBUG=false`, run `php artisan config:cache` (or upload cached config) |
| Dynamic Tailwind classes purged | LOW-MEDIUM | Rewrite dynamic class construction to use full-string maps, rebuild, re-upload `public/build/` |
| Contact emails going to spam | MEDIUM | Switch to a transactional mail service, update DNS SPF/DKIM records (24-48h propagation), test again |
| CSRF 419 errors on contact form | LOW | Extend `SESSION_LIFETIME` in `.env`, or add graceful 419 handling in `app/Exceptions/Handler.php` |
| Wrong document root exposing source | HIGH | Restructure deployment immediately; treat all credentials as compromised and rotate them |

---

## Pitfall-to-Phase Mapping

| Pitfall | Prevention Phase | Verification |
|---------|------------------|--------------|
| Vite manifest missing in production | Infrastructure / Deployment setup | Upload to staging, confirm page renders with styles, no console 404s |
| Laravel source files exposed | Infrastructure / Deployment setup | Visit `yourdomain.com/.env` — must return 403/404 |
| APP_DEBUG=true in production | Infrastructure / Deployment setup | Trigger a deliberate error — must show custom error page, not stack trace |
| SMTP blocks page response | Contact Form phase | Time form submission — must return response in under 3 seconds |
| Dynamic Tailwind classes purged | Frontend UI/Components phase | Inspect production CSS file for presence of dynamic classes before merging |
| Artisan commands unavailable on host | Infrastructure / Deployment setup | Verify SSH access on chosen Hostinger plan; build deploy checklist before writing any code |
| Contact emails land in spam | Contact Form phase | Send test email from production to Gmail + Outlook inbox (not just Mailtrap) |
| CSRF token expiry on form | Contact Form phase | Leave form open for 3 hours, submit — must show friendly session-expired message |

---

## Sources

- [Laravel Production Deployment Checklist — PHP Dev Zone](https://www.php-dev-zone.com/laravel-production-deployment-checklist-and-common-mistakes-to-avoid)
- [Deploying Laravel to Shared Hosting (Hostinger) — DEV Community](https://dev.to/pushpak1300/deploying-laravel7-app-on-shared-hosting-hostinger-31cj)
- [Deploying Your Laravel Project on Shared Hosting Without Changing File Structure — Medium](https://medium.com/@hossamsoliuman/deploying-your-laravel-project-on-shared-hosting-hostinger-godaddy-without-changing-file-dd4fec07bd75)
- [Vite Manifest Not Found in Laravel — Laravel Daily](https://laraveldaily.com/post/laravel-vite-manifest-not-found-at-manifest-json)
- [4 Common Vite Errors in Laravel — Laravel News](https://laravel-news.com/laravel-vite-errors)
- [Troubleshooting Vite, Laravel, Tailwind in cPanel — Medium](https://medium.com/@Positive.Zahid/troubleshooting-vite-laravel-and-tailwind-css-deployment-in-cpanel-lessons-learned-500512ea14eb)
- [Preventing Laravel Emails from Going to Spam — LaravelSMTP](https://www.laravelsmtp.com/blog/preventing-laravel-emails-from-going-to-spam-folders)
- [Resolving Email Sending Problems in Laravel 11 — Medium](https://medium.com/@python-javascript-php-html-css/resolving-email-sending-problems-in-laravel-11-59bdfa9cdc28)
- [Understanding Tailwind CSS Safelist — Perficient](https://blogs.perficient.com/2025/08/19/understanding-tailwind-css-safelist-keep-your-dynamic-classes-safe/)
- [Safelist in Tailwind v4 — GitHub Discussion](https://github.com/tailwindlabs/tailwindcss/discussions/15291)
- [Laravel 419 CSRF Session Expired Fix — eSparkInfo](https://www.esparkinfo.com/qanda/laravel/laravel-post-request-error-419-session-page-has-expired)
- [Run Artisan Commands on Shared Hosting — Scratch Code](https://www.scratchcode.io/run-php-artisan-commands-on-shared-hosting-servers/)
- [Deploy Laravel 11 to Hostinger — DEV Community](https://dev.to/prakash_nayak/deploy-laravel-11-project-to-hostinger-business-plan-ea3)
- [Deploying Laravel on Shared Hosting Using Only .htaccess — GitHub Gist](https://gist.github.com/bladeSk/3666d04964e4de9c263776ba51f63a18)
- [Laravel Deployment Docs — Laravel 11.x Official](https://laravel.com/docs/11.x/deployment)

---

*Pitfalls research for: Laravel Portfolio Site on Shared Hosting (Hostinger)*
*Researched: 2026-03-24*
