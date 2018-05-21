<?php

namespace App\Http\Controllers;

use App\AuthKey;
use App\BillingHistory;
use App\Mail\AccountPaymentPosted;
use App\Module;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use PayPal\Api\Amount;
use PayPal\Api\DetailedRefund;
use PayPal\Api\Details;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;

class BillingController extends BackendController
{
    public function Index()
    {
        $modules = Module::where('available', 1)->get();
        $billingHistory = BillingHistory::where('owner_id', $this->user->id)
            ->where('processed', 1)
            ->orderBy('created_at', 'DESC')
            ->get();

        $billingReviews = BillingHistory::where('owner_id', $this->user->id)
            ->where('need_review', 1)
            ->orderBy('created_at', 'DESC')
            ->get();

        $accountBalance = 0;
        foreach ($billingHistory as $history)
        {
            $accountBalance += $history->amount;
        }

        $dueNextCycle = 0;
        foreach ($this->subscriptions as $subscription)
        {
            $module = Module::where('id', $subscription->module_id)->first();

            $dueNextCycle += $module->price;
        }

        return view('Backend.Billing', ['accountBalance' => $accountBalance, 'dueNextCycle' => $dueNextCycle, 'modules' => $modules, 'billingHistory' => $billingHistory, 'billingReviews' => $billingReviews]);
    }

    public function SaveSubscription(Request $request)
    {
        $hasCoreModule = false;
        $hasExpiredCoreModule = false;
        $coreModule = Module::where('name', 'Core')->first();

        foreach ($this->subscriptions as $subscription)
        {
            if ($subscription->module_id == $coreModule->id && $subscription->expires_at > Carbon::now())
            {
                $hasCoreModule = true;
            }
            elseif ($subscription->module_id == $coreModule->id && $subscription->expires_at < Carbon::now())
            {
                $hasExpiredCoreModule = true;
            }
        }

        if ((!isset($request->CoreModule) && $hasCoreModule == false) || (isset($request->CoreModule) && $hasCoreModule == true))
        {
            return redirect('/Billing#manage-subscriptions')->withErrors('Your subscriptions settings are the same as your current settings, so no changes were made.');
        }

        if (isset($request->CoreModule) && $hasCoreModule == false && $hasExpiredCoreModule == false)
        {
            $expires = Carbon::now()->addMonth()->startOfMonth();
            $chargeAmount = round((($coreModule->price / 30) * $expires->diff(Carbon::now())->days), 2);

            $subscription = new Subscription();
            $subscription->owner_id = $this->user->id;
            $subscription->module_id = $coreModule->id;
            $subscription->charge_amount = $chargeAmount;
            $subscription->paid = 0;
            $subscription->charge_at = Carbon::now();
            $subscription->purchased_at = Carbon::now();
            $subscription->expires_at = Carbon::now()->addMonth()->startOfMonth();
            $subscription->save();

            if ($hasCoreModule == false)
            {
                $coreAuthKey = new AuthKey();
                $coreAuthKey->owner_id = $this->user->id;
                $coreAuthKey->type = "Core";
                $coreAuthKey->auth_key = str_random(25);
                $coreAuthKey->save();
            }

            $billingHistory = new BillingHistory();
            $billingHistory->owner_id = $this->user->id;
            $billingHistory->description = "Charge";
            $billingHistory->amount = $chargeAmount;
            $billingHistory->processed = 1;
            $billingHistory->save();

            Session::flash('status', 'Your subscription changes have been made. You have been charged, please return to the Overview page to pay for the module and begin using ADAM.');
            return redirect('/Billing#manage-subscriptions');
        }

        if (!isset($request->CoreModule) && (($hasCoreModule == false && $hasExpiredCoreModule == true) || ($hasCoreModule == true && $hasExpiredCoreModule == false)))
        {
            $subscription = Subscription::where('owner_id', $this->user->id)->where('expires_at', '>', Carbon::now())->whereNotNull('paid_at')->orderBy('expires_at', 'DESC')->first();

            if (!isset($subscription->paid_at))
            {
                $subscription2 = Subscription::where('owner_id', $this->user->id)->where('expires_at', '>', Carbon::now())->whereNull('paid_at')->orderBy('expires_at', 'DESC')->first();

                $subscription = Subscription::where('owner_id', $this->user->id)->where('expires_at', '>', Carbon::now())->whereNull('paid_at')->orderBy('expires_at', 'DESC')->first();
                $subscription->expires_at = Carbon::now();
                $subscription->save();

                $billingHistory = new BillingHistory();
                $billingHistory->owner_id = $this->user->id;
                $billingHistory->description = "Cancelled Module";
                $billingHistory->amount = $subscription2->charge_amount * -1;
                $billingHistory->processed = 1;
                $billingHistory->save();

                Session::flash('status', 'You never paid your subscription, so your account has been refunded and your subscription is cancelled.');
                return redirect('/Billing#manage-subscriptions');
            }

            $paidAt = new Carbon($subscription->paid_at);
            $chargeAmount = round($coreModule->price - ($coreModule->price / $paidAt->diff(Carbon::now())->days), 2);

            if ($chargeAmount < 0) { $chargeAmount = 0; }

            $billingHistory = new BillingHistory();
            $billingHistory->owner_id = $this->user->id;
            $billingHistory->description = "Cancelled Module";
            $billingHistory->amount = $chargeAmount * -1;
            $billingHistory->processed = 1;
            $billingHistory->save();

            $subscription = Subscription::where('owner_id', $this->user->id)->where('expires_at', '>', Carbon::now())->whereNotNull('paid_at')->orderBy('expires_at', 'DESC')->first();
            $subscription->expires_at = Carbon::now();
            $subscription->save();

            Session::flash('status', 'Your subscription changes have been made. You may have been refunded money. You can check your billing history or overview to determine how much, if any.');
            return redirect('/Billing#manage-subscriptions');
        }
    }

