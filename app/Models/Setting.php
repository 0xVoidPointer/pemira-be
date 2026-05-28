<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Get a setting value by key.
     */
    public static function getValue(string $key, ?string $default = null): ?string
    {
        $setting = static::where('key', $key)->first();

        return $setting?->value ?? $default;
    }

    /**
     * Set a setting value by key.
     */
    public static function setValue(string $key, ?string $value): static
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Get multiple settings as key-value array.
     *
     * @param  list<string>  $keys
     * @return array<string, string|null>
     */
    public static function getMany(array $keys): array
    {
        $settings = static::whereIn('key', $keys)->pluck('value', 'key');

        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $settings[$key] ?? null;
        }

        return $result;
    }
}
