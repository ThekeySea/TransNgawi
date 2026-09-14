# TransNgawi Design System

## 1. Design North Star

> Bold enough to be remembered, restrained enough to be trusted.

Core principle:

> Bold Core, Quiet Structure.

TransNgawi should have a recognizable brand presence while maintaining calm information architecture.

## 2. Brand Character

| Attribute | Target |
|---|---|
| Energy | youthful, confident |
| Trust | professional, clear |
| Price perception | affordable comfort |
| Personality | friendly but not childish |
| Visual density | moderate |
| Decoration | purposeful |
| Luxury | restrained |
| Corporate stiffness | low |

## 3. Color

Orange is the primary brand/CTA color.

Use orange strategically for:
- primary actions;
- selected states;
- key brand moments;
- important accents.

Do not turn the entire interface orange.

Supporting colors should provide:
- neutral surfaces;
- strong text;
- muted text;
- borders;
- success;
- warning;
- error;
- information.

Use existing CSS tokens if they exist. Do not introduce arbitrary one-off colors.

## 4. Typography

Typography should prioritize:
1. readability;
2. hierarchy;
3. brand confidence.

Recommended hierarchy:
- large hero title;
- strong section title;
- readable card/title text;
- comfortable body text;
- compact functional labels.

Avoid excessively small body text.

Do not use an eyebrow/decorative micro-label above a page title unless explicitly required.

## 5. Spacing

Use a consistent spacing scale.

Suggested base scale:
`4, 8, 12, 16, 20, 24, 32, 40, 48, 64, 80, 96, 120`

Use the smallest spacing that preserves hierarchy and readability.

Avoid:
- random 13px/27px/43px spacing without a reason;
- huge empty regions;
- sections that visually collide.

## 6. Container

Recommended content width:
`1200–1280px`

Use consistent horizontal gutters.

On mobile, prioritize safe side padding and readable line length.

## 7. Radius

Use a restrained radius system.

Large radius:
- major cards;
- prominent booking widget;
- large CTA compositions.

Medium radius:
- normal cards;
- form controls where appropriate.

Small radius:
- badges;
- compact controls.

Do not use a different radius for every element.

## 8. Shadows and Borders

Prefer subtle depth.

Use:
- light borders;
- restrained shadows;
- clear surface separation.

Avoid:
- dramatic floating shadows everywhere;
- multiple competing shadows;
- glassmorphism as a default card treatment.

## 9. Buttons

Primary:
- orange brand color;
- strong readable text;
- clear hover/focus;
- adequate hit area.

Secondary:
- neutral or outlined treatment;
- visually subordinate to primary action.

Do not create multiple visually equal primary CTAs in one component unless there is a clear reason.

## 10. Forms

Inputs should:
- have visible labels;
- have clear states;
- maintain consistent height;
- provide useful focus;
- communicate errors.

Booking form should feel like a product tool, not a generic admin form.

## 11. Homepage

### Hero

The hero is a visual brand statement.

Requirements:
- full-bleed bus photo;
- text directly over image;
- strong contrast;
- one primary CTA;
- no internal card/search dashboard.

Hero should not look like a SaaS dashboard.

### Booking Widget

The booking widget is the main functional object.

It should visually overlap:
- Hero bottom;
- next section's upper area.

It should appear intentional, not accidentally floating.

Use a local stacking context and modest z-index.

Maintain clear breathing room after the widget.

### Important Information

Four cards:
- consistent height where practical;
- clear icons or visual markers if useful;
- concise text;
- no decorative overload.

### About CTA

One horizontal rectangular composition:
- image left;
- text/actions right;
- strong but restrained visual treatment.

Do not turn this into a full company-profile section.

## 12. Cards

Cards should exist to group information.

Every card needs:
- a reason to be a card;
- clear hierarchy;
- adequate padding;
- consistent radius/border/shadow treatment.

Avoid card grids where every small piece of text is trapped in a box.

## 13. Navigation

Navigation should prioritize:
- clear destinations;
- easy access to ticket search;
- predictable responsive behavior.

`Cari Tiket` is a prominent action.

Do not add decorative navigation elements that reduce scanability.

## 14. Footer

Footer is dark.

It should establish a visual end to the page without becoming an information dump.

## 15. Photography

Photography should emphasize:
- buses;
- travel;
- road/journey;
- comfort;
- real-world movement.

Avoid overly generic corporate stock imagery when a relevant travel image is available.

## 16. Motion

Use motion to support:
- hover;
- focus;
- state changes;
- page hierarchy.

Good:
- short button hover;
- subtle card elevation;
- controlled image movement.

Avoid:
- constant motion;
- flashy entrance animations;
- excessive parallax;
- animation that delays access to content.

## 17. Responsive Composition

Mobile is not a shrunken desktop.

For each major component decide:
- what remains;
- what stacks;
- what becomes full width;
- what becomes smaller;
- what can disappear only if nonessential.

Booking widget:
- desktop: horizontal when space permits;
- mobile: vertical.

About CTA:
- desktop: image left/content right;
- mobile: image top/content below.

## 18. Accessibility

Design must maintain:
- readable contrast;
- keyboard focus;
- visible states;
- usable touch targets;
- non-color-only state communication.

## 19. Anti-Patterns

Do not use:
- excessive glassmorphism;
- excessive neon;
- giant gradients as a substitute for design;
- random decorative blobs;
- excessive rounded containers;
- dashboard-style cards on the homepage;
- tiny typography;
- enormous unexplained whitespace;
- arbitrary animation;
- arbitrary z-index;
- inconsistent component styles.

## 20. Element Creation Protocol

Before creating any new UI element:

1. Identify its user purpose.
2. Check whether an existing component can be reused.
3. Check design tokens.
4. Define hierarchy.
5. Define responsive behavior.
6. Define states: default, hover, focus, disabled, loading, error if applicable.
7. Implement.
8. Compare against adjacent existing components.
9. Verify at mobile and desktop sizes.
10. Remove unnecessary decoration.

The goal is a coherent system, not isolated beautiful components.
