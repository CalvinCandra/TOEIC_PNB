<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function index(Request $request){
        return view('petugas.content.dashboard');
    }
}
