<?php

namespace App\Providers;

use App\Filament\Resources\ProductResource\Widgets\ProductStats;
use Illuminate\Support\ServiceProvider;
use Filament\Filament;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    protected $policies = [
        'Spatie\Permission\Models\Role' => 'App\Policies\RolePolicy',
        'generator' => [
               'option' => 'policies_and_permissions',
                'policy_directory' => 'Policies',]
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // Filament::registerWidgets([
        //     ProductStats::class,
        // ]);
        //
    }
}
