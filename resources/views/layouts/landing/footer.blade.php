<footer class="bg-brand py-14 px-6" id="contact">
    <div class="max-w-5xl mx-auto">

        <div class="grid md:grid-cols-3 gap-10 mb-10">

            {{-- Kolom 1: Penjelasan TOEIC --}}
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('auth/login.png') }}" alt="Logo PNB" class="w-[30%] object-contain" loading="lazy" />
                </div>
                <p class="text-sm font-normal text-blue-200/70 leading-relaxed mb-4">
                    Welcome to the TOEIC Assessment platform of Politeknik Negeri Bali.
                    Practice and improve your English proficiency score.
                </p>
                <a href="mailto:language-center@pnb.ac.id"
                    class="text-sm font-normal text-blue-300 no-underline hover:text-white transition-colors">
                    language-center@pnb.ac.id
                </a>

                {{-- Social Media --}}
                <div class="mt-6">
                    <h4 class="text-xs font-semibold text-blue-300/60 uppercase tracking-widest mb-3">Follow Us</h4>
                    <div class="flex gap-3">
                        <a href="#"
                            class="w-9 h-9 rounded-lg bg-blue-500/15 border border-blue-400/20 flex items-center justify-center text-blue-300 hover:text-white hover:bg-blue-600 transition-all no-underline">
                            <i class="fa-brands fa-facebook-f text-sm"></i>
                        </a>
                        <a href="#"
                            class="w-9 h-9 rounded-lg bg-blue-500/15 border border-blue-400/20 flex items-center justify-center text-blue-300 hover:text-white hover:bg-blue-600 transition-all no-underline">
                            <i class="fa-brands fa-youtube text-sm"></i>
                        </a>
                        <a href="#"
                            class="w-9 h-9 rounded-lg bg-blue-500/15 border border-blue-400/20 flex items-center justify-center text-blue-300 hover:text-white hover:bg-blue-600 transition-all no-underline">
                            <i class="fa-brands fa-instagram text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Kolom 2: Navigasi --}}
            <div>
                <h4 class="text-xs font-semibold text-blue-300/60 uppercase tracking-widest mb-4">Navigation</h4>
                <ul class="space-y-3 list-none p-0 m-0">
                    <li><a href="#home"
                            class="text-sm font-normal text-blue-200/70 hover:text-white no-underline transition-colors">Home</a>
                    </li>
                    <li><a href="#about"
                            class="text-sm font-normal text-blue-200/70 hover:text-white no-underline transition-colors">About</a>
                    </li>
                    {{-- <li><a href="#tutorial"
                            class="text-sm font-normal text-blue-200/70 hover:text-white no-underline transition-colors">Tutorial</a>
                    </li> --}}
                    <li><a href="#contact"
                            class="text-sm font-normal text-blue-200/70 hover:text-white no-underline transition-colors">Contact</a>
                    </li>
                </ul>
            </div>

            {{-- Kolom 3: Maps --}}
            <div>
                <h4 class="text-xs font-semibold text-blue-300/60 uppercase tracking-widest mb-4">Location</h4>
                <div class="aspect-square w-full rounded-xl overflow-hidden border border-blue-400/20">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d631.3527171427712!2d115.16180381854146!3d-8.799051666950154!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd244c13ee9d753%3A0x6c05042449b50f81!2sPoliteknik%20Negeri%20Bali!5e0!3m2!1sid!2sus!4v1776737742142!5m2!1sid!2sus"
                        width="100%" height="100%" style="border:0; display:block;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" title="Politeknik Negeri Bali Location">
                    </iframe>
                </div>
            </div>

        </div>

        <div class="border-t border-blue-400/15 pt-6 text-center">
            <p class="text-sm font-normal text-blue-200/40">
                &copy; 2026 TOEIC Assessment — Politeknik Negeri Bali. All rights reserved.
            </p>
        </div>

    </div>
</footer>
