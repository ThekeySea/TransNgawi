# TransNgawi --- Design System & UI Skills

> Dokumen ini adalah **design contract**.
>
> Gunakan untuk menjaga visual TransNgawi tetap konsisten ketika AI
> membuat atau memperbaiki UI.

------------------------------------------------------------------------

# 1. Design North Star

> **Bold enough to be remembered, restrained enough to be trusted.**

Prinsip:

> **Bold Core, Quiet Structure.**

Interpretasi: - brand kuat; - hierarchy jelas; - layout tenang; -
decoration minimal; - booking mudah ditemukan.

------------------------------------------------------------------------

# 2. Brand Character

  Karakter        Intensitas
  --------------- -------------
  Youthful        High
  Brand-forward   High
  Clean           High
  Professional    High
  Confident       High
  Friendly        Medium
  Premium         Medium
  Playful         Medium
  Corporate       Low--Medium
  Ornamental      Low
  Aggressive      Low

Jangan membuat TransNgawi: - luxury berlebihan; - childish; -
ultra-cheap/generic; - corporate kaku; - clone KAI.

------------------------------------------------------------------------

# 3. Homepage Design Contract

Struktur:

``` text
NAVBAR
↓
HERO
↓
BOOKING WIDGET OVERLAP
↓
BREATHING SPACE
↓
HAL YANG PERLU DIPERHATIKAN
↓
ABOUT CTA
↓
DARK FOOTER
```

Hanya 3 section utama: 1. Hero; 2. Hal Yang Perlu Diperhatikan; 3. About
CTA.

------------------------------------------------------------------------

# 4. Hero

Hero adalah visual anchor pertama.

## Image

Harus: - full bleed; - full width; - bus-focused; - high quality; -
correct crop; - tidak terdistorsi.

Gunakan `object-fit: cover` atau equivalent.

## Content

Hanya: - headline; - subhead; - CTA.

Tidak ada: - card; - search form; - dashboard; - stats; - badges; -
eyebrow; - multi CTA.

------------------------------------------------------------------------

# 5. Hero Copy

Headline:

> Perjalanan Nyaman, Tanpa Bikin Kantong Berat.

Subhead:

> Pesan tiket bus TransNgawi dengan mudah, pilih perjalanan yang sesuai
> kebutuhan, dan nikmati perjalanan antarkota dengan kenyamanan yang
> lebih masuk akal.

CTA:

> Cari Tiket

------------------------------------------------------------------------

# 6. Hero Overlay

Overlay boleh digunakan untuk readability.

Tujuan:

``` text
Image tetap terlihat
+
Text tetap terbaca
```

Jangan: - membuat image terlalu gelap; - memakai glassmorphism; -
menggunakan gradient sebagai dekorasi utama.

------------------------------------------------------------------------

# 7. Booking Widget

Title:

> Pesan Tiket Cepat

Widget adalah focal point kedua setelah Hero.

Visual: - solid surface; - clear shadow; - controlled radius; - strong
hierarchy.

Tidak boleh: - transparent glass; - neon; - decorative blobs; -
excessive gradient.

------------------------------------------------------------------------

# 8. Booking Fields

Urutan:

``` text
Jenis Layanan
Dari
Ke
Tanggal Berangkat
Penumpang
Cari Perjalanan
```

Service: - ANTIBU; - SATSET; - BIASANE.

Primary CTA menggunakan orange.

------------------------------------------------------------------------

# 9. Booking Overlap

Konsep:

``` text
──── HERO ────
██████████████
██████████████
    ┌──────────────┐
    │ BOOKING      │
    │ WIDGET       │
    └──────────────┘
──── CONTENT ─────
```

Widget: - di atas Hero; - overlap content berikutnya; - tidak
terpotong; - tidak tertutup; - tidak overflow.

Gunakan stacking context yang jelas.

------------------------------------------------------------------------

# 10. Z-index

Jangan memakai angka ekstrem seperti:

``` text
999999
999999999
9999999999
```

Gunakan layer yang terkontrol.

Conceptual hierarchy:

``` text
base content
↓
navigation
↓
booking overlap
↓
modal/dialog
```

Sesuaikan dengan existing app.

------------------------------------------------------------------------

# 11. Critical Spacing

Setelah bottom Booking Widget:

``` text
BOOKING WIDGET
       ↓
CLEAR BREATHING SPACE
       ↓
HAL YANG PERLU DIPERHATIKAN
```

Spacing: - intentional; - responsive; - cukup; - tidak excessive.

------------------------------------------------------------------------

# 12. Hal Yang Perlu Diperhatikan

Heading:

