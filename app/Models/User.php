<?php

namespace App\Models;
use App\Scopes\BranchScope;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'branch_id',
        'role_id',
        'email',
		'password',
	    'active',
	    'delete'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	/**
	 * Relationship one-to-one with role
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch', 'branch_id');
    }

	public function scopeExceptRoot($q) {
		return $q->where('id', '!=', 1);
	}

	public function scopeNotDelete($q) {
		return $q->where('delete', 0);
	}

	public function scopeActivated($q) {
		return $q->where('active', 1);
    }

}
