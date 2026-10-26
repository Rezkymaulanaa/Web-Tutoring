@props(['title', 'icon' => 'heroicon-o-inbox'])

<div {{ $attributes->class('rounded-xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center') }}>
    <x-dynamic-component :component="$icon" class="mx-auto size-10 text-slate-400" aria-hidden="true" />
    <p class="mt-3 font-semibold text-slate-900">{{ $title }}</p>
    @if ($slot->isNotEmpty())
        <div class="mt-1 text-sm text-slate-600">{{ $slot }}</div>
    @endif
</div>
