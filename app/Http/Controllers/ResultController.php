<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ResultController extends Controller
{
    // login view
    public function index(Request $request){
        return view('result1');
    }

}
?>