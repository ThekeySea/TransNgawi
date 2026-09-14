@props(['title', 'description' => null])

<div {{ $attributes->merge(['class' => 'page-header']) }}>
    <div class="container-app">
        <h1 class="text-2xl font-bold tracking-tight text-text md:text-3xl">{{ $title }}</h1>
        @if ($description)
            <p class="mt-2 max-w-2xl text-base text-text-muted">{{ $description }}</p>
        @endif
        @if ($slot->isNotEmpty())
            <div class="mt-4">{{ $slot }}</div>
        @endif
    </div>
</div>
