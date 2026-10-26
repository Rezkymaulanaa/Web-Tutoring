<x-layouts.dashboard title="Tambah course">
    <form method="POST" action="{{ route('dashboard.courses.store') }}" class="max-w-3xl space-y-6 rounded-md border border-rule bg-paper-card p-6" novalidate>
        @csrf
        @include('dashboard.courses.form')

        <div class="flex flex-wrap gap-3 border-t border-rule pt-6">
            <x-button>Simpan course</x-button>
            <x-button :href="route('dashboard.courses.index')" variant="secondary">Batal</x-button>
        </div>
    </form>
</x-layouts.dashboard>
