# TransNgawi --- AI Coding Agent Playbook

> File ini adalah instruksi operasional untuk OpenCode/AI coding agent.
>
> Tujuannya: agent memahami scope, tidak berasumsi, tidak melakukan
> scope creep, dan selalu memvalidasi hasil.

------------------------------------------------------------------------

# 1. Sumber Kebenaran

Sebelum coding, gunakan:

1.  `prd.md` → apa yang harus dibangun.
2.  `architecture.md` → bagaimana membangunnya.
3.  `skills.md` → bagaimana UI harus terlihat.
4.  repository → fakta implementasi yang sudah ada.

Jika agent tidak mengetahui sesuatu, **inspect repository terlebih
dahulu**.

------------------------------------------------------------------------

# 2. HARD RULE --- Jangan Berasumsi

Jangan mengarang: - framework; - package; - route; - database; -
field; - API; - API key; - payment provider; - GPS provider; -
manufacturer API; - harga; - credential; - business rule.

Jika informasi belum tersedia: 1. inspect code/docs/config; 2. gunakan
pattern existing bila valid; 3. nyatakan assumption jika tetap
diperlukan.

Jangan menyamarkan assumption sebagai fakta.

------------------------------------------------------------------------

# 3. Workflow Sebelum Coding

Selalu:

``` text
Inspect repository
↓
Identify framework/version
↓
Inspect composer.json
↓
Inspect package.json
↓
Inspect routes
↓
Inspect views/components
↓
Inspect CSS/JS
↓
Inspect migrations/models
↓
Inspect tests
↓
Map requirement
↓
Plan smallest coherent change
↓
Implement
↓
Test
↓
Build
↓
Browser/UI validation
↓
Report
```

------------------------------------------------------------------------

# 4. Jangan Merusak Existing Project

Jangan: - mengganti framework; - mengganti frontend stack tanpa
alasan; - menghapus dependency penting; - menghapus data; - membuat
duplicate components; - melakukan refactor besar yang tidak diperlukan.

Reuse implementation existing jika memang sehat.

------------------------------------------------------------------------

# 5. Homepage --- HARD SCOPE

Homepage hanya:

``` text
Navbar
↓
Hero
↓
Booking Widget
↓
Hal Yang Perlu Diperhatikan
↓
About CTA
↓
Footer
```

3 section utama: 1. Hero; 2. Hal Yang Perlu Diperhatikan; 3. About CTA.

Booking Widget adalah elemen fungsional overlap, bukan section
marketing.

------------------------------------------------------------------------

# 6. Homepage Cleanup

Hapus dari homepage: - Popular Routes; - Choose Your Comfort; - Why
TransNgawi; - Live Network; - Featured Destinations; - Promotions; -
Testimonials; - Statistics; - Partner logos; - Blog; - News; - FAQ; -
Newsletter; - company profile panjang.

Jangan hanya `display:none`.

Bersihkan: - markup; - CSS; - JS; - component; - data dummy yang hanya
digunakan section lama.

------------------------------------------------------------------------

# 7. Hero Implementation

Hero: - full-bleed; - full-width; - bus image; - text langsung di atas
image.

Content:

``` text
Perjalanan Nyaman, Tanpa Bikin Kantong Berat.

Pesan tiket bus TransNgawi dengan mudah, pilih perjalanan yang sesuai kebutuhan, dan nikmati perjalanan antarkota dengan kenyamanan yang lebih masuk akal.

[Cari Tiket]
```

Dilarang: - card di Hero; - search form di Hero; - dashboard; -
statistics; - badge; - eyebrow; - multiple CTA.

Overlay hanya untuk readability.

------------------------------------------------------------------------

# 8. Booking Widget

Title: `Pesan Tiket Cepat`

Field: - Jenis Layanan; - Dari; - Ke; - Tanggal Berangkat; - Penumpang.

Service: - ANTIBU; - SATSET; - BIASANE.

CTA: `Cari Perjalanan`.

Widget harus overlap Hero dan section berikutnya.

------------------------------------------------------------------------

# 9. Overlap --- Jangan Hanya Mengandalkan z-index

Implementasi harus: - widget berada di atas; - widget tidak terpotong; -
content tidak tertimpa; - mobile tetap usable; - tidak horizontal
overflow.

Gunakan stacking context yang jelas.

Jangan menggunakan:

``` css
z-index: 999999999;
```

Jangan menyelesaikan layout dengan z-index saja.

------------------------------------------------------------------------

# 10. Spacing Setelah Widget

Bagian paling bawah widget harus memiliki ruang yang jelas sebelum:

`Hal Yang Perlu Diperhatikan`

Perhitungkan: - tinggi widget; - responsive wrapping; - breakpoint; -
mobile layout.

Jangan membuat section berikutnya menempel.

Jangan membuat whitespace kosong berlebihan.

------------------------------------------------------------------------

# 11. Important Travel Section

Heading: `Hal Yang Perlu Diperhatikan`

Cards: - Tiket & Identitas; - Waktu Keberangkatan; - Bagasi & Barang
Bawaan; - Informasi Perjalanan.

Tidak ada eyebrow.

Card sederhana, compact, readable.

------------------------------------------------------------------------

# 12. About CTA

Hanya satu card.

Desktop:

``` text
IMAGE LEFT | CONTENT RIGHT
```

Content:

``` text
Kenal Lebih Dekat dengan TransNgawi

Deskripsi singkat.

[Tentang TransNgawi]
```

Mobile:

``` text
IMAGE
CONTENT
CTA
```

