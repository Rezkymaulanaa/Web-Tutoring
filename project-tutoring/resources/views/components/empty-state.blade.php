@props(['title', 'icon' => 'heroicon-o-inbox'])

<div {{ $attributes->class('rounded-md border border-dashed border-ink-300 px-6 py-10 text-center') }}>
    <x-dynamic-component :component="$icon" class="mx-auto size-8 text-ink-500" aria-hidden="true" />
    <p class="mt-3 font-display text-lg font-semibold text-ink-900">{{ $title }}</p>
    @if ($slot->isNotEmpty())
        <div class="mt-1 text-sm text-ink-600">{{ $slot }}</div>
    @endif
</div>
