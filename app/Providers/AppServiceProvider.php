<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire; // Add this import
use App\Livewire\CreateMemberModal;
use App\Livewire\NewMemberButton;

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
        \Illuminate\Support\Facades\Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        Livewire::component('create-member-modal', CreateMemberModal::class);
        Livewire::component('new-member-button', NewMemberButton::class);
    }
}
