# TransNgawi Architecture

## 1. Architecture Style

Use a Laravel monolith unless the repository or explicit requirements justify another architecture.

Prefer Laravel-native mechanisms:
- routes
- controllers
- form requests
- policies
- Eloquent models
- migrations
- services/actions where complexity justifies them
- Blade/components for server-rendered UI where appropriate
- existing frontend tooling already present in the repository

Do not introduce a second application framework without a clear requirement.

## 2. Domain Model

Conceptual entities:

### Identity / Authorization
- User
- AdminRole
- Permission

### Customer / Passenger
- Customer
- Passenger

### Catalog
- RouteCategory
- Route
- Class
- Facility
- ClassFacility

### Fleet
- Bus (includes `model_type` for BIASANE or ANTIBU_SATSET, and `status` for IDLE, ACTIVE, MAINTENANCE)
- Seat (utilizing predefined templates mapping to 40 or 30 total seats based on model)
- BusIssue
- MaintenanceRecord

### Operations
- Location (includes boolean flags for `is_capital` and `is_important` to enforce routing rules)
- Trip
- TripStop
- TripFare
- TripSeat (inventory statuses: `AVAILABLE`, `HELD`, `SOLD`, `BLOCKED`)

### Commerce
- Booking
- BookingPassenger
- BookingSeat
- Payment
- PaymentVerification

### Support
- SupportSession
- SupportMessage
- Notification

### Tracking / Feedback
- TrackingPosition
- Feedback

### Audit
- ActivityLog

These are architectural targets. Inspect the existing project before creating or renaming tables/models.

## 3. Relationship Concepts

RouteCategory:
- has many Routes

Route:
- belongs to RouteCategory
- has many Trips

Class:
- has many configured facilities through ClassFacility
- can be assigned to trips where business rules permit

Bus:
- has many Seats
- participates in Trips
- can have BusIssues and MaintenanceRecords

Trip:
- 1 Trip = 1 Bus + 1 Origin Location + 1 Destination Location
- belongs to Route
- uses a Bus
- has one or more TripFares
- has TripSeats
- may have TripStops (used exclusively for rest stops, not for passenger boarding/alighting)

TripFare:
- belongs to Trip
- identifies the applicable class and fare

TripSeat:
- belongs to Trip
- references a Seat
- carries availability state (`AVAILABLE`, `HELD`, `SOLD`, `BLOCKED`) where required

Booking:
- belongs to a customer/user context as appropriate
- has passengers
- has selected seats
- has payment state
- has a booking status

Payment:
- belongs to Booking
- may have PaymentVerification records

SupportSession:
- belongs to a customer context
- has SupportMessages
- has lifecycle status

BusIssue:
- references a Bus and optionally a Seat/Trip context
- can have maintenance resolution records

## 4. Database Principles

Use relational integrity:
- foreign keys;
- unique constraints where business rules require uniqueness;
- indexes for frequent lookup paths;
- nullable fields only when absence has a defined meaning.

Avoid storing duplicated business facts when they can be derived safely.

However, preserve historical transaction facts where necessary. For example, a booking should retain the fare/seat information required to reproduce the customer's purchased ticket even if catalog data changes later.

## 5. Booking Integrity

Seat availability is not controlled by the frontend.

The backend must:
1. validate the trip;
2. validate the requested seats;
3. verify current availability (`AVAILABLE` state);
4. update state to `HELD` and start a 15-minute expiration timer;
5. create/update booking records transactionally;
6. prevent ordinary double-booking races using database locks/constraints;
7. return an authoritative result;
8. revert `HELD` seats to `AVAILABLE` if the 15-minute timer expires without payment confirmation.

Do not rely on JavaScript-only checks.

## 6. Pricing Integrity

Trip pricing is backend data.

Frontend:
- requests/displays;
- does not calculate authoritative totals.

Backend:
- determines applicable fare;
- validates totals;
- persists transaction facts.

## 7. Payment Integrity

Payment gateway is out of current scope.

Payment verification should be represented as application state.

Suggested lifecycle:
- pending
- submitted
- approved
- rejected
- expired
- cancelled

Use only states actually required by the implementation.

## 8. Support Architecture

Support session lifecycle:
- pending
- active
- closed

Notification is created when a new customer session requires admin attention (to be displayed as a notification badge on the admin dashboard).

Messages should belong to a session and have clear sender identity/type.

## 9. Tracking Architecture

TrackingPosition is optional/future-facing.

If implemented without an external GPS provider, the application must not imply that sample coordinates are live.

