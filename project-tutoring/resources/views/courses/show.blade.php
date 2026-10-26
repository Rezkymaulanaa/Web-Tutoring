<x-layouts.app :title="$course->course" :description="Str::limit($course->deskripsi, 150)">
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6">
        <nav aria-label="Breadcrumb" class="text-sm text-slate-600">
            <ol class="flex flex-wrap items-center gap-1">
                <li><a href="{{ route('courses.index') }}" class="hover:text-slate-900 hover:underline">Kelas</a></li>
                <li aria-hidden="true"><x-heroicon-m-chevron-right class="size-4" /></li>
                <li><a href="{{ route('courses.show', $course) }}" aria-current="page" class="font-medium text-slate-900">{{ $course->course }}</a></li>
            </ol>
        </nav>

        <div class="mt-6 grid gap-8 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <h1 class="text-3xl font-bold text-brand-950 sm:text-4xl">{{ $course->course }}</h1>
                <p class="mt-4 leading-7 whitespace-pre-line text-slate-700">{{ $course->deskripsi }}</p>

                <section aria-labelledby="materi-heading" class="mt-10">
                    <h2 id="materi-heading" class="text-xl font-bold text-slate-900">Daftar materi</h2>

                    @if ($course->contents->isEmpty())
                        <x-empty-state title="Course ini belum memiliki materi." icon="heroicon-o-document-text" class="mt-4">
                            Materi akan muncul di sini setelah pengajar menambahkannya.
                        </x-empty-state>
                    @else
                        <ol class="mt-4 divide-y divide-slate-200 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                            @foreach ($course->contents as $content)
                                <li class="relative flex gap-4 p-4 hover:bg-slate-50 focus-within:bg-slate-50">
                                    <span class="flex size-8 shrink-0 items-center justify-center rounded-full bg-brand-50 text-sm font-semibold text-brand-800" aria-hidden="true">
                                        {{ $loop->iteration }}
                                    </span>
                                    <div class="min-w-0">
                                        <h3 class="font-semibold text-slate-900">
                                            <a href="{{ route('courses.contents.show', [$course, $content]) }}" class="after:absolute after:inset-0">
                                                {{ $content->title }}
                                            </a>
                                        </h3>
                                        <p class="mt-1 line-clamp-2 text-sm text-slate-600">{{ $content->content }}</p>
                                    </div>
                                    @if ($content->youtube_embed_url)
                                        <span class="ml-auto flex shrink-0 items-center gap-1 self-center text-xs font-medium text-slate-600">
                                            <x-heroicon-s-play-circle class="size-4 text-brand-700" aria-hidden="true" /> Video
                                        </span>
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </section>
            </div>

            <aside aria-label="Informasi kelas" class="lg:sticky lg:top-24 lg:self-start">
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <dl class="space-y-4 text-sm">
                        <div>
                            <dt class="text-slate-600">Pengajar</dt>
                            <dd class="mt-1 flex items-center gap-2 font-medium text-slate-900">
                                <x-avatar :user="$course->user" size="sm" /> {{ $course->user->nama }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-slate-600">Periode</dt>
                            <dd class="mt-1 font-medium text-slate-900">
                                {{ $course->start_date->translatedFormat('j F Y') }} – {{ $course->end_date->translatedFormat('j F Y') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-slate-600">Jumlah materi</dt>
                            <dd class="mt-1 font-medium text-slate-900">{{ $course->contents->count() }} materi</dd>
                        </div>
                    </dl>

                    @if ($firstContent = $course->contents->first())
                        <x-button :href="route('courses.contents.show', [$course, $firstContent])" class="mt-6 w-full">
                            <x-heroicon-s-play class="size-5" aria-hidden="true" /> Mulai belajar
                        </x-button>
                    @endif
                </div>
            </aside>
        </div>
    </div>
</x-layouts.app>
