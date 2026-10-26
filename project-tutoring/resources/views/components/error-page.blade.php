@props(['code', 'title'])

<x-layouts.app :title="$title">
    <div class="mx-auto max-w-xl px-4 py-24 text-center sm:px-6">
        <p class="text-base font-semibold text-brand-700">Error {{ $code }}</p>
        <h1 class="mt-2 text-3xl font-bold text-brand-950 sm:text-4xl">{{ $title }}</h1>
        <p class="mt-4 text-slate-600">{{ $slot }}</p>
        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <x-button :href="route('home')">Kembali ke beranda</x-button>
            <x-button :href="route('courses.index')" variant="secondary">Lihat daftar kelas</x-button>
        </div>
    </div>
</x-layouts.app>
