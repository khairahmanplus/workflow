<?php

namespace App;

use App\Models\Authorization\Role;
use App\Models\Authorization\UserRole;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
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
     * Get all roles belongs to user.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id')
            ->using(UserRole::class)
            ->withPivot('user_id', 'role_id');
    }

    /**
     * Get all role names.
     *
     * @return  string
     */
    public function getRoleNames()
    {
        if ($this->roles->isNotEmpty()) {
            return $this->roles->implode('name', ', ');
        }

        return '-';
    }

    /**
     * Check if the user has administrator role.
     *
     * @return  boolean
     */
    public function hasRoleAdministrator()
    {
        return $this->roles->filter(function ($role) {
            return $role->hasAllPermissions();
        })->isNotEmpty();
    }
}
