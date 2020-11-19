<?php

namespace App\Providers;

use App\Permission;
use Illuminate\Support\Facades\Gate;
//use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
            
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // registerPolicies isn't doing anything special. 
        // It just spins through $policies and registers them;
        $this->registerPolicies();

        //Admin check
        Gate::define('isAdmin', function($user) {
            //return $user->hasRole('administrator');
            //return $user->hasPermissionTo('create-tasks');
            return true;
        });

        /*        
        try {
            Permission::get()->map(function ($permission) {
                Gate::define($permission->slug, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission);
                });
            });
        } catch (\Exception $e) {
            report($e);
            return false;
        }
        */        
    }
}
