<nav class="bg-white border-b border-gray-200 px-4 py-2 fixed left-0 right-0 top-0 z-50">
    <div class="flex flex-wrap justify-between items-center">
        <div class="flex justify-start items-center">
            <button data-drawer-target="drawer-navigation" data-drawer-toggle="drawer-navigation"
                aria-controls="drawer-navigation"
                class="py-2 px-3 mr-2 text-gray-900 rounded-lg cursor-pointer md:hidden hover:text-gray-900 focus:bg-gray-100 focus:ring-2 focus:ring-gray-100">
                <i class="fa-solid fa-bars"></i>
                <span class="sr-only">Toggle sidebar</span>
            </button>

            <span class="self-center text-2xl font-semibold whitespace-nowrap">TOEIC</span>
        </div>
        <div class="flex items-center lg:order-2">

            <button type="button"
                class="flex mx-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300"
                id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown">
                <span class="sr-only">Open user menu</span>
                <div class="w-8 h-8 rounded-full overflow-hidden bg-white shadow-md">
                    <img class="w-full" src="{{ asset('profile/profile.png') }}" alt="user photo" loading="lazy" />
                </div>
            </button>
            <!-- Dropdown menu -->
            <div class="hidden z-50 my-4 w-56 text-base list-none bg-white divide-y divide-gray-100 shadow "
                id="dropdown">
                <div class="py-3 px-4">
                    <span class="block text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</span>
                    <span class="block text-sm text-gray-900 truncate">{{ auth()->user()->email }}</span>
                </div>
                <ul class="py-1 text-gray-700" aria-labelledby="dropdown">
                    <li>
                        <a href="{{ url('/') }}"
                            class="block py-2 px-4 text-sm font-bold hover:bg-gray-100">Landing Page</a>
                    </li>
                    <li>
                        <a href="{{ url('/logout') }}" class="block py-2 px-4 text-sm font-bold hover:bg-gray-100">Sign
                            out</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
