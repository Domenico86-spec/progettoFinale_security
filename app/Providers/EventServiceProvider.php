<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

// Fortify Events
use Laravel\Fortify\Events\Login;

use Laravel\Fortify\Events\Registered;

// Listeners
use App\Listeners\LogUserLogin;
use App\Listeners\LogUserLogout;
use App\Listeners\LogUserRegistered;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            LogUserLogin::class,
        ],
        Registered::class => [
            LogUserRegistered::class,
        ],
        Logout::class => [
            LogUserLogout::class,
        ],
    ];

    public function boot()
    {
        //
    }
}
