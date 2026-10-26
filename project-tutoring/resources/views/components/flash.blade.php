{{--
    Pesan setelah aksi berhasil (session 'success') atau ditolak (error 'error').
    role="status" dibacakan dengan sopan oleh pembaca layar; role="alert" langsung dibacakan.
--}}
@if (session('success'))
    <div data-flash role="status" {{ $attributes->class('flex items-start gap-3 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900') }}>
        <x-heroicon-s-check-circle class="size-5 shrink-0 text-emerald-700" aria-hidden="true" />
        <p class="flex-1">{{ session('success') }}</p>
        <button type="button" data-dismiss class="-m-1 rounded p-1 hover:bg-emerald-100">
            <x-heroicon-m-x-mark class="size-5" aria-hidden="true" />
            <span class="sr-only">Tutup pesan</span>
        </button>
    </div>
@endif

@if ($errors->has('error'))
    <div data-flash role="alert" {{ $attributes->class('flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-900') }}>
        <x-heroicon-s-exclamation-triangle class="size-5 shrink-0 text-red-700" aria-hidden="true" />
        <p class="flex-1">{{ $errors->first('error') }}</p>
        <button type="button" data-dismiss class="-m-1 rounded p-1 hover:bg-red-100">
            <x-heroicon-m-x-mark class="size-5" aria-hidden="true" />
            <span class="sr-only">Tutup pesan</span>
        </button>
    </div>
@endif
