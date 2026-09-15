# TransNgawi

Platform tiket bus antarkota berbasis web. Dibangun dengan Laravel 13, Blade, Alpine.js, dan Tailwind CSS.

> **Bold enough to be remembered, restrained enough to be trusted.**

## Tujuan

TransNgawi menyediakan pengalaman pemesanan tiket bus yang nyaman, mudah, dan terjangkau untuk perjalanan antarkota. Platform ini terdiri dari dua sisi:

- **Customer-facing**: Pencarian trip, pemilihan kursi, pemesanan, pembayaran manual, e-ticket, pelacakan status
- **Admin dashboard**: Manajemen armada, trip, transaksi, refund, analitik, dan dukungan pelanggan

## Tech Stack

| Layer | Teknologi |
|-------|-----------|
| Backend | Laravel 13 (PHP 8.3+) |
| Auth | Laravel Breeze (Blade + Alpine.js) |
| Frontend | Blade Templates, Alpine.js 3.17, Tailwind CSS 3.4 |
| Build | Vite 8 |
| PDF | barryvdh/laravel-dompdf |
| Barcode | picqer/php-barcode-generator |
| Database | MySQL (testing: SQLite in-memory) |
| Testing | PHPUnit 12 |

## Akun Default

| Role | Email | Password |
|------|-------|----------|
| Admin | `admin@transngawi.com` | `password` |
| User | `user@transngawi.com` | `password` |

## Cara Testing

### Menjalankan Aplikasi

```bash
composer install
npm install
php artisan migrate
php artisan db:seed
php artisan key:generate
npm run dev
```

Buka `http://localhost:8000` (atau port lain sesuai konfigurasi Laragon).

### Menjalankan Semua Test

```bash
php artisan test
```

### Menjalankan Test Tertentu

```bash
php artisan test --filter=AdminManagementTest
php artisan test --filter=SearchTest
php artisan test --filter=ProfileTest
```

### Build Produksi

```bash
npm run build
```

### Clear Cache

```bash
php artisan view:clear
php artisan cache:clear
php artisan config:clear
```

---

## Halaman & Fitur

### Customer-Facing

| Halaman | URL | Deskripsi |
|---------|-----|-----------|
| **Beranda** | `/` | Hero, widget booking cepat, informasi penting, about CTA |
| **Pencarian** | `/search` | Filter rute, layanan, tanggal, urutan (harga/waktu) |
| **Detail Trip** | `/perjalanan/{id}` | Info bus, foto, fasilitas, peta kursi real-time, harga |
| **Pemilihan Kursi** | `/trips/{id}/seats` | Pilih kursi (max 4), countdown 15 menit |
| **Data Penumpang** | `/booking/{id}/passengers` | Isi nama, email, telepon |
| **Review** | `/booking/{id}/review` | Ringkasan sebelum bayar |
| **Pembayaran** | `/booking/{id}/payment` | Upload bukti bayar (manual) |
| **Status Bayar** | `/booking/{id}/payment-status` | Status verifikasi |
| **Lacak Tiket** | `/track` | Cari booking dengan kode + telepon/email |
| **Detail Tiket** | `/track/{code}` | Status booking, info perjalanan, aksi |
| **E-Ticket** | `/tickets/{code}` | Tiket digital dengan barcode |
| **Invoice** | `/booking/{code}/invoice` | Invoice PDF dan gambar |
| **Tiket Saya** | `/my-trips` | Tab Mendatang, Selesai, Dibatalkan, Semua |
| **Profil** | `/profile` | Update info akun, foto, password |
| **Kelas** | `/classes` | Informasi kelas bus (Sukian, SukianPlus, SukianPro) |
| **Rute** | `/routes` | Peta jaringan rute SVG |
| **Tentang** | `/about` | Bento grid keunggulan, cerita TransNgawi |
| **Bantuan** | `/help` | Sesi dukungan pelanggan |

### Admin Dashboard

| Halaman | URL | Deskripsi |
|---------|-----|-----------|
| **Beranda** | `/admin` | Dashboard notifikasi |
| **Lokasi** | `/admin/locations` | CRUD lokasi + titik naik/turun |
| **Armada** | `/admin/buses` | CRUD bus, status (IDLE/AKTIF/PERAWATAN) |
| **Issue Armada** | `/admin/buses/{id}/issues` | Pelaporan & tracking masalah bus |
| **Rute** | `/admin/routes` | CRUD rute dengan validasi layanan |
| **Trip** | `/admin/trips` | Filter Aktif/Selesai/Dibatalkan/Semua |
| **Wizard Trip** | `/admin/trips/create/{step}` | 5 langkah: Layanan → Rute → Bus/Waktu → Harga → Detail |
| **Edit Trip** | `/admin/trips/{id}/edit` | Ubah jadwal, bus, harga |
| **Monitoring Kursi** | `/admin/trips/{id}/seats` | Live seat map + toggle maintenance |
| **Selesai/Batalkan Trip** | PATCH `/admin/trips/{id}/complete` atau `/cancel` | Status trip + refund otomatis |
| **Transaksi** | `/admin/transactions` | Daftar booking, approve/reject pembayaran |
| **Refund** | `/admin/refunds` | Daftar refund (pembatalan armada/penumpang) |
| **Analitik** | `/admin/analisa` | Pendapatan per periode |
| **Bantuan** | `/admin/help` | Kelola sesi dukungan pelanggan |

---

## MVP Role & Scope

### Layanan (Service Category)

| kode | Nama | Deskripsi |
|------|------|-----------|
| `ANTIBU` | Antar Ibu Kota | Rute antar ibu kota. Kedua ujung harus kota ibu kota. |
| `SATSET` | Antar Tempat Penting | Rute tempat penting. Kedua ujung harus titik penting. |
| `BIASANE` | Perjalanan Reguler | Rute reguler tanpa batasan lokasi. |

