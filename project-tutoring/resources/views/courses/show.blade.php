<x-layouts.app :title="$course->course" :description="Str::limit($course->deskripsi, 150)">
    <div class="mx-auto max-w-4xl px-4 pt-10 sm:px-6">
        <x-breadcrumb :items="['Kelas' => route('courses.index'), $course->course => route('courses.show', $course)]" />

        <header class="mt-8">
            <p class="eyebrow">Kelas oleh {{ $course->user->nama }}</p>
            <h1 class="mt-3 font-display text-4xl leading-tight font-semibold tracking-tight text-ink-900 sm:text-5xl">{{ $course->course }}</h1>
            <p class="mt-5 max-w-prose text-lg leading-8 whitespace-pre-line text-ink-700">{{ $course->deskripsi }}</p>

            <dl class="mt-8 grid gap-y-4 border-y border-rule py-5 text-sm sm:grid-cols-3 sm:divide-x sm:divide-rule">
                <div class="sm:pr-6">
                    <dt class="text-ink-600">Pengajar</dt>
                    <dd class="mt-1 flex items-center gap-2 font-semibold text-ink-900">
                        <x-avatar :user="$course->user" size="sm" /> {{ $course->user->nama }}
                    </dd>
                </div>
                <div class="sm:px-6">
                    <dt class="text-ink-600">Periode</dt>
                    <dd class="tabular mt-1 font-semibold text-ink-900">
                        {{ $course->start_date->translatedFormat('j M Y') }} – {{ $course->end_date->translatedFormat('j M Y') }}
                    </dd>
                </div>
                <div class="sm:pl-6">
                    <dt class="text-ink-600">Isi kelas</dt>
                    <dd class="tabular mt-1 font-semibold text-ink-900">{{ $course->contents->count() }} materi</dd>
                </div>
            </dl>

            @if ($firstContent = $course->contents->first())
                <x-button :href="route('courses.contents.show', [$course, $firstContent])" size="lg" class="mt-8">
                    Mulai dari materi pertama
                    <x-heroicon-m-arrow-long-right class="size-5" aria-hidden="true" />
                </x-button>
            @endif
        </header>

        <section aria-labelledby="materi-heading" class="mt-14">
            <h2 id="materi-heading" class="font-display text-2xl font-semibold text-ink-900">Silabus</h2>

            @if ($course->contents->isEmpty())
                <x-empty-state title="Course ini belum memiliki materi." icon="heroicon-o-document-text" class="mt-5">
                    Materi akan muncul di sini setelah pengajar menambahkannya.
                </x-empty-state>
            @else
                @guest
                    <p class="mt-3 text-sm text-ink-700">
                        Materi pertama bisa dibuka gratis. <a href="{{ route('login') }}" class="link">Masuk</a> atau
                        <a href="{{ route('register') }}" class="link">daftar gratis</a> untuk membuka semua materi dan menyimpan progres belajarmu.
                    </p>
                @endguest

                <ol class="mt-5 border-t border-ink-900">
                    @foreach ($course->contents as $content)
                        @php($locked = auth()->guest() && ! $loop->first)
                        <li class="group relative grid grid-cols-[3rem_1fr] gap-x-4 border-b border-rule py-5 sm:grid-cols-[4rem_1fr_auto]">
                            <span class="tabular font-display text-2xl font-semibold text-ink-300 group-hover:text-marigold-500" aria-hidden="true">
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <div class="min-w-0">
                                <h3 class="font-display text-xl font-semibold text-ink-900">
                                    <a href="{{ route('courses.contents.show', [$course, $content]) }}" class="after:absolute after:inset-0 group-hover:underline decoration-marigold-400 decoration-2 underline-offset-4">
                                        {{ $content->title }}@if ($locked)<span class="sr-only"> (perlu masuk untuk membuka)</span>@endif
                                    </a>
                                </h3>
                                <p class="mt-1 line-clamp-2 text-sm leading-6 text-ink-600">{{ $content->content }}</p>
                            </div>
                            <div class="col-start-2 mt-2 flex gap-3 self-start text-xs font-semibold sm:col-start-3 sm:mt-1 sm:flex-col sm:items-end sm:gap-1.5">
                                @guest
                                    @if ($loop->first)
                                        <span class="rounded-sm bg-marigold-100 px-1.5 py-0.5 text-ink-900">Gratis</span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-ink-600" aria-hidden="true">
                                            <x-heroicon-s-lock-closed class="size-3.5" /> Perlu masuk
                                        </span>
                                    @endif
                                @endguest
                                @if ($content->youtube_embed_url)
                                    <span class="inline-flex items-center gap-1.5 text-ink-700">
                                        <x-heroicon-s-play class="size-3.5" aria-hidden="true" /> Video
                                    </span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ol>
            @endif
        </section>
    </div>
</x-layouts.app>
