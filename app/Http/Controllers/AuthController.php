<?php

namespace App\Http\Controllers;

use App\AuthKey;
use App\User;
use App\UserPage;
use App\UserWidget;
use App\Widget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;

class AuthController extends Controller
{
    public function LoginIndex()
    {
        return view('Frontend.Login');
    }

    public function TermsOfService()
    {
        return view('Frontend.TermsOfService');
    }

    public function PrivacyPolicy()
    {
        return view('Frontend.PrivacyPolicy');
    }

    public function RefundPolicy()
    {
        return view('Frontend.RefundPolicy');
    }

    public function LoginAuthenticate(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255|exists:users,email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (Auth::user()->email_verified == false)
            {
                return view('Frontend.RegisterVerifyEmail', ['email' => $request->email]);
            }

            $authKey = AuthKey::where('owner_id', Auth::user()->id)->where('type', 'Core')->first();

            if (!isset($authKey->id))
            {
                $coreAuthKey = new AuthKey();
                $coreAuthKey->owner_id = Auth::user()->id;
                $coreAuthKey->type = "Core";
                $coreAuthKey->auth_key = str_random(25);
                $coreAuthKey->save();
            }

            $userWidgets = UserWidget::where('owner_id', Auth::user()->id)->get()->count();
            $userPages = UserPage::where('owner_id', Auth::user()->id)->get()->count();

            if ($userWidgets == 0 && $userPages == 0)
            {
                $BotInformation = new UserPage();
                $BotInformation->owner_id = Auth::user()->id;
                $BotInformation->page_name = "Bot Information";
                $BotInformation->page_icon = "android";
                $BotInformation->save();

                $BotInformationPage = UserPage::where('owner_id', Auth::user()->id)->where('page_name', 'Bot Information')->first();

                $Chat = new UserPage();
                $Chat->owner_id = Auth::user()->id;
                $Chat->page_name = "Chat";
                $Chat->page_icon = "comment";
                $Chat->save();

                $ChatPage = UserPage::where('owner_id', Auth::user()->id)->where('page_name', 'Chat')->first();

                $BotStatusWidget = new UserWidget();
                $BotStatusWidget->owner_id = Auth::user()->id;
                $BotStatusWidget->page_id = $BotInformationPage->id;
                $BotStatusWidget->widget_id = 2;
                $BotStatusWidget->x_position = 0;
                $BotStatusWidget->y_position = 0;
                $BotStatusWidget->width = 3;
                $BotStatusWidget->height = 3;
                $BotStatusWidget->save();

                $AvailableBotBasesWidget = new UserWidget();
                $AvailableBotBasesWidget->owner_id = Auth::user()->id;
                $AvailableBotBasesWidget->page_id = $BotInformationPage->id;
                $AvailableBotBasesWidget->widget_id = 1;
                $AvailableBotBasesWidget->x_position = 3;
                $AvailableBotBasesWidget->y_position = 0;
                $AvailableBotBasesWidget->width = 4;
                $AvailableBotBasesWidget->height = 8;
                $AvailableBotBasesWidget->save();

                $AvailablePluginsWidget = new UserWidget();
                $AvailablePluginsWidget->owner_id = Auth::user()->id;
                $AvailablePluginsWidget->page_id = $BotInformationPage->id;
                $AvailablePluginsWidget->widget_id = 10;
                $AvailablePluginsWidget->x_position = 7;
                $AvailablePluginsWidget->y_position = 0;
                $AvailablePluginsWidget->width = 5;
                $AvailablePluginsWidget->height = 8;
                $AvailablePluginsWidget->save();

                $ChatWidget = new UserWidget();
                $ChatWidget->owner_id = Auth::user()->id;
                $ChatWidget->page_id = $ChatPage->id;
                $ChatWidget->widget_id = 3;
                $ChatWidget->x_position = 0;
                $ChatWidget->y_position = 0;
                $ChatWidget->width = 12;
                $ChatWidget->height = 8;
                $ChatWidget->save();

                $ItemsGatheredListWidget = new UserWidget();
                $ItemsGatheredListWidget->owner_id = Auth::user()->id;
                $ItemsGatheredListWidget->page_id = 0;
                $ItemsGatheredListWidget->widget_id = 9;
                $ItemsGatheredListWidget->x_position = 0;
                $ItemsGatheredListWidget->y_position = 0;
                $ItemsGatheredListWidget->width = 3;
                $ItemsGatheredListWidget->height = 8;
                $ItemsGatheredListWidget->save();

                $ItemsCraftedListWidget = new UserWidget();
                $ItemsCraftedListWidget->owner_id = Auth::user()->id;
                $ItemsCraftedListWidget->page_id = 0;
                $ItemsCraftedListWidget->widget_id = 7;
                $ItemsCraftedListWidget->x_position = 3;
                $ItemsCraftedListWidget->y_position = 0;
                $ItemsCraftedListWidget->width = 3;
                $ItemsCraftedListWidget->height = 8;
                $ItemsCraftedListWidget->save();

                $ExperienceGainedWidget = new UserWidget();
                $ExperienceGainedWidget->owner_id = Auth::user()->id;
                $ExperienceGainedWidget->page_id = 0;
                $ExperienceGainedWidget->widget_id = 4;
                $ExperienceGainedWidget->x_position = 6;
                $ExperienceGainedWidget->y_position = 0;
                $ExperienceGainedWidget->width = 1;
                $ExperienceGainedWidget->height = 2;
                $ExperienceGainedWidget->save();

                $TimeTillLevelWidget = new UserWidget();
                $TimeTillLevelWidget->owner_id = Auth::user()->id;
                $TimeTillLevelWidget->page_id = 0;
                $TimeTillLevelWidget->widget_id = 11;
                $TimeTillLevelWidget->x_position = 7;
                $TimeTillLevelWidget->y_position = 0;
                $TimeTillLevelWidget->width = 1;
                $TimeTillLevelWidget->height = 2;
                $TimeTillLevelWidget->save();

                $FreeBagSlotsWidget = new UserWidget();
                $FreeBagSlotsWidget->owner_id = Auth::user()->id;
                $FreeBagSlotsWidget->page_id = 0;
                $FreeBagSlotsWidget->widget_id = 5;
                $FreeBagSlotsWidget->x_position = 8;
                $FreeBagSlotsWidget->y_position = 0;
                $FreeBagSlotsWidget->width = 1;
                $FreeBagSlotsWidget->height = 2;
                $FreeBagSlotsWidget->save();

                $ItemsCraftedWidget = new UserWidget();
                $ItemsCraftedWidget->owner_id = Auth::user()->id;
                $ItemsCraftedWidget->page_id = 0;
                $ItemsCraftedWidget->widget_id = 6;
                $ItemsCraftedWidget->x_position = 6;
                $ItemsCraftedWidget->y_position = 2;
                $ItemsCraftedWidget->width = 1;
                $ItemsCraftedWidget->height = 2;
                $ItemsCraftedWidget->save();

                $ItemsGatheredWidget = new UserWidget();
                $ItemsGatheredWidget->owner_id = Auth::user()->id;
                $ItemsGatheredWidget->page_id = 0;
                $ItemsGatheredWidget->widget_id = 8;
                $ItemsGatheredWidget->x_position = 7;
                $ItemsGatheredWidget->y_position = 2;
                $ItemsGatheredWidget->width = 1;
                $ItemsGatheredWidget->height = 2;
                $ItemsGatheredWidget->save();
            }

            return redirect(route('Dashboard'));
        }
        else
        {
            return redirect()->back()->withInput()->withErrors("Wrong email or password.");
        }
    }

    public function SetPassword(Request $request)
    {
        $user = User::where('password_reset_token', $request->Token)->where('password_reset_expiration', '>', Carbon::now());

        if (!isset($user->id))
        {
            return redirect(route('Login'))->withErrors('Attempting to reset password with invalid token, or password reset token has already expired.');
        }

        $user->password = $user->password_reset_password;
        $user->save();

        return redirect(route('Login'))->with('status', 'Your password has successfully been reset. You can now login with your new password.');
    }

    public function GeneratePassword(Request $request)
    {
        return Hash::make($request->password);
    }

    public function RegisterIndex()
    {
        return view('Frontend.Register');
    }

    public function RegisterCheck(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $verify_code = str_random(20);

        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->email_code = $verify_code;
        $user->save();

        Mail::to($request->email)->send(new VerifyEmail($request->email, $verify_code));

        return view('Frontend.RegisterVerifyEmail', ['email' => $request->email]);
    }

    public function RegisterResendVerificationEmail($Email)
    {
        $user = User::where('email', $Email)->first();

        Mail::to($user->email)->send(new VerifyEmail($user->email, $user->email_code));

        return view('Frontend.RegisterVerifyEmail', ['email' => $user->email, 'Resent' => true]);
    }

    public function RegisterVerifyEmail($Email, $VerificationCode)
    {
        $user = User::where('email', $Email)->where('email_code', $VerificationCode)->first();

        $EmailVerified = false;
        if (isset($user->id))
        {
            $user->email_verified = true;
            $user->save();

            $EmailVerified = true;
        }

        return view('Frontend.RegisterVerifyEmail', ['EmailVerified' => $EmailVerified]);
    }

    public function Logout()
    {
        Auth::logout();

        return redirect('/');
    }
}