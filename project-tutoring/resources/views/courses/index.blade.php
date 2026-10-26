<x-layouts.app title="Daftar Kelas">
    <div class="mx-auto max-w-6xl px-4 pt-12 sm:px-6">
        <div class="grid gap-8 border-b border-rule pb-8 lg:grid-cols-12 lg:items-end">
            <div class="lg:col-span-7">
                <p class="eyebrow">Katalog</p>
                <h1 class="mt-3 font-display text-4xl font-semibold tracking-tight text-ink-900 sm:text-5xl">Daftar kelas</h1>
                <p class="mt-3 text-ink-700">Cari berdasarkan nama kelas atau nama gurunya.</p>
            </div>

            <form method="GET" action="{{ route('courses.index') }}" role="search" class="flex gap-2 lg:col-span-5">
                <label for="search" class="sr-only">Cari kelas atau pengajar</label>
                <div class="relative flex-1">
                    <x-heroicon-o-magnifying-glass class="pointer-events-none absolute top-1/2 left-3 size-5 -translate-y-1/2 text-ink-600" aria-hidden="true" />
                    <input id="search" type="search" name="search" value="{{ $searchTerm }}" placeholder="Contoh: Matematika"
                           class="block min-h-11 w-full rounded-md border-ink-500 bg-paper-card pl-10 placeholder:text-ink-500 focus:border-ink-900 focus:ring-ink-900">
                </div>
                <x-button>Cari</x-button>
            </form>
        </div>

        {{-- Jumlah hasil dibacakan pembaca layar setelah pencarian --}}
        <p role="status" class="mt-5 text-sm text-ink-600">
            @if ($searchTerm)
                <span class="tabular font-semibold text-ink-900">{{ $courses->count() }}</span> kelas cocok dengan “{{ $searchTerm }}”.
                <a href="{{ route('courses.index') }}" class="link ml-1">Hapus pencarian</a>
            @else
                <span class="tabular font-semibold text-ink-900">{{ $courses->count() }}</span> kelas tersedia.
            @endif
        </p>

        @if ($courses->isEmpty())
            <x-empty-state title="Kelas tidak ditemukan" icon="heroicon-o-magnifying-glass" class="mt-6">
                Coba kata kunci lain, atau periksa kembali ejaannya.
            </x-empty-state>
        @else
            <ul class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($courses as $course)
                    <li><x-course-card :course="$course" :heading-level="2" /></li>
                @endforeach
            </ul>
        @endif
    </div>
</x-layouts.app>
