<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class TemplateExcelService
{
    function downloadTemplate(){
        return Storage::download('public/Template/Participation Data.xlsx');
    }
}
