{{-- Live Search Component --}}
{{-- Usage: @include('layouts.dashboard.live-search', ['placeholder' => 'Search by name, NIM...']) --}}
<div class="w-full">
    <form class="flex items-center" method="GET" id="live-search-form">
        <label for="live-search-input" class="sr-only">Search</label>
        <div class="relative w-full">
            {{-- Search icon (left) --}}
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg id="live-search-icon" aria-hidden="true" class="w-5 h-5 text-gray-400 transition-colors" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                {{-- Loading spinner (hidden by default) --}}
                <svg id="live-search-spinner" class="hidden w-5 h-5 text-blue-500 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            {{-- Input --}}
            <input type="text" id="live-search-input" name="search"
                class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 block w-full pl-10 pr-10 p-2.5 transition-all duration-200 outline-none placeholder:text-gray-400"
                value="{{ request('search') }}" placeholder="{{ $placeholder ?? 'Search...' }}" autocomplete="off">

            {{-- Clear button (right) --}}
            <button type="button" id="live-search-clear"
                class="hidden absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 transition-colors cursor-pointer"
                title="Clear search">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </form>
</div>
