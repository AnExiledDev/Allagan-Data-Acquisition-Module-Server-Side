@extends('Frontend.Includes.Layout')

@section('content')

<div class="row">
    <div class="col s12 m4 offset-m4">
        <div class="card-panel">
            <div class="card-panel-title">
                <span class="right">
                    <a href="#!"></a>
                </span>

                <h5>Verify your Email</h5>
            </div>

            <div class="card-panel-content col s12">
                @if (isset($EmailVerified))
                    @if ($EmailVerified == true)
                        <p>You have successfully registered an account with ADAM and your email has been verified. <a href="/">Click here to go to the login screen.</a></p>
                    @else
                        <p>Email verification failed. Please retry the link in your email, or contact an administrator.</p>
                    @endif
                @elseif (isset($Resent) && $Resent == true)
                    <p>The verification email has been resent to the email {{ $email }}. If you do not see the email after an hour, please contact an administrator.</p>
                @else
                    <p>Your registration is nearly complete, however before you can continue you must verify your email address. An email was sent to the address you registered with. If you do not see an email, please check your spam folders. If you still have not received an email, <a href="{{ route('RegisterResendVerificationEmail', ['email' => $email]) }}">click here to resend the validation email.</a></p>
                @endif
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
</div>

@endsection