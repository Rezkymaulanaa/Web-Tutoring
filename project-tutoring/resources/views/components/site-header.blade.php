@php
    $links = [
        ['label' => 'Beranda', 'href' => route('home'), 'active' => request()->routeIs('home')],
        ['label' => 'Kelas', 'href' => route('courses.index'), 'active' => request()->routeIs('courses.*')],
        ['label' => 'Cara belajar', 'href' => route('home').'#tentang', 'active' => false],
    ];
@endphp

<header class="sticky top-0 z-40 border-b border-rule bg-paper/95 backdrop-blur">
    <div class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-4 px-4 sm:px-6">
        <x-logo />

        <button type="button" data-toggle aria-controls="site-nav" aria-expanded="false"
                class="inline-flex size-10 items-center justify-center rounded-md text-ink-900 hover:bg-ink-50 md:hidden">
            <x-heroicon-o-bars-2 class="size-6" aria-hidden="true" />
            <span class="sr-only">Menu</span>
        </button>

        <nav id="site-nav" aria-label="Navigasi utama"
             class="absolute inset-x-0 top-16 hidden border-b border-rule bg-paper px-4 pb-4 md:static md:flex md:items-center md:gap-8 md:border-0 md:bg-transparent md:p-0">
            <ul class="flex flex-col md:flex-row md:gap-7">
                @foreach ($links as $link)
                    <li>
                        <a href="{{ $link['href'] }}" @if ($link['active']) aria-current="page" @endif
                           @class([
                               'block py-2 text-sm font-medium decoration-2 underline-offset-[6px]',
                               'text-ink-900 underline decoration-marigold-400' => $link['active'],
                               'text-ink-700 hover:text-ink-900 hover:underline hover:decoration-ink-300' => ! $link['active'],
                           ])>
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="mt-3 flex flex-col gap-2 border-t border-rule pt-3 md:mt-0 md:flex-row md:items-center md:border-0 md:pt-0">
                @auth
                    <div class="relative">
                        <button type="button" data-toggle="dropdown" aria-controls="user-menu" aria-expanded="false"
                                class="flex w-full items-center gap-2 rounded-md py-1.5 pr-2 pl-1.5 text-sm font-medium text-ink-900 hover:bg-ink-50">
                            <x-avatar :user="auth()->user()" size="sm" />
                            <span>{{ auth()->user()->nama }}</span>
                            <x-heroicon-m-chevron-down class="size-4 text-ink-600" aria-hidden="true" />
                        </button>

                        <div id="user-menu" class="right-0 z-50 mt-2 hidden w-60 rounded-md border border-rule bg-paper-card py-1 shadow-[0_8px_24px_-12px_rgb(20_33_61/0.35)] md:absolute">
                            <p class="border-b border-rule px-4 py-2.5 text-xs text-ink-600">
                                Masuk sebagai <span class="font-semibold text-ink-900">{{ auth()->user()->username }}</span>
                                · {{ auth()->user()->role->value }}
                            </p>
                            <ul class="py-1 text-sm text-ink-800">
                                @unless (auth()->user()->isSiswa())
                                    <li><a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-ink-50">Dashboard</a></li>
                                @endunless
                                <li><a href="{{ route('profile.show') }}" class="block px-4 py-2 hover:bg-ink-50">Profil saya</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full px-4 py-2 text-left hover:bg-ink-50">Keluar</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="py-2 text-sm font-medium text-ink-800 hover:text-ink-900 hover:underline md:px-1">Masuk</a>
                    <x-button :href="route('register')" size="sm">Daftar gratis</x-button>
                @endauth
            </div>
        </nav>
    </div>
</header>
