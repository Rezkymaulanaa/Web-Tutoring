@props(['course', 'headingLevel' => 3])

{{--
    Kartu course bergaya kartu indeks perpustakaan: "punggung" berwarna di kiri (berbeda tiap course),
    nomor kelas, judul serif. Seluruh kartu bisa diklik lewat link di judul (::after menutupi kartu),
    sehingga pembaca layar hanya mendengar satu link dengan nama course yang jelas.
--}}
@php
    $spines = ['bg-ink-900', 'bg-marigold-400', 'bg-[#2f7d6d]', 'bg-[#b5543c]', 'bg-sky', 'bg-[#6b5ca5]'];
    $spine = $spines[$course->id % count($spines)];
@endphp

<article class="group relative flex h-full flex-col rounded-md border border-rule bg-paper-card py-5 pr-5 pl-7 transition-colors hover:border-ink-300 focus-within:border-ink-900">
    <span aria-hidden="true" class="{{ $spine }} absolute inset-y-0 left-0 w-2 rounded-l-md"></span>

    <p class="eyebrow tabular">
        <span class="sr-only">Periode: </span>{{ $course->start_date->translatedFormat('j M') }} – {{ $course->end_date->translatedFormat('j M Y') }}
    </p>

    <h{{ $headingLevel }} class="mt-3 font-display text-2xl leading-tight font-semibold text-ink-900">
        <a href="{{ route('courses.show', $course) }}" class="after:absolute after:inset-0 group-hover:underline decoration-marigold-400 decoration-2 underline-offset-4 focus:outline-none">
            {{ $course->course }}
        </a>
    </h{{ $headingLevel }}>

    <p class="mt-2 line-clamp-3 text-sm leading-6 text-ink-600">{{ $course->deskripsi }}</p>

    <div class="mt-auto pt-5">
        @if (auth()->user()?->isSiswa() && isset($course->contents_count))
            <x-progress :value="$course->progress" :label="'Progres '.$course->course" class="mb-4" />
        @endif

        <div class="flex items-center justify-between gap-2 border-t border-rule pt-4 text-sm text-ink-700">
            <span class="flex min-w-0 items-center gap-2">
                <x-avatar :user="$course->user" size="sm" />
                <span class="truncate"><span class="sr-only">Pengajar: </span>{{ $course->user->nama }}</span>
            </span>
            @isset($course->contents_count)
                <span class="tabular shrink-0 text-ink-600">{{ $course->contents_count }} materi</span>
            @endisset
        </div>
    </div>
</article>
