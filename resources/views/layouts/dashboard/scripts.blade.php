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

{{-- CK Editor Direction --}}
<script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editorTambah'), {
            toolbar: {
                items: [
                    'undo', 'redo', '|',
                    'paragraft', '|',
                    'bold', 'italic', '|',
                    'blockQuote',
                    'bulletedList', 'numberedList'
                ]
            },
        })
        .catch(error => {
            console.error(error);
        });
</script>

{{-- CK Editor Direction Update --}}
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
                            'blockQuote',
                            'bulletedList', 'numberedList'
                        ]
                    },
                })
                .catch(error => {
                    console.error(error);
                });
        });
    });
</script>

{{-- CK Editor Multi --}}
<script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editorTambahMulti'), {
            toolbar: {
                items: [
                    'undo', 'redo', '|',
                    'paragraft', '|',
                    'bold', 'italic', '|',
                    'blockQuote',
                    'bulletedList', 'numberedList'
                ]
            },
        })
        .catch(error => {
            console.error(error);
        });
</script>

{{-- CK Editor Update Multi --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.editorMulti').forEach(function(editorElement) {
            ClassicEditor
                .create(editorElement, {
                    toolbar: {
                        items: [
                            'undo', 'redo', '|',
                            'paragraft', '|',
                            'bold', 'italic', '|',
                            'blockQuote',
                            'bulletedList', 'numberedList'
                        ]
                    },
                })
                .catch(error => {
                    console.error(error);
                });
        });
    });
</script>

<script>
    const nimInput = document.getElementById('nim');
    const note = document.getElementById('note');

    if (nimInput && note) {
        nimInput.addEventListener('keyup', () => {
            if (nimInput.value.length != 10) {
                note.textContent = 'The NIM must be 10 characters.';
            } else {
                note.textContent = '';
            }
        });
    }
</script>

{{-- Live Search with Debounce --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('live-search-input');
    const clearBtn = document.getElementById('live-search-clear');
    const resultsContainer = document.getElementById('search-results-container');

    if (!searchInput || !resultsContainer) return;

    let debounceTimer = null;
    let currentAbortController = null;

    // Toggle clear button visibility
    function toggleClear() {
        if (!clearBtn) return;
        if (searchInput.value.length > 0) {
            clearBtn.classList.remove('hidden');
        } else {
            clearBtn.classList.add('hidden');
        }
    }

    // Show loading state
    function setLoading(isLoading) {
        const spinner = document.getElementById('live-search-spinner');
        const searchIcon = document.getElementById('live-search-icon');
        if (spinner && searchIcon) {
            spinner.classList.toggle('hidden', !isLoading);
            searchIcon.classList.toggle('hidden', isLoading);
        }
    }

    // Perform the search
    function performSearch(query) {
        // Cancel any in-flight request
        if (currentAbortController) {
            currentAbortController.abort();
        }
        currentAbortController = new AbortController();

        // Build URL with search param
        const url = new URL(window.location.href);
        if (query.trim()) {
            url.searchParams.set('search', query.trim());
        } else {
            url.searchParams.delete('search');
        }
        // Reset to page 1 when searching
        url.searchParams.delete('page');

        setLoading(true);

        fetch(url.toString(), {
            signal: currentAbortController.signal,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            // Parse the response HTML
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newResults = doc.getElementById('search-results-container');

            if (newResults) {
                resultsContainer.innerHTML = newResults.innerHTML;

                // Re-init Flowbite components for dropdowns/modals in new content
                if (typeof initFlowbite === 'function') {
                    initFlowbite();
                }
            }

            // Update URL without reload
            history.replaceState(null, '', url.toString());
            setLoading(false);
        })
        .catch(err => {
            if (err.name !== 'AbortError') {
                console.error('Live search error:', err);
                setLoading(false);
            }
        });
    }

    // Debounced input handler
    searchInput.addEventListener('input', function () {
        toggleClear();
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            performSearch(searchInput.value);
        }, 300);
    });

    // Clear button handler
    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            searchInput.value = '';
            toggleClear();
            searchInput.focus();
            clearTimeout(debounceTimer);
            performSearch('');
        });
    }

    // Prevent form submit (Enter key) — let live search handle it
    const searchForm = searchInput.closest('form');
    if (searchForm) {
        searchForm.addEventListener('submit', function (e) {
            e.preventDefault();
            clearTimeout(debounceTimer);
            performSearch(searchInput.value);
        });
    }

    // Init clear button state on page load
    toggleClear();
});
</script>
