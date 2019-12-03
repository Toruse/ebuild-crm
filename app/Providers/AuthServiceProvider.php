<?php

namespace App\Providers;

use App\Models\User\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isCustomer', function (User $user) {
            return $user->isCustomer();
        });

        Gate::define('isVendor', function (User $user) {
            return $user->isVendor();
        });

        Gate::define('isSalesAssociate', function (User $user) {
            return $user->isSalesAssociate();
        });

        Gate::define('isContractor', function (User $user) {
            return $user->isContractor();
        });

        Gate::define('isProjectManager', function (User $user) {
            return $user->isProjectManager();
        });
        
        Gate::define('isAdmin', function (User $user) {
            return $user->isAdmin();
        });

    }
}
