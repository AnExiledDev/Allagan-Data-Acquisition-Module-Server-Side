<?php

namespace App\Console\Commands;

use App\BillingHistory;
use App\Mail\CancellationNotification;
use App\Module;
use App\Subscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CancelForNonPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:cancelfornonpayment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancels all accounts that havent paid their subscription';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $subscriptions = Subscription::where('expires_at', '<=', Carbon::now())->where('paid', 0)->get();

        foreach ($subscriptions as $subscription)
        {
            $user = User::where('id', $subscription['owner_id'])->first();

            Subscription::where('id', $subscription['id'])->delete();

            $billingHistory = new BillingHistory();
            $billingHistory->owner_id = $subscription['owner_id'];
            $billingHistory->description = 'Subscription Cancelled';
            $billingHistory->amount = $subscription['charge_amount'];
            $billingHistory->processed = 1;
            $billingHistory->save();

            \Mail::to($user->email)->send(new CancellationNotification($user->email, true));
        }
    }
}
