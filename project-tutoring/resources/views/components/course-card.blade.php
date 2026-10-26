@props(['course', 'headingLevel' => 3])

{{--
    Seluruh kartu bisa diklik lewat link di judul (pseudo-element ::after menutupi kartu),
    sehingga pembaca layar hanya mendengar satu link dengan nama course yang jelas.
--}}
<article class="group relative flex flex-col overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md focus-within:ring-3 focus-within:ring-brand-600">
    <div class="flex h-28 items-end bg-gradient-to-br from-brand-700 to-brand-950 p-4">
        <x-heroicon-o-book-open class="size-10 text-white/80" aria-hidden="true" />
    </div>

    <div class="flex flex-1 flex-col gap-3 p-5">
        <p class="text-xs font-medium text-slate-600">
            {{ $course->start_date->translatedFormat('j M Y') }} – {{ $course->end_date->translatedFormat('j M Y') }}
        </p>

        <h{{ $headingLevel }} class="text-lg font-semibold text-slate-900">
            <a href="{{ route('courses.show', $course) }}" class="after:absolute after:inset-0 focus:outline-none">
                {{ $course->course }}
            </a>
        </h{{ $headingLevel }}>

        <p class="line-clamp-3 text-sm leading-6 text-slate-600">{{ $course->deskripsi }}</p>

        <div class="mt-auto space-y-3 pt-2">
            @if (auth()->user()?->isSiswa() && isset($course->contents_count))
                <x-progress :value="$course->progress" :label="'Progres '.$course->course" />
            @endif

            <div class="flex items-center justify-between gap-2 text-sm text-slate-600">
                <span class="flex items-center gap-2">
                    <x-avatar :user="$course->user" size="sm" />
                    <span><span class="sr-only">Pengajar: </span>{{ $course->user->nama }}</span>
                </span>
                @isset($course->contents_count)
                    <span class="flex items-center gap-1">
                        <x-heroicon-o-document-text class="size-4" aria-hidden="true" />
                        {{ $course->contents_count }} materi
                    </span>
                @endisset
            </div>
        </div>
    </div>
</article>
