@props(['name' => 'password', 'label' => 'Password', 'hint' => null, 'required' => true, 'id' => null])

@php
    $id ??= $name;
    $invalid = $errors->has($name);
    $describedBy = collect([$hint ? "{$id}-hint" : null, $invalid ? "{$id}-error" : null])->filter()->implode(' ');
@endphp

<x-form.field :id="$id" :name="$name" :label="$label" :hint="$hint" :required="$required" :class="$attributes->get('class')">
    <div class="relative">
        <input id="{{ $id }}" name="{{ $name }}" type="password"
               @required($required)
               @if ($invalid) aria-invalid="true" @endif
               @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
               {{ $attributes->except('class')->class([
                   'block w-full rounded-md border-ink-500 pr-12 focus:border-ink-900 focus:ring-ink-900 sm:text-sm',
                   'border-danger' => $invalid,
               ]) }}>

        {{-- Tombol asli (bukan ikon biasa), jadi bisa dipakai dengan keyboard & dibacakan pembaca layar --}}
        <button type="button" data-password-toggle aria-controls="{{ $id }}" aria-pressed="false"
                class="absolute inset-y-0 right-0 flex w-11 items-center justify-center rounded-r-lg text-ink-600 hover:text-ink-900">
            <x-heroicon-o-eye class="size-5" aria-hidden="true" />
            <span class="sr-only" data-label>Tampilkan password</span>
        </button>
    </div>
</x-form.field>
