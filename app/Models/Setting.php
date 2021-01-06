<?php

namespace App\Models;

use App\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    const CACHE_NAME = 'settings';
    protected $primaryKey = 'setting_name';
    public $incrementing = false;

    public static function allFromCache()
    {
        return Cache::rememberForever(self::CACHE_NAME, function () {
            return Setting::all();
        });
    }
}
