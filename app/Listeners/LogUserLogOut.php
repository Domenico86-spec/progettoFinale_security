<?php

namespace App\Listeners;


use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogUserLogOut
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle( Logout $event): void
    {
         Log::debug('Evento Logout ricevuto');

        Log::info('Logout effettuato', [
            'email' => $event->user->email,
            'ip' => request()->ip(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }
}
