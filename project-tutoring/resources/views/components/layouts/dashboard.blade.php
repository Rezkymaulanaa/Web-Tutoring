@props(['title', 'actions' => null])

@php
    $menu = [
        ['label' => 'Ringkasan', 'route' => 'dashboard', 'active' => 'dashboard', 'icon' => 'heroicon-o-squares-2x2'],
        ['label' => 'Course', 'route' => 'dashboard.courses.index', 'active' => 'dashboard.courses.*', 'icon' => 'heroicon-o-book-open'],
        ['label' => 'Materi', 'route' => 'dashboard.contents.index', 'active' => 'dashboard.contents.*', 'icon' => 'heroicon-o-document-text'],
    ];

    if (auth()->user()->isAdmin()) {
        $menu[] = ['label' => 'Pengguna', 'route' => 'dashboard.users.index', 'active' => 'dashboard.users.*', 'icon' => 'heroicon-o-users'];
    }
@endphp

<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} · Dashboard EduLearn</title>
    <link rel="icon" type="image/png" href="{{ asset('images/eduLearn-logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-slate-100 text-slate-900 antialiased">
    <a href="#main" class="sr-only z-50 rounded-md bg-white px-4 py-2 font-medium text-brand-700 shadow focus:not-sr-only focus:fixed focus:top-3 focus:left-3">
        Lewati ke konten utama
    </a>

    <div class="lg:flex lg:min-h-full">
        {{-- Sidebar: selalu tampil di layar besar, bisa dibuka-tutup di HP --}}
        <aside class="bg-brand-950 text-slate-300 lg:w-64 lg:shrink-0">
            <div class="flex h-16 items-center justify-between px-4">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-lg font-bold text-white">
                    <img src="{{ asset('images/eduLearn-logo.png') }}" alt="" width="32" height="32" class="size-8">
                    EduLearn
                </a>
                <button type="button" data-toggle aria-controls="dashboard-nav" aria-expanded="false"
                        class="inline-flex size-10 items-center justify-center rounded-md hover:bg-white/10 lg:hidden">
                    <x-heroicon-o-bars-3 class="size-6" aria-hidden="true" />
                    <span class="sr-only">Menu dashboard</span>
                </button>
            </div>

            <nav id="dashboard-nav" aria-label="Menu dashboard" class="hidden px-3 pb-4 lg:block">
                <ul class="space-y-1">
                    @foreach ($menu as $item)
                        @php($active = request()->routeIs($item['active']))
                        <li>
                            <a href="{{ route($item['route']) }}" @if ($active) aria-current="page" @endif
                               @class([
                                   'flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium',
                                   'bg-white/10 text-white' => $active,
                                   'hover:bg-white/5 hover:text-white' => ! $active,
                               ])>
                                <x-dynamic-component :component="$item['icon']" class="size-5" aria-hidden="true" />
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <ul class="mt-6 space-y-1 border-t border-white/10 pt-6">
                    <li>
                        <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium hover:bg-white/5 hover:text-white">
                            <x-heroicon-o-globe-alt class="size-5" aria-hidden="true" /> Lihat situs
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left text-sm font-medium hover:bg-white/5 hover:text-white">
                                <x-heroicon-o-arrow-right-start-on-rectangle class="size-5" aria-hidden="true" /> Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <div class="flex-1">
            <header class="border-b border-slate-200 bg-white">
                <div class="flex flex-wrap items-center justify-between gap-4 px-4 py-4 sm:px-8">
                    <h1 class="text-xl font-bold text-slate-900 sm:text-2xl">{{ $title }}</h1>
                    <div class="flex items-center gap-3">
                        {{ $actions }}
                        <a href="{{ route('profile.show') }}" class="flex items-center gap-2 rounded-full py-1 pr-3 pl-1 text-sm hover:bg-slate-100">
                            <x-avatar :user="auth()->user()" size="sm" />
                            <span class="hidden sm:block">
                                <span class="block font-medium text-slate-900">{{ auth()->user()->nama }}</span>
                                <span class="block text-xs text-slate-600">{{ auth()->user()->role->value }}</span>
                            </span>
                        </a>
                    </div>
                </div>
            </header>

            <main id="main" tabindex="-1" class="space-y-6 px-4 py-6 focus:outline-none sm:px-8">
                <x-flash />
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
