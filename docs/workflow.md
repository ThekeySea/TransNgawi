# TransNgawi Development Workflow

## 1. Objective

Use a controlled, incremental development process.

The goal is to reduce:
- hallucinated requirements;
- accidental scope expansion;
- inconsistent UI;
- broken dependencies;
- unverified claims.

## 2. Phase 0 — Understand

For every task:
1. read the user request;
2. identify exact scope;
3. identify unknowns;
4. identify relevant documentation;
5. inspect the repository.

Do not code yet.

## 3. Phase 1 — Plan

Produce a concise internal plan:
- files likely to change;
- data/model impact;
- UI impact;
- tests required;
- dependencies.

Avoid planning unrelated future features.

## 4. Phase 2 — Implement

Implement in small coherent units.

Prefer:
- existing conventions;
- reusable components;
- Laravel-native solutions;
- data-driven behavior.

Avoid:
- speculative abstractions;
- large unrelated refactors;
- temporary hacks that become permanent.

## 5. Phase 3 — Verify

For backend:
- targeted feature/unit tests;
- database assertions;
- authorization;
- validation.

For frontend:
- build;
- rendered-page inspection;
- responsive checks;
- console;
- interaction;
- overflow.

For database:
- migration behavior;
- constraints;
- relationships;
- preservation of existing data.

## 6. Phase 4 — Review

Ask:
- Did I implement exactly the requested scope?
- Did I invent anything?
- Did I break an existing pattern?
- Did I introduce unnecessary dependencies?
- Did I verify the result?
- Is the UI consistent?
- Are there dead styles/scripts?
- Are errors handled?

## 7. Phase 5 — Report

Report:
- summary;
- files changed;
- tests/build;
- verification;
- known limitations.

## 8. Feature Development Order

Recommended order:

### Foundation
- design tokens/components
- layout shell
- navigation/footer

### Domain
- route category
- route
- class
- facility
- bus
- seat
- trip
- fare
- trip seat inventory

### Customer booking
- search
- search results
- trip detail
- seat selection
- booking
- passenger
- payment verification
- e-ticket

### Support/operations
- help
- journey status
- tracking
- fleet issue
- reports

### Admin refinement
- dashboards
- filtering
- audit/activity
- permissions
- operational workflows

## 9. Task Granularity

Prefer tasks that produce one coherent feature.

Good:
`Implement Trip Search Results.`

Too broad:
`Build the entire customer booking platform.`

## 10. Prompt Pattern

Recommended prompt:

```text
Implement [specific feature].

Before coding:
- inspect the repository;
- inspect relevant existing implementation;
- read relevant project documentation.

Scope:
- [specific scope]

Do not:
- invent requirements;
- change unrelated areas;
- create speculative features.

After implementation:
- run relevant tests/build;
- verify the rendered/functional result;
- report files changed and verification.
```

## 11. When a Task Is Ambiguous

Do not invent.

Inspect first.

If the ambiguity affects correctness materially, report the exact missing decision.

If a safe, reversible implementation can proceed without inventing a business rule, proceed and document the assumption.

## 12. Visual Development Loop

For visual work:

`Inspect → Design → Implement → Build → Render → Compare → Fix → Render again`

Do not stop at "build passed".

## 13. Database Development Loop

For schema work:

`Inspect schema → Plan migration → Implement migration/model → Test migration → Test relationships → Test behavior`

Never use destructive reset as a shortcut.

## 14. Regression Discipline

After a change, check the nearest affected flows.

Examples:
- changing TripFare → test search/result price;
- changing TripSeat → test seat selection;
- changing Booking → test payment/ticket state;
- changing navbar → test all major customer pages.

## 15. Finish Criteria

A feature is complete only when:
- requirements are implemented;
- no known blocking issue remains;
- relevant verification passed;
- documentation is updated if behavior/architecture changed.
