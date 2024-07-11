@vite('resources/js/app.js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
<script src="../path/to/flowbite/dist/flowbite.min.js"></script>
<script src="https://kit.fontawesome.com/7eaa0f0932.js" crossorigin="anonymous"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.modal-form');
        const overlay = document.getElementById('overlay');

        forms.forEach(form => {
            form.addEventListener('submit', function(event) {
                overlay.classList.remove('hidden');
                overlay.classList.add('flex');
            });
        });
    });
</script>