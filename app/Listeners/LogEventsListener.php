<?php

namespace App\Listeners;

use App\Events\LoginEvent;
use App\LogModel;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Contracts\ILog;

class LogEventsListener
{

    protected $log;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ILog $log)
    {
        $this->log = $log;
    }

    /**
     * Handle the event.
     *
     * @param  LoginEvent  $event
     * @return void
     */
    public function handle(LoginEvent $event)
    {

        $event->user->logs()->create([
            'tipo_id' => $event->getTipoLog()
        ]);
    }
}
