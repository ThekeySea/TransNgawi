# TransNgawi --- Product Requirements Document (PRD)

## 1. Tujuan Dokumen

Dokumen ini adalah sumber utama untuk memahami **apa yang dibangun**,
**siapa penggunanya**, **fitur apa yang wajib ada**, dan **batasan
produk** TransNgawi.

Gunakan urutan referensi: 1. `prd.md` → kebutuhan produk dan aturan
bisnis. 2. `architecture.md` → cara teknis membangun produk. 3.
`skills.md` → aturan visual dan UX. 4. `agents.md` → cara AI coding
agent mengerjakan task.

------------------------------------------------------------------------

## 2. Identitas Produk

**Nama:** TransNgawi\
**Jenis:** Platform digital pemesanan tiket bus antarkota.

Nama "TransNgawi" adalah nama brand. Jangan menganggap Ngawi sebagai
kantor pusat, hub utama, atau asal seluruh rute.

### Fokus utama

1.  Pemesanan tiket bus.
2.  Pencarian perjalanan.
3.  Pemilihan jenis layanan.
4.  Live pricing.
5.  Visualisasi rute.
6.  Status perjalanan.
7.  Customer support.

Company profile hanya pendukung.

------------------------------------------------------------------------

## 3. Positioning

TransNgawi menjual **affordable comfort**: perjalanan yang nyaman,
modern, dan mudah dipesan dengan harga yang tetap masuk akal.

TransNgawi bukan: - brand bus paling murah; - luxury bus eksklusif; -
website company profile dengan booking sebagai fitur tambahan; - brand
yang kaku atau terlalu korporat.

Karakter: - youthful; - confident; - clean; - modern; - professional; -
accessible; - comfort-oriented.

**North Star:**

> A young, confident transportation company that takes comfort seriously
> --- without pretending to be a luxury brand.

------------------------------------------------------------------------

## 4. Target Pengguna

Target utama: - sekitar usia 20--30 tahun; - daya beli menengah hingga
menengah ke bawah; - sensitif terhadap harga; - tetap mengutamakan
kenyamanan; - terbiasa menggunakan website/mobile web.

Kebutuhan: - mencari rute; - melihat jadwal; - mengetahui harga; -
memilih layanan; - memilih kursi; - memesan; - membayar melalui
mekanisme manual/simulasi; - mendapatkan e-ticket; - melihat status
perjalanan; - mendapatkan bantuan.

------------------------------------------------------------------------

# 5. Layanan

## ANTIBU --- Antar Ibu Kota

Contoh: - Surabaya--Semarang - Surabaya--Yogyakarta -
Surabaya--Bandung - Surabaya--Serang - Surabaya--Jakarta

## SATSET --- Perjalanan Antar Tempat Penting

Contoh: - Surabaya--Cilegon/Pelabuhan Merak -
Yogyakarta--Jakarta/Bandara Soekarno-Hatta

## BIASANE --- Perjalanan Reguler

Untuk perjalanan reguler antarkota menuju destinasi menengah/besar.

**Jangan mengarang rute resmi tambahan tanpa requirement baru.**

------------------------------------------------------------------------

# 6. Kelas

## Sukian

Entry/affordable: - snack gratis; - air mineral.

## SukianPlus

Best-value: - kursi lebih lega; - massage; - snack gratis; - air
mineral; - souvenir keychain.

## SukianPro

Premium sleeper: - compact sleeping cabin; - personal TV.

Jangan menyebut suatu kelas "termurah" secara absolut tanpa data
pembanding.

Tidak semua trip harus menyediakan semua kelas.

------------------------------------------------------------------------

# 7. Struktur Beranda --- HARD REQUIREMENT

Beranda harus **booking-first**.

Hanya ada **3 section utama**:

### Section 1 --- Hero

Foto bus full-bleed + headline + subhead + satu CTA.

### Booking Widget

Elemen fungsional yang overlap antara Hero dan section berikutnya. Ini
**bukan section marketing tambahan**.

### Section 2 --- Hal Yang Perlu Diperhatikan

Informasi penting sebelum bepergian.

### Section 3 --- CTA Tentang TransNgawi

Satu kartu horizontal untuk mengarahkan user ke halaman Tentang.

### Footer

Footer dark.

------------------------------------------------------------------------

## 7.1 Section yang dilarang di Beranda

Jangan menambahkan: - Popular Routes; - Featured Routes; - Choose Your
Comfort; - Why TransNgawi; - Live Network; - Featured Destinations; -
Promotions; - Testimonials; - Statistics; - Partner logos; - Blog; -
News; - FAQ; - Newsletter; - daftar armada; - daftar semua kelas; -
company profile panjang; - section dekoratif tambahan.

