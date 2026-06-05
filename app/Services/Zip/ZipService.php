<?php

namespace App\Services\Zip;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ZipService
{
    public function downloadBySession(string $sesi)
    {
        Log::info('[ZipService::downloadBySession] Mulai proses Download ZIP sesi dari S3', ['sesi' => $sesi]);

        $folderPath = "result/{$sesi}"; 
        
        $files = Storage::disk('s3')->files($folderPath);

        if (empty($files)) {
            Log::warning('[ZipService::downloadBySession] Folder kosong atau tidak ditemukan di S3', ['sesi' => $sesi]);
            return null;
        }

        $zipFileName = "{$sesi}_result.zip";
        $zipPath = storage_path("app/public/{$zipFileName}");

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            Log::error('[ZipService::downloadBySession] Gagal membuat file ZIP di server lokal', ['sesi' => $sesi]);
            return null;
        }

        foreach ($files as $file) {
            $fileContent = Storage::disk('s3')->get($file);
            
            $zip->addFromString(basename($file), $fileContent);
        }
        $zip->close();

        Log::info('[ZipService::downloadBySession] ZIP berhasil dibuat dari S3', [
            'sesi' => $sesi,
            'jumlah_file' => count($files),
            'zip_path' => $zipPath,
        ]);

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}