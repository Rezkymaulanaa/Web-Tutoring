@props(['editUrl', 'deleteUrl', 'name', 'confirm'])

{{--
    Aksi di setiap baris tabel. Sengaja dibuat tenang (tanpa tombol merah menyala di tiap baris);
    nama item ikut dibacakan pembaca layar supaya jelas baris mana yang diubah.
--}}
<div class="flex justify-end gap-1">
    <x-button :href="$editUrl" variant="ghost" size="sm">
        Edit<span class="sr-only"> {{ $name }}</span>
    </x-button>

    <form method="POST" action="{{ $deleteUrl }}" data-confirm="{{ $confirm }}">
        @csrf
        @method('DELETE')
        <x-button variant="danger-quiet" size="sm">
            Hapus<span class="sr-only"> {{ $name }}</span>
        </x-button>
    </form>
</div>
