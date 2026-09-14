 <header
    class="fixed top-0 left-0 right-0 z-[var(--z-nav)] transition-all duration-300 ease-in-out"
    x-data="{
        open: false,
        scrolled: false,
        forceSolid: {{ request()->routeIs('help.index', 'help.show', 'my-trips.index', 'track.show', 'tickets.show') ? 'true' : 'false' }},
        init() {
            this.updateScrolled();
            window.addEventListener('scroll', () => this.updateScrolled(), { passive: true });
        },
        updateScrolled() {
            this.scrolled = window.scrollY > 80 || this.forceSolid;
        }
    }"
    :class="scrolled || forceSolid
        ? 'bg-white/95 backdrop-blur-md border-b border-border shadow-md py-2'
        : 'bg-transparent py-4'"
>
    <div class="container-app">
        <div class="flex items-center justify-between">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 transition-all duration-300" :class="scrolled ? 'scale-90 origin-left' : ''">
                <div class="flex h-9 w-9 items-center justify-center rounded-[var(--radius-md)] bg-brand text-sm font-bold text-white transition-all duration-300 md:h-10 md:w-10 md:text-base"
                    :class="scrolled ? 'h-8 w-8 text-sm md:h-9 md:w-9' : 'md:h-10 md:w-10 md:text-base'"
                >
                    TN
                </div>
                <div class="flex flex-col transition-all duration-300" :class="scrolled ? 'opacity-100 w-auto' : 'opacity-100 w-0 overflow-hidden'">
                    <p class="text-lg font-bold tracking-tight md:text-xl transition-colors duration-300" :class="scrolled ? 'text-text' : 'text-white'">TransNgawi</p>
                </div>
            </a>

            {{-- Desktop Navigation --}}
            <nav class="hidden items-center gap-7 lg:flex" aria-label="Navigasi utama">
                <a href="{{ route('about.index') }}" class="text-sm font-semibold transition-colors duration-200"
                    :class="scrolled
                        ? ({{ request()->routeIs('about.index') ? 'true' : 'false' }} ? 'text-[#ff750f]' : 'text-[#1a1a1a] hover:text-[#ff750f]')
                        : ({{ request()->routeIs('about.index') ? 'true' : 'false' }} ? 'text-[#ff750f]' : 'text-white/90 hover:text-[#ff750f]')"
                >Tentang</a>
                <a href="{{ route('classes.index') }}" class="text-sm font-semibold transition-colors duration-200"
                    :class="scrolled
                        ? ({{ request()->routeIs('classes.index') ? 'true' : 'false' }} ? 'text-[#ff750f]' : 'text-[#1a1a1a] hover:text-[#ff750f]')
                        : ({{ request()->routeIs('classes.index') ? 'true' : 'false' }} ? 'text-[#ff750f]' : 'text-white/90 hover:text-[#ff750f]')"
                >Kelas</a>
                <a href="{{ route('perjalanan.index') }}" class="text-sm font-semibold transition-colors duration-200"
                    :class="scrolled
                        ? ({{ request()->routeIs('search.index', 'perjalanan.index') ? 'true' : 'false' }} ? 'text-[#ff750f]' : 'text-[#1a1a1a] hover:text-[#ff750f]')
                        : ({{ request()->routeIs('search.index', 'perjalanan.index') ? 'true' : 'false' }} ? 'text-[#ff750f]' : 'text-white/90 hover:text-[#ff750f]')"
                >Perjalanan</a>
                <a href="{{ route('help.index') }}" class="text-sm font-semibold transition-colors duration-200"
                    :class="scrolled
                        ? ({{ request()->routeIs('help.index', 'help.show') ? 'true' : 'false' }} ? 'text-[#ff750f]' : 'text-[#1a1a1a] hover:text-[#ff750f]')
                        : ({{ request()->routeIs('help.index', 'help.show') ? 'true' : 'false' }} ? 'text-[#ff750f]' : 'text-white/90 hover:text-[#ff750f]')"
                >Bantuan</a>
                <a href="{{ route('my-trips.index') }}" class="text-sm font-semibold transition-colors duration-200"
                    :class="scrolled
                        ? ({{ request()->routeIs('my-trips.index') ? 'true' : 'false' }} ? 'text-[#ff750f]' : 'text-[#1a1a1a] hover:text-[#ff750f]')
                        : ({{ request()->routeIs('my-trips.index') ? 'true' : 'false' }} ? 'text-[#ff750f]' : 'text-white/90 hover:text-[#ff750f]')"
                >Lacak Tiket</a>
            </nav>

            {{-- Right Side --}}
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="hidden text-sm font-semibold transition-colors duration-200 hover:text-[#ff750f] sm:inline-flex"
                        :class="scrolled ? 'text-[#1a1a1a]' : 'text-white/90'"
                    >Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="hidden text-sm font-semibold transition-colors duration-200 hover:text-[#ff750f] sm:inline-flex"
                        :class="scrolled ? 'text-[#1a1a1a]' : 'text-white/90'"
                    >Masuk</a>
                @endauth

                {{-- Mobile Menu Button --}}
                <button type="button" class="inline-flex items-center justify-center rounded-[var(--radius-sm)] p-2 transition-colors duration-200 lg:hidden"
                    :class="scrolled ? 'text-text hover:bg-surface' : 'text-white hover:bg-white/10'"
                    @click="open = !open" aria-label="Buka menu"
                >
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open" x-transition class="border-t border-border bg-white lg:hidden" @click.outside="open = false">
        <nav class="container-app flex flex-col gap-1 py-4" aria-label="Navigasi mobile">
            <a href="{{ route('about.index') }}" class="rounded-[var(--radius-sm)] px-3 py-3 text-base font-semibold @if(request()->routeIs('about.index')) bg-[#ff750f]/10 text-[#ff750f] @else text-[#1a1a1a] hover:bg-[#ff750f]/10 hover:text-[#ff750f] @endif" @click="open = false">Tentang</a>
            <a href="{{ route('classes.index') }}" class="rounded-[var(--radius-sm)] px-3 py-3 text-base font-semibold @if(request()->routeIs('classes.index')) bg-[#ff750f]/10 text-[#ff750f] @else text-[#1a1a1a] hover:bg-[#ff750f]/10 hover:text-[#ff750f] @endif" @click="open = false">Kelas</a>
            <a href="{{ route('perjalanan.index') }}" class="rounded-[var(--radius-sm)] px-3 py-3 text-base font-semibold @if(request()->routeIs('search.index', 'perjalanan.index')) bg-[#ff750f]/10 text-[#ff750f] @else text-[#1a1a1a] hover:bg-[#ff750f]/10 hover:text-[#ff750f] @endif" @click="open = false">Perjalanan</a>
            <a href="{{ route('help.index') }}" class="rounded-[var(--radius-sm)] px-3 py-3 text-base font-semibold @if(request()->routeIs('help.index', 'help.show')) bg-[#ff750f]/10 text-[#ff750f] @else text-[#1a1a1a] hover:bg-[#ff750f]/10 hover:text-[#ff750f] @endif" @click="open = false">Bantuan</a>
            <a href="{{ route('my-trips.index') }}" class="rounded-[var(--radius-sm)] px-3 py-3 text-base font-semibold @if(request()->routeIs('my-trips.index')) bg-[#ff750f]/10 text-[#ff750f] @else text-[#1a1a1a] hover:bg-[#ff750f]/10 hover:text-[#ff750f] @endif" @click="open = false">Lacak Tiket</a>
            @auth
                <a href="{{ route('dashboard') }}" class="rounded-[var(--radius-sm)] px-3 py-3 text-base font-semibold text-[#1a1a1a] hover:bg-[#ff750f]/10 hover:text-[#ff750f]" @click="open = false">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="rounded-[var(--radius-sm)] px-3 py-3 text-base font-semibold text-[#1a1a1a] hover:bg-[#ff750f]/10 hover:text-[#ff750f]" @click="open = false">Masuk</a>
            @endauth
        </nav>
    </div>
</header>