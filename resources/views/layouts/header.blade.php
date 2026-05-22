<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- CDN Tailwind -->
<!-- <script src="https://cdn.tailwindcss.com"></script> -->
@vite('resources/css/app.css')

<!-- Flowbite -->
<script src="https://unpkg.com/flowbite@2.3.0/dist/flowbite.min.js"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<!-- CDN Fontawsome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

{{-- favicon --}}
<link rel="shortcut icon" href="{{asset('img/logo unit.png')}}" type="image/x-icon">

{{-- goole font --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

<style>
    /* Force Flowbite modal backdrops to stack above fixed top layout navbar (z-50) & sidebar (z-40) */
    [modal-backdrop],
    .fixed.inset-0.bg-gray-900\/50,
    .fixed.inset-0.bg-slate-900\/40 {
        z-index: 60 !important;
        background-color: rgba(15, 23, 42, 0.4) !important; /* bg-slate-900/40 */
        backdrop-filter: blur(4px) !important; /* backdrop-blur-sm */
        -webkit-backdrop-filter: blur(4px) !important;
    }

    /* Ensure all Flowbite modals sit above the backdrop (z-60) */
    div[tabindex="-1"].fixed.z-50,
    div[tabindex="-1"].fixed.z-\[50\],
    [data-modal-backdrop="static"] {
        z-index: 70 !important;
    }
</style>