# TransNgawi Documentation

## Purpose

This directory is the persistent product and engineering knowledge base for the TransNgawi Laravel application.

OpenCode should use these documents as project context instead of requiring the complete specification to be pasted into every prompt.

## Documentation Map

| File | Purpose |
|---|---|
| `PRD.md` | Product scope, users, business rules, features |
| `ARCHITECTURE.md` | Laravel/domain/database architecture |
| `FRONTEND.md` | Frontend implementation architecture |
| `DESIGN-SYSTEM.md` | Visual design system |
| `PROJECT-RULES.md` | Cross-cutting constraints |
| `WORKFLOW.md` | Development process |
| `AI-MODEL-STRATEGY.md` | Model capability and task routing |
| `QA.md` | Testing and Definition of Done |

Agent instructions:
- `../AGENTS.md` is the operational entry point.
- `.opencode/skills/` contains reusable execution procedures.

## How to Use the Documentation

Do not read every document blindly for every task.

Read the documents relevant to the task.

Examples:

### Homepage UI

Read:
- PRD
- FRONTEND
- DESIGN-SYSTEM
- QA
- relevant UI skill

### Database feature

Read:
- PRD
- ARCHITECTURE
- PROJECT-RULES
- QA

### Booking

Read:
- PRD
- ARCHITECTURE
- FRONTEND
- QA

### Visual review

Read:
- DESIGN-SYSTEM
- FRONTEND
- QA
- transngawi-ui skill
- transngawi-qa skill

## Change Management

When requirements change, update the documentation before or together with the implementation when practical.

Do not leave contradictory old requirements in documentation.

When a requirement becomes obsolete:
1. remove or explicitly mark the old rule as obsolete;
2. update dependent documents;
3. update implementation;
4. verify the affected area.

## Prototype vs Real Data

Prototype/seed data must never be mistaken for production business data.

Use explicit names such as:
- demo
- seed
- sample
- prototype

when appropriate.

Never fabricate real schedules, prices, customer information, GPS positions, or operational integrations and present them as live.

## Prompting Principle

A user prompt should define the current task.

The documentation should define the persistent project context.

Good:

```text
Implement Search Results using the project documentation.
Inspect existing implementation first.
Scope only Search Results and required dependencies.
Verify tests/build and responsive behavior.
```

Bad:

```text
Paste the entire PRD and design system into every prompt.
```

## Development Ownership

OpenCode is the primary development agent for:
- frontend
- backend
- database
- testing
- integration

Do not maintain a separate frontend/backend ownership split unless explicitly requested.

## Recommended Development Order

1. Design foundation
2. Route/category/class/bus/trip foundation
3. Search
4. Search Results
5. Trip Detail
6. Seat Inventory
7. Booking
8. Passenger
9. Payment Verification
10. E-ticket
11. Help
12. Journey Status/Tracking
13. Fleet Issue
14. Reports/admin refinement

This order can be changed when a dependency or user request requires it, but avoid implementing downstream flows against undefined domain foundations.
