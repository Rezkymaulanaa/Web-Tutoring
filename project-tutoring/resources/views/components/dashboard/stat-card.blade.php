@props(['label', 'value', 'icon'])

<div class="flex items-center gap-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
    <span class="flex size-12 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-700">
        <x-dynamic-component :component="$icon" class="size-6" aria-hidden="true" />
    </span>
    <dl>
        <dt class="text-sm text-slate-600">{{ $label }}</dt>
        <dd class="text-2xl font-bold text-slate-900">{{ number_format($value, 0, ',', '.') }}</dd>
    </dl>
</div>
