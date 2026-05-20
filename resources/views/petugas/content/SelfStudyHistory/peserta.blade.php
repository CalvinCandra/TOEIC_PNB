@extends('petugas.main')
@section('Title', 'Self Study History | By Participant')

@section('content')
    <section class="p-4 md:ml-64 h-auto pt-20">
        <h1>Self Study History - By Participant</h1>

        <div class="p-3 sm:p-5 antialiased">
            <div class="bg-white shadow-md sm:rounded-lg overflow-hidden p-3">

                {{-- Filter Form --}}
                <form method="GET" action="/dash{{ $routePrefix }}SelfStudyHistoryPeserta" class="mb-5">
                    <div class="mb-3">
                        <label for="search" class="block mb-2 text-sm font-medium text-gray-900">Search (NIM/Nama)</label>
                        <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}"
                            placeholder="Search by NIM or name..."
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit"
                            class="block text-white bg-brand hover:bg-brand-hover font-medium rounded-lg text-sm px-5 py-2.5">
                            Filter
                        </button>
                        <a href="/dash{{ $routePrefix }}SelfStudyHistoryPeserta"
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
                                    <th scope="col" class="px-4 py-3 border-2">Banks Done</th>
                                    <th scope="col" class="px-4 py-3 border-2">Total Attempts</th>
                                    <th scope="col" class="px-4 py-3 border-2">Best Score</th>
                                    <th scope="col" class="px-4 py-3 border-2">Last Activity</th>
                                    <th scope="col" class="px-4 py-3 border-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($peserta as $p)
                                    <tr class="border-b">
                                        <th class="px-4 py-3 border-2">{{ $loop->iteration + ($peserta->currentPage() - 1) * $peserta->perPage() }}</th>
                                        <td class="px-4 py-3 border-2">{{ $p->nim }}</td>
                                        <td class="px-4 py-3 border-2">{{ $p->nama_peserta }}</td>
                                        <td class="px-4 py-3 border-2 text-center">{{ $p->total_banks }}</td>
                                        <td class="px-4 py-3 border-2 text-center">{{ $p->total_attempts }}</td>
                                        <td class="px-4 py-3 border-2 font-semibold">{{ $p->best_skor }}</td>
                                        <td class="px-4 py-3 border-2 text-xs">
                                            {{ \Carbon\Carbon::parse($p->last_activity)->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-4 py-3 border-2">
                                            <ul class="flex py-1 text-sm">
                                                <li>
                                                    <a href="/dash{{ $routePrefix }}SelfStudyHistoryPeserta/{{ $p->id_peserta }}"
                                                        class="flex items-center w-full px-4 py-2 text-green-400 hover:bg-gray-100 hover:scale-95">
                                                        <i class="fa-solid fa-eye me-1"></i>
                                                        View Detail
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-8 text-center text-gray-500 border-2">
                                            No participants with attempts yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Pagination --}}
                <div class="px-4 py-3">
                    {{ $peserta->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