Jika masih ada dari versi lama, hapus secara nyata. Jangan sekadar
`display:none`.

------------------------------------------------------------------------

# 8. Hero

Hero wajib: - full width; - full bleed; - menggunakan foto bus; -
menjadi visual anchor.

Tidak boleh: - card di Hero; - search card di Hero; - dashboard
preview; - split layout "teks + card"; - statistics; - badge; -
eyebrow/decorative label; - banyak CTA.

### Headline

> Perjalanan Nyaman, Tanpa Bikin Kantong Berat.

### Subhead

> Pesan tiket bus TransNgawi dengan mudah, pilih perjalanan yang sesuai
> kebutuhan, dan nikmati perjalanan antarkota dengan kenyamanan yang
> lebih masuk akal.

### CTA

> Cari Tiket

Text langsung di atas image. Overlay/gradient hanya untuk readability.

------------------------------------------------------------------------

# 9. Booking Widget

Judul:

> Pesan Tiket Cepat

Field wajib: 1. Jenis Layanan 2. Dari 3. Ke 4. Tanggal Berangkat 5.
Penumpang 6. Cari Perjalanan

Jenis layanan: - ANTIBU --- Antar Ibu Kota - SATSET --- Perjalanan Antar
Tempat Penting - BIASANE --- Perjalanan Reguler

Widget harus: - overlap Hero dan section berikutnya; - berada di
stacking order tertinggi yang relevan; - tidak terpotong; - tidak
tertutup; - tidak menggunakan z-index absurd; - responsive.

Desktop dapat horizontal. Mobile harus nyaman secara vertikal.

------------------------------------------------------------------------

# 10. Spacing Setelah Booking

Bagian paling bawah Booking Widget harus memiliki **breathing room yang
jelas** sebelum heading "Hal Yang Perlu Diperhatikan".

Spacing harus mempertimbangkan: - tinggi widget; - wrapping mobile; -
breakpoint; - layout aktual.

Jangan menempel dan jangan menciptakan whitespace berlebihan.

------------------------------------------------------------------------

# 11. Hal Yang Perlu Diperhatikan

Heading:

> Hal Yang Perlu Diperhatikan

Tidak memakai eyebrow.

Empat item:

### Tiket & Identitas

Pastikan nama penumpang pada tiket sesuai dengan identitas yang
digunakan saat perjalanan.

### Waktu Keberangkatan

Datang lebih awal agar proses boarding berjalan lebih lancar.

### Bagasi & Barang Bawaan

Pastikan barang bawaan tersimpan dengan aman dan sesuai ketentuan
perjalanan.

### Informasi Perjalanan

Periksa kembali detail rute, jadwal, kelas, dan titik keberangkatan
sebelum berangkat.

Gunakan card sederhana dan mudah discan.

------------------------------------------------------------------------

# 12. CTA Tentang TransNgawi

Hanya satu kartu horizontal.

Desktop: - kiri = foto bus; - kanan = heading + description + satu CTA.

Heading:

> Kenal Lebih Dekat dengan TransNgawi

Description:

> TransNgawi hadir untuk menghadirkan perjalanan antarkota yang nyaman,
> mudah dipesan, dan tetap masuk akal untuk kebutuhan perjalanan
> sehari-hari.

CTA:

> Tentang TransNgawi

Mobile: - image di atas; - content di bawah.

Tidak ada CTA kedua.

------------------------------------------------------------------------

# 13. Footer

Footer wajib dark dan tenang.

Link relevan: - Perjalanan; - Kelas; - Rute; - Bantuan; - Lacak Tiket; -
Tentang.

------------------------------------------------------------------------

# 14. Customer Navigation

Menu: - Perjalanan; - Kelas; - Rute; - Bantuan; - Lacak Tiket; - Masuk.

CTA utama: - Cari Tiket.

Guest boleh mencari dan memulai booking tanpa login.

------------------------------------------------------------------------

# 15. Customer Pages

Minimal: - Home; - Search Results; - Trip Detail; - Seat Selection; -
Passenger Details; - Payment; - Payment Status; - Booking
Confirmation/E-ticket; - My Trips; - Journey Status; - Live Tracking; -
Classes; - Routes; - Help Center; - Help Session; - Profile; - About.

------------------------------------------------------------------------

# 16. Search

Input: - service type; - origin; - destination; - departure date; -
passenger count.

Results: - departure/arrival; - duration; - route; - class; - price; -
availability; - facilities; - CTA.

Filter: - time; - price; - class; - duration; - facilities; -
availability.

------------------------------------------------------------------------

