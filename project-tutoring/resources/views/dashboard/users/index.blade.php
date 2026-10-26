<x-layouts.dashboard title="Pengguna">
    <x-slot:actions>
        <x-button :href="route('dashboard.users.create')" size="sm">
            Tambah pengguna
        </x-button>
    </x-slot:actions>

    @foreach (['Guru' => $gurus, 'Siswa' => $siswas] as $role => $users)
        <section aria-labelledby="tabel-{{ Str::lower($role) }}" class="space-y-3">
            <h2 id="tabel-{{ Str::lower($role) }}" class="font-display text-xl font-semibold text-ink-900">
                {{ $role }} <span class="font-normal text-ink-600">({{ $users->count() }})</span>
            </h2>

            @if ($users->isEmpty())
                <x-empty-state :title="'Belum ada '.Str::lower($role)" icon="heroicon-o-users" />
            @else
                <x-dashboard.table :caption="'Daftar '.$role">
                    <x-slot:head>
                        <tr>
                            <th scope="col" class="px-5 py-3">Nama</th>
                            <th scope="col" class="px-5 py-3">Username</th>
                            <th scope="col" class="px-5 py-3">Email</th>
                            <th scope="col" class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </x-slot:head>
                    @foreach ($users as $user)
                        <tr class="hover:bg-paper">
                            <td class="px-5 py-3.5">
                                <span class="flex items-center gap-3 font-medium text-ink-900">
                                    <x-avatar :user="$user" size="sm" /> {{ $user->nama }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">{{ $user->username }}</td>
                            <td class="px-5 py-3.5">{{ $user->email }}</td>
                            <td class="px-5 py-3.5">
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
