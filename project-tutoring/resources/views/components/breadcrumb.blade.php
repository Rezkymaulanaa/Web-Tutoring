@props(['items'])

{{-- $items: [teks => url]. Item terakhir adalah halaman saat ini. --}}
<nav aria-label="Breadcrumb" {{ $attributes->class('text-sm text-ink-600') }}>
    <ol class="flex flex-wrap items-center gap-x-2 gap-y-1">
        @foreach ($items as $label => $url)
            <li class="flex items-center gap-2">
                @if ($loop->last)
                    <a href="{{ $url }}" aria-current="page" class="font-medium text-ink-900">{{ $label }}</a>
                @else
                    <a href="{{ $url }}" class="hover:text-ink-900 hover:underline">{{ $label }}</a>
                    <span aria-hidden="true" class="text-ink-300">/</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
