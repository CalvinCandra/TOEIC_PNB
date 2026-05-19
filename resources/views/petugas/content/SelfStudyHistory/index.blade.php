@extends('petugas.main')
@section('Title', 'Self Study History | All Attempts')

@section('content')
    <section class="p-4 md:ml-64 h-auto pt-20">
        <h1>Self Study History - All Attempts</h1>

        <div class="p-3 sm:p-5 antialiased">
            <div class="bg-white shadow-md sm:rounded-lg overflow-hidden p-3">

                {{-- Tab navigation --}}
                <div class="flex gap-2 mb-5">
                    <a href="/dash{{ $routePrefix }}SelfStudyHistory"
                        class="block text-white bg-brand hover:bg-brand-hover font-medium rounded-lg text-sm px-5 py-2.5">
                        All Attempts
                    </a>
                    <a href="/dash{{ $routePrefix }}SelfStudyHistoryPeserta"
                        class="block text-gray-700 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">
                        By Participant
                    </a>
                </div>

                {{-- Filter Form --}}
                <form method="GET" action="/dash{{ $routePrefix }}SelfStudyHistory" class="mb-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mb-3">
                        <div>
                            <label for="id_bank" class="block mb-2 text-sm font-medium text-gray-900">Bank</label>
                            <select name="id_bank" id="id_bank"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                <option value="">All Banks</option>
                                @foreach ($banks as $b)
                                    <option value="{{ $b->id_bank }}"
                                        {{ ($filters['id_bank'] ?? '') == $b->id_bank ? 'selected' : '' }}>
                                        {{ $b->bank }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="kategori" class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                            <select name="kategori" id="kategori"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                <option value="">All</option>
                                <option value="Listening" {{ ($filters['kategori'] ?? '') === 'Listening' ? 'selected' : '' }}>
                                    Listening
                                </option>
                                <option value="Reading" {{ ($filters['kategori'] ?? '') === 'Reading' ? 'selected' : '' }}>
                                    Reading
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="date_from" class="block mb-2 text-sm font-medium text-gray-900">Date From</label>
                            <input type="date" name="date_from" id="date_from" value="{{ $filters['date_from'] ?? '' }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        </div>
                        <div>
                            <label for="date_to" class="block mb-2 text-sm font-medium text-gray-900">Date To</label>
                            <input type="date" name="date_to" id="date_to" value="{{ $filters['date_to'] ?? '' }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        </div>
                        <div>
                            <label for="search" class="block mb-2 text-sm font-medium text-gray-900">Search (NIM/Nama)</label>
                            <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}"
                                placeholder="Search..."
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit"
                            class="block text-white bg-brand hover:bg-brand-hover font-medium rounded-lg text-sm px-5 py-2.5">
                            Apply Filter
                        </button>
                        <a href="/dash{{ $routePrefix }}SelfStudyHistory"
                            class="block text-gray-700 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">
                            Reset
                        </a>
                    </div>
                </form>

                {{-- Table --}}
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-sm text-left text-gray-500 table-auto">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-4 border-2">No</th>
                                    <th scope="col" class="px-4 py-3 border-2">NIM</th>
                                    <th scope="col" class="px-4 py-3 border-2">Nama</th>
                                    <th scope="col" class="px-4 py-3 border-2">Bank</th>
                                    <th scope="col" class="px-4 py-3 border-2">Part</th>
                                    <th scope="col" class="px-4 py-3 border-2">Attempt</th>
                                    <th scope="col" class="px-4 py-3 border-2">Benar</th>
                                    <th scope="col" class="px-4 py-3 border-2">Salah</th>
                                    <th scope="col" class="px-4 py-3 border-2">Skor</th>
                                    <th scope="col" class="px-4 py-3 border-2">Tanggal</th>
                                    <th scope="col" class="px-4 py-3 border-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($attempts as $a)
                                    <tr class="border-b">
                                        <th class="px-4 py-3 border-2">{{ $loop->iteration + ($attempts->currentPage() - 1) * $attempts->perPage() }}</th>
                                        <td class="px-4 py-3 border-2">{{ $a->peserta->nim ?? '-' }}</td>
                                        <td class="px-4 py-3 border-2">{{ $a->peserta->nama_peserta ?? '-' }}</td>
                                        <td class="px-4 py-3 border-2">{{ $a->bank->bank ?? '-' }}</td>
                                        <td class="px-4 py-3 border-2">
                                            {{ $a->part->part ?? '-' }}
                                            <span class="text-xs text-gray-400">({{ $a->part->kategori ?? '-' }})</span>
                                        </td>
                                        <td class="px-4 py-3 border-2 text-center">#{{ $a->attempt_number }}</td>
                                        <td class="px-4 py-3 border-2 text-green-500">{{ $a->jumlah_benar }}</td>
                                        <td class="px-4 py-3 border-2 text-red-400">{{ $a->jumlah_salah }}</td>
                                        <td class="px-4 py-3 border-2 font-semibold">{{ $a->skor }}%</td>
                                        <td class="px-4 py-3 border-2 text-xs">{{ $a->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-4 py-3 border-2">
                                            <ul class="flex py-1 text-sm">
                                                <li>
                                                    <a href="/dash{{ $routePrefix }}SelfStudyHistoryPeserta/{{ $a->id_peserta }}/Bank/{{ $a->id_bank }}"
                                                        class="flex items-center w-full px-4 py-2 text-green-400 hover:bg-gray-100 hover:scale-95">
                                                        <i class="fa-solid fa-eye me-1"></i>
                                                        Detail
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="px-4 py-8 text-center text-gray-500 border-2">
                                            No attempts found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Pagination --}}
                <div class="px-4 py-3">
                    {{ $attempts->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
