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
- Bus
- Seat
- BusIssue
- MaintenanceRecord

### Operations
- Trip
- TripStop
- TripFare
- TripSeat

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
- belongs to Route
- uses a Bus
- has one or more TripFares
- has TripSeats
- may have TripStops

TripFare:
- belongs to Trip
- identifies the applicable class and fare

TripSeat:
- belongs to Trip
- references a Seat
- carries availability state where required

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
3. verify current availability;
4. create/update booking records transactionally;
5. prevent ordinary double-booking races;
6. return an authoritative result.

Use appropriate database transactions and locking/unique constraints where needed.

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

Notification is created when a new customer session requires admin attention.

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

Complex operations such as booking creation may use dedicated service/action classes.

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

The architecture should evolve from actual requirements.

Do not prematurely introduce:
- microservices;
- event buses everywhere;
- queues for trivial tasks;
- external APIs;
- repositories for every model;
- complex state machines without need.

Complexity must have a concrete reason.
