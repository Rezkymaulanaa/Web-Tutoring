<x-layouts.app>
    {{-- Hero: pesan utama di kiri, indeks kelas asli di kanan --}}
    <section class="mx-auto grid max-w-6xl gap-12 px-4 pt-14 pb-16 sm:px-6 lg:grid-cols-12 lg:pt-20">
        <div class="lg:col-span-7">
            <p class="eyebrow">EduLearn · Kelas daring dari guru</p>
            <h1 class="mt-5 font-display text-5xl leading-[1.05] font-semibold tracking-tight text-ink-900 sm:text-6xl">
                Kelas yang disusun guru,
                <em class="font-normal">dipelajari sesuai ritmemu.</em>
            </h1>
            <p class="mt-6 max-w-xl text-lg leading-8 text-ink-700">
                Setiap kelas berisi materi tertulis dan video yang bisa dibuka kapan saja.
                EduLearn mencatat materi yang sudah kamu buka, jadi kamu selalu tahu sampai mana.
            </p>
            <div class="mt-8 flex flex-wrap items-center gap-3">
                <x-button :href="route('courses.index')" size="lg">Lihat daftar kelas</x-button>
                @guest
                    <x-button :href="route('register')" variant="secondary" size="lg">Buat akun gratis</x-button>
                @endguest
            </div>

            <dl class="mt-12 grid max-w-lg grid-cols-3 divide-x divide-rule border-y border-rule">
                @foreach ([
                    ['label' => 'Siswa terdaftar', 'value' => $stats['siswa']],
                    ['label' => 'Guru bergabung', 'value' => $stats['guru']],
                    ['label' => 'Materi tersedia', 'value' => $stats['materi']],
                ] as $stat)
                    <div class="flex flex-col-reverse justify-end px-4 py-4 first:pl-0">
                        <dt class="mt-1 text-xs text-ink-600">{{ $stat['label'] }}</dt>
                        <dd class="tabular font-display text-3xl font-semibold text-ink-900">{{ number_format($stat['value'], 0, ',', '.') }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>

        <aside aria-labelledby="indeks-heading" class="surface-dark self-start rounded-md bg-ink-900 p-6 text-ink-300 sm:p-8 lg:col-span-5">
            <div class="flex items-baseline justify-between border-b border-white/15 pb-4">
                <h2 id="indeks-heading" class="font-display text-xl font-semibold text-paper">Indeks kelas</h2>
                <p class="text-xs tracking-[0.14em] uppercase">Baru dibuka</p>
            </div>

            @if ($courses->isEmpty())
                <p class="py-6 text-sm">Belum ada kelas. Kelas akan muncul di sini setelah guru membuatnya.</p>
            @else
                <ol class="divide-y divide-white/10">
                    @foreach ($courses->take(5) as $course)
                        <li class="relative flex items-baseline gap-4 py-4">
                            <span class="tabular w-6 shrink-0 font-display text-sm text-marigold-400" aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <div class="min-w-0 flex-1">
                                <a href="{{ route('courses.show', $course) }}" class="font-display text-lg leading-snug text-paper after:absolute after:inset-0 hover:underline decoration-marigold-400 underline-offset-4">
                                    {{ $course->course }}
                                </a>
                                <p class="mt-0.5 truncate text-sm">{{ $course->user->nama }}</p>
                            </div>
                            <span class="tabular shrink-0 text-xs">{{ $course->contents_count }} materi</span>
                        </li>
                    @endforeach
                </ol>
            @endif

            <a href="{{ route('courses.index') }}" class="mt-2 inline-flex items-center gap-1.5 text-sm font-semibold text-marigold-400 hover:underline">
                Semua kelas <x-heroicon-m-arrow-long-right class="size-4" aria-hidden="true" />
            </a>
        </aside>
    </section>

    {{-- Cara belajar --}}
    <section id="tentang" aria-labelledby="tentang-heading" class="border-y border-rule bg-paper-card">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
            <div class="max-w-2xl">
                <p class="eyebrow">Cara belajar</p>
                <h2 id="tentang-heading" class="mt-3 font-display text-3xl font-semibold text-ink-900 sm:text-4xl">Tiga langkah, tanpa jadwal yang mengikat.</h2>
            </div>

            <ol class="mt-10 grid gap-8 md:grid-cols-3 md:gap-10">
                @foreach ([
                    ['title' => 'Pilih kelas', 'text' => 'Cari berdasarkan mata pelajaran atau nama guru. Setiap kelas mencantumkan periode dan jumlah materinya.'],
                    ['title' => 'Pelajari materinya', 'text' => 'Baca penjelasan tertulis, tonton videonya, lalu lanjut ke materi berikutnya dengan satu klik.'],
                    ['title' => 'Lihat progresmu', 'text' => 'Materi yang sudah dibuka tercatat otomatis. Persentasenya tampil di daftar kelas dan di profilmu.'],
                ] as $step)
                    <li class="border-t-2 border-ink-900 pt-5">
                        <p class="tabular font-display text-4xl font-semibold text-marigold-500" aria-hidden="true">{{ $loop->iteration }}</p>
                        <h3 class="mt-3 text-lg font-semibold text-ink-900">{{ $step['title'] }}</h3>
                        <p class="mt-2 leading-7 text-ink-700">{{ $step['text'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- Kelas terbaru --}}
    <section aria-labelledby="populer-heading" class="mx-auto max-w-6xl px-4 pt-16 sm:px-6">
        <div class="flex flex-wrap items-end justify-between gap-4 border-b border-rule pb-5">
            <div>
                <p class="eyebrow">Katalog</p>
                <h2 id="populer-heading" class="mt-3 font-display text-3xl font-semibold text-ink-900 sm:text-4xl">Kelas terbaru</h2>
            </div>
            <a href="{{ route('courses.index') }}" class="link text-sm">Lihat semua kelas</a>
        </div>

        @if ($courses->isEmpty())
            <x-empty-state title="Belum ada kelas" icon="heroicon-o-book-open" class="mt-8">
                Kelas akan muncul di sini setelah guru membuatnya.
            </x-empty-state>
        @else
            <ul class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($courses as $course)
                    <li><x-course-card :course="$course" /></li>
                @endforeach
            </ul>
        @endif
    </section>
</x-layouts.app>
