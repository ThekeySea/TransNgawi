<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold tracking-tight text-[#1a1a1a]">Masuk ke Akun</h1>
        <p class="mt-2 text-sm text-[#555555]">Selamat datang kembali di TransNgawi.</p>
    </div>

    @if (session('status'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="login" :value="'Email atau Username'" />
            <x-text-input id="login" class="block mt-1 w-full" type="text" name="login" :value="old('login')" required autofocus autocomplete="username" placeholder="kamu@email.com atau @username" />
            <x-input-error :messages="$errors->get('login')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="'Password'" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4 block">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-[#e6e6e6] text-[#ff750f] shadow-sm focus:ring-[#ff750f]/20" name="remember" style="accent-color: #ff750f">
                <span class="ms-2 text-sm text-[#555555]">Ingat saya</span>
            </label>
        </div>

        <div class="mt-6">
            <button type="submit" class="btn-primary w-full justify-center">
                Masuk
            </button>
        </div>

        <div class="mt-4 text-center text-sm text-[#555555]">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-[#ff750f] hover:underline">Daftar sekarang</a>
        </div>

        @if (Route::has('password.request'))
            <div class="mt-3 text-center">
                <a href="{{ route('password.request') }}" class="text-sm text-[#555555] hover:text-[#ff750f]">Lupa password?</a>
            </div>
        @endif
    </form>
</x-guest-layout>
