<x-layouts.dashboard :title="'Edit materi: '.$content->title">
    <form method="POST" action="{{ route('dashboard.contents.update', $content) }}" class="max-w-3xl space-y-6 rounded-md border border-rule bg-paper-card p-6" novalidate>
        @csrf
        @method('PUT')
        @include('dashboard.contents.form', ['content' => $content])

        <div class="flex flex-wrap gap-3 border-t border-rule pt-6">
            <x-button>Simpan perubahan</x-button>
            <x-button :href="route('dashboard.contents.index')" variant="secondary">Batal</x-button>
        </div>
    </form>
</x-layouts.dashboard>
