@props(['caption'])

{{--
    Tabel yang bisa digeser ke samping di layar kecil. Wadahnya bisa difokus (tabindex) & punya nama,
    supaya pengguna keyboard tetap bisa menggulirnya.
--}}
<div class="overflow-hidden rounded-md border border-rule bg-paper-card">
    <div class="overflow-x-auto" tabindex="0" role="region" aria-label="{{ $caption }}">
        <table class="min-w-full text-sm">
            <caption class="sr-only">{{ $caption }}</caption>
            <thead class="border-b border-ink-900 text-left text-xs font-semibold tracking-[0.12em] text-ink-600 uppercase">
                {{ $head }}
            </thead>
            <tbody class="divide-y divide-rule text-ink-700">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
