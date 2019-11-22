<?php

namespace App\Providers;

use App\Models\Authorization\Permission;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::before(function (?User $user = null) {

            if ($user->roles && $user->roles->flatMap->hasAllPermissions()->isNotEmpty()) {
                return true;
            }

            $permissionLabels = Permission::pluck('label');

            $permissionLabels->each(function ($permissionLabel) {
                Gate::define($permissionLabel, function (?User $user = null) use ($permissionLabel) {
                    $permissionLabels = $user->roles->flatMap(function ($role) {
                        return $role->permissions->pluck('label');
                    });

                    return in_array($permissionLabel, $permissionLabels->toArray(), true);
                });
            });
        });
    }
}
