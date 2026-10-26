@props(['items'])

{{-- Statistik dalam satu panel bergaris, seperti tabel ringkasan di laporan; angka besar, tanpa ikon dekoratif. --}}
<dl class="grid grid-cols-2 overflow-hidden rounded-md border border-rule bg-paper-card xl:grid-cols-4">
    @foreach ($items as $item)
        <div @class([
            'flex flex-col-reverse justify-end gap-1 border-rule p-5',
            'border-l' => $loop->index % 2 === 1,
            'xl:border-l' => $loop->index > 0,
            'border-t xl:border-t-0' => $loop->index > 1,
        ])>
            <dt class="text-sm text-ink-600">{{ $item['label'] }}</dt>
            <dd class="tabular font-display text-4xl font-semibold text-ink-900">{{ number_format($item['value'], 0, ',', '.') }}</dd>
        </div>
    @endforeach
</dl>
