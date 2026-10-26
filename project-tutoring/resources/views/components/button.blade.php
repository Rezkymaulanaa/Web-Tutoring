@props(['href' => null, 'variant' => 'primary', 'size' => 'md', 'type' => 'submit'])

@php
    $classes = \Illuminate\Support\Arr::toCssClasses([
        'inline-flex items-center justify-center gap-2 rounded-lg font-semibold transition-colors disabled:cursor-not-allowed disabled:opacity-60',
        'min-h-9 px-3 text-sm' => $size === 'sm',
        'min-h-11 px-4 text-sm' => $size === 'md',
        'min-h-12 px-6 text-base' => $size === 'lg',
        'bg-brand-700 text-white shadow-sm hover:bg-brand-800' => $variant === 'primary',
        'border border-slate-300 bg-white text-slate-800 shadow-sm hover:bg-slate-50' => $variant === 'secondary',
        'text-slate-700 hover:bg-slate-100' => $variant === 'ghost',
        'bg-red-700 text-white shadow-sm hover:bg-red-800' => $variant === 'danger',
        'bg-accent-400 text-slate-900 shadow-sm hover:bg-accent-500' => $variant === 'accent',
    ]);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->class($classes) }}>{{ $slot }}</button>
@endif
