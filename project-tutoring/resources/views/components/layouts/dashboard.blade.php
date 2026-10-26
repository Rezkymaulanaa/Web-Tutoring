@props(['title', 'eyebrow' => 'Dashboard', 'actions' => null])

@php
    $menu = [
        ['label' => 'Ringkasan', 'route' => 'dashboard', 'active' => 'dashboard'],
        ['label' => 'Course', 'route' => 'dashboard.courses.index', 'active' => 'dashboard.courses.*'],
        ['label' => 'Materi', 'route' => 'dashboard.contents.index', 'active' => 'dashboard.contents.*'],
    ];

    if (auth()->user()->isAdmin()) {
        $menu[] = ['label' => 'Pengguna', 'route' => 'dashboard.users.index', 'active' => 'dashboard.users.*'];
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
<body class="min-h-full bg-paper font-sans text-ink-900 antialiased">
    <a href="#main" class="sr-only z-50 rounded-md bg-ink-900 px-4 py-2 font-medium text-paper focus:not-sr-only focus:fixed focus:top-3 focus:left-3">
        Lewati ke konten utama
    </a>

    <div class="lg:flex lg:min-h-screen">
        {{-- Sidebar: selalu tampil di layar besar, bisa dibuka-tutup di HP --}}
        <aside class="border-b border-rule bg-paper-card lg:w-60 lg:shrink-0 lg:border-r lg:border-b-0">
            <div class="flex h-16 items-center justify-between px-5 lg:h-20">
                <x-logo />
                <button type="button" data-toggle aria-controls="dashboard-nav" aria-expanded="false"
                        class="inline-flex size-10 items-center justify-center rounded-md text-ink-900 hover:bg-ink-50 lg:hidden">
                    <x-heroicon-o-bars-2 class="size-6" aria-hidden="true" />
                    <span class="sr-only">Menu dashboard</span>
                </button>
            </div>

            <nav id="dashboard-nav" aria-label="Menu dashboard" class="hidden px-3 pb-6 lg:block">
                <p class="eyebrow px-3 pb-2">Kelola</p>
                <ul>
                    @foreach ($menu as $item)
                        @php($active = request()->routeIs($item['active']))
                        <li>
                            <a href="{{ route($item['route']) }}" @if ($active) aria-current="page" @endif
                               @class([
                                   'relative block rounded-md px-3 py-2 text-sm',
                                   'bg-ink-50 font-semibold text-ink-900 before:absolute before:inset-y-1.5 before:left-0 before:w-1 before:rounded-full before:bg-marigold-400' => $active,
                                   'text-ink-700 hover:bg-ink-50 hover:text-ink-900' => ! $active,
                               ])>
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-8 border-t border-rule pt-6">
                    <div class="flex items-center gap-3 px-3">
                        <x-avatar :user="auth()->user()" />
                        <div class="min-w-0 text-sm">
                            <p class="truncate font-semibold text-ink-900">{{ auth()->user()->nama }}</p>
                            <p class="text-ink-600">{{ auth()->user()->role->value }}</p>
                        </div>
                    </div>
                    <ul class="mt-4 text-sm">
                        <li><a href="{{ route('home') }}" class="block rounded-md px-3 py-2 text-ink-700 hover:bg-ink-50 hover:text-ink-900">Lihat situs</a></li>
                        <li><a href="{{ route('profile.show') }}" class="block rounded-md px-3 py-2 text-ink-700 hover:bg-ink-50 hover:text-ink-900">Profil saya</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full rounded-md px-3 py-2 text-left text-ink-700 hover:bg-ink-50 hover:text-ink-900">Keluar</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
        </aside>

        <div class="min-w-0 flex-1">
            <header class="border-b border-rule">
                <div class="mx-auto flex max-w-6xl flex-wrap items-end justify-between gap-4 px-4 pt-8 pb-6 sm:px-8 lg:pt-10">
                    <div>
                        <p class="eyebrow">{{ $eyebrow }}</p>
                        <h1 class="mt-2 font-display text-3xl font-semibold tracking-tight text-ink-900">{{ $title }}</h1>
                    </div>
                    @if ($actions)
                        <div class="flex items-center gap-3">{{ $actions }}</div>
                    @endif
                </div>
            </header>

            <main id="main" tabindex="-1" class="mx-auto max-w-6xl space-y-8 px-4 py-8 focus:outline-none sm:px-8">
                <x-flash />
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
