---
name: transngawi-frontend
description: Implement TransNgawi frontend features in the existing Laravel application without breaking the established architecture.
---

# TransNgawi Frontend Skill

## Purpose

Use this skill for Laravel frontend implementation, including Blade, CSS, JavaScript, components, forms, responsive layouts, and customer flows.

## Required References

Read relevant sections of:
- `docs/FRONTEND.md`
- `docs/ARCHITECTURE.md`
- `docs/PRD.md`
- `docs/DESIGN-SYSTEM.md`

## Procedure

1. Inspect repository and existing frontend stack.
2. Inspect the relevant route/controller/view/component.
3. Identify existing CSS tokens/components.
4. Identify backend data supplied to the page.
5. Define the smallest implementation surface.
6. Implement.
7. Connect real application data where available.
8. Add states and validation feedback.
9. Build.
10. Test.
11. Render and inspect.
12. Fix issues.
13. Recheck.

## Laravel Boundary

Frontend may:
- display data;
- collect input;
- provide client-side convenience behavior.

Frontend must not become authoritative for:
- fare;
- inventory;
- booking state;
- payment state;
- authorization.

## Forms

Use:
- real labels;
- server validation;
- clear errors;
- loading state;
- keyboard accessibility.

Do not rely solely on JavaScript validation.

## Data

Never replace unavailable business data with fabricated values without explicitly treating them as prototype/seed data.

Do not hardcode live-looking prices or availability in production-facing views.

## CSS

Prefer:
- existing tokens;
- existing utility/component patterns;
- scoped styles where appropriate.

Avoid:
- duplicate token definitions;
- arbitrary one-off values;
- giant CSS rewrites for small tasks.

## JavaScript

Use JavaScript only where it adds necessary interaction.

Avoid adding client-side complexity for behavior the server already owns.

## Responsive

Implement intentional layout changes, not just width reductions.

Pay special attention to:
- forms;
- booking widget;
- navigation;
- trip cards;
- seat selection;
- CTA compositions.

## Cleanup

If a redesign removes a component:
- remove markup;
- remove associated styles;
- remove associated scripts;
- remove dead references where safe.

Do not leave hidden legacy UI as permanent clutter.
