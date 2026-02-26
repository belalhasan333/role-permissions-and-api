<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Policies\UserPolicy;
use App\Policies\ProductPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\RolePolicy;
use Spatie\Permission\Models\Role;
use Laravel\Socialite\Facades\Socialite;
use SocialiteProviders\Apple\Provider as AppleProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Product::class => ProductPolicy::class,
        Category::class => CategoryPolicy::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            if ($user->hasRole('superadmin')) {
                return true; // (web + api)
            }
        });

        //socialite login
        Socialite::extend('apple', static function ($app) {
            $config = $app['config']['services.apple'];

            return new AppleProvider(
                $app['request'],
                $config['client_id'],
                $config['client_secret'],
                $config['redirect']
            );
        });
    }
}
