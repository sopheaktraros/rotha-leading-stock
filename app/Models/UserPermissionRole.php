<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermissionRole extends Model
{
    protected $table = 'user_permission_roles';
    protected $fillable = ['role_id', 'permission_id', 'read', 'write', 'delete'];
}
