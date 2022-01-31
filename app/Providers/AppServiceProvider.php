<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'income' => 'App\Models\Income',
            'expense' => 'App\Models\Expense',
        ]);

        Filament::registerNavigationGroups([
            'Income/Expense',
            'Miscellaneous',
        ]);
    }
}
