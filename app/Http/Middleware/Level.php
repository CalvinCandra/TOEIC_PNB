<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Level
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$level): Response
    {
        if(in_array($request->user()->level, $level)){
            return $next($request);
            
            if(Auth::user()->level == 'admin'){
                redirect('/admin');
            }elseif(Auth::user()->level == 'petugas'){
                redirect('/petugas');
            }elseif(Auth::user()->level == 'peserta'){
                redirect('/peserta');
            }
        }else{
            return response()->view('errors.akses');
        }
        
    }
}
