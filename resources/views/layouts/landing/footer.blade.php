<footer class="bg-[#1D3752] py-14 px-4 lg:px-8" id="contact">
    <div class="max-w-screen-xl mx-auto">

        <div class="grid md:grid-cols-3 gap-10 mb-10">

            {{-- Kolom 1: Penjelasan TOEIC --}}
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('auth/login.png') }}" alt="Logo PNB" class="w-[30%] object-contain" loading="lazy" />
                </div>
                <p class="text-base font-normal text-slate-400 leading-relaxed mb-4">
                    Welcome to the TOEIC Assessment platform of Politeknik Negeri Bali.
                    Practice and improve your English proficiency score.
                </p>
                <a href="mailto:language-center@pnb.ac.id"
                    class="text-base font-normal text-blue-300 no-underline hover:underline">
                    language-center@pnb.ac.id
                </a>

                {{-- Social Media --}}
                <div class="mt-6">
                    <h4 class="text-base font-semibold text-white uppercase tracking-widest mb-3">Follow Us</h4>
                    <div class="flex gap-3">
                        <a href="#"
                            class="w-9 h-9 rounded-lg bg-blue-900 flex items-center justify-center text-slate-400 hover:text-white hover:bg-blue-950 transition-colors no-underline">
                            <i class="fa-brands fa-facebook-f text-sm"></i>
                        </a>
                        <a href="#"
                            class="w-9 h-9 rounded-lg bg-blue-800 flex items-center justify-center text-slate-400 hover:text-white hover:bg-red-500 transition-colors no-underline">
                            <i class="fa-brands fa-youtube text-sm"></i>
                        </a>
                        <a href="#"
                            class="w-9 h-9 rounded-lg bg-blue-800 flex items-center justify-center text-slate-400 hover:text-white hover:bg-pink-500 transition-colors no-underline">
                            <i class="fa-brands fa-instagram text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Kolom 2: Navigasi --}}
            <div>
                <h4 class="text-base font-semibold text-white uppercase tracking-widest mb-4">Navigation</h4>
                <ul class="space-y-3 list-none p-0 m-0">
                    <li><a href="#home"
                            class="text-base font-normal text-slate-400 hover:text-white no-underline transition-colors">Home</a>
                    </li>
                    <li><a href="#about"
                            class="text-base font-normal text-slate-400 hover:text-white no-underline transition-colors">About</a>
                    </li>
                    <li><a href="#tutorial"
                            class="text-base font-normal text-slate-400 hover:text-white no-underline transition-colors">Tutorial</a>
                    </li>
                    <li><a href="#contact"
                            class="text-base font-normal text-slate-400 hover:text-white no-underline transition-colors">Contact</a>
                    </li>
                </ul>
            </div>

            {{-- Kolom 3: Maps (kotak persegi, paling kanan) --}}
            <div>
                <h4 class="text-base font-semibold text-white uppercase tracking-widest mb-4">Location</h4>
                <div class="aspect-square w-full rounded-xl overflow-hidden border border-blue-900">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.219!2d115.1742!3d-8.7345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOMKwNDQnMDQuMiJTIDExNcKwMTAnMjcuMSJF!5e0!3m2!1sen!2sid!4v1234567890"
                        width="100%" height="100%" style="border:0; display:block;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" title="Politeknik Negeri Bali Location">
                    </iframe>
                </div>
            </div>

        </div>

        <div class="border-t border-blue-900 pt-6 text-center">
            <p class="text-base font-normal text-slate-500">
                &copy; 2024 TOEIC Assessment — Politeknik Negeri Bali. All rights reserved.
            </p>
        </div>

    </div>
</footer>
