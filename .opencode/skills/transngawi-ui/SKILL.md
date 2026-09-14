---
name: transngawi-ui
description: Create and refine TransNgawi customer-facing UI using the project's design system and visual verification process.
---

# TransNgawi UI Skill

## Purpose

Use this skill when creating or modifying customer-facing UI.

## Required References

Before implementation, read the relevant parts of:
- `docs/DESIGN-SYSTEM.md`
- `docs/FRONTEND.md`
- `docs/PRD.md`

Inspect existing UI components before creating new ones.

## Procedure

1. Identify the user's task and exact scope.
2. Inspect existing components and styles.
3. Identify reusable tokens/components.
4. Establish hierarchy before decoration.
5. Implement the simplest structure that satisfies the requirement.
6. Design desktop composition.
7. Adapt intentionally to mobile.
8. Implement interaction/state behavior.
9. Build.
10. Render/inspect the affected page.
11. Fix visual inconsistencies.
12. Verify again.

## Design Priorities

Prioritize, in order:
1. information hierarchy;
2. usability;
3. brand recognition;
4. consistency;
5. accessibility;
6. decoration.

## TransNgawi Character

Use:
- bold brand moments;
- restrained structure;
- confident typography;
- practical layouts;
- orange as a strategic brand/CTA accent;
- relevant travel photography.

Avoid:
- generic SaaS dashboard appearance;
- luxury styling;
- childish styling;
- visual noise.

## Component Reuse

Before creating a new:
- button;
- card;
- form control;
- badge;
- heading;
- navigation pattern;

inspect existing equivalents.

Reuse if appropriate.

## States

For interactive components, consider:
- default;
- hover;
- focus;
- active/selected;
- disabled;
- loading;
- error;
- empty where applicable.

Do not invent states that have no meaningful purpose.

## Responsive

Always consider:
- 375px;
- 390px;
- 414px;
- 768px;
- desktop.

Never assume a desktop layout can simply shrink.

## Homepage

When working on the homepage, obey the current homepage contract in:
`docs/PRD.md`.

Do not add old sections.

## Visual Review

After implementation:
- inspect spacing;
- inspect typography;
- inspect alignment;
- inspect image crop;
- inspect overlap;
- inspect z-index;
- inspect overflow;
- inspect mobile;
- inspect console.

Build passing is necessary but not sufficient.
