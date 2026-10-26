<x-layouts.app title="Profil saya">
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6">
        <div class="grid gap-8 lg:grid-cols-3">
            <div class="space-y-8 lg:col-span-2">
                <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="h-28 bg-gradient-to-r from-brand-700 to-brand-950"></div>
                    <div class="px-6 pb-6">
                        <x-avatar :user="$user" size="lg" class="-mt-10 ring-4 ring-white" />
                        <h1 class="mt-4 text-2xl font-bold text-slate-900">{{ $user->nama }}</h1>
                        <p class="text-slate-600">{{ '@'.$user->username }}</p>

                        <dl class="mt-6 grid gap-4 text-sm sm:grid-cols-2">
                            <div class="flex items-center gap-3">
                                <x-heroicon-o-envelope class="size-5 text-slate-500" aria-hidden="true" />
                                <div>
                                    <dt class="text-slate-600">Email</dt>
                                    <dd class="font-medium text-slate-900">{{ $user->email }}</dd>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <x-heroicon-o-identification class="size-5 text-slate-500" aria-hidden="true" />
                                <div>
                                    <dt class="text-slate-600">Tipe akun</dt>
                                    <dd class="font-medium text-slate-900">{{ $user->role->value }}</dd>
                                </div>
                            </div>
                        </dl>
                    </div>
                </section>

                @if ($user->isSiswa())
                    <section aria-labelledby="belajar-heading">
                        <h2 id="belajar-heading" class="text-xl font-bold text-slate-900">Kelas yang sedang saya ikuti</h2>
                        @if ($learningCourses->isEmpty())
                            <x-empty-state title="Belum ada kelas yang diikuti" icon="heroicon-o-academic-cap" class="mt-4">
                                <a href="{{ route('courses.index') }}" class="font-medium text-brand-700 hover:underline">Jelajahi kelas</a> untuk mulai belajar.
                            </x-empty-state>
                        @else
                            <ul class="mt-4 space-y-3">
                                @foreach ($learningCourses as $course)
                                    <li class="relative rounded-xl border border-slate-200 bg-white p-4 shadow-sm hover:shadow-md">
                                        <h3 class="font-semibold text-slate-900">
                                            <a href="{{ route('courses.show', $course) }}" class="after:absolute after:inset-0">{{ $course->course }}</a>
                                        </h3>
                                        <p class="text-sm text-slate-600">Pengajar: {{ $course->user->nama }}</p>
                                        <x-progress :value="$course->progress" :label="'Progres '.$course->course" class="mt-3" />
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </section>
                @else
                    <section aria-labelledby="mengajar-heading">
                        <h2 id="mengajar-heading" class="text-xl font-bold text-slate-900">Course yang saya ajar</h2>
                        @if ($courses->isEmpty())
                            <x-empty-state title="Belum ada course" icon="heroicon-o-book-open" class="mt-4">
                                <a href="{{ route('dashboard.courses.create') }}" class="font-medium text-brand-700 hover:underline">Buat course pertama</a> dari dashboard.
                            </x-empty-state>
                        @else
                            <ul class="mt-4 flex flex-wrap gap-2">
                                @foreach ($courses as $course)
                                    <li>
                                        <a href="{{ route('courses.show', $course) }}" class="inline-flex min-h-10 items-center rounded-full border border-slate-300 bg-white px-4 text-sm font-medium text-slate-800 hover:border-brand-600 hover:text-brand-700">
                                            {{ $course->course }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </section>
                @endif
            </div>

            @unless ($user->isAdmin())
                <aside aria-labelledby="rekan-heading" class="lg:self-start">
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 id="rekan-heading" class="font-semibold text-slate-900">Sesama {{ $user->role->value }}</h2>
                        @if ($associatedUsers->isEmpty())
                            <p class="mt-3 text-sm text-slate-600">Belum ada.</p>
                        @else
                            <ul class="mt-4 max-h-96 space-y-3 overflow-y-auto">
                                @foreach ($associatedUsers as $other)
                                    <li class="flex items-center gap-3">
                                        <x-avatar :user="$other" size="sm" />
                                        <span class="text-sm text-slate-800">{{ $other->nama }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </aside>
            @endunless
        </div>
    </div>
</x-layouts.app>
