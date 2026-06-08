<?php

namespace App\Http\Middleware;

use App\Models\FeatureToggle;
use Closure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class CheckFeatureEnabled
{
    public function handle(Request $request, Closure $next, string $featureKey): Response
    {
        if (! FeatureToggle::isEnabled($featureKey)) {
            Alert::info('Information', 'This feature is currently disabled by admin.');
            return redirect('/peserta');
        }

        return $next($request);
    }
}
