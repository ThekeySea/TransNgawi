@extends('layouts.customer')

@section('title', 'Profil Saya')

@section('content')
    <section class="bg-[#faf9f8] py-16 md:py-24">
        <div class="container-app">
            <div class="mb-8 max-w-2xl">
                <h1 class="text-3xl font-bold tracking-tight text-[#1a1a1a] sm:text-4xl">Profil Saya</h1>
                <p class="mt-3 text-base text-[#555555]">Kelola data akun dan lihat perjalananmu.</p>
            </div>

            @if (session('status') === 'profile-updated')
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-6 py-4 text-sm font-medium text-green-700">
                    Profil berhasil diperbarui.
                </div>
            @endif

            @if (session('status') === 'password-updated')
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-6 py-4 text-sm font-medium text-green-700">
                    Password berhasil diperbarui.
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                {{-- Profile Card --}}
                <div class="card px-6 py-6 md:px-8">
                    <div class="flex flex-col items-center text-center">
                        @if (auth()->user()->profile_photo_path)
                            <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="h-20 w-20 rounded-2xl object-cover">
                        @else
                            <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-[#ff750f]/10">
                                <span class="text-3xl font-bold text-[#ff750f]">{{ auth()->user()->initial }}</span>
                            </div>
                        @endif
                        <p class="mt-4 text-xl font-bold text-[#1a1a1a]">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-[#555555]">{{ auth()->user()->username }}</p>
                        <p class="mt-1 text-sm text-[#555555]">{{ auth()->user()->email }}</p>
                        <p class="mt-1 text-sm text-[#555555]">{{ auth()->user()->phone_number }}</p>
                        <p class="mt-3 text-xs text-[#555555]">Bergabung {{ auth()->user()->created_at->translatedFormat('d M Y') }}</p>
                    </div>
                    <div class="mt-6 flex flex-col gap-3 border-t border-[#e6e6e6] pt-6">
                        <a href="{{ route('my-trips.index') }}" class="btn-secondary w-full justify-center text-center">Perjalanan Saya</a>
                    </div>
                </div>

                {{-- Edit Profile Form --}}
                <div class="card px-6 py-6 md:px-8 lg:col-span-2">
                    <h2 class="mb-6 text-lg font-bold text-[#1a1a1a]">Ubah Profil</h2>
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div>
                                <label for="name" class="input-label">Nama Lengkap</label>
                                <input id="name" type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required class="w-full rounded-lg border border-[#e6e6e6] px-3 py-2 text-sm focus:border-[#ff750f] focus:outline-none">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="phone_number" class="input-label">Nomor Telepon</label>
                                <input id="phone_number" type="tel" name="phone_number" value="{{ old('phone_number', auth()->user()->phone_number) }}" required class="w-full rounded-lg border border-[#e6e6e6] px-3 py-2 text-sm focus:border-[#ff750f] focus:outline-none">
                                @error('phone_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-5">
                            <label for="profile_photo" class="input-label">Foto Profil</label>
                            <input id="profile_photo" type="file" name="profile_photo" accept="image/jpeg,image/png,image/webp" class="w-full rounded-lg border border-[#e6e6e6] px-3 py-2 text-sm focus:border-[#ff750f] focus:outline-none">
                            <p class="mt-1 text-xs text-[#555555]">Format: JPG, PNG, WebP. Maksimal 2MB.</p>
                            @error('profile_photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6 flex gap-3">
                            <button type="submit" class="btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>

                    <hr class="my-8 border-[#e6e6e6]">

                    <h2 class="mb-4 text-lg font-bold text-[#1a1a1a]">Ubah Password</h2>
                    <a href="{{ route('profile.password') }}" class="btn-secondary">Ubah Password</a>
                </div>
            </div>
        </div>
    </section>
@endsection
