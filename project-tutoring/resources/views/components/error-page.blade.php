@props(['code', 'title'])

<x-layouts.app :title="$title">
    <div class="mx-auto max-w-3xl px-4 py-20 sm:px-6">
        <p class="tabular font-display text-8xl font-semibold text-marigold-400" aria-hidden="true">{{ $code }}</p>
        <p class="eyebrow mt-6">Error {{ $code }}</p>
        <h1 class="mt-2 font-display text-4xl font-semibold tracking-tight text-ink-900">{{ $title }}</h1>
        <p class="mt-4 max-w-prose text-lg leading-8 text-ink-700">{{ $slot }}</p>
        <div class="mt-8 flex flex-wrap gap-3">
            <x-button :href="route('home')">Kembali ke beranda</x-button>
            <x-button :href="route('courses.index')" variant="secondary">Lihat daftar kelas</x-button>
        </div>
    </div>
</x-layouts.app>
