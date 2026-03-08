<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    // Helper untuk mengambil nilai dengan mudah
    public static function get($key, $default = null)
    {
        return static::where('key', $key)->first()->value ?? $default;
    }
}
