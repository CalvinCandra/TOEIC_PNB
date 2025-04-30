<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use HTMLPurifier;
use HTMLPurifier_Config;

class PurifyInputs
{
    public function handle(Request $request, Closure $next): mixed
    {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);

        // Bersihkan semua input string
        $clean = collect($request->all())->map(function ($value) use ($purifier) {
            return is_string($value) ? $purifier->purify($value) : $value;
        });

        $request->merge($clean->toArray());

        return $next($request);
    }
}
