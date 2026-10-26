<x-layouts.dashboard title="Ringkasan" :eyebrow="'Halo, '.auth()->user()->nama">
    <section aria-labelledby="statistik-heading">
        <h2 id="statistik-heading" class="sr-only">Statistik</h2>
        <x-dashboard.stats :items="$stats" />
    </section>

    <section aria-labelledby="terbaru-heading" class="space-y-4">
        <div class="flex flex-wrap items-end justify-between gap-3">
            <h2 id="terbaru-heading" class="font-display text-xl font-semibold text-ink-900">
                {{ auth()->user()->isAdmin() ? 'Course terbaru' : 'Course saya' }}
            </h2>
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard.courses.index') }}" class="link text-sm">Semua course</a>
                <x-button :href="route('dashboard.courses.create')" size="sm">Tambah course</x-button>
            </div>
        </div>

        @if ($recentCourses->isEmpty())
            <x-empty-state title="Belum ada course" icon="heroicon-o-book-open">
                Mulai dengan membuat course pertama, lalu tambahkan materinya.
            </x-empty-state>
        @else
            <x-dashboard.table caption="Course terbaru">
                <x-slot:head>
                    <tr>
                        <th scope="col" class="px-5 py-3">Course</th>
                        <th scope="col" class="px-5 py-3">Pengajar</th>
                        <th scope="col" class="px-5 py-3 text-right">Materi</th>
                        <th scope="col" class="px-5 py-3 text-right">Dibuat</th>
                    </tr>
                </x-slot:head>
                @foreach ($recentCourses as $course)
                    <tr class="hover:bg-paper">
                        <td class="px-5 py-3.5 font-medium text-ink-900">
                            <a href="{{ route('courses.show', $course) }}" class="hover:underline">{{ $course->course }}</a>
                        </td>
                        <td class="px-5 py-3.5 whitespace-nowrap">{{ $course->user->nama }}</td>
                        <td class="tabular px-5 py-3.5 text-right">{{ $course->contents_count }}</td>
                        <td class="tabular px-5 py-3.5 text-right whitespace-nowrap">{{ $course->created_at?->translatedFormat('j M Y') ?? '–' }}</td>
                    </tr>
                @endforeach
            </x-dashboard.table>
        @endif
    </section>
</x-layouts.dashboard>
