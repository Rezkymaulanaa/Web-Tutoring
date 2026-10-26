<x-layouts.app title="Profil saya">
    <div class="mx-auto max-w-6xl px-4 pt-12 sm:px-6">
        <header class="flex flex-wrap items-center gap-6 border-b border-rule pb-8">
            <x-avatar :user="$user" size="lg" />
            <div>
                <p class="eyebrow">{{ $user->role->value }}</p>
                <h1 class="mt-2 font-display text-4xl font-semibold tracking-tight text-ink-900">{{ $user->nama }}</h1>
                <dl class="mt-2 flex flex-wrap gap-x-6 gap-y-1 text-sm text-ink-700">
                    <div class="flex gap-1.5"><dt class="text-ink-600">Username</dt><dd class="font-medium text-ink-900">{{ $user->username }}</dd></div>
                    <div class="flex gap-1.5"><dt class="text-ink-600">Email</dt><dd class="font-medium text-ink-900">{{ $user->email }}</dd></div>
                </dl>
            </div>
            @unless ($user->isSiswa())
                <x-button :href="route('dashboard')" variant="secondary" class="sm:ml-auto">Buka dashboard</x-button>
            @endunless
        </header>

        <div class="mt-10 grid gap-12 lg:grid-cols-12">
            <div class="lg:col-span-8">
                @if ($user->isSiswa())
                    <section aria-labelledby="belajar-heading">
                        <h2 id="belajar-heading" class="font-display text-2xl font-semibold text-ink-900">Kelas yang sedang saya ikuti</h2>
                        @if ($learningCourses->isEmpty())
                            <x-empty-state title="Belum ada kelas yang diikuti" icon="heroicon-o-academic-cap" class="mt-5">
                                <a href="{{ route('courses.index') }}" class="link">Jelajahi kelas</a> untuk mulai belajar.
                            </x-empty-state>
                        @else
                            <ul class="mt-5 border-t border-ink-900">
                                @foreach ($learningCourses as $course)
                                    <li class="group relative grid gap-3 border-b border-rule py-5 sm:grid-cols-[1fr_14rem] sm:items-center sm:gap-8">
                                        <div>
                                            <h3 class="font-display text-xl font-semibold text-ink-900">
                                                <a href="{{ route('courses.show', $course) }}" class="after:absolute after:inset-0 group-hover:underline decoration-marigold-400 decoration-2 underline-offset-4">{{ $course->course }}</a>
                                            </h3>
                                            <p class="mt-1 text-sm text-ink-600">{{ $course->user->nama }} · {{ $course->contents_count }} materi</p>
                                        </div>
                                        <x-progress :value="$course->progress" :label="'Progres '.$course->course" />
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </section>
                @else
                    <section aria-labelledby="mengajar-heading">
                        <h2 id="mengajar-heading" class="font-display text-2xl font-semibold text-ink-900">Course yang saya ajar</h2>
                        @if ($courses->isEmpty())
                            <x-empty-state title="Belum ada course" icon="heroicon-o-book-open" class="mt-5">
                                <a href="{{ route('dashboard.courses.create') }}" class="link">Buat course pertama</a> dari dashboard.
                            </x-empty-state>
                        @else
                            <ul class="mt-5 border-t border-ink-900">
                                @foreach ($courses as $course)
                                    <li class="border-b border-rule">
                                        <a href="{{ route('courses.show', $course) }}" class="flex items-center justify-between gap-4 py-4 font-display text-lg font-semibold text-ink-900 hover:underline decoration-marigold-400 decoration-2 underline-offset-4">
                                            {{ $course->course }}
                                            <x-heroicon-m-arrow-long-right class="size-5 shrink-0 text-ink-500" aria-hidden="true" />
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </section>
                @endif
            </div>

            @unless ($user->isAdmin())
                <aside aria-labelledby="rekan-heading" class="lg:col-span-4">
                    <h2 id="rekan-heading" class="eyebrow border-b border-ink-900 pb-3">Sesama {{ $user->role->value }}</h2>
                    @if ($associatedUsers->isEmpty())
                        <p class="mt-4 text-sm text-ink-600">Belum ada.</p>
                    @else
                        <ul class="max-h-96 divide-y divide-rule overflow-y-auto">
                            @foreach ($associatedUsers as $other)
                                <li class="flex items-center gap-3 py-3">
                                    <x-avatar :user="$other" size="sm" />
                                    <span class="text-sm text-ink-800">{{ $other->nama }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </aside>
            @endunless
        </div>
    </div>
</x-layouts.app>
