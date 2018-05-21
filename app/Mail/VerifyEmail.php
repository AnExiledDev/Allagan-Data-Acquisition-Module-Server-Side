<?php

namespace App\Mail;

use App\EmailLog;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    protected $verificationCode;

    public function __construct($email, $verificationCode)
    {
        $this->email = $email;
        $this->verificationCode = $verificationCode;
    }

    public function build()
    {
        $address = 'administrator@allagandata.com';
        $name = 'No Reply - AllaganData';
        $subject = 'Verify your email address for ADAM';

        $user = User::where('email', $this->email)->first();

        $email = new EmailLog();
        $email->receiver_id = $user->id;
        $email->receiver_email = $user->email;
        $email->subject = $subject;
        $email->save();

        return $this->view('Emails.VerifyEmail')
                    ->from($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject)
                    ->with([
                        'Email' => $this->email,
                        'VerificationCode' => $this->verificationCode
                    ]);
    }
}
