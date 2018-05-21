<?php

namespace App\Http\Controllers\Widget;

use App\ActionLog;
use App\BuddyLog;
use App\ChatLog;
use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\Action;

class ChatController extends BackendController
{
    public $NotificationSettings;

    public function __construct()
    {
        $this->GetNotificationSettings();
    }

    public function Index()
    {
        return view('Backend.Widgets.Chat.Core');
    }

    public function GetChatContent(Request $request)
    {
        if (!isset($this->currentCharacter->id)) { return null; }

        $LastChatLineID = 0;
        $LastActionLineID = 0;
        $LastBuddyLineID = 0;

        $ChatLinesArray = $this->GetChatLines($request->LastChat);
        $ActionLinesArray = $this->GetActionLines($request->LastAction);
        $BuddyLinesArray = $this->GetBuddyLines($request->LastBuddy);

        $NewChatLinesArray = array();
        foreach ($ChatLinesArray as $ChatLine)
        {
            $ChatLine['message'] = str_replace("\ue03c", "<img src='./Images/Icons/HQ_icon.png' />", $ChatLine['message']);
            $ChatLine['message'] = str_replace("\ue033", "<img src='./Images/Icons/ItemLevel_icon.png' />", $ChatLine['message']);
            $ChatLine['message'] = str_replace("\ue03d", "<img src='./Images/Icons/Collectable_icon.png' />", $ChatLine['message']);

            $Notify = false;
            if ($request->LastChat > 0)
            {
                $Notify = $this->NeedsNotified($ChatLine);
            }

            $NewChatLinesArray[] = array(
                "Type"      => $ChatLine['type'],
                "Time"      => date("H:i:s", strtotime($this->timezone['setting'] . " hour", strtotime($ChatLine['timestamp']))),
                "Sender"    => $ChatLine['sender'],
                "Message"   => $this->ConvertUnicode($ChatLine['message']),
                "Notify"    => $Notify
            );

            $LastChatLineID = $ChatLine['id'];
        }

        $NewActionLinesArray = array();
        foreach ($ActionLinesArray as $ActionLine)
        {
            $ActionLine['message'] = str_replace("\ue03c", "<img src='./Images/Icons/HQ_icon.png' />", $ActionLine['message']);
            $ActionLine['message'] = str_replace("\ue033", "<img src='./Images/Icons/ItemLevel_icon.png' />", $ActionLine['message']);
            $ActionLine['message'] = str_replace("\ue03d", "<img src='./Images/Icons/Collectable_icon.png' />", $ActionLine['message']);

            $Notify = false;
            if ($request->LastChat > 0)
            {
                $Notify = $this->NeedsNotified($ActionLine);
            }

            $NewActionLinesArray[] = array(
                "Type"      => $ActionLine['type'],
                "Time"      => date("H:i:s", strtotime($this->timezone['setting'] . " hour", strtotime($ActionLine['timestamp']))),
                "Message"   => $this->ConvertUnicode($ActionLine['message']),
                "Notify"    => $Notify
            );

            $LastActionLineID = $ActionLine['id'];
        }

        $NewBuddyLinesArray = array();
        foreach ($BuddyLinesArray as $BuddyLine)
        {
            $Notify = false;
            if ($request->LastChat > 0)
            {
                $Notify = $this->NeedsNotified($BuddyLine);
            }

            $NewBuddyLinesArray[] = array(
                "Type"      => $BuddyLine['type'],
                "Time"      => date("H:i:s", strtotime($this->timezone['setting'] . " hour", strtotime($BuddyLine['timestamp']))),
                "Message"   => $this->ConvertUnicode($BuddyLine['message']),
                "Notify"    => $Notify
            );

            $LastBuddyLineID = $BuddyLine['id'];
        }

        return view('Backend.Widgets.Chat.CoreContent',
        [
            "ChatLines" => $NewChatLinesArray,
            "ActionLines" => $NewActionLinesArray,
            "BuddyLines" => $NewBuddyLinesArray,
            "LastChatLineID" => $LastChatLineID,
            "LastActionLineID" => $LastActionLineID,
            "LastBuddyLineID" => $LastBuddyLineID
        ]);
    }

    public function GetChatLines($LastChat)
    {
        $ChatLines = ChatLog::where('owner_id', $this->user->id)
            ->where('id', '>', $LastChat)
            ->where('player_name', $this->currentCharacter->player_name)
            ->orderBy('id', 'DESC')
            ->take(100)
            ->get();

        $ChatLinesArray = array();
        foreach ($ChatLines AS $ChatLine)
        {
            array_push($ChatLinesArray, $ChatLine);
        }

        $ChatLinesArray = array_reverse($ChatLinesArray);

        return $ChatLinesArray;
    }

