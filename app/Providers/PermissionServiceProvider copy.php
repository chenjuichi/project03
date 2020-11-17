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
        if (Gate::allows('create-tasks')) {
            Gate::define('create-tasks', function($user) {
                //return $user->hasRole('administrator');
                return $user->hasPermissionTo('create-tasks');
            });
        }

        //user check
        Gate::define('isUser', function($user){
            return $user->hasRole('user');
        });
        
        //manager check
        Gate::define('isManager', function($user){
            return $user->hasRole('manager');
        });

        //author check
        Gate::define('isAuthor', function($user){
            return $user->hasRole('author');
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
