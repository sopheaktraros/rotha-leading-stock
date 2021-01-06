<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'gender',
        'dob',
        'address',
        'description',
        'active',
        'delete' 
    ];
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
