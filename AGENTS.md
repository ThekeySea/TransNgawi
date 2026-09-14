<laravel-boost-guidelines>

**# Laravel Application**

This repository contains a Laravel application. Complete the following setup before working on the user's request.

**## Prerequisites**

Verify that PHP and Composer are available:

```sh
php -v
composer -V
```

If either command is unavailable, detect the user's operating system and install the prerequisites with the appropriate command.

**## Agent Setup**

If Laravel Boost is not already installed, install it from the application root:

```sh
composer require laravel/boost --dev
php artisan boost:install
```

After Boost installation, read `AGENTS.md` again and continue with the user's original request using the generated Laravel guidelines.

</laravel-boost-guidelines>

# TransNgawi Project Instructions

## 1. Role

You are the primary development agent for TransNgawi.

You are responsible for the application as a whole, including:

- frontend
- backend
- database
- tests
- application integration

Do not split frontend and backend ownership unless the user explicitly asks for separate agents.

## 2. Source of Truth

Read the relevant documentation before implementing a task.

- `docs/README.md` — documentation map and authority hierarchy
- `docs/PRD.md` — product requirements and business rules
- `docs/ARCHITECTURE.md` — technical and domain architecture
- `docs/FRONTEND.md` — frontend implementation rules
- `docs/DESIGN-SYSTEM.md` — visual language and UI rules
- `docs/PROJECT-RULES.md` — project-wide constraints
- `docs/WORKFLOW.md` — development workflow
- `docs/AI-MODEL-STRATEGY.md` — model-selection guidance
- `docs/QA.md` — verification and Definition of Done

Skills live under `.opencode/skills/`. Use the relevant skill when its purpose matches the task.

Authority order:
1. Explicit user instruction in the current task.
2. Existing working code and database constraints when documenting actual current behavior.
3. `docs/PRD.md` for product/business requirements.
4. `docs/ARCHITECTURE.md` for technical structure.
5. `docs/FRONTEND.md` and `docs/DESIGN-SYSTEM.md` for UI implementation.
6. `docs/PROJECT-RULES.md` for cross-cutting constraints.
7. `docs/WORKFLOW.md` and `docs/QA.md` for process and verification.

If two sources conflict, do not silently choose. Inspect the repository and resolve or report the conflict.

## 3. Mandatory Inspect-Before-Edit

Before changing code:

1. Inspect the repository structure.
2. Inspect relevant routes, controllers, models, migrations, views, CSS, JavaScript, and tests.
3. Read the relevant documentation.
4. Identify existing patterns to reuse.
5. Identify the smallest set of files that need modification.
6. Implement only after the above inspection.

Never start by rewriting a large area without first understanding the existing implementation.

## 4. No-Invention Rule

Never invent:

- product requirements
- business rules
- routes
- schedules
- fares
- seat layouts
- passenger restrictions
- payment states
- API contracts
- credentials
- external integrations
- manufacturer integrations
- GPS positions
- customer records
- operational facts

If information is missing:
1. inspect the repository;
2. inspect the documentation;
3. inspect existing data/schema;
4. if still unknown, do not fabricate it.

Use explicit placeholders only when the task calls for prototype content, and clearly distinguish prototype seed data from real business data.

## 5. Scope Discipline

Implement only the requested scope and dependencies that are objectively necessary.

Do not:

- redesign unrelated pages;
- refactor unrelated code;
- replace Laravel architecture without justification;
- install unnecessary packages;
- create speculative features;
- add fake integrations that appear real;
- change unrelated migrations;
- hide obsolete UI when the requirement is to remove it;
- add sections simply because they are common on other websites.

If an adjacent issue blocks the requested task, fix the minimum necessary blocker and report it.

## 6. Backend Authority

Backend/database is authoritative for:

- route data
- trip data
- fares
- seat inventory
- booking state
- passenger data
- payment verification
- authentication
- authorization
- journey status

Frontend state is never authoritative for these values.

Client input must be validated server-side.

## 7. Payment Boundary

TransNgawi does not use a payment gateway unless explicitly requested later.

