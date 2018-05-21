<?php

namespace App\Http\Controllers;

use App\ActionLog;
use App\ChatLog;
use App\ChatQueue;
use App\CraftingLog;
use App\DataQueue;
use App\DBItem;
use App\ElementSetting;
use App\ExperienceLog;
use App\GatheringLog;
use App\Socket;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends BackendController
{
    public function index()
    {
        return view('Backend.Dashboard.Dashboard');
    }

    public function GetExperienceGained()
    {
        if (!isset($this->currentCharacter->id)) { return "NA"; }

        $experienceMessages = ExperienceLog::where('owner_id', $this->user->id)
            ->where('skill', $this->currentCharacter->current_job)
            ->where('timestamp', '>', Carbon::now()->subMinutes(10)->toDateTimeString())
            ->where('player_name', $this->currentCharacter->player_name)
            ->get();

        $experienceGained = 0;

        foreach ($experienceMessages AS $expMsg)
        {
            $experienceGained += $expMsg['exp_gained'];
        }

        return $experienceGained;
    }

    public function GetTimeTillLevelUp()
    {
        if (!isset($this->currentCharacter->id) || $this->GetExperienceGained() == 0) { return "NA"; }

        $expNextLevel = $this->CalculateExperience($this->GetCharacterClassLevel($this->currentCharacter->current_job) + 1);
        $expPerMinute = $this->GetExperienceGained() / 10;
        @$minutesTillLevel = ($expNextLevel - $this->currentCharacter->current_experience) / $expPerMinute;

        return number_format(ceil($minutesTillLevel)) . " Minutes";
    }

    public function GetItemsGathered()
    {
        if (!isset($this->currentCharacter->id)) { return "NA"; }

        $duration = ElementSetting::where('owner_id', $this->user->id)
            ->where('page', 'Dashboard')
            ->where('element', 'ItemsGathered')
            ->where('type', 'DisplayHours')
            ->first();

        $listDuration = 1;
        if (isset($duration->setting))
        {
            $listDuration = $duration->setting;
        }

        $itemsGathered = GatheringLog::where('owner_id', $this->user->id)
            ->where('timestamp', '>', Carbon::now()->subHours($listDuration)->toDateTimeString())
            ->where('player_name', $this->currentCharacter->player_name)
            ->orderBy('id', 'DESC')
            ->get();

        $totalGathered = 0;

        if (count($itemsGathered) == 0) { return 0; }

        foreach ($itemsGathered as $itemGathered)
        {
            if ($itemGathered['item_name'] == "gil") { continue; }
            $totalGathered += $itemGathered['amount'];
        }

        return number_format($totalGathered);
    }

    public function GetItemsCrafted()
    {
        if (!isset($this->currentCharacter->id)) { return "NA"; }

        $duration = ElementSetting::where('owner_id', $this->user->id)
            ->where('page', 'Dashboard')
            ->where('element', 'ItemsCrafted')
            ->where('type', 'DisplayHours')
            ->first();

        $listDuration = 1;
        if (isset($duration->setting))
        {
            $listDuration = $duration->setting;
        }

        $itemsCrafted = CraftingLog::where('owner_id', $this->user->id)
            ->where('timestamp', '>', Carbon::now()->subHours($listDuration)->toDateTimeString())
            ->where('player_name', $this->currentCharacter->player_name)
            ->orderBy('id', 'DESC')
            ->get();

        $totalCrafted = 0;

        if (count($itemsCrafted) == 0) { return 0; }

        foreach ($itemsCrafted as $itemCrafted)
        {
            $totalCrafted += $itemCrafted['amount'];
        }

        return number_format($totalCrafted);
    }

    public function GetFreeBagSlots()
    {
        if (!isset($this->currentCharacter->id)) { return "NA"; }

        return $this->currentCharacter->free_inventory_slots;
    }

    public function GetItemsCraftedList()
    {
        if (!isset($this->currentCharacter->id)) { return ""; }

        $duration = ElementSetting::where('owner_id', $this->user->id)
            ->where('page', 'Dashboard')
            ->where('element', 'ItemsCrafted')
            ->where('type', 'DisplayHours')
            ->first();

        $listDuration = 1;
        if (isset($duration->setting))
        {
            $listDuration = $duration->setting;
        }

        $itemsCrafted = CraftingLog::select('item_name', DB::raw('SUM(amount) as amount'))->where('owner_id', $this->user->id)
            ->where('timestamp', '>', Carbon::now()->subHours($listDuration)->toDateTimeString())
            ->where('player_name', $this->currentCharacter->player_name)
            ->groupBy('item_name')
            ->orderBy('item_name', 'ASC')
            ->get();

        echo "<table class='striped'>";

        foreach ($itemsCrafted AS $itemCrafted)
        {
            $rawName = str_replace("\ue03c", '', $itemCrafted['item_name']);
            $rawName = str_replace("\ue03d", '', $rawName);

            $item = DBItem::where('name_en', $rawName)->first();

            if (isset($item->xivdb_id))
            {
                $xivdb_id = $item->xivdb_id;
                $name = $item->xivdb_name;
            }
            else
            {
                $xivdb_id = 0;
                $name = $rawName;
            }

            $imageURL = "https://secure.xivdb.com/img/game_local/" . substr($xivdb_id, 0, 1) . "/" . $xivdb_id . ".png";

            if ($xivdb_id == "1") { $imageURL = "https://secure.xivdb.com/img/game/065000/065002.png"; }
            if ($xivdb_id == "20") { $imageURL = "https://secure.xivdb.com/img/game/065000/065004.png"; }
            if ($xivdb_id == "21") { $imageURL = "https://secure.xivdb.com/img/game/065000/065005.png"; }
            if ($xivdb_id == "22") { $imageURL = "https://secure.xivdb.com/img/game/065000/065006.png"; }

            echo "<tr>
                    <td class='col s4 m2 l1'>" . number_format($itemCrafted['amount']) . "</td>
                    <td class='col s8 m10 l11'>";

            echo "
                <object data='" . $imageURL . "' type='image/png' style='height: 21px; border-radius: 3px; vertical-align: middle; margin-top: -2px;'></object>
                <a href='https://xivdb.com/item/" . $xivdb_id . "/' data-tooltip-id='item/" . $xivdb_id . "' data-xivdb-seturlicon='0' target='_blank'>
                    " . urldecode(ucwords($name)) . "
                </a>";

            if (strpos($itemCrafted['item_name'], '\ue03c') > 0)
            {
                echo "&nbsp;<img src='./Images/Icons/HQ_icon.png' />";
            }

            if (strpos($itemCrafted['item_name'], '\ue03d') > 0)
            {
                echo "&nbsp;<img src='./Images/Icons/Collectable_icon.png' />";
            }

            echo "</td>
                </tr>";
        }

        echo "</table>";
    }

    public function GetItemsSoldList()
    {
        if (!isset($this->currentCharacter->id)) { return ""; }

        $duration = ElementSetting::where('owner_id', $this->user->id)
            ->where('page', 'Dashboard')
            ->where('element', 'ItemsSold')
            ->where('type', 'DisplayHours')
            ->first();

        $listDuration = 1;
        if (isset($duration->setting))
        {
            $listDuration = $duration->setting;
        }

        $itemsSold = ActionLog::where('owner_id', $this->user->id)
            ->where('timestamp', '>', Carbon::now()->subHours($listDuration)->toDateTimeString())
            ->where('player_name', $this->currentCharacter->player_name)
            ->where('type', 'Sell Message')
            ->orderBy('id', 'DESC')
            ->get();

        echo "<table class='striped'>";
        foreach ($itemsSold AS $itemSold)
        {
            echo "<tr><td>" . $itemSold['message'] . "</td></tr>";
        }
        echo "</table>";
    }

    public function CheckSocketConnection()
    {
        $oldSockets = Socket::where('last_message', '<', Carbon::now()->subMinutes(2)->toDateTimeString())->get();

        /** Move to cron! */
        foreach ($oldSockets AS $socket)
        {
            exec('kill ' . $socket->process_id);
        }

        if (count($oldSockets) > 0)
        {
            Socket::where('last_message', '<', Carbon::now()->subMinutes(2)->toDateTimeString())->delete();
        }

        $socket = Socket::where('owner_id', $this->user->id)
            ->where('last_message', '>', Carbon::now()->subMinutes(2)->toDateTimeString())
            ->first();

        if (!isset($socket->id))
        {
            return "<strong style='color: #f70f3b;'>Not Connected</strong>";
        }
        else
        {
            return "<strong style='color: #64c2ca;'>Connected</strong>";
        }
    }

    public function GetDataQueueStatus()
    {
        $dataQueueSize = DataQueue::all()->count();

        if ($dataQueueSize < 500)
        {
            return "<strong style='color: #64c2ca;'>Healthy</strong>";
        }

        if ($dataQueueSize > 500 && $dataQueueSize < 2000)
        {
            return "<strong style='color: #ff5019;'>Strained</strong>";
        }

        if ($dataQueueSize > 2000 && $dataQueueSize < 10000)
        {
            return "<strong style='color: #f73d2b;'>Backed Up</strong>";
        }

        if ($dataQueueSize > 10000)
        {
            return "<strong style='color: #f70f3b;'>Down</strong>";
        }
    }

    public function GetCurrentCharacterInfo()
    {
        if (!isset($this->currentCharacter->id)) { return ""; }

        return $this->currentCharacter->player_name . " - Level " . $this->GetCharacterClassLevel($this->currentCharacter->current_job) . " - " . $this->currentCharacter->current_job;
    }

    public function SwitchCharacters()
    {
        $newCharacter = $_GET['character'];

        $user = User::where('id', $this->user->id)->first();
        $user->current_character = $newCharacter;
        $user->save();

        return redirect(route('Dashboard'));
    }

    public function UpdateElementSettings()
    {
        $page = $_POST['Page'];
        $element = $_POST['Element'];
        $type = $_POST['Type'];
        $setting = $_POST['Setting'];

        $existingSetting = ElementSetting::where('owner_id', $this->user->id)
            ->where('page', $page)
            ->where('element', $element)
            ->where('type', $type)
            ->first();

        if (isset($existingSetting->id))
        {
            $elementSettings = ElementSetting::where('owner_id', $this->user->id)
                ->where('page', $page)
                ->where('element', $element)
                ->where('type', $type)
                ->first();
            $elementSettings->page = $page;
            $elementSettings->element = $element;
            $elementSettings->type = $type;
            $elementSettings->setting = $setting;
            $elementSettings->save();
        }
        else
        {
            $elementSettings = new ElementSetting();
            $elementSettings->owner_id = $this->user->id;
            $elementSettings->page = $page;
            $elementSettings->element = $element;
            $elementSettings->type = $type;
            $elementSettings->setting = $setting;
            $elementSettings->save();
        }
    }

    public function UpdateSetting(Request $request)
    {
        $page = $request->Page;
        $element = $request->Element;
        $type = $request->Type;
        $setting = $request->Setting;

        $existingSetting = ElementSetting::where('owner_id', $this->user->id)
            ->where('page', $page)
            ->where('element', $element)
            ->where('type', $type)
            ->first();

        if (isset($existingSetting->owner_id))
        {
            $elementSettings = ElementSetting::find($existingSetting->id)->first();
            $elementSettings->page = $page;
            $elementSettings->element = $element;
            $elementSettings->type = $type;
            $elementSettings->setting = $setting;
            $elementSettings->save();
        }
        else
        {
            $elementSettings = new ElementSetting();
            $elementSettings->owner_id = $this->user->id;
            $elementSettings->page = $page;
            $elementSettings->element = $element;
            $elementSettings->type = $type;
            $elementSettings->setting = $setting;
            $elementSettings->save();
        }
    }
}
