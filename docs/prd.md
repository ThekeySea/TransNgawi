# TransNgawi Product Requirements Document

## 1. Product Overview

TransNgawi is a modern intercity bus ticketing platform and bus company website.

The product priority is ticket booking. Company-profile content supports trust and brand understanding but must not overpower the booking experience.

The name "TransNgawi" is a brand name. It does not mean the company is limited to Ngawi or that Ngawi is the network center.

## 2. Positioning

Core positioning:

> Comfortable intercity travel without making the customer pay a luxury price.

Brand principle:

> Bold enough to be remembered, restrained enough to be trusted.

TransNgawi should communicate:
- affordable comfort
- convenience
- confidence
- modernity
- practical travel
- trustworthy operations

It should not communicate:
- ultra-cheap travel at the expense of quality
- luxury-only travel
- stiff corporate transportation

## 3. Primary Audience

Primary audience:
- young adults approximately 20–30;
- budget-conscious travelers;
- customers who care about comfort and convenience;
- customers traveling between cities for routine, education, work, family, or personal reasons.

The product should remain usable for broader audiences.

## 4. Core Customer Job

A customer should be able to:

1. enter the website;
2. choose a service type;
3. choose origin and destination;
4. choose departure date;
5. choose passenger count;
6. see available trips;
7. compare price/class/time;
8. select a trip and seat;
9. provide passenger information;
10. choose the available payment method;
11. complete manual/simulated payment instructions;
12. receive a booking/e-ticket state;
13. track or check journey status when that capability is available;
14. contact support.

## 5. Service Categories

### ANTIBU — Antar Ibu Kota

Purpose:
Inter-province/capital-oriented long-distance routes.

Current example routes:
- Surabaya–Semarang
- Surabaya–Yogyakarta
- Surabaya–Bandung
- Surabaya–Serang
- Surabaya–Jakarta

These are product examples, not permission to invent additional routes.

### SATSET — Perjalanan Antar Tempat Penting

Purpose:
Connect important destinations where utility matters more than city-center branding.

Current examples:
- Surabaya–Cilegon / Pelabuhan Merak
- Yogyakarta–Jakarta / Bandara Soekarno-Hatta

### BIASANE — Perjalanan Reguler

Purpose:
Regular intercity travel to medium/large destinations within or outside the province.

Specific routes must come from configured business data, not invented UI copy.

## 6. Travel Classes

### Sukian

Entry-level class.

Included:
- free snack
- bottled water

Positioning:
Affordable entry point.

### SukianPlus

Best-value / likely high-demand class.

Included:
- more spacious seats
- massage feature
- free snack
- bottled water
- souvenir keychain

Positioning:
Strong value proposition between basic and premium.

### SukianPro

Premium long-distance sleeper class.

Included:
- compact sleeping cabin
- personal TV per seat

Positioning:
Premium comfort without changing the overall affordable-comfort brand.

Do not claim any class is objectively "cheapest" or "best" unless supported by configured product data.

## 7. Homepage Requirements

Homepage has three marketing/content sections plus one functional overlapping booking element and a footer.

### Section 1 — Hero

Requirements:
- full-bleed bus photography;
- heading and subheading directly over image;
- one primary CTA;
- strong visual hierarchy;
- readable contrast;
- no card/dashboard/search card inside hero;
- no eyebrow above the heading.

Copy:

Heading:
`Perjalanan Nyaman, Tanpa Bikin Kantong Berat.`

Subheading:
`Pesan tiket bus TransNgawi dengan mudah, pilih perjalanan yang sesuai kebutuhan, dan nikmati perjalanan antarkota dengan kenyamanan yang lebih masuk akal.`

CTA:
`Cari Tiket`

### Quick Booking Widget

This is a functional overlap element, not a marketing section.

Title:
`Pesan Tiket Cepat`

Required inputs:
- service type
- origin
- destination
- departure date
- passenger count

Service type choices:
- ANTIBU
- SATSET
- BIASANE

Action:
`Cari Perjalanan`

Desktop may use a horizontal layout.

Mobile should become a clear vertical flow.

The widget overlaps the bottom of the Hero and the beginning area of the next section.

There must be deliberate breathing room between the widget and the Important Information section.

### Section 2 — Hal Yang Perlu Diperhatikan

Heading:
`Hal Yang Perlu Diperhatikan`

Four cards:
1. Tiket & Identitas
2. Waktu Keberangkatan
3. Bagasi & Barang Bawaan
4. Informasi Perjalanan

Content must be concise and useful. Do not invent legal policies that have not been defined.

### Section 3 — About CTA