Tidak ada CTA kedua.

------------------------------------------------------------------------

# 13. Footer

Footer dark.

Bukan marketing section.

------------------------------------------------------------------------

# 14. Brand

TransNgawi: - youthful; - strong; - clean; - professional; - modern; -
confident; - affordable comfort.

Jangan: - membuat luxury aesthetic; - membuat childish aesthetic; -
membuat generic SaaS; - meniru KAI.

Screenshot/referensi KAI hanya referensi UX, bukan target visual untuk
dicopy.

------------------------------------------------------------------------

# 15. No Eyebrow

Jangan membuat decorative eyebrow di atas heading.

Functional form labels tetap boleh:

``` text
Jenis Layanan
Dari
Ke
Tanggal Berangkat
Penumpang
```

------------------------------------------------------------------------

# 16. Design Tokens

Gunakan centralized tokens: - colors; - typography; - spacing; -
radius; - shadows; - breakpoints; - motion; - z-index.

Jangan membuat nilai random di setiap component.

------------------------------------------------------------------------

# 17. Color

Orange: - primary CTA; - active; - selected; - brand highlight.

Orange bukan warning.

Semantic: - blue = info; - green = success; - amber = warning; - red =
error.

Jangan membuat seluruh website orange.

------------------------------------------------------------------------

# 18. Typography

Pilih/pertahankan satu: - Inter; - Plus Jakarta Sans; - Manrope.

Jangan membuat body text terlalu kecil.

Hero harus memiliki hierarchy tertinggi.

------------------------------------------------------------------------

# 19. Responsive

Wajib cek:

``` text
375
390
414
768
1024
1280
1440
```

Mobile: - hero tetap full bleed; - text readable; - booking vertical; -
overlap tetap; - spacing tetap; - About CTA vertical; - navbar usable.

Tidak boleh horizontal scrollbar.

------------------------------------------------------------------------

# 20. Accessibility

Wajib: - semantic HTML; - heading hierarchy; - visible focus; -
labels; - keyboard navigation; - sufficient contrast; - alt text; -
meaningful buttons; - errors understandable; - status tidak hanya
berdasarkan warna.

------------------------------------------------------------------------

# 21. Backend Authority

Frontend tidak authoritative terhadap: - price; - seat availability; -
booking status; - payment status; - permissions; - trip status.

Backend harus memvalidasi ulang semuanya.

------------------------------------------------------------------------

# 22. Booking

Seat booking: - transaction; - lock; - availability check; - unique
constraint.

Jangan percaya data availability dari browser.

------------------------------------------------------------------------

# 23. Payment

MVP tanpa payment gateway.

`I Have Paid` hanya membuat status menjadi:

`Waiting Verification`

Admin authorized yang approve/reject.

------------------------------------------------------------------------

# 24. Help

Lifecycle:

``` text
WAITING
↓
ACTIVE
↓
RESOLVED
↓
CLOSED
```

New session: - queue; - admin notification; - accept; - reply; - close.

------------------------------------------------------------------------

# 25. Tracking

Simulation boleh.

Tetapi: - jangan menyebutnya real GPS; - jangan membuat fake production
API; - gunakan replaceable TrackingService.

------------------------------------------------------------------------

# 26. Fleet

Status: - Available; - Assigned; - On Trip; - Maintenance; - Out of
Service.

Maintenance/Out of Service tidak boleh digunakan untuk trip baru.

------------------------------------------------------------------------

# 27. Testing

Setelah perubahan relevan:

``` bash
npm run build
php artisan test
```

Jika gagal: 1. baca error; 2. cari root cause; 3. perbaiki; 4. jalankan
ulang.

Jangan menyatakan selesai jika hasil belum diverifikasi.

------------------------------------------------------------------------

# 28. Browser Validation

Untuk UI check: - page loading; - console; - network; - horizontal
overflow; - image loading; - font loading; - responsive; - button; -
navigation; - z-index; - overlap; - spacing; - focus; - mobile menu.

Khusus homepage: - Hero full bleed; - tidak ada card Hero; - Booking
Widget overlap; - widget di atas; - spacing cukup; - About CTA
terakhir; - footer dark.

------------------------------------------------------------------------

# 29. Scope Discipline

Jika user meminta satu task: - kerjakan task itu; - jangan mengerjakan
phase berikutnya; - jangan menambahkan fitur "sekalian"; - jangan
membuat integration yang belum diminta.

Jika dependency diperlukan, jelaskan dependency tersebut.

------------------------------------------------------------------------

# 30. Development Sequence

``` text
1. Homepage visual foundation
2. Route/category/class/trip foundation
3. Search
4. Search Results
5. Trip Detail
6. Seat Inventory
7. Booking
8. Passenger
9. Payment Verification
10. E-ticket
11. Help
12. Journey Status / Tracking
13. Fleet Issue
14. Reports
```

------------------------------------------------------------------------

# 31. Definition of Done

Jangan menyatakan selesai jika: - build gagal; - test gagal tanpa
penjelasan; - homepage overflow; - widget tertutup; - overlap tidak
bekerja; - section menempel; - section lama masih ada; - CTA rusak; -
ada console error kritis.

------------------------------------------------------------------------

# 32. Reporting

Gunakan format:

``` text
## Files Changed
- ...

## What Changed
- ...

## Validation
- npm run build: PASS/FAIL
- php artisan test: PASS/FAIL

## UI Validation
- ...

## Assumptions
- ...

## Remaining Issues
- ...
```

Jangan hanya mengatakan "Done".
