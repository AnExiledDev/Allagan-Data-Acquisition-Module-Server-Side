<?php

namespace App\Mail;

use App\EmailLog;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountPaymentPosted extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    protected $price;

    public function __construct($email, $price)
    {
        $this->email = $email;
        $this->price = $price;
    }

    public function build()
    {
        $address = 'administrator@allagandata.com';
        $name = 'No Reply - AllaganData';
        $subject = 'Payment posted to your account';

        $user = User::where('email', $this->email)->first();

        $email = new EmailLog();
        $email->receiver_id = $user->id;
        $email->receiver_email = $this->email;
        $email->subject = $subject;
        $email->save();

        return $this->view('Emails.AccountPaymentPosted')
                    ->from($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject)
                    ->with([
                        'PaymentAmount' => $this->price
                    ]);
    }
}
