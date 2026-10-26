<x-layouts.dashboard :title="'Edit pengguna: '.$user->nama">
    <form method="POST" action="{{ route('dashboard.users.update', $user) }}" class="max-w-3xl space-y-6 rounded-md border border-rule bg-paper-card p-6" novalidate>
        @csrf
        @method('PUT')
        <p class="text-sm text-ink-600">Isian bertanda <span class="text-danger">*</span> wajib diisi.</p>

        <div class="grid gap-5 sm:grid-cols-2">
            <x-form.input name="nama" label="Nama lengkap" :value="$user->nama" required autocomplete="off" class="sm:col-span-2" />
            <x-form.input name="username" label="Username" :value="$user->username" required autocomplete="off" hint="Minimal 5 karakter." />
            <x-form.input name="email" type="email" label="Email" :value="$user->email" required autocomplete="off" />
            <x-form.role-picker :value="$user->role->value" class="sm:col-span-2" />
        </div>

        <div class="flex flex-wrap gap-3 border-t border-rule pt-6">
            <x-button>Simpan perubahan</x-button>
            <x-button :href="route('dashboard.users.index')" variant="secondary">Batal</x-button>
        </div>
    </form>
</x-layouts.dashboard>
