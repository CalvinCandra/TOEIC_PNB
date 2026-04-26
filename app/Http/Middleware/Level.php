<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Level
{
    public function handle(Request $request, Closure $next, string ...$level): Response
    {
        if (in_array($request->user()->level, $level)) {
            return $next($request);
        }

        return response()->view('errors.akses');
    }
}