# 17. Live Pricing

Harga dapat dipengaruhi: - base fare; - route; - class; - demand; -
remaining seats; - date; - season/day; - departure time.

Dynamic pricing boleh disimulasikan untuk prototype/sekolah.

Jangan menyebut simulated data sebagai live production data.

Backend harus authoritative terhadap harga final.

------------------------------------------------------------------------

# 18. Booking

Flow:

``` text
Search
→ Select Trip
→ Trip Detail
→ Select Seat
→ Passenger Details
→ Review
→ Payment
→ Waiting Verification
→ Confirmed
→ E-ticket
```

Booking code: - unique; - collision-safe; - human-readable.

Contoh format: `TNX8F29`

------------------------------------------------------------------------

# 19. Seat

Status: - Available; - Held; - Booked; - Blocked.

Satu kursi tidak boleh dijual dua kali.

------------------------------------------------------------------------

# 20. Payment

MVP **tidak menggunakan payment gateway**.

Jangan menambahkan Midtrans, Xendit, Stripe, PayPal, atau gateway lain
tanpa requirement baru.

Flow:

``` text
Booking
→ Payment Instructions
→ Customer "I Have Paid"
→ Waiting Verification
→ Admin Review
→ Approved / Rejected
```

"I Have Paid" tidak langsung berarti Paid/Confirmed.

Status: - Pending; - Waiting Verification; - Paid; - Rejected; -
Expired; - Cancelled; - Refunded.

------------------------------------------------------------------------

# 21. E-ticket

Minimal: - booking code; - passenger; - route; - date/time; -
origin/destination; - bus/service; - class; - seat; - payment status; -
QR/ticket code; - boarding information.

------------------------------------------------------------------------

# 22. Journey Status

Status: - Scheduled; - Boarding; - Departed; - On Route; - Delayed; -
Arrived; - Cancelled.

Tracking awal boleh simulasi. Jangan mengklaim simulasi sebagai GPS
real.

------------------------------------------------------------------------

# 23. Help

Lifecycle:

``` text
WAITING
→ ACTIVE
→ RESOLVED
→ CLOSED
```

Topic: - Booking; - Payment; - Ticket; - Schedule; - Boarding; - Seat; -
Route; - Trip Status; - Refund/Cancellation; - Other.

Customer membuat session → admin menerima notification → admin accept →
chat → close.

------------------------------------------------------------------------

# 24. Fleet Issue

Workflow:

``` text
Reported
→ Verified
→ Manufacturer Notified
→ Under Repair
→ Resolved
```

Konsep penting: TransNgawi bekerja langsung dengan manufacturer agar
masalah armada dapat diteruskan dan ditangani lebih cepat.

Tidak perlu real manufacturer API pada MVP.

------------------------------------------------------------------------

# 25. Admin

Modul: - Dashboard; - Bookings; - Payments; - Trips; - Tracking; -
Fleet; - Routes; - Classes; - Customers; - Help; - Issues; - Reports; -
Notifications; - Admin Users; - Settings; - Activity Log.

Roles: - Super Admin; - Operations; - Customer Support; - Finance.

KPI: - Today's Trips; - Tickets Sold; - Revenue; - Help Sessions.

------------------------------------------------------------------------

# 26. Critical Business Rules

1.  Seat tidak boleh double-book.
2.  Confirmed ticket harus memiliki trip valid.
3.  Trip harus memiliki route valid.
4.  Trip tidak boleh menggunakan bus maintenance/unavailable.
5.  Payment approval harus auditable.
6.  Booking transition harus dikontrol.
7.  Help session memiliki state eksplisit.
8.  Active help session memiliki primary owner.
9.  Cancelled/expired booking tidak purchasable.
10. Simulated tracking harus jelas sebagai simulasi.
11. Admin permissions harus server-side.
12. Checkout price harus authoritative.

------------------------------------------------------------------------

# 27. MVP

Customer: - Home; - Search; - Results; - Trip Detail; - Seat; -
Passenger; - Payment; - Payment Status; - E-ticket; - Help; - Journey
Status; - basic tracking visualization.

Admin: - Dashboard; - Booking; - Payment Verification; - Trip; - Help
Queue/Chat; - Notifications; - basic Route/Class/Fleet.

------------------------------------------------------------------------

# 28. Fitur Setelah MVP

-   advanced reports;
-   customer accounts;
-   refund/reschedule;
-   loyalty;
-   saved passengers;
-   saved routes;
-   advanced dynamic pricing;
-   cargo/parcel;
-   charter;
-   merchandise;
-   membership;
-   partnerships;
-   real GPS;
-   manufacturer API.