    public function GetActionLines($LastAction)
    {
        $ActionLines = ActionLog::where('owner_id', $this->user->id)
            ->where('id', '>', $LastAction)
            ->where('player_name', $this->currentCharacter->player_name)
            ->orderBy('id', 'DESC')
            ->take(100)
            ->get();

        $ActionLinesArray = array();
        foreach ($ActionLines AS $ActionLine)
        {
            array_push($ActionLinesArray, $ActionLine);
        }

        $ActionLinesArray = array_reverse($ActionLinesArray);

        return $ActionLinesArray;
    }

    public function GetBuddyLines($LastBuddy)
    {
        $BuddyLines = BuddyLog::where('owner_id', $this->user->id)
            ->where('id', '>', $LastBuddy)
            ->where('player_name', $this->currentCharacter->player_name)
            ->orderBy('id', 'DESC')
            ->take(250)
            ->get();

        $BuddyLinesArray = array();
        foreach ($BuddyLines AS $BuddyLine)
        {
            array_push($BuddyLinesArray, $BuddyLine);
        }

        $BuddyLinesArray = array_reverse($BuddyLinesArray);

        return $BuddyLinesArray;
    }

    public function NeedsNotified($Line)
    {
        if ($this->NotificationSettings[0]) { return true; }
        if ($Line['type'] == "Say" && $this->NotificationSettings[1]) { return true; }
        if ($Line['type'] == "Yell" && $this->NotificationSettings[2]) { return true; }
        if ($Line['type'] == "Novice Network" && $this->NotificationSettings[3]) { return true; }
        if (($Line['type'] == "Tell" || $Line['type'] == "Tell_Receive") && $this->NotificationSettings[4]) { return true; }
        if ($Line['type'] == "FreeCompany" && $this->NotificationSettings[5]) { return true; }
        if ($Line['type'] == "Party" && $this->NotificationSettings[6]) { return true; }
        if ($Line['type'] == "Linkshell1" && $this->NotificationSettings[8]) { return true; }
        if ($Line['type'] == "Linkshell2" && $this->NotificationSettings[9]) { return true; }
        if ($Line['type'] == "Linkshell3" && $this->NotificationSettings[10]) { return true; }
        if ($Line['type'] == "Linkshell4" && $this->NotificationSettings[11]) { return true; }
        if ($Line['type'] == "Linkshell5" && $this->NotificationSettings[12]) { return true; }
        if ($Line['type'] == "Linkshell6" && $this->NotificationSettings[13]) { return true; }
        if ($Line['type'] == "Linkshell7" && $this->NotificationSettings[14]) { return true; }
        if ($Line['type'] == "Linkshell8" && $this->NotificationSettings[15]) { return true; }
        if (
            (
                $Line['type'] == "Linkshell1" ||
                $Line['type'] == "Linkshell2" ||
                $Line['type'] == "Linkshell3" ||
                $Line['type'] == "Linkshell4" ||
                $Line['type'] == "Linkshell5" ||
                $Line['type'] == "Linkshell6" ||
                $Line['type'] == "Linkshell7" ||
                $Line['type'] == "Linkshell8"
            )
            && $this->NotificationSettings[7]
        ) { return true; }

        return false;
    }

    public function GetNotificationSettings()
    {
        $all = false;
        $say = false;
        $yell = false;
        $novice_network = false;
        $tells = false;
        $free_company = false;
        $party = false;
        $all_linkshells = false;
        $linkshell1 = false;
        $linkshell2 = false;
        $linkshell3 = false;
        $linkshell4 = false;
        $linkshell5 = false;
        $linkshell6 = false;
        $linkshell7 = false;
        $linkshell8 = false;

        if ($this->notificationSettings != null)
        {
            foreach ($this->notificationSettings as $notificationSetting)
            {
                if ($notificationSetting['setting'] == 'on')
                {
                    ${$notificationSetting['type']} = true;
                }
            }
        }

        $this->NotificationSettings = array(
            $all,
            $say,
            $yell,
            $novice_network,
            $tells,
            $free_company,
            $party,
            $all_linkshells,
            $linkshell1,
            $linkshell2,
            $linkshell3,
            $linkshell4,
            $linkshell5,
            $linkshell6,
            $linkshell7,
            $linkshell8
        );
    }

    public function JsonDecodeUnicode($s)
    {
        $json = '"' . $s . '"';
        return json_decode($json);
    }

    public function ConvertUnicode($s)
    {
        return preg_replace_callback(
            '/\\\\u[0-9a-fA-F]{4}/',
            function ($matches) {
                return $this->JsonDecodeUnicode($matches[0]);
            },
            $s
        );
    }
}
