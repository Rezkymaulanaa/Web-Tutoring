@props(['title', 'subtitle' => null])

<div class="mx-auto grid max-w-5xl gap-12 px-4 py-12 sm:px-6 sm:py-16 lg:grid-cols-12 lg:items-start">
    <div class="lg:col-span-5 lg:pt-6">
        <p class="eyebrow">EduLearn</p>
        <h1 class="mt-3 font-display text-4xl leading-tight font-semibold tracking-tight text-ink-900">{{ $title }}</h1>
        @if ($subtitle)
            <p class="mt-4 max-w-sm leading-7 text-ink-700">{{ $subtitle }}</p>
        @endif
        @isset($footer)
            <p class="mt-6 text-sm text-ink-700">{{ $footer }}</p>
        @endisset
    </div>

    <div class="rounded-md border border-rule bg-paper-card p-6 sm:p-8 lg:col-span-7">
        {{ $slot }}
    </div>
</div>