The current payment concept is manual/simulated payment with administrative verification.

Do not integrate Midtrans, Xendit, Stripe, or another gateway unless explicitly requested.

Do not claim that a simulated/manual payment flow is a live payment integration.

## 8. Current Homepage Contract

The homepage contains:

1. Hero
2. Quick Booking Widget
3. Hal Yang Perlu Diperhatikan
4. About CTA
5. Footer

The Quick Booking Widget is a functional overlapping element, not a marketing section.

Hero:
- full-bleed bus image;
- text directly over the image;
- no floating card/dashboard/search card inside the hero;
- no eyebrow/decorative micro-heading.

Hero copy:
- Heading: `Perjalanan Nyaman, Tanpa Bikin Kantong Berat.`
- Subheading: `Pesan tiket bus TransNgawi dengan mudah, pilih perjalanan yang sesuai kebutuhan, dan nikmati perjalanan antarkota dengan kenyamanan yang lebih masuk akal.`
- CTA: `Cari Tiket`

Quick Booking:
- title: `Pesan Tiket Cepat`
- service type: ANTIBU, SATSET, BIASANE
- fields: Dari, Ke, Tanggal Berangkat, Penumpang
- action: Cari Perjalanan
- desktop: horizontal composition where appropriate
- mobile: vertical composition
- overlaps Hero and the next section
- must have deliberate breathing room before the next section
- must not use absurd z-index values

Important information section:
- heading: `Hal Yang Perlu Diperhatikan`
- cards: Tiket & Identitas; Waktu Keberangkatan; Bagasi & Barang Bawaan; Informasi Perjalanan

About CTA:
- heading: `Kenal Lebih Dekat dengan TransNgawi`
- description: `TransNgawi hadir untuk menghadirkan perjalanan antarkota yang nyaman, mudah dipesan, dan tetap masuk akal untuk kebutuhan perjalanan sehari-hari.`
- CTA: `Tentang TransNgawi`
- desktop: image left, content right
- mobile: image above content

Do not reintroduce removed homepage sections unless explicitly requested.

## 9. Brand/UI Contract

TransNgawi follows:

> Bold enough to be remembered, restrained enough to be trusted.

Core principle:

> Bold Core, Quiet Structure.

The interface should feel:
- youthful
- confident
- professional
- approachable
- affordable-comfort oriented
- brand-forward

Do not make it:
- luxury-heavy
- stiff corporate
- visually noisy
- neon-heavy
- glassmorphism-heavy
- gradient-dependent
- decoration-driven

`docs/DESIGN-SYSTEM.md` is authoritative for detailed UI rules.

No small eyebrow text above page titles unless it is explicitly required as a functional label.

## 10. Database Safety

Before schema changes:
- inspect existing migrations;
- inspect models and relationships;
- inspect relevant database state;
- preserve existing data unless destructive behavior is explicitly requested.

Never use destructive reset/fresh/wipe commands as a shortcut for ordinary feature work.

Do not delete production-like data to make a migration pass.

## 11. Verification

A task is not complete because code was written.

For relevant changes:
- run targeted tests;
- run `php artisan test` when appropriate;
- run `npm run build` for frontend/build changes;
- inspect rendered UI for visual changes;
- check console errors;
- check responsive layouts;
- check horizontal overflow;
- check forms, buttons, links, and navigation;
- verify database/migration behavior for schema changes.

Do not claim a check passed unless it was actually run.

## 12. Reporting

End substantial tasks with:
- Summary
- Files changed
- Tests/build run
- Verification result
- Known limitations
- Any decision or ambiguity that remains

Do not claim completion when a known blocking issue remains.

## 13. Skills

Use:
- `.opencode/skills/transngawi-ui/SKILL.md` for customer-facing visual/UI work.
- `.opencode/skills/transngawi-frontend/SKILL.md` for Laravel frontend implementation.
- `.opencode/skills/transngawi-qa/SKILL.md` for verification/review work.

Skills are reusable procedures. They do not replace the project documentation.
