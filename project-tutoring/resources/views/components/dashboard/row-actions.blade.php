@props(['editUrl', 'deleteUrl', 'name', 'confirm'])

{{-- Tombol Edit & Hapus di setiap baris tabel. Nama item ikut dibacakan supaya jelas baris mana yang diubah. --}}
<div class="flex justify-end gap-2">
    <x-button :href="$editUrl" variant="secondary" size="sm">
        <x-heroicon-o-pencil-square class="size-4" aria-hidden="true" />
        Edit<span class="sr-only"> {{ $name }}</span>
    </x-button>

    <form method="POST" action="{{ $deleteUrl }}" data-confirm="{{ $confirm }}">
        @csrf
        @method('DELETE')
        <x-button variant="danger" size="sm">
            <x-heroicon-o-trash class="size-4" aria-hidden="true" />
            Hapus<span class="sr-only"> {{ $name }}</span>
        </x-button>
    </form>
</div>
