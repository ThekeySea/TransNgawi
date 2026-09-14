---
name: transngawi-qa
description: Verify TransNgawi features through functional, visual, responsive, accessibility, and regression checks.
---

# TransNgawi QA Skill

## Purpose

Use this skill after implementing a meaningful feature or when reviewing an existing implementation.

## Required References

Read relevant sections of:
- `docs/QA.md`
- `docs/PRD.md`
- `docs/FRONTEND.md`
- `docs/DESIGN-SYSTEM.md`

## Procedure

1. Identify the affected feature.
2. Identify expected behavior from documentation.
3. Run targeted tests.
4. Run build when frontend assets changed.
5. Render the affected page/flow.
6. Check browser console.
7. Check network failures where relevant.
8. Check responsive behavior.
9. Check accessibility basics.
10. Check regression risk.
11. Fix issues that are within scope.
12. Re-run verification.

## Functional Checks

Verify:
- happy path;
- invalid input;
- empty state;
- error state;
- authorization;
- persistence;
- important state transitions.

## Booking Checks

For booking-related work verify:
- authoritative fare;
- authoritative availability;
- invalid seat rejected;
- booking persistence;
- concurrency-sensitive behavior;
- payment state.

## Visual Checks

Inspect:
- hierarchy;
- spacing;
- typography;
- alignment;
- imagery;
- contrast;
- interaction states;
- consistency with TransNgawi design system.

## Responsive Checks

At minimum:
- 375px;
- 390px;
- 414px;
- 768px;
- 1024px;
- desktop.

Look specifically for:
- horizontal overflow;
- clipped controls;
- overlapping content;
- unreadable text;
- broken navigation;
- incorrect image crop.

## Homepage Checks

Confirm:
- full-bleed hero;
- no internal hero search card;
- booking widget overlap;
- widget clickability;
- correct service types;
- correct fields;
- deliberate spacing after widget;
- four Important Information cards;
- About CTA composition;
- dark footer;
- no obsolete sections.

## Honesty Rule

Never report:
- "tests pass" unless tests ran;
- "build passes" unless build ran;
- "responsive verified" unless responsive behavior was actually inspected;
- "fixed" when the underlying issue remains.

## Final Report

Provide:
- checks performed;
- result;
- files changed if this was an implementation task;
- unresolved issues;
- areas not verified.