    public function InitiatePayment()
    {
        $billingHistory = BillingHistory::where('owner_id', $this->user->id)
            ->where('processed', 1)
            ->orderBy('created_at', 'DESC')
            ->get();

        $accountBalance = 0;
        foreach ($billingHistory as $history)
        {
            $accountBalance += $history->amount;
        }

        $accountBalance = $accountBalance * -1;

        if ($accountBalance > -1)
        {
            Session::flash('status', 'You can not make a payment if you owe less than $1.');
            return redirect('/Billing');
        }

        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                'PAYPALCREDENTIALSHERE',
                'PAYPALCREDENTIALSHERE'
            )
        );

        $apiContext->setConfig(
            array (
                'mode' => 'live',
            )
        );

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($accountBalance * -1);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription("ADAM Subscription");

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl('https://allagandata.com/Payment/Complete')
            ->setCancelUrl('https://allagandata.com/Payment/Cancelled');

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($apiContext);
        }
        catch (PayPalConnectionException $e)
        {
            Session::flash('status', 'There was an issue creating a payment URL for you. Please try again, if the issue persists, contact us on the support page. ' . $e->getData());
            return redirect('/Billing');
        }
        catch (\Exception $e)
        {
            Session::flash('status', 'There was an issue creating a payment URL for you. Please try again, if the issue persists, contact us on the support page. ');
            return redirect('/Billing');
        }

        $approvalUrl = $payment->getApprovalLink();

        return Redirect::to($approvalUrl);
    }

    public function PaymentComplete(Request $request)
    {
        $billingHistory = BillingHistory::where('owner_id', $this->user->id)
            ->where('processed', 1)
            ->orderBy('created_at', 'DESC')
            ->get();

        $accountBalance = 0;
        foreach ($billingHistory as $history)
        {
            $accountBalance += $history->amount;
        }

        $accountBalance = $accountBalance * -1;

        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                'PAYPALCREDENTIALSHERE',
                'PAYPALCREDENTIALSHERE'
            )
        );

        $apiContext->setConfig(
            array (
                'mode' => 'live',
            )
        );

        $payment = Payment::get($request->paymentId, $apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);

        try
        {
            $result = $payment->execute($execution, $apiContext);

            $paymentID = $result->getId();

            if ($accountBalance > -1)
            {
                $billing = new BillingHistory();
                $billing->owner_id = $this->user->id;
                $billing->description = "Paypal Payment";
                $billing->amount = $accountBalance;
                $billing->processed = 0;
                $billing->transaction_id = $paymentID;
                $billing->error = 1;
                $billing->error_detail = "Transaction was made for less than $1.";
                $billing->need_review = 1;
                $billing->full_detail = $result;
                $billing->processed_at = Carbon::now();
                $billing->save();

                Session::flash('status', 'The payment was made, but you owed less than $1. This shouldnt be possible. Your transaction has been flagged for review.');
                return redirect('/Billing');
            }

            $billing = new BillingHistory();
            $billing->owner_id = $this->user->id;
            $billing->description = "Paypal Payment";
            $billing->amount = $accountBalance;
            $billing->processed = 1;
            $billing->transaction_id = $paymentID;
            $billing->full_detail = $result;
            $billing->processed_at = Carbon::now();
            $billing->save();

            $subscription = Subscription::where('owner_id', $this->user->id)->where('paid', '0')->where('charge_at', '<', Carbon::now())->first();
            $subscription->paid = 1;
            $subscription->paid_at = Carbon::now();
            $subscription->save();

            \Mail::to($this->user->email)->send(new AccountPaymentPosted($this->user->email, $accountBalance, true));

            Session::flash('status', 'Payment posted successfully. Thanks!');
            return redirect('/Billing');
        }
        catch (PayPalConnectionException $e)
        {
            $billing = new BillingHistory();
            $billing->owner_id = $this->user->id;
            $billing->description = "Paypal Payment";
            $billing->amount = $accountBalance;
            $billing->processed = 0;
            $billing->transaction_id = '';
            $billing->error = 1;
            $billing->error_detail = 'PaypalConnectionException';
            $billing->need_review = 1;
            $billing->full_detail = $e->getData();
            $billing->processed_at = Carbon::now();
            $billing->save();

            Session::flash('status', 'There was an issue processing your payment. The payment has not been completed. If the charge shows on your account, please contact us on the support page and we will update your account manually.');
            return redirect('/Billing');
        }
        catch (\Exception $e)
        {
            $billing = new BillingHistory();
            $billing->owner_id = $this->user->id;
            $billing->description = "Paypal Payment";
            $billing->amount = $accountBalance;
            $billing->processed = 0;
            $billing->transaction_id = '';
            $billing->error = 1;
            $billing->error_detail = 'General Exception';
            $billing->need_review = 1;
            $billing->full_detail = $e;
            $billing->processed_at = Carbon::now();
            $billing->save();

            Session::flash('status', 'There was an issue processing your payment. The payment has not been completed. If the charge shows on your account, please contact us on the support page and we will update your account manually.');
            return redirect('/Billing');
        }
    }

    public function PaymentCancelled()
    {
        Session::flash('status', 'You cancelled your paypal payment. If this was done in error, please try again. If you did not cancel, and this continues to happen, please contact us on the support page.');
        return redirect('/Billing');
    }
}
