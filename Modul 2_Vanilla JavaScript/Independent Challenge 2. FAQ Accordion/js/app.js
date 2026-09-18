const pertanyaan = document.querySelectorAll('.faq-question');

pertanyaan.forEach((tombol)=> {
    tombol.addEventListener('click', () => {
        const item = tombol.closest('.faq-item');
        const sedangTerbuka = item.classList.contains('is-open');

        pertanyaan.forEach((tombolLain) => {
            const itemLain = tombolLain.closest('.faq-item');

            itemLain.classList.remove('is-open');
            tombolLain.setAttribute('aria-expanded', 'false');
        });

        if (!sedangTerbuka) {
            item.classList.add('is-open');
            tombol.setAttribute('aria-expanded', 'true');
        }
    });
});
