<?php

namespace App\Models;

use App\Enums\SystemSettingKeyEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'is_public',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'array',
            'is_public' => 'boolean',
        ];
    }

    public static function getValue(SystemSettingKeyEnum|string $key, mixed $default = null): mixed
    {
        $record = static::query()
            ->where('key', $key instanceof SystemSettingKeyEnum ? $key->value : $key)
            ->first();

        return $record?->value ?? $default;
    }

    public static function putValue(SystemSettingKeyEnum|string $key, mixed $value, string $type = 'json', bool $isPublic = false): self
    {
        return static::query()->updateOrCreate(
            ['key' => $key instanceof SystemSettingKeyEnum ? $key->value : $key],
            [
                'value' => $value,
                'type' => $type,
                'is_public' => $isPublic,
            ],
        );
    }
}
