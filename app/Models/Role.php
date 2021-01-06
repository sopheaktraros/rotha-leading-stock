<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'user_roles';
    protected $fillable = ['name', 'description', 'active', 'delete'];

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

	/**
	 * Relationship many-to-many with permissions
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
    public function permission()
    {
        return $this->belongsToMany('App\Models\UserPermission', 'user_permission_roles', 'role_id', 'permission_id')->withPivot('read', 'write', 'delete');
    }

}
