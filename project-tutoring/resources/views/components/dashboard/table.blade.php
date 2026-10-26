@props(['caption'])

{{--
    Tabel yang bisa digeser ke samping di layar kecil. Wadahnya bisa difokus (tabindex) & punya nama,
    supaya pengguna keyboard tetap bisa menggulirnya.
--}}
<div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto" tabindex="0" role="region" aria-label="{{ $caption }}">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <caption class="sr-only">{{ $caption }}</caption>
            <thead class="bg-slate-50 text-left text-xs font-semibold tracking-wide text-slate-700 uppercase">
                {{ $head }}
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
