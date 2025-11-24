<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.navigation', function($view) {
            $employees = User::select('employee_code','first_name','last_name')->orderBy('employee_code')->get();
            $view->with('employees', $employees);
        });
    }
}
