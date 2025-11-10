// Smooth scroll ke atas saat klik navbar brand
document.querySelectorAll('.navbar-brand').forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});

// Efek hover dinamis pada tombol
document.querySelectorAll('.btn-custom').forEach(button => {
    button.addEventListener('mouseenter', () => {
        button.style.boxShadow = '0 4px 12px rgba(0, 128, 0, 0.4)';
    });
    button.addEventListener('mouseleave', () => {
        button.style.boxShadow = 'none';
    });
});

// Menampilkan alert sambutan saat pertama kali masuk dashboard
document.addEventListener('DOMContentLoaded', () => {
    if (document.body.classList.contains('dashboard-page')) {
        setTimeout(() => {
            const alertBox = document.createElement('div');
            alertBox.className = 'alert alert-success shadow position-fixed top-0 start-50 translate-middle-x mt-3';
            alertBox.style.zIndex = '9999';
            alertBox.textContent = '🌲 Selamat datang di GoCamp! Siap berpetualang?';
            document.body.appendChild(alertBox);
            setTimeout(() => alertBox.remove(), 4000);
        }, 600);
    }
});

// Inisialisasi AOS (Animate On Scroll)
document.addEventListener('DOMContentLoaded', () => {
    if (window.AOS) {
        AOS.init({ duration: 800, once: true });
    }
});
