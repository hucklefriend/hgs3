<?php

namespace Hgs3\Providers;

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
        'Hgs3\Model' => 'Hgs3\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // 'admin'ゲートを定義
        Gate::define('admin', function ($user) {
            return ($user->role == \Hgs3\Constants\UserRole::ADMIN);
        });
    }
}
