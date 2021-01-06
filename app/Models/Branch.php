<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Branch extends Model
{
    const CACHE_NAME = 'branches';
    protected $fillable = [
        'name',
        'address',
        'description',
        'active',
        'delete' 
    ];

    public static function allFromCache()
    {
        return Cache::rememberForever(self::CACHE_NAME, function () {
            return Branch::where(function ($q){
                $q->where('active',1);
                $q->where('delete',0);
            })->get();
        });
    }

    public function scopeActive($q)
    {
        return $q->where('active', 1);
    }

    public function scopeNotDelete($q)
    {
        return $q->where('delete', 0);
    }

	/**
	 * @param $q
	 *
	 * @return mixed
	 */
	public function scopeExceptRoot($q) {
		return $q->where('id', '!=', 1);
    }

}
