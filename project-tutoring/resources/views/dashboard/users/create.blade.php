<x-layouts.dashboard title="Tambah pengguna">
    <form method="POST" action="{{ route('dashboard.users.store') }}" class="max-w-3xl space-y-6 rounded-md border border-rule bg-paper-card p-6" novalidate>
        @csrf
        <p class="text-sm text-ink-600">Isian bertanda <span class="text-danger">*</span> wajib diisi.</p>

        <div class="grid gap-5 sm:grid-cols-2">
            <x-form.input name="nama" label="Nama lengkap" required autocomplete="off" class="sm:col-span-2" />
            <x-form.input name="username" label="Username" required autocomplete="off" hint="Minimal 5 karakter." />
            <x-form.input name="email" type="email" label="Email" required autocomplete="off" />
            <x-form.role-picker class="sm:col-span-2" />
            <x-form.password autocomplete="new-password" hint="Minimal 8 karakter, berisi huruf dan angka." class="sm:col-span-2" />
        </div>

        <div class="flex flex-wrap gap-3 border-t border-rule pt-6">
            <x-button>Simpan pengguna</x-button>
            <x-button :href="route('dashboard.users.index')" variant="secondary">Batal</x-button>
        </div>
    </form>
</x-layouts.dashboard>
