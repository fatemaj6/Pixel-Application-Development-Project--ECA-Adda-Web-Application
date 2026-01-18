<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\AdminMessage;

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
        if ($this->app->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        View::composer(['components.navbar', 'components.dashboard-navbar'], function ($view) {
            $unreadAdminMessages = 0;
            $user = Auth::user();

            if ($user) {
                $unreadAdminMessages = AdminMessage::where('user_id', $user->id)
                    ->whereNull('read_at')
                    ->count();
            }

            $view->with('unreadAdminMessages', $unreadAdminMessages);
        });
    }
}
