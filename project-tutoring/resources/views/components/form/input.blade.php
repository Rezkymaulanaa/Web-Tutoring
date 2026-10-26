@props(['name', 'label', 'type' => 'text', 'value' => null, 'hint' => null, 'required' => false, 'id' => null])

@php
    $id ??= $name;
    $invalid = $errors->has($name);
    $describedBy = collect([$hint ? "{$id}-hint" : null, $invalid ? "{$id}-error" : null])->filter()->implode(' ');
@endphp

<x-form.field :id="$id" :name="$name" :label="$label" :hint="$hint" :required="$required" :class="$attributes->get('class')">
    <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}"
           value="{{ $type === 'password' ? '' : old($name, $value) }}"
           @required($required)
           @if ($invalid) aria-invalid="true" @endif
           @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
           {{ $attributes->except('class')->class([
               'block w-full rounded-lg border-slate-500 shadow-sm placeholder:text-slate-500 focus:border-brand-600 focus:ring-brand-600 sm:text-sm',
               'border-red-600 pr-10' => $invalid,
           ]) }}>
</x-form.field>
