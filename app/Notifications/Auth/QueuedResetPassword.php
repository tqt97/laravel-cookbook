<?php

namespace App\Notifications\Auth;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class QueuedResetPassword extends ResetPasswordNotification implements ShouldQueue
{
    use Queueable;

    public $queue = 'auth';

    /**
     * Create a new notification instance.
     */
    public function __construct(public $token)
    {
        // specifying queue is optional but recommended
        // $this->queue = 'auth';
    }
}
