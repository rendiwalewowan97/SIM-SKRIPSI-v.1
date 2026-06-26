<?php

namespace App\Models\Concerns;

trait UsesIndonesianColumns
{
    // public const CREATED_AT = 'dibuat_pada';
    // public const UPDATED_AT = 'diperbarui_pada';

    protected array $indonesianColumnMap = [];

    public function getAttribute($key)
    {
        $map = array_merge(['created_at' => self::CREATED_AT, 'updated_at' => self::UPDATED_AT], $this->indonesianColumnMap);
        return parent::getAttribute($map[$key] ?? $key);
    }

    public function setAttribute($key, $value)
    {
        $map = array_merge(['created_at' => self::CREATED_AT, 'updated_at' => self::UPDATED_AT], $this->indonesianColumnMap);
        return parent::setAttribute($map[$key] ?? $key, $value);
    }
}
