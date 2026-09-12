<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TransNgawi - Perjalanan Nyaman, Harga Pas</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-[#faf9f8] text-[#1a1a1a] antialiased flex flex-col min-h-screen">

    <!-- ========= NAVBAR ========= -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-sm border-b border-[#e6e6e6] shadow-sm">
        <div class="max-w-7xl mx-auto px-5 md:px-8 lg:px-10">
            <div class="flex items-center justify-between h-20">
                <a href="/" class="flex items-center gap-3.5">
                    <div class="bg-[#ff750f] text-white p-3 rounded-2xl flex items-center justify-center font-bold text-2xl tracking-wider">
                        TN
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-2xl tracking-tight text-[#1a1a1a]">TransNgawi</span>
                        <span class="text-sm text-[#666666] -mt-0.5 font-medium">Affordable Comfort</span>
                    </div>
                </a>

                <nav class="hidden md:flex items-center gap-10">
                    <a href="#perjalanan" class="text-base font-semibold text-[#1a1a1a] hover:text-[#ff750f] transition-colors">Perjalanan</a>
                    <a href="#kelas" class="text-base font-semibold text-[#1a1a1a] hover:text-[#ff750f] transition-colors">Kelas</a>
                    <a href="#rute" class="text-base font-semibold text-[#1a1a1a] hover:text-[#ff750f] transition-colors">Rute</a>
                    <a href="#bantuan" class="text-base font-semibold text-[#1a1a1a] hover:text-[#ff750f] transition-colors">Bantuan</a>
                    <a href="#lacak" class="text-base font-semibold text-[#1a1a1a] hover:text-[#ff750f] transition-colors">Lacak Tiket</a>
                </nav>

                <div class="flex items-center gap-6">
                    <a href="#masuk" class="hidden sm:inline-flex text-base font-semibold text-[#1a1a1a] hover:text-[#ff750f] px-5 py-2.5 transition-colors">
                        Masuk
                    </a>
                    <a href="#quick-ticket" class="button button--primary button--large shadow-md font-semibold">
                        Cari Tiket
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- ========= SECTION 1: HERO ========= -->
    <section class="relative pt-24 pb-48 md:pb-56 lg:pb-64 overflow-hidden bg-neutral-900 text-white">
        <!-- Full-Width Background Visual -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>

        <div class="max-w-7xl mx-auto px-5 md:px-8 lg:px-10 relative z-20">
            <div class="max-w-3xl">
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold text-white tracking-tight leading-[1.1] mb-6 drop-shadow-lg">
                    Perjalanan Nyaman,<br/>
                    <span class="text-[#ff750f]">Tanpa Bikin Kantong Berat.</span>
                </h1>

                <p class="text-xl text-neutral-300 leading-relaxed max-w-2xl font-normal drop-shadow">
                    Pesan perjalanan antarkota bersama TransNgawi dengan pilihan kelas yang sesuai kebutuhanmu.
                </p>
            </div>
        </div>

        <!-- Floating Booking Widget (z-index highest - z-50) -->
        <div class="absolute bottom-0 left-0 right-0 transform translate-y-1/2 z-50">
            <div class="max-w-7xl mx-auto px-5 md:px-8 lg:px-10">
                <div id="quick-ticket" class="bg-white rounded-[2rem] border border-[#e6e6e6] shadow-2xl p-8 md:p-10 text-[#1a1a1a] max-w-md mx-auto">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-3.5 h-3.5 rounded-full bg-[#ff750f]"></div>
                        <h2 class="text-2xl md:text-3xl font-bold text-[#1a1a1a]">Pesan Tiket Cepat</h2>
                    </div>

                    <form onsubmit="event.preventDefault();" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 items-end">
                        <!-- Jenis Layanan -->
                        <div>
                            <label for="service" class="input-label text-base font-semibold">Jenis Layanan</label>
                            <select id="service" class="input font-semibold text-base h-14">
                                <option value="antibu">ANTIBU - Antar Ibu Kota</option>
                                <option value="satset">SATSET - Antar Tempat Penting</option>
                                <option value="biasane">BIASANE - Reguler Antarkota</option>
                            </select>
                        </div>

                        Dari
                        <select id="origin" class="input font-semibold text-base h-14">
                            <option value="">Pilih Kota Asal</option>
                            <option value="surabaya" selected>Surabaya</option>
                            <option value="semarang">Semarang</option>
                            <option value="yogyakarta">Yogyakarta</option>
                            <option value="bandung">Bandung</option>
                            <option value="jakarta">Jakarta</option>
                        </select>

                        Ke
                        <select id="destination" class="input font-semibold text-base h-14">
                            <option value="">Pilih Kota Tujuan</option>
                            <option value="surabaya">Surabaya</option>
                            <option value="semarang">Semarang</option>
                            <option value="yogyakarta">Yogyakarta</option>
                            <option value="bandung">Bandung</option>
                            <option value="jakarta" selected>Jakarta</option>
                        </select>

                        Tanggal Berangkat
                        <input type="date" id="departure_date" class="input font-semibold text-base h-14" value="2026-09-11">

                        Penumpang
                        <select id="passengers" class="input font-semibold text-base h-14">
                            <option value="1" selected>1 Penumpang</option>
                            <option value="2">2 Penumpang</option>
                            <option value="3">3 Penumpang</option>
                            <option value="4">4 Penumpang</option>
                        </select>

                        <div>
                            <button type="submit" class="button button--primary w-full text-lg font-bold h-14 shadow-lg hover:shadow-xl">
                                Cari Perjalanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- ========= SECTION 2: HAL YANG PERLU DIPERHATIKAN ========= -->
    <section class="py-36 md:py-48 bg-[#faf9f8]">
        <div class="max-w-7xl mx-auto px-5 md:px-8 lg:px-10">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <h2 class="text-4xl md:text-5xl font-bold text-[#1a1a1a] tracking-tight mb-6">Hal Yang Perlu Diperhatikan</h2>
                <p class="text-lg text-[#555555] font-normal leading-relaxed">
                    Pastikan beberapa hal ini sudah kamu siapkan sebelum memulai perjalanan bersama TransNgawi.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Card 1 -->
                <div class="bg-white rounded-[2rem] border border-[#e6e6e6] p-8 shadow-md hover:shadow-xl transition-shadow">
                    <div>
                        <div class="w-16 h-16 rounded-2xl bg-[#ff750f]/10 text-[#ff750f] flex items-center justify-center font-black text-3xl mb-6">
                            01
                        </div>
                        <h3 class="text-xl font-bold text-[#1a1a1a] mb-3">Tiket & Identitas</h3>
                        <p class="text-base text-[#555555] leading-relaxed font-normal">
                            Pastikan tiket sudah terkonfirmasi dan identitas siap digunakan saat boarding.
                        </p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-[2rem] border border-[#e6e6e6] p-8 shadow-md hover:shadow-xl transition-shadow">
                    <div>
                        <div class="w-16 h-16 rounded-2xl bg-[#ff750f]/10 text-[#ff750f] flex items-center justify-center font-black text-3xl mb-6">
                            02
                        </div>
                        <h3 class="text-xl font-bold text-[#1a1a1a] mb-3">Waktu Keberangkatan</h3>
                        <p class="text-base text-[#555555] leading-relaxed font-normal">
                            Datang lebih awal agar proses boarding berjalan lebih nyaman.
                        </p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-[2rem] border border-[#e6e6e6] p-8 shadow-md hover:shadow-xl transition-shadow">
                    <div>
                        <div class="w-16 h-16 rounded-2xl bg-[#ff750f]/10 text-[#ff750f] flex items-center justify-center font-black text-3xl mb-6">
                            03
                        </div>
                        <h3 class="text-xl font-bold text-[#1a1a1a] mb-3">Bagasi & Barang Bawaan</h3>
                        <p class="text-base text-[#555555] leading-relaxed font-normal">
                            Pastikan barang bawaan sesuai dengan ketentuan perjalanan TransNgawi.
                        </p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="bg-white rounded-[2rem] border border-[#e6e6e6] p-8 shadow-md hover:shadow-xl transition-shadow">
                    <div>
                        <div class="w-16 h-16 rounded-2xl bg-[#ff750f]/10 text-[#ff750f] flex items-center justify-center font-black text-3xl mb-6">
                            04
                        </div>
                        <h3 class="text-xl font-bold text-[#1a1a1a] mb-3">Informasi Perjalanan</h3>
                        <p class="text-base text-[#555555] leading-relaxed font-normal">
                            Periksa kembali jadwal, titik keberangkatan, kelas, dan informasi perjalananmu.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========= SECTION 3: CTA TENTANG TRANSNGAWI ========= -->
    <section class="py-24 bg-white border-t border-b border-[#e6e6e6]">
        <div class="max-w-7xl mx-auto px-5 md:px-8 lg:px-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-[#1a1a1a] tracking-tight mb-6">Kenal Lebih Dekat dengan TransNgawi</h2>
                    <p class="text-lg text-[#555555] leading-relaxed font-normal">
                        TransNgawi hadir untuk menghadirkan perjalanan antarkota yang nyaman, mudah dipesan, dan tetap masuk akal untuk kebutuhan perjalanan sehari-hari.
                    </p>
                    <a href="/about" class="button button--primary button--large shadow-md font-semibold mt-6">
                        Tentang TransNgawi
                    </a>
                </div>
                <div class="relative flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1581091011114-36e207e1d63e?w=800&q=80" alt="Bus TransNgawi" class="w-full h-64 object-cover rounded-[2rem] shadow-2xl">
                </div>
            </div>
        </div>
    </section>

    <!-- ========= GLOBAL DARK FOOTER ========= -->
    <footer id="bantuan" class="bg-[#14171c] text-neutral-300 border-t border-neutral-800 pt-20 pb-16 mt-auto">
        <div class="max-w-7xl mx-auto px-5 md:px-8 lg:px-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 pb-16 border-b border-neutral-800">
                <div class="lg:col-span-2">
                    <a href="/" class="flex items-center gap-3.5 mb-6">
                        <div class="bg-[#ff750f] text-white p-2.5 rounded-xl font-bold text-xl">
                            TN
                        </div>
                        <span class="font-bold text-2xl tracking-tight text-white">TransNgawi</span>
                    </a>
                    <p class="text-base text-neutral-400 leading-relaxed max-w-sm mb-8 font-normal">
                        Platform digital resmi perusahaan bus antarkota TransNgawi. Menghadirkan kenyamanan perjalanan berkualitas tinggi dengan harga yang tetap terjangkau.
                    </p>
                    <p class="text-sm text-neutral-500">
                        &copy; {{ date('Y') }} TransNgawi. Hak Cipta Dilindungi.
                    </p>
                </div>

                <div>
                    <h4 class="font-bold text-base text-white mb-6">Perjalanan</h4>
                    <ul class="space-y-3.5 text-base text-neutral-400">
                        <li><a href="#quick-ticket" class="hover:text-[#ff750f] transition-colors font-medium">Cari Tiket</a></li>
                        <li><a href="#quick-ticket" class="hover:text-[#ff750f] transition-colors font-medium">Rute Populer</a></li>
                        <li><a href="#quick-ticket" class="hover:text-[#ff750f] transition-colors font-medium">Kelas Bus</a></li>
                        <li><a href="#quick-ticket" class="hover:text-[#ff750f] transition-colors font-medium">Jadwal Keberangkatan</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-base text-white mb-6">Layanan & Fitur</h4>
                    <ul class="space-y-3.5 text-base text-neutral-400">
                        <li><a href="#quick-ticket" class="hover:text-[#ff750f] transition-colors font-medium">Lacak Tiket</a></li>
                        <li><a href="#quick-ticket" class="hover:text-[#ff750f] transition-colors font-medium">Fasilitas Kami</a></li>
                        <li><a href="#bantuan" class="hover:text-[#ff750f] transition-colors font-medium">Pusat Bantuan</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-base text-white mb-6">Bantuan & Syarat</h4>
                    <ul class="space-y-3.5 text-base text-neutral-400">
                        <li><a href="#bantuan" class="hover:text-[#ff750f] transition-colors font-medium">Syarat & Ketentuan</a></li>
                        <li><a href="#bantuan" class="hover:text-[#ff750f] transition-colors font-medium">Kebijakan Privasi</a></li>
                        <li><a href="#bantuan" class="hover:text-[#ff750f] transition-colors font-medium">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>