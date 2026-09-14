# TransNgawi Frontend Implementation Guide

## 1. Purpose

This document defines how OpenCode should implement the customer-facing frontend inside the existing Laravel application.

The frontend must feel like one coherent product, not a collection of individually generated pages.

## 2. Technology Rule

Inspect the repository first.

Use the frontend stack already present in the Laravel project unless the user explicitly requests a change.

Do not install a new CSS framework, component library, animation library, icon library, or build system merely for convenience.

## 3. Component Strategy

Prefer reusable components for repeated patterns:
- buttons;
- inputs;
- badges;
- cards;
- navigation;
- footer;
- booking controls;
- trip cards;
- class cards;
- notices;
- status indicators.

Do not abstract a component merely because two elements look vaguely similar. Reuse should reduce inconsistency without making simple markup difficult to understand.

## 4. Data Flow

Server-provided data is authoritative.

Do not hardcode:
- live fares;
- seat availability;
- booking totals;
- journey state.

Client-side state may improve interaction but must be reconciled with backend state.

## 5. Forms

Every important form should have:
- clear labels;
- useful input types;
- sensible defaults only when justified;
- validation feedback;
- disabled/loading state where necessary;
- keyboard accessibility;
- clear submission feedback.

Do not use placeholder text as the only label.

## 6. Search

Search fields:
- service type;
- origin;
- destination;
- departure date;
- passenger count.

Search should prevent obviously invalid combinations where practical, but the backend remains authoritative.

## 7. Search Results

Results should allow customers to understand:
- route;
- departure/arrival information when available;
- class;
- fare;
- availability/status;
- relevant facilities.

Do not create comparison clutter.

The result hierarchy should make the most important decision information easy to scan.

## 8. Trip Detail

Trip Detail should consolidate:
- journey information;
- class;
- included facilities;
- fare;
- seat-selection entry point;
- relevant notes.

Do not repeat the same information excessively.

## 9. Seat Selection

Seat UI must visually communicate:
- available;
- selected;
- unavailable;
- any special/reserved state that is actually configured.

Color cannot be the only state indicator.

The final availability is always validated by the backend.

## 10. Homepage Implementation

Hero:
- full-bleed;
- strong image;
- text overlay;
- readable contrast;
- no internal booking card.

Booking widget:
- overlaps the Hero/next-section boundary;
- highest local stacking layer;
- controlled z-index;
- responsive transformation.

Important notes:
- four useful cards;
- concise content;
- consistent card rhythm.

About CTA:
- one horizontal card;
- image left on desktop;
- content right;
- stacked on mobile.

Footer:
- dark;
- consistent across pages.

## 11. Responsive Targets

Test at least:
- 375px
- 390px
- 414px
- 768px
- 1024px
- 1280px
- 1440px

Do not optimize for only one desktop and one mobile size.

## 12. Layout Rules

Use a coherent container system.

Recommended maximum content width:
- approximately 1200–1280px unless an existing project token defines another value.

Avoid:
- unexplained huge whitespace;
- cramped text;
- accidental overflow;
- arbitrary negative margins;
- excessive absolute positioning.

Absolute positioning is acceptable for deliberate compositions, not as a substitute for layout architecture.

## 13. Layering

For overlapping elements:
- establish an intentional stacking context;
- use modest, understandable z-index values;
- ensure the widget remains clickable;
- ensure no unrelated element unexpectedly covers it.

Do not solve every layering problem with `z-index: 99999`.

## 14. Typography

Typography must have clear hierarchy:
- page title;
- section title;
- body;
- supporting text;
- functional labels.

Do not make body text tiny merely to fit a design.

No decorative eyebrow text above headings unless explicitly required.

## 15. Motion

Motion should:
- communicate state;
- guide attention;
- reinforce hierarchy;
- remain quick and restrained.

Avoid:
- animation on every element;
- long transitions;
- distracting parallax;
- effects that reduce readability.

Respect reduced-motion preferences where applicable.

## 16. Images

Use relevant bus/travel photography.

Image treatment should support the content:
- correct aspect ratio;
- predictable cropping;
- appropriate object positioning;
- adequate contrast for text overlays.

Do not use random images simply to fill space.

Do not claim a stock/placeholder image represents an actual TransNgawi fleet vehicle unless it is actually supplied as such.

## 17. Accessibility

Minimum requirements:
- semantic HTML;
- visible focus states;
- keyboard access;
- sufficient contrast;
- labels for controls;
- meaningful link/button text;
- alt text for meaningful images;
- decorative images appropriately treated as decorative.

## 18. Loading / Empty / Error

Design states deliberately.

Do not leave:
- blank screens;
- broken image boxes;
- invisible errors;
- buttons that appear clickable while permanently disabled.

Search results should have sensible empty and error states.

## 19. UI Verification Loop

For visual changes:

1. implement;
2. build;
3. open/render the relevant page;
4. inspect layout;
5. inspect mobile;
6. inspect desktop;
7. inspect console;
8. fix issues;
9. verify again.

Code validity is not visual validity.

## 20. Existing UI Preservation

When modifying one page:
- preserve shared navbar/footer behavior unless the task changes them;
- preserve existing tokens/components;
- do not duplicate CSS rules unnecessarily;
- do not replace working components without a reason.

## 21. Cleanup

When an old component is explicitly obsolete:
- remove references;
- remove unused styles;
- remove unused scripts;
- remove dead assets when safe.

Do not leave large amounts of dead code after a redesign.
