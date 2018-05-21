<?php

namespace App\Http\Controllers;

use App\ActionLog;
use App\BuddyLog;
use App\ChatLog;
use App\ChatQueue;
use App\CommandQueue;
use App\ElementSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\Auth;

class ChatController extends BackendController
{
    public function Index()
    {
        $settings = ElementSetting::where('owner_id', $this->user->id)->get();

        $parametersArray = array();
        foreach ($settings as $setting)
        {
            if ($setting['page'] == "Dashboard")
            {
                if ($setting['type'] == "Width")
                {
                    $parametersArray[$setting['element'] . "Width"] = $setting['setting'];
                }

                if ($setting['type'] == "Height")
                {
                    $parametersArray[$setting['element'] . "Height"] = $setting['setting'];
                }
            }
        }

        return view('Backend.Chat', [ 'ParametersArray' => $parametersArray ]);
    }

    public function GetChat(Request $request)
    {
        if (!isset($this->currentCharacter->id)) { return ""; }

        $lastChatID = $request->LastChat;
        $chatLines = ChatLog::where('owner_id', $this->user->id)
            ->where('id', '>', $lastChatID)
            ->where('player_name', $this->currentCharacter->player_name)
            ->orderBy('id', 'DESC')
            ->take(100)
            ->get();

        $lastActionID = $request->LastAction;
        $actionLines = ActionLog::where('owner_id', $this->user->id)
            ->where('id', '>', $lastActionID)
            ->where('player_name', $this->currentCharacter->player_name)
            ->orderBy('id', 'DESC')
            ->take(100)
            ->get();

        $lastBuddyID = $request->LastBuddy;
        $buddyLines = BuddyLog::where('owner_id', $this->user->id)
            ->where('id', '>', $lastBuddyID)
            ->where('player_name', $this->currentCharacter->player_name)
            ->orderBy('id', 'DESC')
            ->take(200)
            ->get();

        $arrayChatLines = array();
        foreach ($chatLines AS $chatLine)
        {
            array_push($arrayChatLines, $chatLine);
        }

        $arrayActionLines = array();
        foreach ($actionLines AS $actionLine)
        {
            array_push($arrayActionLines, $actionLine);
        }

        $arrayBuddyLines = array();
        foreach ($buddyLines AS $buddyLine)
        {
            array_push($arrayBuddyLines, $buddyLine);
        }

        $arrayChatLines = array_reverse($arrayChatLines);
        $arrayActionLines = array_reverse($arrayActionLines);
        $arrayBuddyLines = array_reverse($arrayBuddyLines);

        $lastChatIDTemp = 0;
        foreach($arrayChatLines AS $chatLine)
        {
            $chatLine['message'] = str_replace("\ue03c", "<img src='./Images/Icons/HQ_icon.png' />", $chatLine['message']);
            $chatLine['message'] = str_replace("\ue033", "<img src='./Images/Icons/ItemLevel_icon.png' />", $chatLine['message']);
            $chatLine['message'] = str_replace("\ue03d", "<img src='./Images/Icons/Collectable_icon.png' />", $chatLine['message']);

            if ($chatLine['type'] == "StandardEmotes")
            {
                echo "<p class='chat chat-" . str_replace(' ', '', $chatLine['type']) . "'>(" . date("H:i:s", strtotime($this->timezone['setting'] . " hour", strtotime($chatLine['timestamp']))) . ") " . $this->ConvertUnicode($chatLine['message']) . "</p>";
            }
            else
            {
                echo "<p class='chat chat-" . str_replace(' ', '', $chatLine['type']) . "'>(" . date("H:i:s", strtotime($this->timezone['setting'] . " hour", strtotime($chatLine['timestamp']))) . ") <a onclick='Chat.SetChannelByType(\"" . $chatLine['type'] . "\");'>[" . $chatLine['type'] . "]</a> <a onclick='Chat.SetTellUser(\"" . $chatLine['sender'] . "\");'>" . $chatLine['sender'] . "</a>: " . $this->ConvertUnicode($chatLine['message']) . "</p>";
            }

            if ($lastChatID > 0)
            {
                $hasNotified = false;
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
                foreach ($this->notificationSettings as $notificationSetting)
                {
                    if ($notificationSetting['setting'] == 'on')
                    {
                        ${$notificationSetting['type']} = true;
                    }
                }

                if ($all == true) { echo "<script>Core.SendNotification('New Message In Chat', '" . $chatLine['sender'] . ": " .  $this->ConvertUnicode($chatLine['message']) . "');</script>"; $hasNotified = true;}

                if ($all_linkshells == true &&
                    ($chatLine['type'] == 'Linkshell1' ||
                    $chatLine['type'] == 'Linkshell2' ||
                    $chatLine['type'] == 'Linkshell3' ||
                    $chatLine['type'] == 'Linkshell4' ||
                    $chatLine['type'] == 'Linkshell5' ||
                    $chatLine['type'] == 'Linkshell6' ||
                    $chatLine['type'] == 'Linkshell7' ||
                    $chatLine['type'] == 'Linkshell8') &&
                    $hasNotified == false) { echo "<script>Core.SendNotification('New Linkshell Message', '" . $chatLine['sender'] . ": " .  $this->ConvertUnicode($chatLine['message']) . "');</script>"; $hasNotified = true; }

                if ($say == true && $chatLine['type'] == 'Say' && $hasNotified == false) { echo "<script>Core.SendNotification('New Say Message', '" . $chatLine['sender'] . ": " .  $this->ConvertUnicode($chatLine['message']) . "');</script>"; $hasNotified = true; }

                if ($yell == true && $chatLine['type'] == 'Yell' && $hasNotified == false) { echo "<script>Core.SendNotification('New Yell Message', '" . $chatLine['sender'] . ": " .  $this->ConvertUnicode($chatLine['message']) . "');</script>"; $hasNotified = true; }

                if ($novice_network == true && $chatLine['type'] == 'Novice Network' && $hasNotified == false) { echo "<script>Core.SendNotification('New Novice Network Message', '" . $chatLine['sender'] . ": " .  $this->ConvertUnicode($chatLine['message']) . "');</script>"; $hasNotified = true; }

                if ($tells == true && $chatLine['type'] == 'Tell_Receive' && $hasNotified == false) { echo "<script>Core.SendNotification('New Tell Message from: " . $chatLine['sender'] . "', '" .  $this->ConvertUnicode($chatLine['message']) . "');</script>"; $hasNotified = true; }

                if ($free_company == true && $chatLine['type'] == 'FreeCompany' && $hasNotified == false) { echo "<script>Core.SendNotification('New Free Company Message', '" . $chatLine['sender'] . ": " .  $this->ConvertUnicode($chatLine['message']) . "');</script>"; $hasNotified = true; }

                if ($party == true && $chatLine['type'] == 'Party' && $hasNotified == false) { echo "<script>Core.SendNotification('New Party Message', '" . $chatLine['sender'] . ": " .  $this->ConvertUnicode($chatLine['message']) . "');</script>"; $hasNotified = true; }

                if ($linkshell1 == true && $chatLine['type'] == 'Linkshell1' && $hasNotified == false) { echo "<script>Core.SendNotification('New Linkshell 1 Message', '" . $chatLine['sender'] . ": " .  $this->ConvertUnicode($chatLine['message']) . "');</script>"; $hasNotified = true; }

                if ($linkshell2 == true && $chatLine['type'] == 'Linkshell2' && $hasNotified == false) { echo "<script>Core.SendNotification('New Linkshell 2 Message', '" . $chatLine['sender'] . ": " .  $this->ConvertUnicode($chatLine['message']) . "');</script>"; $hasNotified = true; }

                if ($linkshell3 == true && $chatLine['type'] == 'Linkshell3' && $hasNotified == false) { echo "<script>Core.SendNotification('New Linkshell 3 Message', '" . $chatLine['sender'] . ": " .  $this->ConvertUnicode($chatLine['message']) . "');</script>"; $hasNotified = true; }

                if ($linkshell4 == true && $chatLine['type'] == 'Linkshell4' && $hasNotified == false) { echo "<script>Core.SendNotification('New Linkshell 4 Message', '" . $chatLine['sender'] . ": " .  $this->ConvertUnicode($chatLine['message']) . "');</script>"; $hasNotified = true; }

                if ($linkshell5 == true && $chatLine['type'] == 'Linkshell5' && $hasNotified == false) { echo "<script>Core.SendNotification('New Linkshell 5 Message', '" . $chatLine['sender'] . ": " .  $this->ConvertUnicode($chatLine['message']) . "');</script>"; $hasNotified = true; }

                if ($linkshell6 == true && $chatLine['type'] == 'Linkshell6' && $hasNotified == false) { echo "<script>Core.SendNotification('New Linkshell 6 Message', '" . $chatLine['sender'] . ": " .  $this->ConvertUnicode($chatLine['message']) . "');</script>"; $hasNotified = true; }

                if ($linkshell7 == true && $chatLine['type'] == 'Linkshell7' && $hasNotified == false) { echo "<script>Core.SendNotification('New Linkshell 7 Message', '" . $chatLine['sender'] . ": " .  $this->ConvertUnicode($chatLine['message']) . "');</script>"; $hasNotified = true; }

                if ($linkshell8 == true && $chatLine['type'] == 'Linkshell8' && $hasNotified == false) { echo "<script>Core.SendNotification('New Linkshell 8 Message', '" . $chatLine['sender'] . ": " .  $this->ConvertUnicode($chatLine['message']) . "');</script>"; $hasNotified = true; }
            }

            $lastChatIDTemp = $chatLine['id'];
        }

        if ($lastChatIDTemp > 0)
        {
            $lastChatID = $lastChatIDTemp;
        }

        foreach($arrayActionLines AS $actionLine)
        {
            $actionLine['message'] = str_replace("\ue03c", "<img src='./Images/Icons/HQ_icon.png' />", $actionLine['message']);
            $actionLine['message'] = str_replace("\ue033", "<img src='./Images/Icons/ItemLevel_icon.png' />", $actionLine['message']);
            $actionLine['message'] = str_replace("\ue03d", "<img src='./Images/Icons/Collectable_icon.png' />", $actionLine['message']);

            echo "<p class='actionText action-" . str_replace(' ', '', $actionLine['type']) . "'>(" . date("H:i:s", strtotime($this->timezone['setting'] . " hour", strtotime($actionLine['timestamp']))) . ") [" . $actionLine['type'] . "] " . $this->ConvertUnicode($actionLine['message']) . "</p>";
            $lastActionID = $actionLine['id'];
        }

        foreach($arrayBuddyLines AS $buddyLine)
        {
            echo "<p class='buddyText buddy-" . str_replace(' ', '', $buddyLine['type']) . "'>(" . date("H:i:s", strtotime($this->timezone['setting'] . " hour", strtotime($buddyLine['timestamp']))) . ") " . $this->ConvertUnicode($buddyLine['message']) . "</p>";
            $lastBuddyID = $buddyLine['id'];
        }

        echo "<div id='lastChatID'>" . $lastChatID . "</div>";
        echo "<div id='lastActionID'>" . $lastActionID . "</div>";
        echo "<div id='lastBuddyID'>" . $lastBuddyID . "</div>";
    }

    public function SendChat()
    {
        if (!isset($this->currentCharacter->id)) { return ""; }

        $channel = $_POST['channel'];
        $chatMessage = $_POST['chatMessage'];

        if (strlen($chatMessage) == 0) { return null; }

        if ($channel == "/")
        {
            $fullMessage = $channel . $chatMessage;
        }
        else
        {
            $fullMessage = $channel . " " . $chatMessage;
        }

        $newChat = new CommandQueue();
        $newChat->owner_id = $this->user->id;
        $newChat->player_name = $this->currentCharacter->player_name;
        $newChat->type = "SendChat";
        $newChat->command = $fullMessage;
        $newChat->save();
    }

    function JsonDecodeUnicode($s)
    {
        $json = '"' . $s . '"';
        return json_decode($json);
    }

    function ConvertUnicode($s)
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
