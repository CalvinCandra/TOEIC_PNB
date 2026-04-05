<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Loading overlay ──
    const overlay = document.getElementById('overlay');
    if (overlay) {
        window.addEventListener('beforeunload', function () {
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
        });
        window.addEventListener('load', function () {
            overlay.classList.remove('flex');
            overlay.classList.add('hidden');
        });
    }

    // ── Active nav link berdasarkan hash ──
    const navLinks = document.querySelectorAll('.nav-link');

    function setActiveLink() {
        const hash = window.location.hash || '#home';
        navLinks.forEach(link => {
            const isActive = link.getAttribute('href') === hash;
            link.classList.toggle('text-[#219EBC]', isActive);
            link.classList.toggle('font-semibold', isActive);
            link.classList.toggle('text-slate-600', !isActive);
        });
    }

    window.addEventListener('hashchange', setActiveLink);
    setActiveLink();

    // ── Scroll spy: deteksi section aktif saat scroll ──
    const sections = document.querySelectorAll('section[id]');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.getAttribute('id');
                window.history.replaceState(null, '', '#' + id);
                setActiveLink();
            }
        });
    }, { threshold: 0.4 });

    sections.forEach(s => observer.observe(s));

});
</script>
