<?php

namespace App\Services\Zip;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ZipService
{
    public function downloadBySession(string $sesi)
    {
        Log::info('[ZipService::downloadBySession] Download ZIP sesi', ['sesi' => $sesi]);

        $folderPath = "public/result/{$sesi}";
        $files = Storage::files($folderPath);

        if (empty($files)) {
            Log::warning('[ZipService::downloadBySession] Folder kosong', ['sesi' => $sesi]);

            return null;
        }

        $zipFileName = "{$sesi}_result.zip";
        $zipPath = storage_path("app/public/{$zipFileName}");

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            Log::error('[ZipService::downloadBySession] Gagal membuat ZIP', ['sesi' => $sesi]);

            return null;
        }

        foreach ($files as $file) {
            $zip->addFile(storage_path("app/{$file}"), basename($file));
        }
        $zip->close();

        Log::info('[ZipService::downloadBySession] ZIP berhasil dibuat', [
            'sesi' => $sesi,
            'jumlah' => count($files),
            'zip_path' => $zipPath,
        ]);

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
