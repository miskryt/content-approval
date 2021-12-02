<?php

namespace App\Providers;

use App\Models\Asset;
use App\Models\Campaign;
use App\Models\Role;
use App\Policies\AssetPolicy;
use App\Policies\CampaignPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         User::class => UserPolicy::class,
         Campaign::class => CampaignPolicy::class,
         Asset::class => AssetPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /*
        Gate::define('view-users', function (User $user)
        {
            return $user->role_id === Role::where('name', 'Super-Admin')->first()->id;
        });
        */
    }
}
