<?php

namespace App\Models\Traits;


trait QueryDateTrait
{
    protected static function whereDate($attribute, array $range)
    {
        if ($range[0] && $range[1]) {
            return static::whereBetween($attribute, $range);
        } elseif ($range[0]) {
            return static::where($attribute, '>=', $range[0]);
        } elseif ($range[1]) {
            return static::where($attribute, '<', $range[1]);
        } else {
            return new static;
        }
    }
}