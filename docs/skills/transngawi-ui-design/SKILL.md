Markdown
---
name: transngawi-ui-design
description: Gunakan saat membuat, mengubah, memperbaiki, atau menilai elemen UI/UX TransNgawi. Menjadi aturan desain utama untuk layout, typography, warna, spacing, cards, buttons, forms, booking, route, ticket, navigation, admin UI, imagery, motion, responsive behavior, accessibility, performance, dan visual QA.
license: MIT
compatibility: opencode
metadata:
  project: TransNgawi
  domain: bus-ticketing
  discipline: ui-ux
  source-inspiration: MengTo-Skills
---

# TransNgawi UI Design Skill

## 0. Peran

Ini adalah **design operating system** untuk seluruh antarmuka TransNgawi. Perlakukan sebagai aturan keputusan, bukan moodboard.

Setiap kali membuat/mengubah UI:
1. Identifikasi jenis elemen dan tujuan UX.
2. Tentukan hierarchy dan primary action.
3. Reuse token dan komponen existing.
4. Jangan membuat pattern baru jika pattern lama masih cocok.
5. Tentukan states, responsive behavior, accessibility, dan motion sebelum coding.
6. Implementasikan seminimal mungkin.
7. Validasi visual + interaction + responsive, bukan hanya build/test.

## 1. North Star

> Bold enough to be remembered, restrained enough to be trusted.

> Bold Core, Quiet Structure.

TransNgawi harus terasa: kuat, modern, muda, percaya diri, ramah, profesional, terjangkau, nyaman, dan punya identitas brand.

Bukan: luxury bus brand, corporate banking UI, marketplace generik, dashboard penuh widget, sci-fi/neon interface, glassmorphism everywhere, template SaaS, atau tiruan KAI/brand transportasi lain.

### Prioritas keputusan

1. Accessibility
2. Usability
3. Content hierarchy
4. Brand identity
5. Consistency
6. Performance
7. Motion
8. Decoration

## 2. Aturan Keras

### Jangan

- membuat elemen hanya karena terlihat keren
- memakai gradient sebagai dekorasi default
- memakai glassmorphism pada hampir semua card
- membuat semua elemen rounded/shadow
- memakai orange pada seluruh UI
- membuat semua heading terlalu besar
- membuat semua elemen center-aligned
- memakai terlalu banyak font atau icon style
- membuat animasi tanpa fungsi UX
- memenuhi negative space hanya karena terlihat kosong
- menambahkan section yang tidak punya tujuan
- membuat fake testimonials, partners, statistics, reviews, atau claims
- mengarang data bisnis
- mengubah framework/architecture tanpa kebutuhan
- menambah dependency tanpa alasan
- memakai `overflow:hidden` untuk menyembunyikan masalah layout
- menggunakan z-index ekstrem sebagai solusi stacking
- memakai `!important` sebagai solusi default

### Selalu

- gunakan design tokens
- gunakan semantic HTML
- reuse component existing
- pertahankan focus state
- dukung `prefers-reduced-motion`
- gunakan image ratio dan crop yang disengaja
- gunakan alt text
- lazy-load media below-fold bila sesuai
- cek horizontal overflow
- cek mobile dan desktop
- validasi semua state yang relevan

## 3. Workflow Sebelum Coding

### Inspect

Baca struktur repository, framework, routes, views/components, CSS/JS architecture, tokens, assets, tests, dan implementasi halaman terkait. Jangan mengarang file/dependency.

### Classify

Tentukan page, section, component, UX goal, primary action, secondary action, information density, dan responsive priority.

### Reuse

Cari existing `Button`, `Input`, `Select`, `Card`, `Badge`, `Modal`, `Drawer`, `Tabs`, `Navbar`, `Footer`, `Toast`, `Alert`, `Skeleton`, `EmptyState`, dan `ErrorState` sebelum membuat yang baru.

### Design

Tetapkan hierarchy, layout, spacing, typography, surface, border, shadow, color, interaction, states, responsive behavior, dan accessibility.

### Implement

Jangan melakukan refactor unrelated.

### Validate

Build + tests + browser rendering + responsive + keyboard/focus + hover/touch + loading/error/empty + reduced motion + overflow + image/font loading + console errors.

## 4. Token System

### Spacing

Gunakan skala:

