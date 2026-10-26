@props(['value', 'label' => 'Progres belajar'])

<div {{ $attributes->class('flex items-center gap-3') }}>
    <div role="progressbar" aria-label="{{ $label }}" aria-valuenow="{{ $value }}" aria-valuemin="0" aria-valuemax="100"
         class="h-1.5 flex-1 overflow-hidden rounded-full bg-ink-100">
        <div class="h-full rounded-full bg-ink-900" style="width: {{ $value }}%"></div>
    </div>
    <span class="tabular w-10 text-right text-sm font-semibold text-ink-900">{{ $value }}%</span>
</div>
