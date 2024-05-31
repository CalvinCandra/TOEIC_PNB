<?php
    namespace App\Http\Controllers;

    class TestController extends Controller{
        public function index()
        {
            $questions = range(1, 50); // Array with numbers from 1 to 50
            return view('toeic.testPeserta', compact('questions'));
        }
    }
?>