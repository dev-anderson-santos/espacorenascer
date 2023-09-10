<?php

namespace App\Providers;

use App\User;
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
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('is_admin', function (User $user) {
            return $user->is_admin == 1;
        });

        Gate::define('is_super_admin', function (User $user) {
            return $user->is_admin == 1 && ($user->email == 'danielamontechiaregentil@gmail.com' || $user->email == 'dev.anderson.santos@gmail.com');
        });
    }
}
