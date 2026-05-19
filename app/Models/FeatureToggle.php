<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class FeatureToggle extends Model
{
    use HasFactory;

    protected $fillable = ['feature_key', 'is_enabled', 'updated_by'];
    protected $casts = ['is_enabled' => 'boolean'];

    public static function isEnabled(string $key): bool
    {
        return Cache::remember("feature_toggle.{$key}", 300, function () use ($key) {
            $value = self::where('feature_key', $key)->value('is_enabled');
            return $value === null ? true : (bool) $value;
        });
    }

    protected static function booted(): void
    {
        static::saved(fn ($m) => Cache::forget("feature_toggle.{$m->feature_key}"));
        static::deleted(fn ($m) => Cache::forget("feature_toggle.{$m->feature_key}"));
    }
}