Prefer explicit source/status fields when a prototype needs to distinguish:
- live;
- simulated;
- manually updated.

## 10. Fleet Issue Architecture

BusIssue should support:
- issue category;
- description;
- severity;
- bus;
- optional seat;
- optional trip;
- lifecycle status;
- timestamps.

MaintenanceRecord can store:
- action;
- diagnosis;
- resolution;
- responsible party;
- status;
- timestamps.

Manufacturer integration remains an abstraction boundary, not a fake API.

## 11. Controllers / Services

Controllers should remain thin.

Typical responsibilities:
- receive validated input;
- authorize;
- call domain/application logic;
- return response.

Complex operations such as booking creation (handling the 15-minute hold logic) or the admin trip creation wizard may use dedicated service/action classes.

Do not create service classes solely to wrap trivial Eloquent calls.

## 12. Authorization

Use Laravel's authorization mechanisms:
- policies;
- gates;
- middleware;
- role/permission checks where required.

Do not rely on hidden UI buttons for security.

## 13. Frontend / Backend Boundary

Frontend handles:
- presentation;
- interaction;
- client-side convenience validation;
- loading/error states.

Backend handles:
- validation;
- authorization;
- business rules;
- authoritative pricing;
- inventory;
- booking;
- payment state.

## 14. Homepage Component Tree

Conceptually:

Home
├── Navbar
├── Hero
│   ├── BackgroundImage
│   └── HeroContent
├── BookingWidget
│   ├── ServiceType
│   ├── Origin
│   ├── Destination
│   ├── DepartureDate
│   ├── PassengerCount
│   └── SearchButton
├── ImportantTravelNotes
│   ├── TicketIdentity
│   ├── DepartureTime
│   ├── Baggage
│   └── TravelInformation
├── AboutCTA
│   ├── BusImage
│   └── Content
└── Footer

The widget must visually overlap the Hero/next-section boundary.

## 15. Security

Apply:
- server-side validation;
- CSRF protection;
- authorization;
- mass-assignment protection;
- output escaping;
- secure authentication practices;
- rate limiting where appropriate;
- safe file upload handling if uploads are later added.

Never expose secrets in code, views, JavaScript, or documentation.

## 16. Testing Architecture

Prefer:
- feature tests for user-visible flows;
- unit tests for isolated domain logic;
- database assertions for persistence;
- authorization tests for protected operations.

Critical areas:
- search;
- fare calculation/selection;
- seat availability;
- booking creation;
- double-booking prevention;
- payment verification;
- support lifecycle;
- authorization.

## 17. Migration Safety

Never use `migrate:fresh` or destructive resets as routine development shortcuts.

Before migration changes:
- inspect current migrations;
- inspect current schema;
- preserve data;
- run targeted migration verification.

## 18. Architecture Evolution

TransNgawi's architecture should evolve from actual requirements.

Do not prematurely introduce:
- microservices;
- event buses everywhere;
- queues for trivial tasks;
- external APIs;
- repositories for every model;
- complex state machines without need.

Complexity must have a concrete reason.

## 19. Admin Trip Wizard (implemented)

Admin trip creation (`/admin/trips/create`, 4 steps) is the single backend
enforcer for catalog rules from PROJECT-RULES §8:

- Step 1 (service) → Step 2 (route) → Step 3 (date/bus) → Step 4 (pricing).
- Wizard state lives in session; each step is backend-validated and steps
  cannot be skipped. Final creation re-validates everything inside a
  transaction (`App\Services\TripCreationService`).
- Location rules: ANTIBU requires both endpoint `is_capital`; SATSET requires
  both endpoint `is_important`; BIASANE unrestricted. `Route::forService()`
  applies the same filter for dropdown convenience, but the service is
  authoritative on submit.
- Seat templates (`App\Support\BusSeatTemplate`, v1):
  - BIASANE: 40 seats (rows A–J × cols 1–4; A–B SukianPlus, C–J Sukian).
  - ANTIBU_SATSET: 30 seats (rows A–J × cols 1–3; A–C SukianPro,
    D–F SukianPlus, G–J Sukian).
- Pricing step must supply fares for exactly the template's class set, so
  SukianPro can never be sold on a BIASANE bus and every generated seat has
  a matching fare. Fares are integers (IDR), min Rp1.000.

Open ambiguity (not decided): `buses.status` vocabulary differs between this
document (IDLE/ACTIVE/MAINTENANCE) and AGENTS.md §26 (Available/Assigned/
On Trip/Maintenance/Out of Service). The column is a free string until the
business picks one closed set.