Heading:
`Kenal Lebih Dekat dengan TransNgawi`

Description:
`TransNgawi hadir untuk menghadirkan perjalanan antarkota yang nyaman, mudah dipesan, dan tetap masuk akal untuk kebutuhan perjalanan sehari-hari.`

CTA:
`Tentang TransNgawi`

Layout:
- desktop: bus image left, content right;
- mobile: image above content.

### Footer

Footer must use a dark visual treatment.

Do not overload the footer with invented links or company information.

## 8. Homepage Explicit Exclusions

Do not add these sections unless explicitly requested:
- Popular Routes
- Choose Your Comfort
- Why TransNgawi
- Live Network
- Featured Destinations
- Promotions
- testimonials
- statistics
- partners
- blog/news
- newsletter
- long FAQ
- oversized company profile
- duplicate booking forms

If obsolete versions already exist and the current requirement says they are removed, remove them from the relevant markup/styles/scripts instead of merely hiding them.

## 9. Navigation

Current customer navigation concept:
- Perjalanan
- Kelas
- Rute
- Bantuan
- Lacak Tiket
- Masuk
- prominent `Cari Tiket` CTA

Guest users should be able to search trips without logging in.

Exact navigation implementation may evolve as pages are implemented, but do not invent additional major navigation categories without product justification.

## 10. Booking

Booking flow:
1. search;
2. results;
3. trip detail;
4. seat selection;
5. passenger data;
6. booking creation;
7. payment instructions/state;
8. manual verification;
9. ticket/e-ticket state.

The backend owns:
- price
- availability
- booking state
- payment state

Seat selection must handle concurrency safely enough that two customers cannot successfully purchase the same seat through ordinary race conditions.

## 11. Pricing

Pricing should be data-driven.

Conceptual inputs may include:
- route
- service category
- class
- trip
- configured fare

"Live pricing" means the displayed price should come from current application data rather than hardcoded frontend values.

Do not create a fake external pricing API.

## 12. Payment

No payment gateway in the current scope.

The application may represent:
- payment instructions;
- payment reference;
- uploaded/provided proof if later required;
- pending verification;
- approved;
- rejected;
- expired/cancelled.

Admin verification is authoritative.

## 13. E-ticket

The ticket should expose the necessary booking/travel information once implemented, such as:
- booking reference;
- passenger information;
- route;
- departure date/time;
- class;
- seat;
- payment state;
- ticket status.

Do not invent fields that have no product or operational purpose.

## 14. Help

Customer support model:
1. customer starts a help session;
2. admin receives a notification/queue item;
3. admin accepts the session;
4. customer and admin exchange messages;
5. admin closes the session.

Admin should be able to distinguish:
- new/pending;
- active;
- closed.

## 15. Journey Status / Tracking

Tracking is a planned product capability.

Do not claim live GPS integration unless an actual data source exists.

A future architecture may support tracking positions and journey status, but prototype/sample positions must be clearly labeled.

## 16. Fleet Issue / Manufacturer Feedback

TransNgawi's differentiator includes direct collaboration with bus manufacturers.

Conceptual operational loop:
1. customer reports a vehicle/seat/problem;
2. TransNgawi records the issue;
3. issue is associated with the relevant bus/seat/trip where possible;
4. manufacturer-facing workflow can receive the issue;
5. technical diagnosis/resolution is recorded;
6. customer-facing status can be updated.

No real manufacturer API is required in the current MVP unless explicitly requested.

## 17. Admin

Admin dashboard may include:
- overview;
- trips;
- routes;
- classes;
- buses;
- seats;
- bookings;
- payments;
- support;
- journey status;
- fleet issues;
- reports;
- users/permissions.

Do not implement every module at once. Follow the workflow and current task scope.

## 18. MVP Boundary

MVP should prioritize:
- customer homepage;
- search;
- results;
- trip detail;
- seat inventory;
- booking;
- passenger data;
- manual payment verification;
- e-ticket;
- basic support;
- essential admin management.

Future/conditional:
- live GPS integration;
- payment gateway;
- manufacturer API;
- advanced membership;
- cargo/parcel;
- charter;
- merchandise;
- partnerships;
- advanced analytics.

## 19. Business Integrity

Revenue concept:
`seats × occupancy × average fare`

Trip contribution concept:
`trip revenue − trip operating costs`

Relevant operating costs may include:
- fuel;
- tolls;
- crew;
- maintenance;
- depreciation;
- taxes/licensing;
- terminal/operational fees.

These concepts are for product/business reasoning. Do not turn them into fabricated UI statistics unless data is actually configured.
