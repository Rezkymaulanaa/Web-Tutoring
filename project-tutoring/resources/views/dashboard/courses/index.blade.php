<x-layouts.dashboard title="Course">
    <x-slot:actions>
        <x-button :href="route('dashboard.courses.create')" size="sm">
            Tambah course
        </x-button>
    </x-slot:actions>

    @if ($courses->isEmpty())
        <x-empty-state title="Belum ada course" icon="heroicon-o-book-open">
            Klik “Tambah course” untuk membuat course pertama.
        </x-empty-state>
    @else
        <x-dashboard.table caption="Daftar course">
            <x-slot:head>
                <tr>
                    <th scope="col" class="px-5 py-3">Course</th>
                    @if (auth()->user()->isAdmin())
                        <th scope="col" class="px-5 py-3">Pengajar</th>
                    @endif
                    <th scope="col" class="px-5 py-3">Periode</th>
                    <th scope="col" class="px-5 py-3 text-right">Materi</th>
                    <th scope="col" class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </x-slot:head>
            @foreach ($courses as $course)
                <tr class="hover:bg-paper">
                    <td class="px-5 py-3.5">
                        <a href="{{ route('courses.show', $course) }}" class="font-medium text-ink-900 hover:text-ink-900 hover:underline">{{ $course->course }}</a>
                        <p class="mt-0.5 line-clamp-1 max-w-md text-ink-600">{{ $course->deskripsi }}</p>
                    </td>
                    @if (auth()->user()->isAdmin())
                        <td class="px-5 py-3.5 whitespace-nowrap">{{ $course->user->nama }}</td>
                    @endif
                    <td class="px-5 py-3.5 whitespace-nowrap">
                        {{ $course->start_date->translatedFormat('j M Y') }} – {{ $course->end_date->translatedFormat('j M Y') }}
                    </td>
                    <td class="tabular px-5 py-3.5 text-right">{{ $course->contents_count }}</td>
                    <td class="px-5 py-3.5">
                        @can('update', $course)
                            <x-dashboard.row-actions :edit-url="route('dashboard.courses.edit', $course)"
                                                     :delete-url="route('dashboard.courses.destroy', $course)"
                                                     :name="$course->course"
                                                     :confirm="'Hapus course “'.$course->course.'” beserta semua materinya?'" />
                        @endcan
                    </td>
                </tr>
            @endforeach
        </x-dashboard.table>
    @endif
</x-layouts.dashboard>
