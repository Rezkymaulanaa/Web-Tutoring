<x-layouts.dashboard title="Tambah course">
    <form method="POST" action="{{ route('dashboard.courses.store') }}" class="max-w-3xl space-y-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm" novalidate>
        @csrf
        @include('dashboard.courses.form')

        <div class="flex flex-wrap gap-3 border-t border-slate-200 pt-6">
            <x-button>Simpan course</x-button>
            <x-button :href="route('dashboard.courses.index')" variant="secondary">Batal</x-button>
        </div>
    </form>
</x-layouts.dashboard>
