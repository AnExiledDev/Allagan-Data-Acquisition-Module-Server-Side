@extends('Backend.Includes.Layout')

@section('content')

<div class="row">
    <div class="col s12 m6 l4 offset-m3 offset-l4">
        <ul class="tabs">
            <li class="tab col s3"><a href="#billing-overview">Overview</a></li>
            <li class="tab col s3"><a href="#manage-subscriptions">Manage Subscriptions</a></li>
            <li class="tab col s3"><a href="#billing-history">Billing History</a></li>
        </ul>
    </div>

    <div id="billing-overview" class="col s12 m6 l4 offset-m3 offset-l4">
        <div class="card-panel">
            <div class="card-panel-content col s12">
                <table class="col s12 m10 l8 offset-m1 offset-l2">
                    <tr>
                        <th>Current Account Balance:</th>
                        <td>${{ money_format('%(.2n', $accountBalance * -1) }}</td>
                    </tr>
                    <tr>
                        <th>Due Next Billing Cycle:</th>
                        <td>${{ money_format('%(.2n', $dueNextCycle * -1) }}</td>
                    </tr>
                    <tr>
                        <th>Next Billing Cycle:</th>
                        <td>{{ \Carbon\Carbon::now()->addMonth()->startOfMonth()->toDateString() }}</td>
                    </tr>
                    <tr>
                        <th>Subscription Expires On:</th>
                        <td>{{ \Carbon\Carbon::parse($coreSubscription['expires_at'])->toDateString() }}</td>
                    </tr>
                    <tr>
                        <th colspan='2' class='center-align'>
                            @if (Session::has('status'))
                                <p>{{ Session::get('status') }}</p><br>
                            @endif

                            @if ($accountBalance >= 1 && count($billingReviews) == 0)
                                <a href="{{ route('PaymentInitiate') }}">
                                    <img src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_paynow_cc_144x47.png" alt="Pay Now">
                                </a>

                                <p>Clicking the above button will take you to paypal to pay your outstanding balance of ${{ money_format('%(.2n', $accountBalance) }}</p>
                            @elseif ($accountBalance > 0 && $accountBalance < 1 && count($billingReviews) == 0)
                                <p>You currently have an outstanding balance, however we don't accept payments until you owe at least $1.00. Owing less than $1.00 will not effect your account or your services. An auth key has been generated for you, and your balance will carry over to the next billing cycle. At that time you will need to pay.</p>
                            @elseif (count($billingReviews) > 0)
                                <p>You're account has transactions marked for review. They are listed below. An administrator will contact you by email to resolve these transaction issues.</p>
                                <br>
                                <table class="col s12 striped">
                                    <tr>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>
                                    @foreach ($billingReviews as $review)
                                        <tr>
                                            <td>{{ $review->created_at }}</td>
                                            <td>{{ $review->description }}</td>
                                            <td>${{ money_format('%(.2n', ($accountBalance * -1) + 0.00) }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                            <br>
                            <p>Please review our<br> <a href="/RefundPolicy">Refund Policy</a><br>and also PayPals<br><a href="https://www.paypal.com/us/webapps/mpp/ua/acceptableuse-full">Acceptable Use Policy</a></p>
                            <br>
                            <p>Powered by Paypal</p>
                        </th>
                    </tr>
                </table>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>

    <div id="manage-subscriptions" class="col s12 m6 l4 offset-m3 offset-l4">
        <div class="card-panel">
            <div class="card-panel-content col s12">
                <p>Here you can see your current subscription, or add and remove modules as you like.</p>
                @if ($coreSubscription == null)
                    <p>You do not currently have an active subscription. This means when you select a subscription below, your account will incur the charge immediately. You will be able to pay this balance whenever you like, however your account will not become active until that balance is paid.</p>
                @else
                    <p>You currently have an active subscription. If you add any modules below, you will be charged a pro-rated amount for the time you have used that module at the next billing cycle. If you add, then later remove that module before the next billing cycle, you will be charged only for those few days you used the module, at the next billing cycle.</p>
                @endif
                <br>

                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach

                @if (Session::has('status'))
                    <p>{{ Session::get('status') }}</p>
                @endif

                <form action="{{ route('Billing-SaveSubscription') }}" method="post">
                <table class="col s12 striped">
                    <tr>
                        <th>Module Name</th>
                        <th>Charge Frequency</th>
                        <th>Price</th>
                        <th>Subscribe</th>
                    </tr>
                    @foreach ($modules as $module)
                        <tr>
                            <td>{{ $module['name'] }} Module</td>
                            <td>{{ $module['frequency'] }}</td>
                            <td>${{ money_format('%i', $module['price']) }}</td>
                            <td class="center-align">
                                @foreach ($subscriptions as $subscription)
                                    @if ($subscription['module_id'] == $module['id'] && $subscription->expires_at > \Carbon\Carbon::now())
                                        @php($hasSub = false)
                                        @php($hasSub = true)
                                    @endif
                                @endforeach

                                <input type="checkbox" class="filled-in" id="{{ $module['name'] }}" name="{{ $module['name'] }}Module" value="{{ $module['name'] }}Module"
                                    @if (isset($hasSub) && $hasSub == true)
                                        checked="checked"
                                    @endif
                                >
                                <label for="{{ $module['name'] }}">&nbsp;</label>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="4" class="center-align"><button class="waves-effect btn" type="submit">Save Subscription</button></th>
                    </tr>
                </table>

                {{ csrf_field() }}
                </form>
            </div>

            <div class="clearfix">&nbsp;</div>
        </div>
    </div>

    <div id="billing-history" class="col s12 m6 l4 offset-m3 offset-l4">
        <div class="card-panel">
            <div class="card-panel-content col s12">
                <p>A list of your recent charges and payments is displayed here.</p>
                <table class="col s12 striped">
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                    @foreach ($billingHistory as $history)
                        <tr>
                        <td>{{ $history->created_at }}</td>
                        <td>{{ $history->description }}</td>
                        <td>${{ money_format('%(.2n', $history->amount) }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>

            <div class="clearfix">&nbsp;</div>
        </div>
    </div>
</div>

@endsection