---
phase: 03-contact-form-backend
plan: 02
subsystem: mail
tags: [laravel-mail, mailable, blade, brevo, smtp]

# Dependency graph
requires:
  - phase: 03-contact-form-backend-01
    provides: ContactController::store() that calls new ContactFormMail($validated)
provides:
  - ContactFormMail Mailable class with replyTo sender and [Portfólio] subject prefix
  - resources/views/mail/contact.blade.php email template with XSS-safe rendering
  - config/mail.php owner_address key reading MAIL_OWNER_ADDRESS env var
  - .env configured for log mailer (safe local dev)
  - .env.example documenting full Brevo SMTP setup for production
affects:
  - 03-contact-form-backend-03
  - 03-contact-form-backend-04
  - 04-deployment

# Tech tracking
tech-stack:
  added: []
  patterns:
    - Laravel Mailable with Envelope/Content/Address (modern API introduced in Laravel 9)
    - replyTo on Envelope for contact-form reply-to-sender UX pattern
    - log mailer for local development (no external SMTP dependency)

key-files:
  created:
    - app/Mail/ContactFormMail.php
    - resources/views/mail/contact.blade.php
  modified:
    - config/mail.php
    - .env
    - .env.example

key-decisions:
  - "Used log mailer in .env for local dev — no real SMTP credentials needed to test locally"
  - "replyTo on Envelope (not from) lets owner reply directly to sender from their email client"
  - "Subject prefixed with [Portfólio] to aid inbox filtering for owner"
  - "nl2br(e($message)) order is critical: escape first to prevent XSS, then convert newlines to <br>"
  - "Did NOT implement ShouldQueue — shared hosting has no worker daemon"

patterns-established:
  - "Contact email template: plain HTML with inline styles for email client compatibility"
  - "owner_address config key pattern: config('mail.owner_address') to fetch recipient in controller"

requirements-completed: [CONTACT-03]

# Metrics
duration: 1min
completed: 2026-03-25
---

# Phase 3 Plan 2: ContactFormMail Mailable and Mail Config Summary

**Laravel Mailable with replyTo-sender envelope, XSS-safe Blade template, and Brevo SMTP documentation in .env.example**

## Performance

- **Duration:** 1 min
- **Started:** 2026-03-25T01:12:26Z
- **Completed:** 2026-03-25T01:13:32Z
- **Tasks:** 2 completed
- **Files modified:** 5

## Accomplishments

- Created ContactFormMail Mailable with modern Laravel Envelope/Content/Address API — replyTo sender, [Portfólio] subject prefix, no ShouldQueue
- Created resources/views/mail/contact.blade.php with XSS-safe message rendering (e() then nl2br()) and all four form fields
- Added owner_address key to config/mail.php reading MAIL_OWNER_ADDRESS env var
- Updated .env to use log mailer for safe local testing (no real SMTP)
- Replaced placeholder mail section in .env.example with full documented Brevo SMTP production configuration

## Task Commits

Each task was committed atomically:

1. **Task 1: Create ContactFormMail Mailable and email template** - `342e6dc` (feat)
2. **Task 2: Configure mail — owner_address in config/mail.php and env variables** - `d687cbb` (chore)

**Plan metadata:** `6de5baa` (docs: complete plan)

## Files Created/Modified

- `app/Mail/ContactFormMail.php` - Mailable with envelope() (replyTo, subject prefix) and content() (mail.contact view)
- `resources/views/mail/contact.blade.php` - Email template rendering name, email, subject, message with XSS protection
- `config/mail.php` - Added owner_address config key reading MAIL_OWNER_ADDRESS
- `.env` - Updated to use log mailer with contato@localhost from address and MAIL_OWNER_ADDRESS
- `.env.example` - Replaced placeholder comment block with documented Brevo SMTP production setup

## Decisions Made

- Used `log` mailer in `.env` for local development — email output goes to `storage/logs/laravel.log`, no external SMTP dependency needed to develop or test
- Set `replyTo` on the Envelope (not `from`) so hitting "Reply" in the owner's mail client addresses the form sender directly — critical UX for a contact form
- Prefixed subject with `[Portfólio]` to aid inbox filtering
- Used `{!! nl2br(e($formData['message'])) !!}` — escape with `e()` first to prevent XSS, then `nl2br()` for readable line breaks; order is critical
- No `ShouldQueue` implementation — shared hosting has no worker daemon, synchronous SMTP is the right approach

## Deviations from Plan

None - plan executed exactly as written.

## Issues Encountered

None.

## User Setup Required

Before production deployment, the following environment variables must be set in the server `.env`:

- `MAIL_MAILER=smtp`
- `MAIL_HOST=smtp-relay.brevo.com`
- `MAIL_PORT=587`
- `MAIL_USERNAME=` (Brevo account login email)
- `MAIL_PASSWORD=` (Brevo SMTP API key — from Brevo dashboard, SMTP & API tab)
- `MAIL_ENCRYPTION=tls`
- `MAIL_FROM_ADDRESS=contato@yourdomain.com`
- `MAIL_FROM_NAME="${APP_NAME}"`
- `MAIL_OWNER_ADDRESS=` (owner's real inbox where contact form emails are delivered)

These are documented in `.env.example`.

## Next Phase Readiness

- ContactFormMail Mailable is ready — ContactController::store() can call `Mail::to(config('mail.owner_address'))->send(new ContactFormMail($validated))`
- config/mail.php owner_address key is available via `config('mail.owner_address')`
- Plan 03-03 (ContactController store() implementation) has all mail infrastructure in place

---
*Phase: 03-contact-form-backend*
*Completed: 2026-03-25*
