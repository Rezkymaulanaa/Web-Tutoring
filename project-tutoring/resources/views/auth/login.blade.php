<x-layouts.app title="Masuk">
    <x-auth-card title="Masuk ke EduLearn" subtitle="Selamat datang kembali! Masuk untuk melanjutkan belajar.">
        <x-flash class="mb-6" />

        @if (session('loginError'))
            <div role="alert" class="mb-6 flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-900">
                <x-heroicon-s-exclamation-triangle class="size-5 shrink-0 text-red-700" aria-hidden="true" />
                {{ session('loginError') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5" novalidate>
            @csrf

            <x-form.input name="email_or_username" label="Email atau username" required autofocus
                          autocomplete="username" autocapitalize="none" spellcheck="false" />

            <x-form.password autocomplete="current-password" />

            <label class="flex items-center gap-2 text-sm text-slate-700">
                <input type="checkbox" name="remember" value="1" @checked(old('remember'))
                       class="size-4 rounded border-slate-500 text-brand-700 focus:ring-brand-600">
                Ingat saya di perangkat ini
            </label>

            <x-button class="w-full">Masuk</x-button>
        </form>

        <x-slot:footer>
            Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-brand-700 hover:underline">Daftar gratis</a>
        </x-slot:footer>
    </x-auth-card>
</x-layouts.app>
