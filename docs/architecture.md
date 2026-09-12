# TransNgawi --- Architecture Specification

## 1. Tujuan

Dokumen ini menjelaskan bagaimana requirement PRD diterjemahkan menjadi
struktur teknis.

Prinsip: - simple; - maintainable; - testable; - secure; -
concurrency-safe; - tidak over-engineered.

Rekomendasi:

> Laravel Monolith + Relational Database + satu frontend strategy yang
> konsisten.

------------------------------------------------------------------------

# 2. Stack

Backend: - Laravel; - PHP; - MySQL/MariaDB.

Frontend dapat mempertahankan stack existing: - Blade + Alpine; -
Blade + Livewire; - Laravel + Vue; - Laravel + React.

**Jangan mengganti framework tanpa alasan teknis yang jelas.**

------------------------------------------------------------------------

# 3. Layer

``` text
Browser
↓
UI / Components
↓
Routes
↓
Controllers
↓
Requests / Policies
↓
Services
↓
Models / Domain Rules
↓
Database
```

Controller tidak boleh menjadi tempat business logic kompleks.

------------------------------------------------------------------------

# 4. Entity Map

``` text
User
AdminRole
Permission
Customer
Passenger

RouteCategory
Route
Class
Facility
ClassFacility

Bus
Seat
BusIssue
MaintenanceRecord

Trip
TripStop
TripFare
TripSeat

Booking
BookingPassenger
BookingSeat

Payment
PaymentVerification

SupportSession
SupportMessage

Notification
Feedback
TrackingPosition
ActivityLog
```

------------------------------------------------------------------------

# 5. RouteCategory

Fields:

``` text
id
code
name
description
active
timestamps
```

Seed: - ANTIBU; - SATSET; - BIASANE.

------------------------------------------------------------------------

# 6. Route

Fields:

``` text
id
route_category_id
origin
destination
description
estimated_duration
active
timestamps
```

Relationship:

``` text
RouteCategory
└── hasMany Route
```

Jangan menyimpan category sebagai free-text jika relational model
digunakan.

------------------------------------------------------------------------

# 7. Class

Fields:

``` text
id
code
name
description
active
timestamps
```

Class: - Sukian; - SukianPlus; - SukianPro.

Fasilitas dapat dipisahkan melalui Facility/ClassFacility.

------------------------------------------------------------------------

# 8. Bus

Fields:

``` text
id
fleet_code
model
manufacturer
capacity
operational_status
active
timestamps
```

Status: - Available; - Assigned; - On Trip; - Maintenance; - Out of
Service.

Bus Maintenance/Out of Service tidak boleh dipakai untuk trip baru.

------------------------------------------------------------------------

# 9. Seat

Seat adalah konfigurasi fisik bus.

Fields:

``` text
id
bus_id
seat_number
row
column
seat_type
active
timestamps
```

------------------------------------------------------------------------

# 10. Trip

Trip adalah perjalanan yang benar-benar dapat dipesan.

Fields:

``` text
id
route_id
bus_id
departure_at
arrival_at
estimated_arrival_at
status
published_at
cancellation_reason
timestamps
```

------------------------------------------------------------------------

# 11. TripFare

Jangan menaruh harga final sebagai satu harga global pada Class.

Fields:

``` text
id
trip_id
class_id
base_price
current_price
available
pricing_version
timestamps
```

Harga final ditentukan PricingService.

------------------------------------------------------------------------

# 12. TripSeat

TripSeat adalah inventory kursi untuk satu trip.

Fields:

``` text
id
trip_id
seat_id
status
held_until
booking_id
timestamps
```

Status: - Available; - Held; - Booked; - Blocked.

Gunakan constraint yang mencegah duplicate inventory.

------------------------------------------------------------------------

# 13. Booking

Fields:

``` text
id
booking_code
trip_id
customer_id nullable
status
subtotal
total
expires_at
timestamps
```

Lifecycle:

``` text
Draft
↓
Pending Payment
↓
Waiting Verification
↓
Confirmed
```

