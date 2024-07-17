<script src="../path/to/flowbite/dist/flowbite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    function setActiveLink() {
        const links = document.querySelectorAll('.nav-link');
        const hash = window.location.hash;

        links.forEach(link => {
            link.classList.remove('text-white', 'bg-[#219EBC]', 'md:bg-transparent', 'md:text-[#219EBC]');
            link.classList.add('text-gray-900', 'hover:bg-gray-100', 'md:hover:bg-transparent', 'md:hover:text-[#219EBC]', 'dark:text-white', 'dark:hover:bg-gray-700', 'md:dark:hover:text-blue-500');
        });

        if (hash) {
            const activeLink = document.querySelector(`a[href="${hash}"]`);
            if (activeLink) {
                activeLink.classList.add('text-white', 'bg-[#219EBC]', 'md:bg-transparent', 'md:text-[#219EBC]');
                activeLink.classList.remove('text-gray-900', 'hover:bg-gray-100', 'md:hover:bg-transparent', 'md:hover:text-[#219EBC]', 'dark:text-white', 'dark:hover:bg-gray-700', 'md:dark:hover:text-blue-500');
            }
        }
    }

    window.addEventListener('hashchange', setActiveLink);
    setActiveLink();
});

</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.modal-form');
        const overlay = document.getElementById('overlay');

        // Menampilkan overlay saat pengguna meninggalkan halaman
        window.addEventListener('beforeunload', function(event) {
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
        });

        // Menyembunyikan overlay setelah halaman sepenuhnya dimuat
        window.addEventListener('load', function(event) {
            overlay.classList.remove('flex');
            overlay.classList.add('hidden');
        });
    });
</script>