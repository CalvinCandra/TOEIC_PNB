<?php

namespace App\Http\Controllers;

use App\Services\Zip\ZipService;

class ZipController extends Controller
{
    public function __construct(protected ZipService $zipService) {}

    public function index(string $sesi)
    {
        $response = $this->zipService->downloadBySession($sesi);

        if (! $response) {
            toast('There are no results yet in this session', 'error');

            return redirect()->back();
        }

        return $response;
    }
}
