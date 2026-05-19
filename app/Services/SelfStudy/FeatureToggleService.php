<?php

namespace App\Services\SelfStudy;

use App\Models\FeatureToggle;
use Illuminate\Support\Facades\Log;

class FeatureToggleService
{
    public function toggle(string $key, bool $enabled, int $userId): FeatureToggle
    {
        $toggle = FeatureToggle::updateOrCreate(
            ['feature_key' => $key],
            ['is_enabled' => $enabled, 'updated_by' => $userId]
        );

        Log::info('[FeatureToggleService] Feature toggled', [
            'key'     => $key,
            'enabled' => $enabled,
            'by'      => $userId,
        ]);

        return $toggle;
    }

    public function isEnabled(string $key): bool
    {
        return FeatureToggle::isEnabled($key);
    }
}
