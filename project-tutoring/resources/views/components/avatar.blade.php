@props(['user', 'size' => 'md'])

{{-- Inisial nama sebagai pengganti foto profil. Dekoratif, karena nama selalu ditulis di sebelahnya. --}}
@php
    $initials = collect(explode(' ', trim($user->nama)))
        ->filter()
        ->take(2)
        ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
        ->implode('');
@endphp

<span aria-hidden="true" {{ $attributes->class([
    'inline-flex shrink-0 items-center justify-center rounded-full bg-brand-100 font-semibold text-brand-800',
    'size-8 text-xs' => $size === 'sm',
    'size-10 text-sm' => $size === 'md',
    'size-20 text-2xl' => $size === 'lg',
]) }}>{{ $initials }}</span>
