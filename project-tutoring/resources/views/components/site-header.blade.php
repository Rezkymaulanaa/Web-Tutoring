@php
    $links = [
        ['label' => 'Beranda', 'href' => route('home'), 'active' => request()->routeIs('home')],
        ['label' => 'Kelas', 'href' => route('courses.index'), 'active' => request()->routeIs('courses.*')],
        ['label' => 'Tentang', 'href' => route('home').'#tentang', 'active' => false],
    ];
@endphp

<header class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur">
    <div class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-4 px-4 sm:px-6">
        <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-bold text-brand-950">
            <img src="{{ asset('images/eduLearn-logo.png') }}" alt="" width="36" height="36" class="size-9">
            EduLearn
        </a>

        <button type="button" data-toggle aria-controls="site-nav" aria-expanded="false"
                class="inline-flex size-10 items-center justify-center rounded-md text-slate-700 hover:bg-slate-100 md:hidden">
            <x-heroicon-o-bars-3 class="size-6" aria-hidden="true" />
            <span class="sr-only">Menu</span>
        </button>

        <nav id="site-nav" aria-label="Navigasi utama"
             class="absolute inset-x-0 top-16 hidden border-b border-slate-200 bg-white px-4 pb-4 shadow-sm md:static md:flex md:items-center md:gap-6 md:border-0 md:p-0 md:shadow-none">
            <ul class="flex flex-col gap-1 md:flex-row md:gap-1">
                @foreach ($links as $link)
                    <li>
                        <a href="{{ $link['href'] }}" @if ($link['active']) aria-current="page" @endif
                           @class([
                               'block rounded-md px-3 py-2 text-sm font-medium',
                               'bg-brand-50 text-brand-800' => $link['active'],
                               'text-slate-700 hover:bg-slate-100 hover:text-slate-900' => ! $link['active'],
                           ])>
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="mt-3 flex flex-col gap-2 border-t border-slate-200 pt-3 md:mt-0 md:flex-row md:items-center md:border-0 md:pt-0">
                @auth
                    <div class="relative">
                        <button type="button" data-toggle="dropdown" aria-controls="user-menu" aria-expanded="false"
                                class="flex w-full items-center gap-2 rounded-full py-1 pr-3 pl-1 text-sm font-medium text-slate-700 hover:bg-slate-100">
                            <x-avatar :user="auth()->user()" size="sm" />
                            <span>{{ auth()->user()->nama }}</span>
                            <x-heroicon-m-chevron-down class="size-4" aria-hidden="true" />
                        </button>

                        <div id="user-menu" class="right-0 z-50 mt-2 hidden w-56 rounded-lg border border-slate-200 bg-white py-1 shadow-lg md:absolute">
                            <p class="border-b border-slate-100 px-4 py-2 text-sm text-slate-600">
                                Masuk sebagai <span class="font-medium text-slate-900">{{ auth()->user()->username }}</span>
                            </p>
                            <ul>
                                @unless (auth()->user()->isSiswa())
                                    <li>
                                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                                            <x-heroicon-o-squares-2x2 class="size-5" aria-hidden="true" /> Dashboard
                                        </a>
                                    </li>
                                @endunless
                                <li>
                                    <a href="{{ route('profile.show') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                                        <x-heroicon-o-user-circle class="size-5" aria-hidden="true" /> Profil saya
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center gap-2 px-4 py-2 text-left text-sm text-slate-700 hover:bg-slate-100">
                                            <x-heroicon-o-arrow-right-start-on-rectangle class="size-5" aria-hidden="true" /> Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @else
                    <x-button :href="route('login')" variant="ghost">Masuk</x-button>
                    <x-button :href="route('register')">Daftar gratis</x-button>
                @endauth
            </div>
        </nav>
    </div>
</header>
