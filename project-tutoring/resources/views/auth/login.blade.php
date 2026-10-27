<x-layouts.app title="Masuk">
    <x-auth-card title="Masuk ke akunmu" subtitle="Lanjutkan dari materi terakhir yang kamu buka. Progres belajarmu tersimpan otomatis.">
        <x-flash class="mb-6" />

        {{-- Alasan diarahkan ke halaman login, misalnya saat membuka materi yang perlu masuk --}}
        @if (session('status'))
            <div role="status" class="mb-6 flex items-start gap-3 border-l-4 border-marigold-400 bg-marigold-100 px-4 py-3 text-sm text-ink-900">
                <x-heroicon-s-lock-closed class="mt-0.5 size-5 shrink-0 text-ink-700" aria-hidden="true" />
                {{ session('status') }}
            </div>
        @endif

        @if (session('loginError'))
            <div role="alert" class="mb-6 flex items-start gap-3 border-l-4 border-danger bg-danger-soft px-4 py-3 text-sm text-ink-900">
                <x-heroicon-s-exclamation-triangle class="mt-0.5 size-5 shrink-0 text-danger" aria-hidden="true" />
                {{ session('loginError') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5" novalidate>
            @csrf

            <x-form.input name="email_or_username" label="Email atau username" required autofocus
                          autocomplete="username" autocapitalize="none" spellcheck="false" />

            <x-form.password autocomplete="current-password" />

            <label class="flex items-center gap-2 text-sm text-ink-700">
                <input type="checkbox" name="remember" value="1" @checked(old('remember'))
                       class="size-4 rounded border-ink-500 text-ink-900 focus:ring-ink-900">
                Ingat saya di perangkat ini
            </label>

            <x-button class="w-full">Masuk</x-button>
        </form>

        <x-slot:footer>
            Belum punya akun? <a href="{{ route('register') }}" class="link">Daftar gratis</a>
        </x-slot:footer>
    </x-auth-card>
</x-layouts.app>
