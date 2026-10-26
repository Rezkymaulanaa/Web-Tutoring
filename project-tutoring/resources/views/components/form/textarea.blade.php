@props(['name', 'label', 'value' => null, 'hint' => null, 'required' => false, 'rows' => 6, 'id' => null])

@php
    $id ??= $name;
    $invalid = $errors->has($name);
    $describedBy = collect([$hint ? "{$id}-hint" : null, $invalid ? "{$id}-error" : null])->filter()->implode(' ');
@endphp

<x-form.field :id="$id" :name="$name" :label="$label" :hint="$hint" :required="$required" :class="$attributes->get('class')">
    <textarea id="{{ $id }}" name="{{ $name }}" rows="{{ $rows }}"
              @required($required)
              @if ($invalid) aria-invalid="true" @endif
              @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
              {{ $attributes->except('class')->class([
                  'block w-full rounded-md border-ink-500 placeholder:text-ink-500 focus:border-ink-900 focus:ring-ink-900 sm:text-sm',
                  'border-danger' => $invalid,
              ]) }}>{{ old($name, $value) }}</textarea>
</x-form.field>
