/**
 * Tombol buka/tutup (menu navigasi HP, menu user, sidebar dashboard).
 * Markup: <button data-toggle aria-controls="id-target" aria-expanded="false">
 * Target disembunyikan dengan class `hidden`; atribut aria-expanded selalu ikut diperbarui
 * supaya pembaca layar tahu status menu.
 */
document.querySelectorAll('[data-toggle]').forEach((button) => {
    const target = document.getElementById(button.getAttribute('aria-controls'));

    if (!target) {
        return;
    }

    const setOpen = (open) => {
        button.setAttribute('aria-expanded', String(open));
        target.classList.toggle('hidden', !open);
    };

    button.addEventListener('click', () => setOpen(button.getAttribute('aria-expanded') !== 'true'));

    // Menu dropdown ikut tertutup saat klik di luar atau saat menekan Escape
    if (button.dataset.toggle === 'dropdown') {
        document.addEventListener('click', (event) => {
            if (!button.contains(event.target) && !target.contains(event.target)) {
                setOpen(false);
            }
        });
    }

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && button.getAttribute('aria-expanded') === 'true') {
            setOpen(false);
            button.focus();
        }
    });
});

/**
 * Tombol tampilkan/sembunyikan password.
 * Markup: <button data-password-toggle aria-controls="id-input" aria-pressed="false">
 */
document.querySelectorAll('[data-password-toggle]').forEach((button) => {
    const input = document.getElementById(button.getAttribute('aria-controls'));

    button.addEventListener('click', () => {
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        button.setAttribute('aria-pressed', String(show));
        button.querySelector('[data-label]').textContent = show ? 'Sembunyikan password' : 'Tampilkan password';
    });
});

/**
 * Konfirmasi sebelum menghapus. Markup: <form data-confirm="Hapus course ini?">
 */
document.querySelectorAll('form[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        if (!window.confirm(form.dataset.confirm)) {
            event.preventDefault();
        }
    });
});

/**
 * Tombol tutup pada pesan notifikasi.
 */
document.querySelectorAll('[data-dismiss]').forEach((button) => {
    button.addEventListener('click', () => button.closest('[data-flash]')?.remove());
});
