Markdown
# TransNgawi QA and Definition of Done

## 1. Purpose

QA verifies that implementation is:
- functionally correct;
- visually consistent;
- responsive;
- secure enough for its scope;
- free of obvious regressions.

## 2. Definition of Done

A task is Done when:
1. requested scope is implemented;
2. existing behavior is preserved unless intentionally changed;
3. relevant tests pass;
4. build passes when applicable;
5. UI has been visually inspected when UI changed;
6. responsive behavior has been checked;
7. no known blocking error remains;
8. documentation is updated when requirements/architecture changed.

## 3. Backend Checklist

Check:
- routes;
- validation;
- authorization;
- controller behavior;
- service/action behavior;
- database persistence;
- relationships;
- error states;
- transactions for critical operations;
- admin creation constraints (e.g., system rejects ANTIBU routes if cities are not capitals, rejects invalid bus class configurations).

## 4. Booking Checklist

Check:
- invalid trip rejected;
- invalid date rejected;
- passenger count validated;
- unavailable seat rejected;
- fare validated server-side;
- booking total cannot be trusted from client input;
- ordinary double-booking race is prevented;
- booking state transitions are valid;
- 15-minute seat hold timer expires correctly and releases seat to `AVAILABLE` if unpaid.

## 5. Payment Checklist

Check:
- no accidental gateway integration;
- manual/simulated state is clearly represented;
- verification is admin-authoritative;
- invalid transitions are rejected;
- customer cannot mark a payment approved by changing frontend state.

## 6. Support Checklist

Check:
- customer can create a session;
- admin sees pending session;
- admin can accept;
- messages belong to the correct session;
- closed session cannot be used as an active session unless explicitly reopened by defined rules.

## 7. Frontend Checklist

Check:
- typography hierarchy;
- spacing;
- alignment;
- buttons;
- forms;
- hover/focus;
- loading;
- empty;
- error;
- images;
- navigation;
- footer;
- seat map exact capacity (30 or 40 seats) and layout (2-2 or 1-1) renders correctly based on the backend bus model;
- 15-minute checkout countdown timer is clearly visible to the user during booking.

## 8. Homepage Checklist

Confirm:
- hero is full-bleed;
- hero has no internal search/dashboard card;
- exact current hero copy is used unless explicitly changed;
- booking widget overlaps Hero/next-section boundary;
- booking widget remains clickable;
- service type exists;
- required fields exist;
- breathing room after widget is intentional;
- four Important Information cards exist;
- About CTA is one horizontal composition on desktop;
- footer is dark;
- obsolete sections are absent;
- no decorative eyebrow above headings.

## 9. Responsive Checklist

Check at:
- 375px
- 390px
- 414px
- 768px
- 1024px
- 1280px
- 1440px

Check:
- no horizontal scrolling;
- no clipped content;
- no overlapping controls;
- usable tap targets;
- readable text;
- booking widget stacking;
- image cropping;
- navigation behavior.

## 10. Accessibility Checklist

Check:
- semantic HTML;
- keyboard navigation;
- visible focus;
- labels;
- contrast;
- alt text;
- non-color-only state indicators;
- logical heading structure.

## 11. Browser Verification

For visual tasks inspect:
- console;
- network failures;
- missing images/fonts;
- layout overflow;
- z-index/stacking;
- hover/focus;
- responsive states.

## 12. Commands

Use commands appropriate to the repository.

Typical Laravel checks:

```sh
php artisan test
Typical frontend build:

Bash
npm run build
```
Do not report a command as passed unless it was actually executed.

13. Database QA
For migrations:

inspect migration;

run migration in a safe environment;

verify schema;

verify relationships;

verify rollback where appropriate.

Do not destroy existing data just to make a migration pass.

14. Regression QA
After changes to shared components:

check all pages that use them.

After changes to booking:

check search → results → detail → seat → booking.

After changes to payment:

check booking → payment → verification → ticket.

15. Visual QA Standard
Ask:

Does this look like TransNgawi?

Is the hierarchy obvious?

Is there unnecessary decoration?

Is there excessive whitespace?

Is text too small?

Does the component look consistent with existing components?

Does mobile feel intentionally designed?

16. Reporting
Final QA report should state:

checks run;

pass/fail;

unresolved issues;

scope not tested;

relevant files changed.