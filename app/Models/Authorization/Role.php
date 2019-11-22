<?php

namespace App\Models\Authorization;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'label'
    ];

    /**
     * Get all permissions belongs to role.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id')
            ->using(RolePermission::class)
            ->withPivot('role_id', 'permission_id');
    }

    /**
     * Determine if role has all permissions.
     *
     * @return  boolean
     */
    public function hasAllPermissions()
    {
        return $this->has_all_permissions;
    }
}