> Hal Yang Perlu Diperhatikan

Tidak ada eyebrow.

Cards: 1. Tiket & Identitas; 2. Waktu Keberangkatan; 3. Bagasi & Barang
Bawaan; 4. Informasi Perjalanan.

Card: - simple; - compact; - readable; - subtle border/shadow; -
consistent radius.

Jangan membuat section ini menjadi feature showcase.

------------------------------------------------------------------------

# 13. About CTA

Satu kartu horizontal.

Desktop:

``` text
IMAGE | CONTENT
```

Image: - kiri; - cukup besar; - object-fit cover.

Content: - heading; - short description; - one CTA.

Heading:

> Kenal Lebih Dekat dengan TransNgawi

CTA:

> Tentang TransNgawi

Mobile:

``` text
IMAGE
CONTENT
CTA
```

------------------------------------------------------------------------

# 14. Navigation

Menu:

``` text
Perjalanan
Kelas
Rute
Bantuan
Lacak Tiket
Masuk
```

CTA:

``` text
Cari Tiket
```

Navbar: - compact; - readable; - stable; - not oversized.

------------------------------------------------------------------------

# 15. Footer

Footer: - dark; - quiet; - structured; - compact.

Jangan membuat footer orange penuh.

------------------------------------------------------------------------

# 16. No Eyebrow Rule

Jangan menggunakan decorative eyebrow.

Dilarang:

``` text
TRAVEL WITH US
Perjalanan Nyaman...
```

Boleh:

``` text
Jenis Layanan
[ANTIBU]
```

karena merupakan functional label.

------------------------------------------------------------------------

# 17. Typography

Pilih satu: - Inter; - Plus Jakarta Sans; - Manrope.

Jika repository sudah memiliki salah satunya, pertahankan.

Hierarchy:

``` text
Display
H1
H2
H3
H4
Body Large
Body
Body Small
Caption
Label
```

Jangan mengecilkan typography hanya untuk memasukkan lebih banyak
content.

------------------------------------------------------------------------

# 18. Spacing Tokens

Gunakan:

``` text
4
8
12
16
20
24
32
40
48
64
80
96
120
```

Jangan membuat spacing acak tanpa alasan.

------------------------------------------------------------------------

# 19. Container

Customer desktop:

``` text
max-width sekitar 1200–1280px
```

Gunakan responsive horizontal padding.

------------------------------------------------------------------------

# 20. Radius

Guidance:

``` text
8–10px  controls
14–18px standard cards
20–24px large cards
pill hanya untuk chip/status tertentu
```

Jangan membuat semua element sangat rounded.

------------------------------------------------------------------------

# 21. Shadows

Gunakan shadow untuk hierarchy.

Booking Widget: - strongest relevant shadow.

Normal card: - subtle.

Jangan memberikan shadow besar pada semua element.

------------------------------------------------------------------------

# 22. Borders

Gunakan border untuk: - form clarity; - card definition; - selected
state; - separation.

Jangan memberi border pada setiap element.

------------------------------------------------------------------------

# 23. Color System

## Orange

-   primary CTA;
-   active;
-   selected;
-   brand highlight.

Orange bukan warning.

## Dark

-   footer;
-   dark surfaces.

## Light

-   page background;
-   cards;
-   inputs.

## Semantic

-   blue = information;
-   green = success;
-   amber = warning;
-   red = error/destructive.

Status tidak boleh dibedakan hanya dengan warna.

------------------------------------------------------------------------

# 24. Buttons

Primary: - orange background; - white text.

States: - default; - hover; - focus; - active; - loading; - disabled.

Secondary: - neutral/outline/light.

Destructive: - semantic red.

Hover tidak boleh mengubah ukuran button secara ekstrem.

------------------------------------------------------------------------

# 25. Forms

Setiap input: - visible label; - correct input type; - clear focus; -
validation; - accessible error.

Placeholder bukan pengganti label.

Booking form harus menjadi form paling mudah ditemukan.

------------------------------------------------------------------------

# 26. Cards

Gunakan card hanya ketika grouping informasi memang membantu.

Hindari **card soup**.

Homepage secara konseptual hanya memiliki: - Booking Widget; - 4
information cards; - 1 About CTA card.

------------------------------------------------------------------------

# 27. Trip Card

Prioritas:

1.  origin/destination;
2.  departure/arrival;
3.  class;
4.  price;
5.  availability;
6.  facilities;
7.  CTA.

Jangan membuat decoration lebih dominan daripada informasi.

------------------------------------------------------------------------

# 28. Class UI

### Sukian

Affordable / practical.

### SukianPlus

Best value / balanced comfort.

