Your account at <a href="https://allagandata.com/">AllaganData.com</a> has just been charged {{ $ChargeAmount }} to pay for this months subscription. Your paypal has not been automatically charged. You will need to pay this charge manually by logging into your account and going to your billing page.

@if ($IsMonthlyCharge == true)
    This is a first of the month charge, which means if you do not pay this charge before the end of the day on the 3rd of this month, your auth keys will no longer work. You can login but not send new data to our servers.
@endif