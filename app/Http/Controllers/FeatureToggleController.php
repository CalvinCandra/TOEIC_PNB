<?php

namespace App\Http\Controllers;

use App\Services\SelfStudy\FeatureToggleService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class FeatureToggleController extends Controller
{
    public function __construct(protected FeatureToggleService $service) {}

    public function update(Request $request, string $key)
    {
        $request->validate(['is_enabled' => 'required|boolean']);

        $allowedKeys = ['toeic_simulation', 'self_study'];
        if (! in_array($key, $allowedKeys)) {
            Alert::error('Failed', 'Invalid feature key');
            return back();
        }

        $this->service->toggle($key, (bool) $request->is_enabled, auth()->id());

        $status = $request->is_enabled ? 'enabled' : 'disabled';
        Alert::success('Success', "Feature {$status} successfully");

        return back();
    }
}
