<?php

namespace App\Services\Media;

use App\Models\Audio;
use App\Models\Gambar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    public function getGambarAll()
    {
        Log::info('[MediaService::getGambarAll] Mengambil semua gambar');

        return Gambar::latest()->paginate(20);
    }

    public function storeGambar(Request $request): bool
    {
        Log::info('[MediaService::storeGambar] Memulai upload gambar');

        $request->validate([
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $path = $request->file('gambar')->store('public/gambar');
            Gambar::create(['gambar' => basename($path)]);
            DB::commit();
            Log::info('[MediaService::storeGambar] Upload gambar berhasil', [
                'gambar' => basename($path),
            ]);

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[MediaService::storeGambar] Upload gambar gagal', [
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }

    public function deleteGambar(int $id_gambar): bool
    {
        Log::info('[MediaService::deleteGambar] Memulai hapus gambar', [
            'id_gambar' => $id_gambar,
        ]);

        $gambar = Gambar::find($id_gambar);

        if (! $gambar) {
            Log::warning('[MediaService::deleteGambar] Gambar tidak ditemukan', [
                'id_gambar' => $id_gambar,
            ]);

            return false;
        }

        try {
            \App\Models\Soal::where('id_gambar', $id_gambar)->update(['id_gambar' => null]);
            Storage::delete('public/gambar/'.$gambar->gambar);
            $gambar->delete();
            Log::info('[MediaService::deleteGambar] Hapus gambar berhasil', [
                'id_gambar' => $id_gambar,
                'gambar' => $gambar->gambar,
            ]);

            return true;
        } catch (\Throwable $th) {
            Log::error('[MediaService::deleteGambar] Hapus gambar gagal', [
                'id_gambar' => $id_gambar,
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }

    public function getAudioAll()
    {
        Log::info('[MediaService::getAudioAll] Mengambil semua audio');

        return Audio::latest()->paginate(20);
    }

    public function storeAudio(Request $request): bool
    {
        Log::info('[MediaService::storeAudio] Memulai upload audio');

        $request->validate([
            'audio' => 'required|mimes:mp3,wav,ogg|max:10240',
        ]);

        DB::beginTransaction();
        try {
            $path = $request->file('audio')->store('public/audio');
            Audio::create(['audio' => basename($path)]);
            DB::commit();
            Log::info('[MediaService::storeAudio] Upload audio berhasil', [
                'audio' => basename($path),
            ]);

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[MediaService::storeAudio] Upload audio gagal', [
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }

    public function deleteAudio(int $id_audio): bool
    {
        Log::info('[MediaService::deleteAudio] Memulai hapus audio', [
            'id_audio' => $id_audio,
        ]);

        $audio = Audio::find($id_audio);

        if (! $audio) {
            Log::warning('[MediaService::deleteAudio] Audio tidak ditemukan', [
                'id_audio' => $id_audio,
            ]);

            return false;
        }

        try {
            \App\Models\Soal::where('id_audio', $id_audio)->update(['id_audio' => null]);
            Storage::delete('public/audio/'.$audio->audio);
            $audio->delete();
            Log::info('[MediaService::deleteAudio] Hapus audio berhasil', [
                'id_audio' => $id_audio,
                'audio' => $audio->audio,
            ]);

            return true;
        } catch (\Throwable $th) {
            Log::error('[MediaService::deleteAudio] Hapus audio gagal', [
                'id_audio' => $id_audio,
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return false;
        }
    }
}
