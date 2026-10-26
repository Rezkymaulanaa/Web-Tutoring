@props(['href' => null, 'variant' => 'primary', 'size' => 'md', 'type' => 'submit'])

@php
    $classes = \Illuminate\Support\Arr::toCssClasses([
        'inline-flex items-center justify-center gap-2 rounded-md font-semibold transition-colors disabled:cursor-not-allowed disabled:opacity-60',
        'min-h-9 px-3 text-sm' => $size === 'sm',
        'min-h-11 px-4 text-sm' => $size === 'md',
        'min-h-12 px-6 text-base' => $size === 'lg',
        'bg-ink-900 text-paper hover:bg-ink-800' => $variant === 'primary',
        'border border-ink-900 text-ink-900 hover:bg-ink-900 hover:text-paper' => $variant === 'secondary',
        'text-ink-800 hover:bg-ink-50' => $variant === 'ghost',
        'bg-marigold-400 text-ink-950 hover:bg-marigold-300' => $variant === 'accent',
        'bg-danger text-white hover:bg-red-800' => $variant === 'danger',
        'text-danger hover:bg-danger-soft' => $variant === 'danger-quiet',
    ]);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->class($classes) }}>{{ $slot }}</button>
@endif
