<x-layouts.app :title="$content->title.' · '.$course->course">
    <div class="mx-auto max-w-6xl px-4 pt-10 sm:px-6">
        <x-breadcrumb :items="[
            'Kelas' => route('courses.index'),
            $course->course => route('courses.show', $course),
            $content->title => route('courses.contents.show', [$course, $content]),
        ]" />

        <div class="mt-8 grid gap-10 lg:grid-cols-12">
            <article class="lg:col-span-8">
                <p class="eyebrow tabular">Materi {{ $position }} dari {{ $course->contents->count() }}</p>
                <h1 class="mt-3 font-display text-4xl leading-tight font-semibold tracking-tight text-ink-900">{{ $content->title }}</h1>
                <p class="mt-3 text-sm text-ink-600">Ditulis oleh {{ $course->user->nama }} untuk kelas {{ $course->course }}</p>

                @if ($content->youtube_embed_url)
                    <div class="mt-8 aspect-video overflow-hidden rounded-md bg-ink-950">
                        <iframe src="{{ $content->youtube_embed_url }}" title="Video materi: {{ $content->title }}"
                                class="size-full" loading="lazy" allowfullscreen
                                allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                    </div>
                @endif

                <div class="mt-8 max-w-prose text-[1.0625rem] leading-8 text-ink-800">
                    <p>{!! nl2br(e($content->content)) !!}</p>
                </div>

                <nav aria-label="Navigasi materi" class="mt-12 grid gap-3 border-t border-ink-900 pt-6 sm:grid-cols-2">
                    @if ($previous)
                        <a href="{{ route('courses.contents.show', [$course, $previous]) }}" class="group rounded-md border border-rule bg-paper-card p-4 hover:border-ink-900">
                            <span class="eyebrow flex items-center gap-1"><x-heroicon-m-arrow-long-left class="size-4" aria-hidden="true" /> Sebelumnya</span>
                            <span class="mt-1 block font-display text-lg font-semibold text-ink-900 group-hover:underline">{{ $previous->title }}</span>
                        </a>
                    @else
                        <a href="{{ route('courses.show', $course) }}" class="group rounded-md border border-rule bg-paper-card p-4 hover:border-ink-900">
                            <span class="eyebrow flex items-center gap-1"><x-heroicon-m-arrow-long-left class="size-4" aria-hidden="true" /> Kembali</span>
                            <span class="mt-1 block font-display text-lg font-semibold text-ink-900 group-hover:underline">Ringkasan kelas</span>
                        </a>
                    @endif

                    @if ($next)
                        <a href="{{ route('courses.contents.show', [$course, $next]) }}" class="group rounded-md bg-ink-900 p-4 text-right text-paper hover:bg-ink-800 sm:col-start-2">
                            <span class="flex items-center justify-end gap-1 text-xs font-semibold tracking-[0.14em] text-ink-300 uppercase">Berikutnya <x-heroicon-m-arrow-long-right class="size-4" aria-hidden="true" /></span>
                            <span class="mt-1 block font-display text-lg font-semibold group-hover:underline">{{ $next->title }}</span>
                        </a>
                    @endif
                </nav>
            </article>

            <aside aria-labelledby="daftar-materi" class="lg:col-span-4">
                <div class="lg:sticky lg:top-24">
                    <h2 id="daftar-materi" class="eyebrow border-b border-ink-900 pb-3">Silabus · {{ $course->course }}</h2>
                    <ol>
                        @foreach ($course->contents as $item)
                            @php($current = $item->is($content))
                            <li class="border-b border-rule">
                                <a href="{{ route('courses.contents.show', [$course, $item]) }}" @if ($current) aria-current="page" @endif
                                   @class([
                                       'flex gap-3 py-3 text-sm',
                                       'font-semibold text-ink-900' => $current,
                                       'text-ink-700 hover:text-ink-900' => ! $current,
                                   ])>
                                    <span @class(['tabular w-6 shrink-0 font-display', 'text-marigold-500' => $current, 'text-ink-500' => ! $current]) aria-hidden="true">
                                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                    <span>{{ $item->title }}</span>
                                    @if ($current)
                                        <span class="ml-auto shrink-0 text-xs font-medium text-ink-600">Sedang dibuka</span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </aside>
        </div>
    </div>
</x-layouts.app>
