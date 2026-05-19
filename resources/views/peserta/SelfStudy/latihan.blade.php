@extends('peserta.main')

@section('content')
    <section class="p-4 md:ml-64 h-auto pt-20">
        <div class="p-3 sm:p-5 antialiased">

            <div class="bg-white border border-gray-200 rounded-2xl p-5 mb-6">
                <div class="flex items-center justify-between mb-2">
                    <span
                        class="text-xs font-semibold px-2 py-1 rounded
                  {{ $part->kategori === 'Listening' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                        {{ $part->kategori }} — Self Study
                    </span>
                    <a href="/SelfStudy/Bank/{{ $bank->id_bank }}" class="text-sm text-gray-500 hover:text-red-600">
                        ← Cancel
                    </a>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $part->part }}</h1>
                <p class="text-sm text-gray-500 mb-2">Bank: {{ $bank->bank }}</p>
                <p class="text-gray-600 mt-2">{{ $part->petunjuk }}</p>
            </div>

            @if ($part->kategori === 'Listening' && $part->audio)
                <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm font-semibold text-blue-800 mb-2">
                        🎧 Part Audio (replay as many times as you want)
                    </p>
                    <audio controls class="w-full">
                        <source src="{{ Storage::disk('s3')->url('audio/' . $part->audio->audio) }}" type="audio/mpeg">
                    </audio>
                </div>
            @endif

            @if ($part->kategori === 'Reading' && $part->multi_soal)
                <div class="mb-6 bg-gray-50 border rounded-lg p-5 prose max-w-none">
                    {!! $part->multi_soal !!}
                </div>
            @endif

            <form action="/SelfStudy/Submit" method="POST" id="form-selfstudy">
                @csrf
                <input type="hidden" name="id_bank" value="{{ $bank->id_bank }}">
                <input type="hidden" name="id_part" value="{{ $part->id_part }}">
                <input type="hidden" name="durasi_detik" id="durasi_detik" value="0">

                @foreach ($soal as $s)
                    <div class="bg-white border border-gray-200 rounded-2xl p-5 mb-4">
                        <div class="flex items-start gap-3">
                            <span
                                class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 text-blue-700
                                 flex items-center justify-center font-bold">
                                {{ $s->nomor_soal }}
                            </span>
                            <div class="flex-1">
                                @if ($s->soal)
                                    <p class="font-semibold text-gray-800 mb-3">{{ $s->soal }}</p>
                                @endif
                                @if ($s->text)
                                    <div class="text-gray-700 mb-3">{!! $s->text !!}</div>
                                @endif
                                @if ($s->gambar)
                                    <img src="{{ Storage::disk('s3')->url('gambar/' . $s->gambar->gambar) }}"
                                        class="my-3 max-w-full rounded border">
                                @endif
                                @if ($s->audio && $part->kategori === 'Listening')
                                    <audio controls class="my-3 w-full">
                                        <source src="{{ Storage::disk('s3')->url('audio/' . $s->audio->audio) }}"
                                            type="audio/mpeg">
                                    </audio>
                                @endif

                                <div class="space-y-2 mt-3">
                                    @foreach (['A', 'B', 'C', 'D'] as $opt)
                                        @php $field = 'jawaban_' . strtolower($opt); @endphp
                                        @if ($s->$field)
                                            <label
                                                class="flex items-start gap-2 p-2 rounded hover:bg-gray-50 cursor-pointer">
                                                <input type="radio" name="jawaban[{{ $s->id_soal }}]"
                                                    value="{{ $opt }}" class="mt-1"> {{ $s->$field }}
                                            </label>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div
                    class="flex justify-between items-center mt-6 sticky bottom-0 bg-white border border-gray-200 rounded-2xl p-4">
                    <a href="/SelfStudy/Bank/{{ $bank->id_bank }}"
                        class="px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-lg font-semibold">
                        <i class="fa-solid fa-paper-plane me-1"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </section>

    <script>
        const startTime = Date.now();
        document.getElementById('form-selfstudy').addEventListener('submit', () => {
            document.getElementById('durasi_detik').value = Math.floor((Date.now() - startTime) / 1000);
        });
    </script>
@endsection
