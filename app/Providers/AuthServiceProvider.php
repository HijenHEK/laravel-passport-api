<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Bridge\AccessTokenRepository;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];
    
    public function register()
    {

        /***
         * overriding AccessToken repository 
         * https://gist.github.com/RDelorier/9ec45bbb595b7e21c30df80c34b03cac
         */
        parent::register();
        $this->app->bind(AccessTokenRepository::class, function ($app) {
            return $app->make(\App\Auth\AccessTokenRepository::class);
        });
    }
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // adding passport routes at boot
    }
}
