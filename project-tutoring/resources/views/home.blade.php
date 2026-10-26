<x-layouts.app>
    {{-- Hero --}}
    <section class="bg-white">
        <div class="mx-auto grid max-w-6xl items-center gap-10 px-4 py-16 sm:px-6 md:grid-cols-2 md:py-24">
            <div>
                <p class="inline-flex items-center gap-2 rounded-full bg-accent-100 px-3 py-1 text-sm font-medium text-slate-900">
                    <x-heroicon-s-sparkles class="size-4 text-accent-500" aria-hidden="true" />
                    Ingin belajar dengan mudah?
                </p>
                <h1 class="mt-5 text-4xl font-bold tracking-tight text-brand-950 sm:text-5xl">
                    Belajar di mana saja, kapan saja.
                </h1>
                <p class="mt-5 max-w-prose text-lg leading-8 text-slate-600">
                    Materi yang mudah dipahami, dilengkapi video, dan disusun langsung oleh guru. Pantau progres belajarmu di setiap kelas.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <x-button :href="route('courses.index')" size="lg">
                        Jelajahi kelas
                        <x-heroicon-m-arrow-right class="size-5" aria-hidden="true" />
                    </x-button>
                    @guest
                        <x-button :href="route('register')" variant="secondary" size="lg">Daftar gratis</x-button>
                    @endguest
                </div>
            </div>
            <img src="{{ asset('images/edu-logo.png') }}" alt="" width="560" height="420" class="mx-auto w-full max-w-md">
        </div>
    </section>

    {{-- Statistik asli dari database --}}
    <section id="tentang" aria-labelledby="tentang-heading" class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        <h2 id="tentang-heading" class="text-center text-3xl font-bold text-brand-950">Tentang EduLearn</h2>
        <p class="mx-auto mt-3 max-w-2xl text-center text-slate-600">
            EduLearn mempertemukan guru dan siswa dalam satu tempat: guru menyusun materi, siswa belajar sesuai kecepatannya sendiri.
        </p>

        <dl class="mt-10 grid gap-6 sm:grid-cols-3">
            @foreach ([
                ['label' => 'Siswa terdaftar', 'value' => $stats['siswa'], 'image' => 'students-logo.png'],
                ['label' => 'Guru bergabung', 'value' => $stats['guru'], 'image' => 'teachers-logo.png'],
                ['label' => 'Materi tersedia', 'value' => $stats['materi'], 'image' => 'courses-logo.png'],
            ] as $stat)
                <div class="flex flex-col items-center rounded-xl border border-slate-200 bg-white p-6 text-center shadow-sm">
                    <img src="{{ asset('images/'.$stat['image']) }}" alt="" width="96" height="96" class="size-24 object-contain">
                    <dt class="order-last mt-1 text-slate-600">{{ $stat['label'] }}</dt>
                    <dd class="mt-4 text-4xl font-bold text-brand-700">{{ number_format($stat['value'], 0, ',', '.') }}</dd>
                </div>
            @endforeach
        </dl>
    </section>

    {{-- Course terbaru --}}
    <section aria-labelledby="populer-heading" class="mx-auto max-w-6xl px-4 py-8 sm:px-6">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <h2 id="populer-heading" class="text-3xl font-bold text-brand-950">Kelas terbaru</h2>
                <p class="mt-2 text-slate-600">Mulai dari kelas yang baru saja dibuka.</p>
            </div>
            <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-1 font-semibold text-brand-700 hover:underline">
                Lihat semua kelas <x-heroicon-m-arrow-right class="size-4" aria-hidden="true" />
            </a>
        </div>

        @if ($courses->isEmpty())
            <x-empty-state title="Belum ada kelas" icon="heroicon-o-book-open" class="mt-8">
                Kelas akan muncul di sini setelah guru membuatnya.
            </x-empty-state>
        @else
            <ul class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($courses as $course)
                    <li><x-course-card :course="$course" /></li>
                @endforeach
            </ul>
        @endif
    </section>
</x-layouts.app>
