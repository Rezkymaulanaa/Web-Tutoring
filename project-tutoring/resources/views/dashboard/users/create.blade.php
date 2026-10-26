<x-layouts.dashboard title="Tambah pengguna">
    <form method="POST" action="{{ route('dashboard.users.store') }}" class="max-w-3xl space-y-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm" novalidate>
        @csrf
        <p class="text-sm text-slate-600">Isian bertanda <span class="text-red-700">*</span> wajib diisi.</p>

        <div class="grid gap-5 sm:grid-cols-2">
            <x-form.input name="nama" label="Nama lengkap" required autocomplete="off" class="sm:col-span-2" />
            <x-form.input name="username" label="Username" required autocomplete="off" hint="Minimal 5 karakter." />
            <x-form.input name="email" type="email" label="Email" required autocomplete="off" />
            <x-form.role-picker class="sm:col-span-2" />
            <x-form.password autocomplete="new-password" hint="Minimal 8 karakter, berisi huruf dan angka." class="sm:col-span-2" />
        </div>

        <div class="flex flex-wrap gap-3 border-t border-slate-200 pt-6">
            <x-button>Simpan pengguna</x-button>
            <x-button :href="route('dashboard.users.index')" variant="secondary">Batal</x-button>
        </div>
    </form>
</x-layouts.dashboard>
