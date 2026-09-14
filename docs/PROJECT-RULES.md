# TransNgawi Project Rules

## 1. General

This document contains cross-cutting rules that apply regardless of feature.

## 2. No Assumption

When a requirement is unknown, do not fill the gap with a plausible invention.

Inspect:
- code;
- migrations;
- models;
- routes;
- configuration;
- docs.

If still unknown, state the ambiguity.

## 3. Existing Code First

Prefer extending existing working patterns over creating parallel patterns.

Before creating:
- model;
- component;
- helper;
- service;
- CSS token;
- database table;

check whether an existing equivalent already exists.

## 4. Minimal Change

Change the smallest appropriate surface.

Avoid unrelated cleanup during feature implementation unless it is necessary to prevent a bug.

## 5. Dependencies

Do not install a package simply because it makes a task slightly easier.

Before adding a dependency:
- confirm it is necessary;
- check whether Laravel or existing project tooling already provides the capability;
- consider maintenance cost;
- verify compatibility.

## 6. Data Integrity

Never fabricate production-like data.

Seed/demo data must be explicitly distinguishable.

Never:
- delete user data casually;
- overwrite transaction history;
- reset the database as a convenience;
- change historical booking facts without a migration/data strategy.

## 7. Security

Never expose:
- API keys;
- passwords;
- tokens;
- database credentials;
- private customer information.

Do not place secrets in frontend code.

Validate and authorize server-side.

## 8. Business Rules

Business rules must live in an authoritative backend location.

Do not duplicate a critical business rule only in JavaScript.

Examples:
- fare;
- availability;
- booking validity;
- payment state;
- permissions.

## 9. UI Consistency

Follow `docs/DESIGN-SYSTEM.md`.

A new page should look like it belongs to TransNgawi.

Do not introduce a new visual language for one page.

## 10. Prototype Honesty

A prototype can simulate behavior, but the interface must not falsely imply a live integration.

Examples:
- simulated tracking must not look like verified live GPS;
- manual payment must not be labeled as gateway payment;
- sample manufacturer communication must not be presented as a real external API.

## 11. Homepage Constraint

The homepage is intentionally limited.

Do not add sections because:
- another bus site has them;
- an AI model thinks they are useful;
- they make the page feel "fuller".

Whitespace is acceptable when it supports hierarchy.

## 12. Accessibility

Accessibility is part of implementation, not an optional polish phase.

Minimum:
- semantic structure;
- keyboard access;
- visible focus;
- labels;
- contrast;
- meaningful link/button names;
- alt text where applicable.

## 13. Error Handling

Errors should be:
- understandable;
- actionable where possible;
- visible;
- consistent.

Do not swallow errors silently.

Do not expose sensitive stack traces to customers.

## 14. Naming

Use existing project conventions.

Prefer names that describe domain meaning:
- `Trip`
- `TripFare`
- `Booking`
- `SupportSession`

Avoid vague names:
- `DataManager`
- `ThingService`
- `TempController`

## 15. Documentation

When architecture or product behavior materially changes:
- update the relevant documentation;
- remove obsolete statements;
- keep examples aligned with current implementation.

## 16. Completion Honesty

Never say:
- "done";
- "fixed";
- "tested";

unless the relevant work/check was actually performed.

If verification could not be performed, say so explicitly.
