<footer class="surface-dark mt-24 bg-ink-950 text-ink-300">
    <div class="mx-auto max-w-6xl px-4 pt-14 pb-10 sm:px-6">
        <div class="grid gap-10 border-b border-white/10 pb-12 md:grid-cols-12">
            <div class="md:col-span-8">
                <x-logo dark />
                <p class="mt-4 max-w-sm font-display text-xl leading-snug text-paper">
                    Kelas yang disusun guru, dipelajari sesuai ritmemu.
                </p>
            </div>

            <nav aria-labelledby="footer-explore" class="md:col-span-4">
                <h2 id="footer-explore" class="text-xs font-semibold tracking-[0.14em] text-paper uppercase">Jelajahi</h2>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-paper hover:underline">Beranda</a></li>
                    <li><a href="{{ route('courses.index') }}" class="hover:text-paper hover:underline">Daftar kelas</a></li>
                    @guest
                        <li><a href="{{ route('register') }}" class="hover:text-paper hover:underline">Daftar akun</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-paper hover:underline">Masuk</a></li>
                    @endguest
                </ul>
            </nav>
        </div>

        <p class="pt-6 text-xs">&copy; {{ now()->year }} EduLearn. Hak cipta dilindungi.</p>
    </div>
</footer>
