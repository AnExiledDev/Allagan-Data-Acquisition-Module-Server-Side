<?php

namespace App\Mail;

use App\EmailLog;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CancellationNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function build()
    {
        $address = 'administrator@allagandata.com';
        $name = 'No Reply - AllaganData';
        $subject = 'Notification of subscription cancellation';

        $user = User::where('email', $this->email)->first();

        $email = new EmailLog();
        $email->receiver_id = $user->id;
        $email->receiver_email = $this->email;
        $email->subject = $subject;
        $email->save();

        return $this->view('Emails.CancellationNotification')
                    ->from($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject);
    }
}
