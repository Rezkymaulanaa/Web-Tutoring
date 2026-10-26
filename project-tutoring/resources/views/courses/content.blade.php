<x-layouts.app :title="$content->title.' · '.$course->course">
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6">
        <nav aria-label="Breadcrumb" class="text-sm text-slate-600">
            <ol class="flex flex-wrap items-center gap-1">
                <li><a href="{{ route('courses.index') }}" class="hover:text-slate-900 hover:underline">Kelas</a></li>
                <li aria-hidden="true"><x-heroicon-m-chevron-right class="size-4" /></li>
                <li><a href="{{ route('courses.show', $course) }}" class="hover:text-slate-900 hover:underline">{{ $course->course }}</a></li>
                <li aria-hidden="true"><x-heroicon-m-chevron-right class="size-4" /></li>
                <li><a href="{{ route('courses.contents.show', [$course, $content]) }}" aria-current="page" class="font-medium text-slate-900">{{ $content->title }}</a></li>
            </ol>
        </nav>

        <div class="mt-6 grid gap-8 lg:grid-cols-3">
            <article class="lg:col-span-2">
                <h1 class="text-3xl font-bold text-brand-950">{{ $content->title }}</h1>
                <p class="mt-2 text-sm text-slate-600">
                    Materi {{ $position }} dari {{ $course->contents->count() }} · Pengajar: {{ $course->user->nama }}
                </p>

                @if ($content->youtube_embed_url)
                    <div class="mt-6 aspect-video overflow-hidden rounded-xl bg-slate-900 shadow">
                        <iframe src="{{ $content->youtube_embed_url }}" title="Video materi: {{ $content->title }}"
                                class="size-full" loading="lazy" allowfullscreen
                                allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                    </div>
                @endif

                <div class="mt-8 max-w-prose text-base leading-8 text-slate-800">
                    <p>{!! nl2br(e($content->content)) !!}</p>
                </div>

                <nav aria-label="Navigasi materi" class="mt-10 flex flex-wrap justify-between gap-3 border-t border-slate-200 pt-6">
                    @if ($previous)
                        <x-button :href="route('courses.contents.show', [$course, $previous])" variant="secondary">
                            <x-heroicon-m-arrow-left class="size-5" aria-hidden="true" />
                            <span><span class="sr-only">Materi sebelumnya: </span>{{ Str::limit($previous->title, 30) }}</span>
                        </x-button>
                    @else
                        <x-button :href="route('courses.show', $course)" variant="secondary">
                            <x-heroicon-m-arrow-left class="size-5" aria-hidden="true" /> Kembali ke kelas
                        </x-button>
                    @endif

                    @if ($next)
                        <x-button :href="route('courses.contents.show', [$course, $next])">
                            <span><span class="sr-only">Materi berikutnya: </span>{{ Str::limit($next->title, 30) }}</span>
                            <x-heroicon-m-arrow-right class="size-5" aria-hidden="true" />
                        </x-button>
                    @endif
                </nav>
            </article>

            <aside aria-labelledby="daftar-materi" class="lg:sticky lg:top-24 lg:self-start">
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <h2 id="daftar-materi" class="px-2 font-semibold text-slate-900">Daftar materi</h2>
                    <ol class="mt-3 space-y-1">
                        @foreach ($course->contents as $item)
                            @php($current = $item->is($content))
                            <li>
                                <a href="{{ route('courses.contents.show', [$course, $item]) }}" @if ($current) aria-current="page" @endif
                                   @class([
                                       'flex gap-3 rounded-lg px-2 py-2 text-sm',
                                       'bg-brand-50 font-semibold text-brand-800' => $current,
                                       'text-slate-700 hover:bg-slate-100' => ! $current,
                                   ])>
                                    <span class="w-5 shrink-0 text-right" aria-hidden="true">{{ $loop->iteration }}.</span>
                                    <span>{{ $item->title }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </aside>
        </div>
    </div>
</x-layouts.app>