Alternative:

``` text
Pending Payment → Expired
Pending Payment → Cancelled
Waiting Verification → Rejected
Confirmed → Cancelled
Confirmed → Refunded
```

Status transition harus dikontrol backend.

------------------------------------------------------------------------

# 14. BookingPassenger

Satu booking dapat memiliki banyak passenger.

Fields minimal:

``` text
id
booking_id
passenger_id nullable
name
identity_reference sesuai kebutuhan
contact information sesuai kebutuhan
timestamps
```

Jangan meminta personal data yang tidak diperlukan.

------------------------------------------------------------------------

# 15. BookingSeat

Fields:

``` text
id
booking_id
trip_seat_id
passenger_id
price
timestamps
```

Seat harus berasal dari trip yang sama.

------------------------------------------------------------------------

# 16. Seat Concurrency

Seat booking adalah critical section.

Gunakan: - transaction; - row lock; - server-side check; - unique
constraint.

Konsep:

``` text
BEGIN TRANSACTION
↓
LOCK TripSeat
↓
Check availability
↓
Check hold expiration
↓
Hold/Book
↓
Create BookingSeat
↓
COMMIT
```

Frontend tidak authoritative.

------------------------------------------------------------------------

# 17. Services

Recommended:

``` text
BookingService
SeatInventoryService
PricingService
PaymentVerificationService
TicketService
SupportSessionService
TripStatusService
TrackingService
FleetIssueService
NotificationService
```

------------------------------------------------------------------------

# 18. BookingService

Tanggung jawab: - create booking; - validate trip; - validate seats; -
calculate authoritative total; - reserve seats; - manage lifecycle; -
expire booking.

Critical operations harus transaction-safe.

------------------------------------------------------------------------

# 19. SeatInventoryService

Tanggung jawab: - availability; - hold; - release; - book; - block.

Harus concurrency-safe.

------------------------------------------------------------------------

# 20. PricingService

Tanggung jawab: - calculate fare; - apply route/class rules; - demand; -
remaining seats; - date; - departure time; - pricing version.

Frontend tidak boleh menentukan harga final.

------------------------------------------------------------------------

# 21. Payment

Payment:

``` text
id
booking_id
method
amount
status
submitted_at
verified_at
verified_by
timestamps
```

PaymentVerification:

``` text
id
payment_id
admin_id
decision
note
created_at
```

Flow:

``` text
I Have Paid
↓
Waiting Verification
↓
Admin Review
├── Approve → Confirmed
└── Reject → Rejected
```

Tidak ada payment gateway MVP.

------------------------------------------------------------------------

# 22. PaymentVerificationService

Tanggung jawab: - authorize verifier; - validate payment; -
approve/reject; - update booking; - create audit log; - notify customer.

Approval tidak boleh berasal dari frontend.

------------------------------------------------------------------------

# 23. TicketService

Ticket hanya dibuat untuk booking Confirmed.

Data: - booking code; - passenger; - route; - schedule; -
service/class; - seat; - payment state; - QR/ticket identifier; -
boarding information.

------------------------------------------------------------------------

# 24. SupportSession

Fields:

``` text
id
customer_id nullable
guest_identifier nullable
booking_id nullable
topic
status
assigned_admin_id nullable
created_at
accepted_at
resolved_at
closed_at
```

Status: - WAITING; - ACTIVE; - RESOLVED; - CLOSED.

------------------------------------------------------------------------

# 25. SupportMessage

Fields:

``` text
id
support_session_id
sender_type
sender_id nullable
message
created_at
```

Rule: - WAITING = queue; - ACTIVE = sedang ditangani; - RESOLVED =
selesai; - CLOSED = ditutup.

------------------------------------------------------------------------

# 26. Notification

Fields:

``` text
id
recipient_id
type
title
payload
reference_type
reference_id
read_at
created_at
```

Events: - new Help; - payment verification; - trip delay; - fleet
issue; - maintenance; - booking exception.

