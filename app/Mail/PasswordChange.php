<?php

namespace App\Mail;

use App\EmailLog;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordChange extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    protected $token;

    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    public function build()
    {
        $address = 'administrator@allagandata.com';
        $name = 'No Reply - AllaganData';
        $subject = 'Password Change Request';

        $user = User::where('email', $this->email)->first();

        $email = new EmailLog();
        $email->receiver_id = $user->id;
        $email->receiver_email = $this->email;
        $email->subject = $subject;
        $email->save();

        return $this->view('Emails.PasswordChange')
                    ->from($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject)
                    ->with([
                        'Email' => $this->email,
                        'Token' => $this->token
                    ]);
    }
}
