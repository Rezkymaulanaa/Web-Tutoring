@props(['name', 'label', 'options' => [], 'value' => null, 'placeholder' => 'Pilih salah satu', 'hint' => null, 'required' => false, 'id' => null])

{{-- $options: [nilai => teks yang ditampilkan] --}}
@php
    $id ??= $name;
    $invalid = $errors->has($name);
    $selected = (string) old($name, $value);
    $describedBy = collect([$hint ? "{$id}-hint" : null, $invalid ? "{$id}-error" : null])->filter()->implode(' ');
@endphp

<x-form.field :id="$id" :name="$name" :label="$label" :hint="$hint" :required="$required" :class="$attributes->get('class')">
    <select id="{{ $id }}" name="{{ $name }}"
            @required($required)
            @if ($invalid) aria-invalid="true" @endif
            @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
            {{ $attributes->except('class')->class([
                'block w-full rounded-lg border-slate-500 shadow-sm focus:border-brand-600 focus:ring-brand-600 sm:text-sm',
                'border-red-600' => $invalid,
            ]) }}>
        <option value="">{{ $placeholder }}</option>
        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @selected($selected === (string) $optionValue)>{{ $optionLabel }}</option>
        @endforeach
    </select>
</x-form.field>
