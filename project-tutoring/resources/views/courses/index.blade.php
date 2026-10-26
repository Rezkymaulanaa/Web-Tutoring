<x-layouts.app title="Daftar Kelas">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
        <h1 class="text-3xl font-bold text-brand-950">Daftar kelas</h1>
        <p class="mt-2 text-slate-600">Cari kelas berdasarkan nama kelas atau nama pengajarnya.</p>

        <form method="GET" action="{{ route('courses.index') }}" role="search" class="mt-6 flex max-w-xl gap-2">
            <label for="search" class="sr-only">Cari kelas atau pengajar</label>
            <div class="relative flex-1">
                <x-heroicon-o-magnifying-glass class="pointer-events-none absolute top-1/2 left-3 size-5 -translate-y-1/2 text-slate-500" aria-hidden="true" />
                <input id="search" type="search" name="search" value="{{ $searchTerm }}" placeholder="Contoh: Matematika"
                       class="block min-h-11 w-full rounded-lg border-slate-500 pl-10 shadow-sm placeholder:text-slate-500 focus:border-brand-600 focus:ring-brand-600">
            </div>
            <x-button>Cari</x-button>
        </form>

        {{-- Jumlah hasil dibacakan pembaca layar setelah pencarian --}}
        <p role="status" class="mt-6 text-sm text-slate-600">
            @if ($searchTerm)
                {{ $courses->count() }} kelas ditemukan untuk “{{ $searchTerm }}”.
                <a href="{{ route('courses.index') }}" class="font-medium text-brand-700 hover:underline">Hapus pencarian</a>
            @else
                {{ $courses->count() }} kelas tersedia.
            @endif
        </p>

        @if ($courses->isEmpty())
            <x-empty-state title="Kelas tidak ditemukan" icon="heroicon-o-magnifying-glass" class="mt-6">
                Coba kata kunci lain, atau periksa kembali ejaannya.
            </x-empty-state>
        @else
            <ul class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($courses as $course)
                    <li><x-course-card :course="$course" :heading-level="2" /></li>
                @endforeach
            </ul>
        @endif
    </div>
</x-layouts.app>
