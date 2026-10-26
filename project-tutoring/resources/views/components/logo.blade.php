@props(['dark' => false])

<a href="{{ route('home') }}" {{ $attributes->class(['inline-flex items-center gap-2.5', 'text-paper' => $dark, 'text-ink-900' => ! $dark]) }}>
    <img src="{{ asset('images/eduLearn-logo.png') }}" alt="" width="32" height="32" class="size-8">
    <span class="font-display text-xl font-semibold tracking-tight">EduLearn</span>
</a>
