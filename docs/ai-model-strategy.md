# TransNgawi AI Model Strategy

## 1. Purpose

This document defines how to choose among available OpenCode models by capability, not by hardcoded provider/model IDs.

Model availability may change. Do not treat a specific model ID as a permanent project requirement.

## 2. Capability Tiers

### Tier A — Lite / Fast

Use for:
- simple edits;
- formatting;
- small copy changes;
- obvious CSS adjustments;
- straightforward test updates;
- simple repository questions.

Avoid using this tier for architectural decisions or concurrency-sensitive database work.

### Tier B — General / Regular

Use for:
- normal feature implementation;
- Blade/UI work;
- CRUD;
- routine migrations;
- controllers;
- ordinary tests;
- moderate refactors.

This is the default tier for most tasks.

### Tier C — Strong Reasoning

Use for:
- architecture decisions;
- booking concurrency;
- seat inventory integrity;
- complex database relationships;
- authorization design;
- difficult debugging;
- cross-cutting refactors;
- ambiguous requirements that require careful repository reasoning.

### Tier D — Review / Verification

A fast or general model can be used for:
- test-result review;
- lint/build interpretation;
- consistency checks;
- documentation cleanup.

For difficult failures, escalate to stronger reasoning.

## 3. Model Independence

Do not encode exact model names into:
- PRD;
- architecture;
- design system;
- business rules.

The current custom pool may contain Gemini and Claude variants, but exact availability and naming can change.

Choose based on capability.

## 4. Task Routing

| Task | Suggested capability |
|---|---|
| Tiny text/CSS edit | Lite/Fast |
| Simple UI component | Fast/General |
| New customer page | General |
| Normal Laravel feature | General |
| Migration with simple relations | General |
| Complex booking flow | Strong Reasoning |
| Seat concurrency | Strong Reasoning |
| Architecture change | Strong Reasoning |
| Debugging unclear failure | Strong Reasoning |
| Final routine review | Fast/General |
| Security-sensitive review | Strong Reasoning |

## 5. Agent Behavior

The model is not a substitute for repository inspection.

Regardless of model:
- inspect before edit;
- use documentation;
- do not invent;
- verify;
- report honestly.

A stronger model is not permission to expand scope.

## 6. Context Management

For large tasks:
- read only relevant documentation;
- inspect relevant code;
- work incrementally;
- verify after each meaningful unit.

Do not overwhelm the model with every file in the repository when only one feature is relevant.

## 7. Escalation

Escalate when:
- tests fail for an unclear reason;
- multiple architectural choices are plausible;
- data integrity is at risk;
- concurrency is involved;
- existing code contradicts documentation;
- a change affects many domains.

## 8. Model Selection Principle

Choose the cheapest capability that can perform the task reliably.

Do not use a weak model for a high-risk task simply because it is available for free.

Do not use the strongest model for every trivial edit if a faster model is sufficient.

## 9. No Model-Specific Business Logic

Product behavior must never depend on which AI model performed the implementation.

Once committed, code must stand on its own.
