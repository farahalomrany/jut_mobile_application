<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\Sanctum;
use Laravel\Sanctum\HasApiTokens;
use App\Models\PersonalAccessToken;


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
        // Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        // Sanctum::authenticateAccessTokensUsing(
        //     static function (PersonalAccessToken $accessToken, bool $is_valid) {
        //         // your logic here
        //     }
        // );

        //
    }
}
