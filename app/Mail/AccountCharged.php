<?php

namespace App\Mail;

use App\EmailLog;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountCharged extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    protected $price;
    protected $isMonthlyCharge;

    public function __construct($email, $price, $isMonthlyCharge)
    {
        $this->email = $email;
        $this->price = $price;
        $this->isMonthlyCharge = $isMonthlyCharge;
    }

    public function build()
    {
        $address = 'administrator@allagandata.com';
        $name = 'No Reply - AllaganData';
        $subject = 'Your account has incurred a charge';

        $user = User::where('email', $this->email)->first();

        $email = new EmailLog();
        $email->receiver_id = $user->id;
        $email->receiver_email = $this->email;
        $email->subject = $subject;
        $email->save();

        return $this->view('Emails.AccountCharged')
                    ->from($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject)
                    ->with([
                        'ChargeAmount' => $this->price,
                        'IsMonthlyCharge' => $this->isMonthlyCharge
                    ]);
    }
}