Realtime boleh menggunakan broadcasting/WebSocket jika infrastructure
tersedia. Polling adalah fallback.

------------------------------------------------------------------------

# 27. Tracking

MVP menggunakan simulation.

TrackingPosition:

``` text
id
trip_id
latitude
longitude
recorded_at
source
is_simulated
```

Arsitektur masa depan:

``` text
GPS / Device / API
↓
TrackingService
↓
Application
↓
Customer UI
```

UI jangan terikat langsung pada provider GPS.

------------------------------------------------------------------------

# 28. Fleet Issue

BusIssue:

``` text
id
bus_id
reporter/customer reference
category
description
severity
status
manufacturer_reference
timestamps
```

Status:

``` text
Reported
↓
Verified
↓
Manufacturer Notified
↓
Under Repair
↓
Resolved
```

Tidak perlu manufacturer API pada MVP.

------------------------------------------------------------------------

# 29. MaintenanceRecord

Fields:

``` text
id
bus_id
type
description
scheduled_at
started_at
completed_at
status
notes
timestamps
```

Trip creation wajib memvalidasi operational status bus.

------------------------------------------------------------------------

# 30. Authorization

Roles: - Super Admin; - Operations; - Customer Support; - Finance.

Gunakan: - middleware; - policies; - gates/permissions.

Menyembunyikan tombol pada frontend bukan authorization.

------------------------------------------------------------------------

# 31. Controllers

Struktur:

``` text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Customer/
│   │   └── Admin/
│   ├── Requests/
│   └── Middleware/
├── Models/
├── Services/
├── Policies/
└── Notifications/
```

Controller: 1. authorize; 2. validate; 3. call service; 4. return
response/view.

------------------------------------------------------------------------

# 32. Frontend Components

Customer: - Navbar; - Footer; - BookingWidget; - Button; - Input; -
Select; - TripCard; - ClassCard; - RouteCard; - StatusBadge; - Seat; -
BookingSummary; - Notification; - LoadingState; - EmptyState; -
ErrorState.

Admin: - Sidebar; - Topbar; - KPICard; - DataTable; - FilterBar; -
ChatPanel; - NotificationPanel; - ConfirmationModal; - StatusBadge.

------------------------------------------------------------------------

# 33. Homepage Component Tree

``` text
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
```

Tidak ada homepage marketing component lain.

------------------------------------------------------------------------

# 34. Homepage Overlap Architecture

Jangan sekadar menambahkan negative margin.

Struktur konseptual:

``` text
Hero
↓
Overlap Layer
↓
BookingWidget
↓
Reserved Spacing
↓
ImportantTravelNotes
```

Reserved spacing harus menyesuaikan tinggi widget pada breakpoint
berbeda.

Z-index harus menggunakan stacking context yang jelas dan angka
terkontrol.

------------------------------------------------------------------------

# 35. Database Integrity

Wajib: - foreign keys; - unique constraints; - indexes; -
transactions; - timestamps; - explicit state rules.

Index penting: - booking_code; - trip route/date; - trip_seat
trip/status; - payment status; - support status; - notification
recipient/read.

------------------------------------------------------------------------

# 36. ActivityLog

Catat: - payment approve/reject; - refund; - trip cancellation; - fare
change; - bus assignment; - support accept/close; - fleet issue
update; - admin permission change.

Minimal: - actor; - action; - entity; - entity ID; - metadata; -
timestamp.

------------------------------------------------------------------------

# 37. Security

Wajib: - CSRF; - server-side validation; - authorization; - password
hashing; - rate limiting; - escaped output; - protected admin routes; -
secure sessions; - no secrets in Git; - safe errors.

Jangan expose: - SQL; - stack trace; - credentials; - API keys; -
internal paths.

------------------------------------------------------------------------

# 38. Architecture Boundary

Jangan implement real: - GPS; - manufacturer API; - payment gateway; -
external pricing API,

sebelum ada requirement eksplisit.

Buat service boundary agar integrasi masa depan mudah.
