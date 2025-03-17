<?php

namespace App\Http\Controllers;

use ZipArchive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ZipController extends Controller
{
    public function index($sesi){
        $folderPath = "public/result/$sesi"; // Path folder sesi
        $files = Storage::files($folderPath); // Ambil semua file dalam folder sesi

        if (empty($files)) {
            toast('There are no results yet in this session','error');
            return redirect()->back();
        }

        // Nama ZIP yang akan didownload
        $zipFileName = $sesi."_result.zip";
        $zipPath = storage_path("app/public/$zipFileName");

        // Buat ZIP
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($files as $file) {
                $filePath = storage_path("app/$file"); // Path lengkap file
                $zip->addFile($filePath, basename($file)); // Tambahkan file ke ZIP
            }
            $zip->close();
        }

        // Download ZIP
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
