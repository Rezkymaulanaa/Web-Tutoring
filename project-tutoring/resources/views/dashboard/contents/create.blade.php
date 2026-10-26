<x-layouts.dashboard title="Tambah materi">
    <form method="POST" action="{{ route('dashboard.contents.store') }}" class="max-w-3xl space-y-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm" novalidate>
        @csrf
        @include('dashboard.contents.form')

        <div class="flex flex-wrap gap-3 border-t border-slate-200 pt-6">
            <x-button>Simpan materi</x-button>
            <x-button :href="route('dashboard.contents.index')" variant="secondary">Batal</x-button>
        </div>
    </form>
</x-layouts.dashboard>
