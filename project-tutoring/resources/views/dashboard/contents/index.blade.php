<x-layouts.dashboard title="Materi">
    <x-slot:actions>
        <x-button :href="route('dashboard.contents.create')" size="sm">
            Tambah materi
        </x-button>
    </x-slot:actions>

    @if ($contents->isEmpty())
        <x-empty-state title="Belum ada materi" icon="heroicon-o-document-text">
            Klik “Tambah materi” untuk menulis materi pertama.
        </x-empty-state>
    @else
        <x-dashboard.table caption="Daftar materi">
            <x-slot:head>
                <tr>
                    <th scope="col" class="px-5 py-3 text-right">Materi</th>
                    <th scope="col" class="px-5 py-3">Course</th>
                    <th scope="col" class="px-5 py-3">Video</th>
                    <th scope="col" class="px-5 py-3">Diperbarui</th>
                    <th scope="col" class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </x-slot:head>
            @foreach ($contents as $content)
                <tr class="hover:bg-paper">
                    <td class="px-5 py-3.5">
                        <a href="{{ route('courses.contents.show', [$content->course, $content]) }}" class="font-medium text-ink-900 hover:text-ink-900 hover:underline">{{ $content->title }}</a>
                        <p class="mt-0.5 line-clamp-1 max-w-md text-ink-600">{{ $content->content }}</p>
                    </td>
                    <td class="px-5 py-3.5">{{ $content->course->course }}</td>
                    <td class="px-5 py-3.5">
                        @if ($content->youtube_embed_url)
                            <span class="inline-flex items-center gap-1 rounded-full bg-success-soft px-2 py-0.5 text-xs font-medium text-success">
                                <x-heroicon-s-play-circle class="size-4" aria-hidden="true" /> Ada
                            </span>
                        @else
                            <span class="text-ink-600">Tidak ada</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 whitespace-nowrap">{{ $content->updated_at?->translatedFormat('j M Y') ?? '–' }}</td>
                    <td class="px-5 py-3.5">
                        @can('update', $content)
                            <x-dashboard.row-actions :edit-url="route('dashboard.contents.edit', $content)"
                                                     :delete-url="route('dashboard.contents.destroy', $content)"
                                                     :name="$content->title"
                                                     :confirm="'Hapus materi “'.$content->title.'”?'" />
                        @endcan
                    </td>
                </tr>
            @endforeach
        </x-dashboard.table>
    @endif
</x-layouts.dashboard>
