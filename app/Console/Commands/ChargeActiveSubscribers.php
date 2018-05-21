<?php

namespace App\Console\Commands;

use App\BillingHistory;
use App\Mail\AccountCharged;
use App\Module;
use App\Subscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ChargeActiveSubscribers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:chargeactivesubscribers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Charges all active subscribers at the 1st of every month.';

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
        $subscriptions = Subscription::where('expires_at', Carbon::now()->firstOfMonth())->where('paid_at', '<', Carbon::now()->firstOfMonth())->get();

        foreach ($subscriptions as $subscription)
        {
            $user = User::where('id', $subscription['owner_id'])->first();
            $module = Module::where('id', $subscription['module_id'])->first();

            $modifySubscription = Subscription::where('id', $subscription['id'])->first();
            $modifySubscription->charge_amount = $module->price;
            $modifySubscription->paid = 0;
            $modifySubscription->paid_at = null;
            $modifySubscription->charge_at = Carbon::now();
            $modifySubscription->expires_at = Carbon::now()->addMonth()->firstOfMonth();
            $modifySubscription->save();

            $billingHistory = new BillingHistory();
            $billingHistory->owner_id = $subscription['owner_id'];
            $billingHistory->description = 'Charge';
            $billingHistory->amount = $module->price;
            $billingHistory->processed = 1;
            $billingHistory->save();

            \Mail::to($user->email)->send(new AccountCharged($user->email, $module->price, true));
        }
    }
}
