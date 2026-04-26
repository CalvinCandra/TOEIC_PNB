<?php

namespace App\Services\Media;

use App\Models\Audio;
use App\Models\Gambar;
use App\Models\Soal;
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
        $request->validate([
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $filename    = pathinfo($request->file('gambar')->getClientOriginalName(), PATHINFO_FILENAME);
            $ext         = $request->file('gambar')->getClientOriginalExtension();
            $newFilename = $filename . '_' . date('His') . '.' . $ext;

            $request->file('gambar')->storeAs('gambar', $newFilename, [
                'disk'       => 's3',
                'visibility' => 'public',
            ]);

            Gambar::create(['gambar' => $newFilename]);
            DB::commit();

            Log::info('Gambar uploaded to S3: gambar/' . $newFilename);
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Gagal upload gambar ke S3: ' . $th->getMessage());
            return false;
        }
    }

    public function deleteGambar(int $id_gambar): bool
    {
        $gambar = Gambar::find($id_gambar);

        if (! $gambar) {
            return false;
        }

        try {
            soal::where('id_gambar', $id_gambar)->update(['id_gambar' => null]);
            Storage::disk('s3')->delete('gambar/' . $gambar->gambar);
            $gambar->delete();

            Log::info('Gambar deleted from S3: gambar/' . $gambar->gambar);
            return true;
        } catch (\Throwable $th) {
            Log::error('Gagal hapus gambar dari S3: ' . $th->getMessage());
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
        $request->validate([
            'audio' => 'required|mimes:mp3,wav,ogg|max:10240',
        ]);

        DB::beginTransaction();
        try {
            $filename    = pathinfo($request->file('audio')->getClientOriginalName(), PATHINFO_FILENAME);
            $ext         = $request->file('audio')->getClientOriginalExtension();
            $newFilename = $filename . '_' . date('His') . '.' . $ext;

            $request->file('audio')->storeAs('audio', $newFilename, [
                'disk'       => 's3',
                'visibility' => 'public',
            ]);

            Audio::create(['audio' => $newFilename]);
            DB::commit();

            Log::info('Audio uploaded to S3: audio/' . $newFilename);
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Gagal upload audio ke S3: ' . $th->getMessage());
            return false;
        }
    }

    public function deleteAudio(int $id_audio): bool
    {
        $audio = Audio::find($id_audio);

        if (! $audio) {
            return false;
        }

        try {
            soal::where('id_audio', $id_audio)->update(['id_audio' => null]);
            Storage::disk('s3')->delete('audio/' . $audio->audio);
            $audio->delete();

            Log::info('Audio deleted from S3: audio/' . $audio->audio);
            return true;
        } catch (\Throwable $th) {
            Log::error('Gagal hapus audio dari S3: ' . $th->getMessage());
            return false;
        }
    }
}