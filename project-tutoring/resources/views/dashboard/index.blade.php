<x-layouts.dashboard title="Ringkasan">
    <p class="text-slate-600">Selamat datang kembali, <span class="font-semibold text-slate-900">{{ auth()->user()->nama }}</span>.</p>

    <section aria-labelledby="statistik-heading">
        <h2 id="statistik-heading" class="sr-only">Statistik</h2>
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($stats as $stat)
                <x-dashboard.stat-card :label="$stat['label']" :value="$stat['value']" :icon="$stat['icon']" />
            @endforeach
        </div>
    </section>

    <section aria-labelledby="terbaru-heading" class="space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 id="terbaru-heading" class="text-lg font-semibold text-slate-900">
                {{ auth()->user()->isAdmin() ? 'Course terbaru' : 'Course saya' }}
            </h2>
            <x-button :href="route('dashboard.courses.create')" size="sm">
                <x-heroicon-m-plus class="size-4" aria-hidden="true" /> Tambah course
            </x-button>
        </div>

        @if ($recentCourses->isEmpty())
            <x-empty-state title="Belum ada course" icon="heroicon-o-book-open">
                Mulai dengan membuat course pertama, lalu tambahkan materinya.
            </x-empty-state>
        @else
            <x-dashboard.table caption="Course terbaru">
                <x-slot:head>
                    <tr>
                        <th scope="col" class="px-4 py-3">Course</th>
                        <th scope="col" class="px-4 py-3">Pengajar</th>
                        <th scope="col" class="px-4 py-3">Materi</th>
                        <th scope="col" class="px-4 py-3">Dibuat</th>
                    </tr>
                </x-slot:head>
                @foreach ($recentCourses as $course)
                    <tr>
                        <td class="px-4 py-3 font-medium text-slate-900">
                            <a href="{{ route('courses.show', $course) }}" class="hover:text-brand-700 hover:underline">{{ $course->course }}</a>
                        </td>
                        <td class="px-4 py-3">{{ $course->user->nama }}</td>
                        <td class="px-4 py-3">{{ $course->contents_count }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $course->created_at?->translatedFormat('j M Y') ?? '–' }}</td>
                    </tr>
                @endforeach
            </x-dashboard.table>
        @endif
    </section>
</x-layouts.dashboard>
