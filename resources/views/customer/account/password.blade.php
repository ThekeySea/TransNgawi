@extends('layouts.customer')

@section('title', 'Ubah Password')

@section('content')
    <section class="bg-[#faf9f8] py-16 md:py-24">
        <div class="container-app">
            <div class="mb-8 max-w-2xl">
                <h1 class="text-3xl font-bold tracking-tight text-[#1a1a1a] sm:text-4xl">Ubah Password</h1>
                <p class="mt-3 text-base text-[#555555]">Pastikan akunmu tetap aman dengan password yang kuat.</p>
            </div>

            <div class="card max-w-lg px-6 py-6 md:px-8">
                <form method="POST" action="{{ route('profile.password.update') }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="input-label">Password Saat Ini</label>
                        <input id="current_password" type="password" name="current_password" required class="w-full rounded-lg border border-[#e6e6e6] px-3 py-2 text-sm focus:border-[#ff750f] focus:outline-none" autocomplete="current-password">
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-5">
                        <label for="password" class="input-label">Password Baru</label>
                        <input id="password" type="password" name="password" required class="w-full rounded-lg border border-[#e6e6e6] px-3 py-2 text-sm focus:border-[#ff750f] focus:outline-none" autocomplete="new-password">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-5">
                        <label for="password_confirmation" class="input-label">Konfirmasi Password Baru</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full rounded-lg border border-[#e6e6e6] px-3 py-2 text-sm focus:border-[#ff750f] focus:outline-none" autocomplete="new-password">
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="btn-primary">Simpan Password</button>
                        <a href="{{ route('profile.index') }}" class="btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
