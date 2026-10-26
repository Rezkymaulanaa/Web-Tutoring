@props(['title' => null, 'description' => 'EduLearn: belajar mudah lewat materi dan video yang disusun oleh guru berpengalaman.'])

<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $description }}">
    <title>{{ $title ? $title.' · ' : '' }}EduLearn</title>
    <link rel="icon" type="image/png" href="{{ asset('images/eduLearn-logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-full flex-col bg-paper font-sans text-ink-900 antialiased">
    <a href="#main" class="sr-only z-50 rounded-md bg-ink-900 px-4 py-2 font-medium text-paper focus:not-sr-only focus:fixed focus:top-3 focus:left-3">
        Lewati ke konten utama
    </a>

    <x-site-header />

    <main id="main" tabindex="-1" class="flex-1 focus:outline-none">
        {{ $slot }}
    </main>

    <x-site-footer />
</body>
</html>
