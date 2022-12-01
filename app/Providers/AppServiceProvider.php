<?php

namespace App\Providers;

use PDO;
use App\Models\chatMessageBuddy;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

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
        view()->composer('admin.layouts.partials.left-sidebar', function($view)
        {
            $view->with('uList', User::all());
            $view->with('OnlineUsers', User::select("*")
                ->whereNotNull('last_seen')
                ->orderBy('last_seen', 'DESC')
                ->paginate(10));
            $view->with('loginUname', Auth::id());
            $view->with('avatar', User::where('id',Auth::id())->pluck('avatar'));
        });

        view()->composer('admin.layouts.partials.header', function($view)
        {
            $view->with('avatar', User::where('id',Auth::id())->pluck('avatar'));
        });
    }
}
