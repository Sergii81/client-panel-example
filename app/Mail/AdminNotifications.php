<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNotifications extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $notification;

    /**
     * AdminNotifications constructor.
     * @param $mailer
     */
    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $notification = $this->notification;

        return $this->view('emails.admin_notification')
                    ->subject($notification->subject);
    }
}
