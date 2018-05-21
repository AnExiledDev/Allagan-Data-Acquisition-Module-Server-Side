<?php

namespace App\Http\Controllers\Widget;

use App\CraftingLog;
use App\DBItem;
use App\Http\Controllers\BackendController;
use App\Widget;
use App\WidgetSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemsCraftedListController extends BackendController
{
    public function Index()
    {
        return view('Backend.Widgets.ItemsCraftedList.Core');
    }

    public function GetItemsCraftedListContent(Request $request)
    {
        if (!isset($this->currentCharacter->id)) { return null; }

        $itemsCrafted = $this->CreateItemsCraftedArray($request->page);

        return view('Backend.Widgets.ItemsCraftedList.CoreContent', [ "ItemsCrafted" => $itemsCrafted ]);
    }

    public function GetListDuration()
    {
        /*$widget = Widget::where('owner_id', $this->user->id)
            ->where('page_id', $page)
            ->where('widget_name', 'ItemsCraftedList')
            ->first();

        if (!isset($widget->id)) { return 1; }

        $setting = WidgetSetting::where('widget_id', $widget->id)
            ->where('setting_name', 'ListDuration')
            ->first();

        if (!isset($setting->id)) { return 1; }

        return $setting->setting_value;*/

        return 1;
    }

    public function CreateItemsCraftedArray($page)
    {
        $listDuration = $this->GetListDuration();

        $itemsCrafted = CraftingLog::select('item_name', DB::raw('SUM(amount) as amount'))->where('owner_id', $this->user->id)
            ->where('timestamp', '>', Carbon::now()->subHours($listDuration)->toDateTimeString())
            ->where('player_name', $this->currentCharacter->player_name)
            ->groupBy('item_name')
            ->orderBy('item_name', 'ASC')
            ->get();

        $itemsCraftedList = array();
        foreach ($itemsCrafted AS $itemCrafted)
        {
            $isHighQuality = false;
            $isCollectable = false;
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

            if (strpos($itemCrafted['item_name'], '\ue03c') > 0)
            {
                $isHighQuality = true;
            }

            if (strpos($itemCrafted['item_name'], '\ue03d') > 0)
            {
                $isCollectable = true;
            }

            array_push($itemsGatheredList, array(
                'xivdb_id' => $xivdb_id,
                'image_url' => $imageURL,
                'name' => urldecode(ucwords($name)),
                'amount' => number_format($itemCrafted['amount']),
                'isHighQuality' => $isHighQuality,
                'isCollectable' => $isCollectable)
            );
        }

        return ($itemsCraftedList);
    }
}
