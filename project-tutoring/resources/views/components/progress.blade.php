@props(['value', 'label' => 'Progres belajar'])

<div {{ $attributes->class('flex items-center gap-3') }}>
    <div role="progressbar" aria-label="{{ $label }}" aria-valuenow="{{ $value }}" aria-valuemin="0" aria-valuemax="100"
         class="h-2 flex-1 overflow-hidden rounded-full bg-slate-200">
        <div class="h-full rounded-full bg-emerald-600" style="width: {{ $value }}%"></div>
    </div>
    <span class="text-sm font-medium text-slate-700">{{ $value }}%</span>
</div>
