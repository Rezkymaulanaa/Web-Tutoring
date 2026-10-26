<x-layouts.dashboard title="Pengguna">
    <x-slot:actions>
        <x-button :href="route('dashboard.users.create')" size="sm">
            <x-heroicon-m-plus class="size-4" aria-hidden="true" /> Tambah pengguna
        </x-button>
    </x-slot:actions>

    @foreach (['Guru' => $gurus, 'Siswa' => $siswas] as $role => $users)
        <section aria-labelledby="tabel-{{ Str::lower($role) }}" class="space-y-3">
            <h2 id="tabel-{{ Str::lower($role) }}" class="text-lg font-semibold text-slate-900">
                {{ $role }} <span class="font-normal text-slate-600">({{ $users->count() }})</span>
            </h2>

            @if ($users->isEmpty())
                <x-empty-state :title="'Belum ada '.Str::lower($role)" icon="heroicon-o-users" />
            @else
                <x-dashboard.table :caption="'Daftar '.$role">
                    <x-slot:head>
                        <tr>
                            <th scope="col" class="px-4 py-3">Nama</th>
                            <th scope="col" class="px-4 py-3">Username</th>
                            <th scope="col" class="px-4 py-3">Email</th>
                            <th scope="col" class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </x-slot:head>
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-4 py-3">
                                <span class="flex items-center gap-3 font-medium text-slate-900">
                                    <x-avatar :user="$user" size="sm" /> {{ $user->nama }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ $user->username }}</td>
                            <td class="px-4 py-3">{{ $user->email }}</td>
                            <td class="px-4 py-3">
                                <x-dashboard.row-actions :edit-url="route('dashboard.users.edit', $user)"
                                                         :delete-url="route('dashboard.users.destroy', $user)"
                                                         :name="$user->nama"
                                                         :confirm="'Hapus pengguna “'.$user->nama.'”?'" />
                            </td>
                        </tr>
                    @endforeach
                </x-dashboard.table>
            @endif
        </section>
    @endforeach
</x-layouts.dashboard>