### Kelas Travel

| Kelas | Deskripsi | Layout |
|-------|-----------|--------|
| **Sukian** | Standar | 2-2 (4 kolom) |
| **SukianPlus** | Eksekutif | 1-1 (2 kolom, kursi lebih lebar) |
| **SukianPro** | Sleeper Pod | 1-1 (2 kolom, pod kapsul) |

### Model Bus

| Model | Kursi | Layout |
|-------|-------|--------|
| **PLETON** | 40 | SukianPlus (8) + Sukian (32) |
| **KSATRIA** | 30 | SukianPro (8) + SukianPlus (10) + Sukian (12) |

### Alur Booking

1. **Pilih Kursi** → Kursi ditahan 15 menit (status: HELD)
2. **Isi Data Penumpang** → Nama, email, telepon
3. **Review** → Ringkasan pesanan
4. **Bayar** → Upload bukti pembayaran (manual)
5. **Verifikasi** → Admin approve/reject
6. **Selesai** → Status CONFIRMED, e-ticket aktif

### Alur Pembatalan

- **Oleh Admin (Trip)**: Semua booking di trip → `CANCELLED_BY_ADMIN` → Refund 100% otomatis → Kursi dilepas
- **Oleh Penumpang (Booking)**: Booking individual → `CANCELLED` → Refund 100% → Kursi dilepas

### Status Booking

| Status | Deskripsi |
|--------|-----------|
| `PENDING` | Baru dibuat |
| `HELD` | Kursi ditahan (15 menit) |
| `WAITING_VERIFICATION` | Menunggu verifikasi admin |
| `CONFIRMED` | Pembayaran terverifikasi |
| `REJECTED` | Pembayaran ditolak |
| `EXPIRED` | Hold kedaluwarsa |
| `CANCELLED` | Dibatalkan oleh penumpang |
| `CANCELLED_BY_ADMIN` | Dibatalkan oleh admin (trip dibatalkan) |

### Status Trip

| Status | Deskripsi |
|--------|-----------|
| `SCHEDULED` | Terjadwal |
| `IN_PROGRESS` | Berlangsung |
| `COMPLETED` | Selesai |
| `CANCELLED` | Dibatalkan |

### Status Bus

| Status | Deskripsi |
|--------|-----------|
| `IDLE` | Tersedia |
| `ACTIVE` | Sedang dalam trip |
| `MAINTENANCE` | Dalam perawatan |

### Format Kode

- **Trip Code**: `TRIP-YYYYMMDD-XXXX` (contoh: TRIP-20260914-X89A) — auto-generate, immutable
- **Booking Code**: `TN` + 6 hex (contoh: TNX8F29) — auto-generate

---

## Database

27 tabel, 15 model, 7 enum.

### Model Utama

```
User ─┬─ Booking ──── BookingSeat ──── TripSeat
      │                      │
      │                      └── Refund
      │
      └── SupportSession ──── SupportMessage

Location ──── Route ──── Trip ──── TripFare
                  │                 TripSeat
                  │
Bus ──── BusIssue ──── MaintenanceRecord
```

---

## Arsitektur

```
TransNgawi/
├── app/
│   ├── Enums/           # 7 enum (ServiceCategory, BusModelType, TripStatus, dll)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/   # 11 controller admin
│   │   │   └── Customer/# 12 controller customer
│   │   └── Middleware/   # EnsureUserIsAdmin
│   ├── Models/          # 15 model
│   ├── Services/        # BookingService, TripCreationService
│   └── Support/         # BusSeatTemplate, MockData
├── database/
│   ├── migrations/      # 27 migration
│   └── seeders/         # DatabaseSeeder, TripSeeder
├── resources/
│   └── views/           # ~90 blade templates
│       ├── admin/       # Admin dashboard views
│       ├── customer/    # Customer-facing views
│       ├── components/  # Reusable components
│       └── layouts/     # Admin & customer layouts
├── routes/
│   ├── web.php          # Semua route utama
│   └── auth.php         # Route autentikasi Breeze
└── tests/
    └── Feature/         # 13 test file, 103 test case
```

---

## Konfigurasi Penting

### Tailwind Brand Color

Gunakan `bg-[#ff750f]` / `text-[#ff750f]` — brand color `#ff750f` belum didefinisikan di `tailwind.config.js`.

### `js()` Helper

Helper `js()` tidak tersedia. Gunakan `json_encode()` atau `@js()` Blade directive.

### Enum to String

`$trip->seats->pluck('status', 'seat_code')` mengembalikan enum objects. Chain `->map(fn ($s) => is_string($s) ? $s : $s->value)` sebelum `toArray()`.

### Pembayaran

TransNgawi **tidak** menggunakan payment gateway. Pembayaran bersifat manual/simulated dengan verifikasi admin.

---

## Test Coverage

| Kategori | Test | Assertions |
|----------|------|------------|
| Admin Management | 50+ | 200+ |
| Search | 10+ | 40+ |
| Auth | 20+ | 60+ |
| Profile | 5 | 20+ |
| Domain Relationships | 8 | 30+ |
| **Total** | **103** | **383** |

### Yang Diuji

- Akses kontrol (guest, non-admin, admin)
- CRUD lokasi, bus, rute
- Wizard trip 5 langkah
- Validasi rute berdasarkan layanan
- Lifecycle status bus (IDLE → ACTIVE → IDLE)
- Toggle kursi maintenance (BLOCKED ↔ AVAILABLE)
- Auto-generate kode trip
- Invoice view & PDF download
- Autentikasi email & username
- Registrasi, reset password, verifikasi email
