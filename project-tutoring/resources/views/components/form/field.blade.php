@props(['id', 'name', 'label', 'hint' => null, 'required' => false])

{{--
    Pembungkus untuk semua input: label, petunjuk, dan pesan error.
    Isi $slot menerima $describedBy & $invalid lewat komponen anak (input/textarea/select).
--}}
<div {{ $attributes }}>
    <label for="{{ $id }}" class="block text-sm font-medium text-ink-900">
        {{ $label }}
        @if ($required)
            <span class="text-danger" aria-hidden="true">*</span>
        @else
            <span class="font-normal text-ink-600">(opsional)</span>
        @endif
    </label>

    @if ($hint)
        <p id="{{ $id }}-hint" class="mt-1 text-sm text-ink-600">{{ $hint }}</p>
    @endif

    <div class="mt-1.5">{{ $slot }}</div>

    @error($name)
        <p id="{{ $id }}-error" class="mt-1.5 flex items-start gap-1 text-sm text-danger">
            <x-heroicon-s-exclamation-circle class="mt-0.5 size-4 shrink-0" aria-hidden="true" />
            {{ $message }}
        </p>
    @enderror
</div>
