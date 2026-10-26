@props(['value' => null, 'legend' => 'Tipe akun'])

{{-- Pilihan role dalam bentuk radio (fieldset + legend), lebih jelas daripada dropdown. --}}
@php
    $selected = old('role', $value);
    $options = [
        'Siswa' => ['icon' => 'heroicon-o-academic-cap', 'text' => 'Siswa', 'description' => 'Ikuti kelas dan pantau progres belajar.'],
        'Guru' => ['icon' => 'heroicon-o-presentation-chart-bar', 'text' => 'Guru', 'description' => 'Buat course dan tulis materi.'],
    ];
@endphp

<fieldset {{ $attributes }} @error('role') aria-describedby="role-error" @enderror>
    <legend class="text-sm font-medium text-slate-900">{{ $legend }} <span class="text-red-700" aria-hidden="true">*</span></legend>

    <div class="mt-1.5 grid gap-3 sm:grid-cols-2">
        @foreach ($options as $optionValue => $option)
            <label class="relative flex cursor-pointer gap-3 rounded-lg border border-slate-300 bg-white p-3 shadow-sm has-checked:border-brand-600 has-checked:bg-brand-50 has-checked:ring-1 has-checked:ring-brand-600 has-focus-visible:outline-3 has-focus-visible:outline-brand-600">
                <input type="radio" name="role" value="{{ $optionValue }}" required @checked($selected === $optionValue)
                       class="mt-0.5 size-4 border-slate-500 text-brand-700 focus:ring-brand-600">
                <span>
                    <span class="flex items-center gap-1.5 text-sm font-semibold text-slate-900">
                        <x-dynamic-component :component="$option['icon']" class="size-5" aria-hidden="true" />
                        {{ $option['text'] }}
                    </span>
                    <span class="mt-0.5 block text-sm text-slate-600">{{ $option['description'] }}</span>
                </span>
            </label>
        @endforeach
    </div>

    @error('role')
        <p id="role-error" class="mt-1.5 flex items-start gap-1 text-sm text-red-700">
            <x-heroicon-s-exclamation-circle class="mt-0.5 size-4 shrink-0" aria-hidden="true" />
            {{ $message }}
        </p>
    @enderror
</fieldset>
