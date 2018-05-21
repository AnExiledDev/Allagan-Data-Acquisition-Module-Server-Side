<?php

namespace App\Http\Controllers;

use App\ActionLog;
use App\AuthKey;
use App\Character;
use App\ChatLog;
use App\ChatQueue;
use App\CombatLog;
use App\CraftingLog;
use App\ElementSetting;
use App\ExperienceLog;
use App\GatheringLog;
use App\Mail\PasswordChange;
use App\Mail\VerifyEmail;
use App\Setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class SettingsController extends BackendController
{
    public function Index()
    {
        $timezoneArray = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);

        $timezones = array();
        $utcTime = new \DateTime('now', new \DateTimeZone('UTC'));
        foreach ($timezoneArray as $timezone)
        {
            $currentTimezone = new \DateTimeZone($timezone);
            $timezones[$timezone] = $currentTimezone->getOffset($utcTime) / 3600;
        }

        asort($timezones);

        $coreAuthKey = AuthKey::where('owner_id', $this->user->id)->where('type', 'Core')->first();

        $latestVersion = Setting::where('name', 'LatestPluginVersion')->first();

        return view('Backend.Settings', [ 'timezones' => $timezones, 'CoreAuthKey' => $coreAuthKey, 'LatestVersion' => $latestVersion ]);
    }

    public function SaveTimezone(Request $request)
    {
        $timezoneName = $request->timezone;

        $utcTime = Carbon::now();
        $currentTimezone = new \DateTimeZone($timezoneName);

        $timezoneOffset = $currentTimezone->getOffset($utcTime) / 3600;

        $existingSetting = ElementSetting::where('owner_id', $this->user->id)
            ->where('page', 'Global')
            ->where('element', 'Timezone')
            ->first();

        if (isset($existingSetting->owner_id))
        {
            $updateSetting = ElementSetting::where('id', $existingSetting->id)->first();
            $updateSetting->page = 'Global';
            $updateSetting->element = 'Timezone';
            $updateSetting->type = $timezoneName;
            $updateSetting->setting = $timezoneOffset;
            $updateSetting->save();
        }
        else
        {
            $insertSetting = new ElementSetting();
            $insertSetting->owner_id = $this->user->id;
            $insertSetting->page = 'Global';
            $insertSetting->element = 'Timezone';
            $insertSetting->type = $timezoneName;
            $insertSetting->setting = $timezoneOffset;
            $insertSetting->save();
        }

        Session::flash('status', 'Your timezone has been set successfully.');
        return redirect('/Settings#settings');
    }

    public function SaveEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        if (!Hash::check($request->password, $this->user->password))
        {
            return redirect(route('Settings'))->withErrors('Incorrect password.');
        }

        $verify_code = str_random(20);

        $user = User::where('id', $this->user->id);
        $user->email = $request->email;
        $user->email_code = $verify_code;
        $user->email_verified = 0;
        $user->save();

        Mail::to($request->email)->send(new VerifyEmail($request->email, $verify_code));

        Session::flash('status', 'Your email has been updated. An email has been sent and you will need to verify your email.');
        return redirect('/Settings#update-email');
    }

    public function SavePassword(Request $request)
    {
        $this->validate($request, [
            'password_current' => 'required|min:6',
            'password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->password_current, $this->user->password))
        {
            return redirect(route('Settings'))->withErrors('Incorrect password.');
        }

        $passwordResetToken = str_random(20);

        $user = User::where('id', $this->user->id);
        $user->password_reset_password = Hash::make($request->password);
        $user->password_reset_token = $passwordResetToken;
        $user->password_reset_expiration = Carbon::now() + 21600;
        $user->save();

        Mail::to($request->email)->send(new PasswordChange($request->email, $passwordResetToken));

        Session::flash('status', 'Your password change request has been sent, however your password has not yet been changed. An email has been sent to you with a link to reset your password. The link in the email will expire within 6 hours.');
        return redirect('/Settings#update-password');
    }

    public function PurgeAllData()
    {
        ActionLog::where('owner_id', $this->user->id)->delete();
        ChatLog::where('owner_id', $this->user->id)->delete();
        ChatQueue::where('owner_id', $this->user->id)->delete();
        CombatLog::where('owner_id', $this->user->id)->delete();
        CraftingLog::where('owner_id', $this->user->id)->delete();
        ExperienceLog::where('owner_id', $this->user->id)->delete();
        GatheringLog::where('owner_id', $this->user->id)->delete();

        Character::where('owner_id', $this->user->id)->delete();

        Session::flash('status', 'All data purged successfully.');
        return redirect(route('Settings'));
    }

    public function SaveNotifications(Request $request)
    {
        if ($request->has('all_chat_notifications')) { $this->SetNotificationStatus('Chat', 'all', 'on'); } else { $this->SetNotificationStatus('Chat', 'all', 'off'); }
        if ($request->has('say_notifications')) { $this->SetNotificationStatus('Chat', 'say', 'on'); } else { $this->SetNotificationStatus('Chat', 'say', 'off'); }
        if ($request->has('yell_notifications')) { $this->SetNotificationStatus('Chat', 'yell', 'on'); } else { $this->SetNotificationStatus('Chat', 'yell', 'off'); }
        if ($request->has('shout_notifications')) { $this->SetNotificationStatus('Chat', 'shout', 'on'); } else { $this->SetNotificationStatus('Chat', 'shout', 'off'); }
        if ($request->has('novice_network_notifications')) { $this->SetNotificationStatus('Chat', 'novice_network', 'on'); } else { $this->SetNotificationStatus('Chat', 'novice_network', 'off'); }
        if ($request->has('tells_notifications')) { $this->SetNotificationStatus('Chat', 'tells', 'on'); } else { $this->SetNotificationStatus('Chat', 'tells', 'off'); }
        if ($request->has('free_company_notifications')) { $this->SetNotificationStatus('Chat', 'free_company', 'on'); } else { $this->SetNotificationStatus('Chat', 'free_company', 'off'); }
        if ($request->has('party_notifications')) { $this->SetNotificationStatus('Chat', 'party', 'on'); } else { $this->SetNotificationStatus('Chat', 'party', 'off'); }
        if ($request->has('all_linkshells_notifications')) { $this->SetNotificationStatus('Chat', 'all_linkshells', 'on'); } else { $this->SetNotificationStatus('Chat', 'all_linkshells', 'off'); }
        if ($request->has('linkshell1_notifications')) { $this->SetNotificationStatus('Chat', 'linkshell1', 'on'); } else { $this->SetNotificationStatus('Chat', 'linkshell1', 'off'); }
        if ($request->has('linkshell2_notifications')) { $this->SetNotificationStatus('Chat', 'linkshell2', 'on'); } else { $this->SetNotificationStatus('Chat', 'linkshell2', 'off'); }
        if ($request->has('linkshell3_notifications')) { $this->SetNotificationStatus('Chat', 'linkshell3', 'on'); } else { $this->SetNotificationStatus('Chat', 'linkshell3', 'off'); }
        if ($request->has('linkshell4_notifications')) { $this->SetNotificationStatus('Chat', 'linkshell4', 'on'); } else { $this->SetNotificationStatus('Chat', 'linkshell4', 'off'); }
        if ($request->has('linkshell5_notifications')) { $this->SetNotificationStatus('Chat', 'linkshell5', 'on'); } else { $this->SetNotificationStatus('Chat', 'linkshell5', 'off'); }
        if ($request->has('linkshell6_notifications')) { $this->SetNotificationStatus('Chat', 'linkshell6', 'on'); } else { $this->SetNotificationStatus('Chat', 'linkshell6', 'off'); }
        if ($request->has('linkshell7_notifications')) { $this->SetNotificationStatus('Chat', 'linkshell7', 'on'); } else { $this->SetNotificationStatus('Chat', 'linkshell7', 'off'); }
        if ($request->has('linkshell8_notifications')) { $this->SetNotificationStatus('Chat', 'linkshell8', 'on'); } else { $this->SetNotificationStatus('Chat', 'linkshell8', 'off'); }

        Session::flash('status', 'Notification settings saved.');
        return redirect('/Settings#settings');
    }

    public function SetNotificationStatus($element, $type, $setting)
    {
        $exists = ElementSetting::where('page', 'Notifications')->where('element', $element)->where('type', $type)->where('owner_id', $this->user->id)->first();

        if (isset($exists->id))
        {
            $elementSetting = ElementSetting::where('page', 'Notifications')->where('element', $element)->where('type', $type)->where('owner_id', $this->user->id)->first();
            $elementSetting->setting = $setting;
            $elementSetting->save();
        }
        else
        {
            if ($setting == 'on')
            {
                $elementSetting = new ElementSetting();
                $elementSetting->owner_id = $this->user->id;
                $elementSetting->page = 'Notifications';
                $elementSetting->element = $element;
                $elementSetting->type = $type;
                $elementSetting->setting = $setting;
                $elementSetting->save();
            }
        }
    }
}
