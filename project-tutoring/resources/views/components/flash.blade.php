{{--
    Pesan setelah aksi berhasil (session 'success') atau ditolak (error 'error').
    role="status" dibacakan dengan sopan oleh pembaca layar; role="alert" langsung dibacakan.
--}}
@if (session('success'))
    <div data-flash role="status" {{ $attributes->class('flex items-start gap-3 border-l-4 border-success bg-success-soft px-4 py-3 text-sm text-ink-900') }}>
        <x-heroicon-s-check-circle class="mt-0.5 size-5 shrink-0 text-success" aria-hidden="true" />
        <p class="flex-1">{{ session('success') }}</p>
        <button type="button" data-dismiss class="-m-1 rounded p-1 text-ink-700 hover:bg-white/60">
            <x-heroicon-m-x-mark class="size-5" aria-hidden="true" />
            <span class="sr-only">Tutup pesan</span>
        </button>
    </div>
@endif

@if ($errors->has('error'))
    <div data-flash role="alert" {{ $attributes->class('flex items-start gap-3 border-l-4 border-danger bg-danger-soft px-4 py-3 text-sm text-ink-900') }}>
        <x-heroicon-s-exclamation-triangle class="mt-0.5 size-5 shrink-0 text-danger" aria-hidden="true" />
        <p class="flex-1">{{ $errors->first('error') }}</p>
        <button type="button" data-dismiss class="-m-1 rounded p-1 text-ink-700 hover:bg-white/60">
            <x-heroicon-m-x-mark class="size-5" aria-hidden="true" />
            <span class="sr-only">Tutup pesan</span>
        </button>
    </div>
@endif
