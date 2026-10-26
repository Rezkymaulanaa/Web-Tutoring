<footer class="mt-16 bg-brand-950 text-slate-300">
    <div class="mx-auto grid max-w-6xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-3">
        <div>
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-bold text-white">
                <img src="{{ asset('images/eduLearn-logo.png') }}" alt="" width="36" height="36" class="size-9">
                EduLearn
            </a>
            <p class="mt-3 max-w-xs text-sm leading-6">
                Belajar mudah lewat materi dan video yang disusun oleh guru berpengalaman.
            </p>
        </div>

        <nav aria-labelledby="footer-explore">
            <h2 id="footer-explore" class="text-sm font-semibold text-white">Jelajahi</h2>
            <ul class="mt-3 space-y-2 text-sm">
                <li><a href="{{ route('home') }}" class="hover:text-white hover:underline">Beranda</a></li>
                <li><a href="{{ route('courses.index') }}" class="hover:text-white hover:underline">Daftar kelas</a></li>
                @guest
                    <li><a href="{{ route('register') }}" class="hover:text-white hover:underline">Daftar akun</a></li>
                @endguest
            </ul>
        </nav>

        <div>
            <h2 class="text-sm font-semibold text-white">Hubungi kami</h2>
            <address class="mt-3 space-y-2 text-sm not-italic">
                <p>Jl. A. [dihapus] No. 50, Kota [dihapus], Sulawesi Selatan [dihapus]</p>
                <p>
                    <a href="mailto:[dihapus]" class="inline-flex items-center gap-2 hover:text-white hover:underline">
                        <x-heroicon-o-envelope class="size-5" aria-hidden="true" /> [dihapus]
                    </a>
                </p>
                <p>
                    <a href="https://wa.me/[dihapus]" target="_blank" rel="noopener" class="inline-flex items-center gap-2 hover:text-white hover:underline">
                        <x-heroicon-o-chat-bubble-left-right class="size-5" aria-hidden="true" />
                        WhatsApp [dihapus] <span class="sr-only">(membuka tab baru)</span>
                    </a>
                </p>
                <p>
                    <a href="https://www.instagram.com/[dihapus]/" target="_blank" rel="noopener" class="inline-flex items-center gap-2 hover:text-white hover:underline">
                        <x-heroicon-o-camera class="size-5" aria-hidden="true" />
                        Instagram <span class="sr-only">(membuka tab baru)</span>
                    </a>
                </p>
            </address>
        </div>
    </div>

    <div class="border-t border-white/10">
        <p class="mx-auto max-w-6xl px-4 py-6 text-sm sm:px-6">&copy; {{ now()->year }} EduLearn. Hak cipta dilindungi.</p>
    </div>
</footer>
