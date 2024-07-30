@vite('resources/js/app.js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
<script src="../path/to/flowbite/dist/flowbite.min.js"></script>
<script src="https://kit.fontawesome.com/7eaa0f0932.js" crossorigin="anonymous"></script>

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

<script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editorTambah'), {
            toolbar: {
                items: [
                    'undo', 'redo', '|',
                    'paragraft', '|',
                    'bold', 'italic', '|',
                    'numberedList', 'bulletedList', '|',
                    'blockQuote',
                ]
            },
        })
        .catch(error => {
            console.error(error);
        });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.editor').forEach(function(editorElement) {
            ClassicEditor
                .create(editorElement, {
                    toolbar: {
                        items: [
                            'undo', 'redo', '|',
                            'paragraft', '|',
                            'bold', 'italic', '|',
                            'numberedList', 'bulletedList', '|',
                            'blockQuote',
                        ]
                    },
                })
                .catch(error => {
                    console.error(error);
                });
        });
    });
</script>
