<x-layouts.app title="Daftar">
    <x-auth-card title="Buat akun EduLearn" subtitle="Gratis. Isian bertanda * wajib diisi.">
        <form method="POST" action="{{ route('register') }}" class="space-y-5" novalidate>
            @csrf

            <x-form.input name="nama" label="Nama lengkap" required autofocus autocomplete="name" />
            <x-form.input name="username" label="Username" required autocomplete="username" autocapitalize="none" spellcheck="false"
                          hint="Minimal 5 karakter, dipakai untuk masuk." />
            <x-form.input name="email" type="email" label="Email" required autocomplete="email" />
            <x-form.role-picker legend="Daftar sebagai" />
            <x-form.password autocomplete="new-password" hint="Minimal 8 karakter, berisi huruf dan angka." />

            <x-button class="w-full">Daftar</x-button>
        </form>

        <x-slot:footer>
            Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-brand-700 hover:underline">Masuk</a>
        </x-slot:footer>
    </x-auth-card>
</x-layouts.app>