### SukianPro

Premium / sleeper.

Semua menggunakan visual system yang sama.

Jangan membuat Sukian terlihat buruk karena entry-level.

------------------------------------------------------------------------

# 29. Route Visualization

Gunakan: - nodes; - lines; - origin; - destination; - route category; -
duration/status.

MVP tidak membutuhkan geographic map real.

Jangan membuat visual seolah-olah berasal dari GPS real jika bukan.

------------------------------------------------------------------------

# 30. Live Pricing UI

Hierarchy:

``` text
Current Price
Class
Availability
Supporting Context
```

Jika simulated, jangan menyebutnya sebagai real external live data.

------------------------------------------------------------------------

# 31. Photography

Image harus: - relevant; - high quality; - consistent; - correctly
cropped.

Jangan menyebut random stock photo sebagai bus resmi TransNgawi.

Jika conceptual asset: - buat mudah diganti.

------------------------------------------------------------------------

# 32. Motion

Motion: - subtle; - fast; - purposeful.

Gunakan untuk: - hover; - focus; - selection; - menu; - state
transition.

Hindari: - infinite decoration; - heavy parallax; - bouncing; -
excessive animation.

------------------------------------------------------------------------

# 33. Responsive

Wajib validasi:

``` text
375
390
414
768
1024
1280
1440
```

Mobile: - Hero full bleed; - text readable; - Booking Widget vertical; -
overlap tetap; - spacing tetap; - About CTA vertical; - footer usable.

Tidak boleh horizontal overflow.

------------------------------------------------------------------------

# 34. Accessibility

Wajib: - semantic HTML; - correct heading order; - visible focus; -
keyboard navigation; - sufficient contrast; - alt text; - labels; -
understandable errors; - status bukan color-only.

------------------------------------------------------------------------

# 35. Admin Visual Language

Admin tetap memakai DNA TransNgawi tetapi fokus pada operational
clarity.

Priority:

``` text
Clarity
↓
Scanning
↓
Status
↓
Action
```

Sidebar:

``` text
OVERVIEW
Dashboard

BOOKING
Bookings
Payments

OPERATIONS
Trips
Tracking
Fleet

NETWORK
Routes
Classes

CUSTOMER
Customers
Help
Issues

ANALYTICS
Reports

SYSTEM
Notifications
Admin Users
Settings
Activity Log
```

------------------------------------------------------------------------

# 36. Admin Tables

Harus: - scannable; - clear; - consistent; - filterable; - paginated.

Jangan membuat terlalu banyak kolom tanpa kebutuhan.

------------------------------------------------------------------------

# 37. Help Admin

Recommended:

``` text
Conversations | Chat | Context
```

Context: - customer; - topic; - status; - booking; - trip; - assignment.

------------------------------------------------------------------------

# 38. Loading / Empty / Error

Major UI harus memiliki: - loading; - empty; - error; - success jika
relevan.

Error harus jelas dan actionable.

------------------------------------------------------------------------

# 39. Anti-Patterns

Hindari: - excessive gradients; - excessive glassmorphism; - neon; -
rounded-everything; - too many colors; - inconsistent shadows; -
inconsistent radii; - tiny typography; - meaningless decoration; - too
many CTAs; - fake urgency; - dashboard-as-homepage; - dense text
walls; - giant unused whitespace; - color-only status.

------------------------------------------------------------------------

# 40. Visual QA

Sebelum UI dianggap selesai:

### Brand

Apakah terasa TransNgawi?

### Hero

Apakah image benar-benar full bleed?

### Hero

Apakah tidak ada card/dashboard?

### Booking

Apakah user langsung menemukan booking?

### Service

Apakah ANTIBU/SATSET/BIASANE jelas?

### Overlap

Apakah widget benar-benar overlap?

### Z-index

Apakah widget tidak tertutup?

### Spacing

Apakah section berikutnya tidak menempel?

### Information

Apakah empat informasi mudah discan?

### CTA

Apakah About CTA hanya satu card?

### Footer

Apakah dark dan tenang?

### Responsive

Apakah mobile tidak overflow?

### Restraint

Apakah tidak ada section yang tidak diperlukan?

------------------------------------------------------------------------

# 41. Final Rule

Jika ragu antara menambahkan sesuatu atau menjaga layout sederhana:

> **Pilih yang lebih sederhana selama fungsi utama tidak berkurang.**

TransNgawi harus: - strong brand; - booking-first; - easy to use; -
visually distinctive; - restrained.

Bukan website yang penuh section, card, animasi, atau dekorasi.

> **Bold enough to be remembered, restrained enough to be trusted.**