```text
4 8 12 16 20 24 32 40 48 64 80 96 120
Default:

4–8: micro/icon spacing

12–16: control/card internals

20–24: component spacing

32–48: component groups

64–96: section spacing

120+: exceptional hero composition

Hindari angka acak seperti 37px/53px kecuali ada alasan layout yang kuat.

Container
Target desktop 1200–1280px; gunakan responsive horizontal padding. Prinsip awal: mobile 20–24px, tablet 32px, desktop 40–64px.

Radius
Plaintext
small   8px
medium  12–16px
large   20–24px
pill    999px
Color
Orange adalah primary brand/CTA, bukan warna seluruh halaman. Gunakan untuk primary CTA, active/selected state, key highlight, progress, dan brand moments.

Neutral surfaces harus menjadi mayoritas. Success/warning/error/info harus semantic dan tidak semuanya orange.

Shadow
Gunakan elevation untuk hierarchy, bukan dekorasi. Small untuk controls/compact cards, medium untuk cards/panels/popovers, strong hanya untuk modal/hero media yang benar-benar membutuhkan separation. Hindari colored glow.

5. Typography
Hierarchy minimum:

Plaintext
Display / Hero
H1
H2
H3
Body
Small
Label
Utility
Rules:

H1 adalah focal point.

Body harus nyaman dibaca.

Label form harus jelas.

Utility text boleh kecil tetapi tetap readable.

Hindari uppercase seluruh interface dan letter-spacing ekstrem.

Maksimal 1 display family + 1 body/UI family jika font baru memang diperlukan.

Jika existing project sudah punya font system, pertahankan.

Batasi body text sekitar 45–75 karakter/baris jika memungkinkan.

6. Layout & Grid
Gunakan 12-column grid untuk halaman kompleks, 6/8-column untuk composition sederhana, flex untuk control rows, grid untuk repeated cards.

Mobile bukan desktop yang diperkecil. Mobile harus menyederhanakan hierarchy, mengubah row menjadi column bila perlu, menjaga touch target, dan mempertahankan CTA.

Negative space dipakai untuk grouping. Jangan mengisi ruang kosong hanya agar penuh, tetapi jangan membuat whitespace sampai hubungan konten hilang.

7. Visual Hierarchy
Setiap layar idealnya punya:

Plaintext
1 primary focal point
1 primary action
supporting information
secondary actions
background/decorative layer
Gunakan size, weight, contrast, position, spacing, dan color secara terukur. Jangan membuat semuanya bold untuk menciptakan hierarchy.

8. Navigation
Primary navigation TransNgawi:

Plaintext
Perjalanan
Kelas
Rute
Bantuan
Lacak Tiket
Masuk
Cari Tiket
Cari Tiket adalah prominent CTA.

Desktop: brand kiri, nav teratur, CTA jelas. Mobile: compact navigation/drawer yang accessible; jangan memaksa seluruh menu tampil.

Navbar boleh shrink saat scroll jika meningkatkan usability. Jangan membuat transisinya dramatis.

9. Hero
Hero adalah authored moment terkuat.

Homepage:

full-bleed bus photography

text langsung di atas image

tidak ada dashboard/search card besar di dalam hero

headline + supporting copy + CTA

overlay hanya untuk readability

Hierarchy:

Plaintext
image
→ tonal overlay
→ headline
→ supporting copy
→ CTA
Image harus terasa sebagai stage: deliberate crop, strong focal subject, responsive object-position, readable overlay.

10. Quick Booking Widget
Booking adalah core product UI.

Plaintext
Pesan Tiket Cepat
Service Type
Dari
Ke
Tanggal Berangkat
Penumpang
Cari Perjalanan
Service types:

Plaintext
ANTIBU
SATSET
BIASANE
Rules:

service type harus prominent

origin/destination mudah dibedakan

date picker jelas

passenger control bukan text input biasa

primary action paling mudah ditemukan

validation inline dan spesifik

Overlap
Jika widget overlap hero/section berikutnya:

buat stacking context yang jelas

parent positioning harus jelas

z-index harus kecil dan bermakna

jangan gunakan 999999

reserve vertical space di section berikutnya

Overlap adalah compositional technique, bukan bug fix.

Mobile: horizontal form berubah menjadi vertical flow; jangan mempertahankan row dengan field terlalu sempit.

11. Buttons
Hierarchy:

Plaintext
Primary
Secondary
Tertiary/Text
Destructive
Primary orange untuk aksi utama seperti Cari Tiket, Lanjutkan, Konfirmasi, Bayar, Simpan.

Hover boleh memakai background shift, slight lift, border/shadow change, atau icon movement kecil. Press cukup subtle.

Disabled harus jelas tidak actionable tanpa membuat teks tidak terbaca.

12. Forms
Anatomy:

Plaintext
label
control
helper/error
Input harus punya tinggi/padding konsisten, border jelas, focus state jelas, dan label nyata. Placeholder bukan pengganti label.

Jangan menghapus focus outline tanpa replacement. Error harus dekat field, spesifik, singkat, dan actionable.

13. Cards
Card hanya dipakai jika konten memang merupakan unit mandiri.

Anatomy dapat berupa:

Plaintext
media/icon
label bila semantik
 title
supporting content
metadata
action
Jangan membuat decorative eyebrow hanya untuk gaya. Card yang tidak actionable jangan dibuat terlihat clickable.

14. Route Cards
Prioritaskan:

Plaintext
origin → destination
date/time
class
fare
availability/status
CTA
Route visualization harus membantu scanning, bukan menjadi dekorasi. State tetap harus terbaca tanpa animation.

15. Class Cards
Sukian
free snack

bottled water

SukianPlus
wider seat

massage feature

free snack

bottled water

souvenir keychain

SukianPro
compact sleeper cabin

personal TV

Tunjukkan value difference dengan hierarchy. Jangan memakai klaim absolut seperti "termurah" tanpa data.

16. Pricing
Harga adalah core conversion information.

Harus konsisten, mudah dipindai, tidak ambigu, dan menyatakan unit bila diperlukan.

Jika harga dipengaruhi route/date/class/seat/occupancy/demand, UI harus jujur. Jangan menyebut fake pricing sebagai live/real-time.

17. Seat Selection
Seat map adalah functional UI.

Minimal state:

Plaintext
available (contoh: Hijau)
selected
occupied
unavailable / held (contoh: Merah / Abu-abu, mengindikasikan status ditahan selama 15 menit saat checkout)
special/accessibility jika didukung
State tidak boleh hanya dibedakan dengan warna. Setiap kelas (Sukian, SukianPlus, SukianPro) harus direpresentasikan dengan bentuk atau simbol kursi yang berbeda agar pengguna mudah membedakannya secara langsung. Layout kursi wajib mengikuti respons backend (misalnya 2-2 dan 1-1) sesuai kapasitas total 40 atau 30 kursi. Legend harus jelas, seat number terbaca, touch target memadai, dan mobile mudah dioperasikan.

18. Booking Summary & E-ticket
Booking summary memprioritaskan:

Plaintext
route
date/time
class
passenger count
seat
fare
fees jika ada
total
primary action
Total paling menonjol. Jangan menyembunyikan biaya yang sudah diketahui.

E-ticket memprioritaskan booking code, passenger, route, departure, seat, class, status, dan important instruction. Branded boleh, tetapi readability selalu lebih penting.

19. Tracking
Bedakan status:

Plaintext
scheduled
boarding
departed
on route
approaching
arrived
cancelled
delayed
Jangan menampilkan fake GPS sebagai data nyata. Jika simulated/demo, labeli dengan jujur.

20. Help / Support
Flow:

Plaintext
Start Help Session
→ waiting
→ admin accepted
→ conversation
→ closed
Chat harus membedakan customer/admin, memiliki timestamp yang readable, input ergonomis, session status, dan loading state.

Admin help UI boleh three-pane:

Plaintext
session queue | active conversation | customer/session context
21. Admin UI
Admin lebih information-dense daripada customer UI, tetapi tetap memakai typography, color semantics, spacing, button logic, dan accessibility yang sama.

Struktur menu dasbor Admin dibatasi dengan tegas:

Beranda: Menampilkan ringkasan dan badge notifikasi jumlah permintaan sesi Bantuan yang masuk.

Rute: Menambahkan titik lokasi (kota/terminal).

Perjalanan: Membuat jadwal perjalanan.

Bus: Manajemen armada sesuai templat model bus (BIASANE atau ANTIBU/SATSET).

Transaksi: Melihat riwayat pembelian tiket dengan filter.

Analisa: Statistik tiket terjual dan pendapatan harian/bulanan.

Gunakan table untuk data dense. Gunakan cards untuk summary. Gunakan charts hanya jika menjawab pertanyaan bisnis nyata.

22. Tables & Status
Table cocok untuk bookings, passengers, trips, payments, issues, support sessions, buses.

Status badge harus semantic, readable, dan tidak bergantung pada warna saja.

Contoh status:

Plaintext
Confirmed
Pending
Paid
Awaiting Verification
Cancelled
Delayed
Resolved
Open
Closed
23. Modal, Dropdown, Date Picker
Modal hanya untuk focused task, confirmation, warning, atau compact detail. Harus responsive, focus-aware, dan dapat ditutup dengan Escape jika sesuai.

Dropdown/select/date picker wajib memiliki selected, active, focus, keyboard behavior, dan loading/empty/error state jika async.

Untuk banyak kota/rute, gunakan searchable select.

24. Icons
Satu visual language. Icon mendukung label. Icon-only control wajib punya accessible name. Jangan mencampur outline/filled/3D/emoji icon secara sembarangan.

25. Imagery
Prioritaskan bus, perjalanan, interior, seat experience, road/travel context, dan human context yang relevan.

Jangan memakai image random, watermark, fake partner/customer imagery, atau foto yang menyiratkan klaim palsu.

Gunakan crop/object-position yang disengaja dan alt text.

26. Decoration & Blur
Dekorasi yang boleh: line, subtle grid, route line, accent marker, image framing, controlled overlap, subtle texture.

Hindari blob gradient everywhere, neon, particles, ornamental bento, pseudo-dashboard, dan meaningless counters.

Blur adalah depth tool. Gunakan hanya jika membantu readability/depth/edge treatment. Jangan blur seluruh page atau text. Decorative blur harus pointer-events:none dan tidak berlebihan karena GPU cost.

27. Motion System
Motion harus melayani salah satu:

hierarchy

feedback

attention

continuity

polish

Jika tidak, hapus.

Defaults:

Plaintext
micro hover/press  120–200ms
UI state           180–260ms
popover/toast      220–320ms
section entrance   400–800ms
hero sequence      800–1600ms
stagger            40–90ms
Utamakan transform dan opacity. Hindari animasi layout-heavy seperti width/height/top/left jika tidak perlu.

Hover default: lift ringan 2–4px + subtle shadow/border/background shift.

Scroll reveal: trigger sekitar 20–30% visible, animasikan sekali, jangan replay terus.

Wajib dukung:

CSS
@media (prefers-reduced-motion: reduce)
Saat reduced motion: content tetap visible, kurangi transform, nonaktifkan scroll-scrub/pin dan looping non-essential.

28. GSAP / WebGL
GSAP hanya jika CSS/vanilla tidak cukup. Gunakan satu motion architecture dan cleanup lifecycle.

WebGL/Three.js bukan default. Untuk booking/high-intent pages:

conversion clarity > WebGL spectacle

Jika digunakan: static/mobile fallback, reduced-motion policy, capped DPR, bounded render cost, resource disposal, dan jangan menutupi CTA.

29. Accessibility
Minimum:

semantic HTML

keyboard navigation

visible focus

correct heading hierarchy

form labels

accessible names

sufficient contrast

alt text

status tidak hanya melalui color

reduced motion

touch target memadai

Gunakan button untuk action dan a untuk navigation. Jangan menghapus focus.

30. Responsive Validation
Validasi minimal:

Plaintext
375 390 414 768 1024 1280 1440
Periksa overflow, wrapping, CTA reachability, navigation, form stacking, image crop, card width, spacing, table behavior, dan modal behavior.

31. Loading / Empty / Error
Loading harus mempertahankan layout: skeleton, compact spinner, disabled submit, atau progress indicator.

Empty state menjawab: apa yang kosong, kenapa, dan apa yang dapat dilakukan.

Error harus specific, actionable, dan dekat sumbernya. Bedakan validation, network, server, permission, not-found, dan business-rule errors. Jangan semua menjadi "Something went wrong."

32. Homepage Contract
Homepage hanya memiliki:

Hero

Quick Booking Widget sebagai functional overlap element

Hal Yang Perlu Diperhatikan

About CTA

Footer

Quick Booking Widget bukan marketing section.

Hero copy
Headline:

Perjalanan Nyaman, Tanpa Bikin Kantong Berat.

Subhead:

Pesan tiket bus TransNgawi dengan mudah, pilih perjalanan yang sesuai kebutuhan, dan nikmati perjalanan antarkota dengan kenyamanan yang lebih masuk akal.

CTA:

Cari Tiket

Hal Yang Perlu Diperhatikan
Cards:

Tiket & Identitas

Waktu Keberangkatan

Bagasi & Barang Bawaan

Informasi Perjalanan

About CTA
Heading:

Kenal Lebih Dekat dengan TransNgawi

Description:

TransNgawi hadir untuk menghadirkan perjalanan antarkota yang nyaman, mudah dipesan, dan tetap masuk akal untuk kebutuhan perjalanan sehari-hari.

CTA:

Tentang TransNgawi

Desktop: image kiri, content kanan. Mobile: image atas, content bawah.

Footer dark.

33. Page-Level Section Rule
Sebelum membuat section, jawab:

Plaintext
Apa tujuan section ini?
Informasi apa yang disampaikan?
Apa action yang diharapkan?
Kenapa section ini diperlukan?
Jika tidak ada jawaban kuat, jangan buat section.

34. Copy Rules
Copy harus jelas, singkat, human, confident, dan tidak overclaim.

Hindari klaim seperti "terbaik", "nomor satu", "paling murah", atau "paling nyaman" tanpa bukti.

CTA sebaiknya spesifik:

Plaintext
Cari Tiket
Lihat Rute
Pilih Perjalanan
Lanjutkan
Lacak Tiket
Hubungi Bantuan
35. Reference Handling
Jika user memberi screenshot/website reference:

Analisis reference secara menyeluruh.

Ambil high-level traits: hierarchy, pacing, contrast, image treatment, typography relationship, interaction principles.

Jangan menyalin logo, identity, copy, source code, exact composition, atau proprietary assets.

Bangun identity TransNgawi sendiri.

Reference adalah art direction input, bukan template tracing.

36. Element Creation Protocol
Untuk setiap elemen baru:

A. Purpose
Apa fungsi elemen?

B. Priority
Primary / Secondary / Supporting / Decorative.

C. Anatomy
Tentukan struktur internal.

D. Visual
Tentukan typography, surface, spacing, border, shadow, color, imagery.

E. States
Normal, hover, focus, active, selected, disabled, loading, error, empty bila relevan.

F. Responsive
Tentukan mobile/tablet/desktop behavior.

G. Motion
Tentukan apakah motion benar-benar dibutuhkan.

H. Accessibility
Semantic element, keyboard behavior, focus, accessible name, contrast.

I. Validation
Uji viewport dan state yang relevan.

37. Anti-Pattern Audit
Sebelum handoff, cari:

excessive gradients

excessive glass

excessive shadows

inconsistent radius

inconsistent spacing

tiny text

oversized headings

repeated decorative elements

random icon styles

fake content/data/claims

dead buttons

missing hover/focus

missing mobile behavior

horizontal overflow

purposeless animation

excessive z-index

unnecessary dependencies

duplicate component patterns

38. Visual QA
Structure
[ ] hierarchy obvious

[ ] primary action obvious

[ ] section order logical

[ ] spacing consistent

Typography
[ ] H1 strongest

[ ] body readable

[ ] labels clear

[ ] no accidental tiny text

Components
[ ] buttons consistent

[ ] inputs consistent

[ ] cards consistent

[ ] badges consistent

[ ] states complete

Brand
[ ] orange selective

[ ] TransNgawi identity visible

[ ] not generic SaaS

[ ] not luxury

[ ] not KAI clone

Responsive
[ ] 375

[ ] 390

[ ] 414

[ ] 768

[ ] 1024

[ ] 1280

[ ] 1440

[ ] no horizontal overflow

Accessibility
[ ] keyboard

[ ] focus

[ ] labels

[ ] contrast

[ ] alt

[ ] reduced motion

Performance
[ ] images optimized

[ ] below-fold media lazy loaded where appropriate

[ ] no unnecessary animation loops

[ ] no heavy WebGL without justification

[ ] no layout thrashing

39. Completion Gate
Build/test success alone tidak berarti UI selesai.

Definition of Done:

Plaintext
technical correctness
+ visual correctness
+ responsive correctness
+ interaction correctness
+ accessibility
40. Final Decision Rules
Jika ragu antara lebih banyak visual vs lebih jelas → lebih jelas.

Jika ragu membuat pattern baru vs reuse → reuse.

Jika ragu banyak animation vs sedikit bermakna → sedikit bermakna.

Jika ragu wow effect vs booking usability → booking usability.

TransNgawi harus terlihat seperti satu produk yang dirancang oleh satu design team, bukan kumpulan komponen yang dibuat satu per satu oleh AI.