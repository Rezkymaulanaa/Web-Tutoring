<x-layouts.dashboard :title="'Edit course: '.$course->course">
    <form method="POST" action="{{ route('dashboard.courses.update', $course) }}" class="max-w-3xl space-y-6 rounded-md border border-rule bg-paper-card p-6" novalidate>
        @csrf
        @method('PUT')
        @include('dashboard.courses.form', ['course' => $course])

        <div class="flex flex-wrap gap-3 border-t border-rule pt-6">
            <x-button>Simpan perubahan</x-button>
            <x-button :href="route('dashboard.courses.index')" variant="secondary">Batal</x-button>
        </div>
    </form>
</x-layouts.dashboard>
