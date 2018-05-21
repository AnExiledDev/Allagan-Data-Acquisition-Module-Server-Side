<?php

namespace App\Http\Controllers\Widget;

use App\DBItem;
use App\ElementSetting;
use App\GatheringLog;
use App\Http\Controllers\BackendController;
use App\UserWidgetSetting;
use App\Widget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemsGatheredListController extends BackendController
{
    public function Index()
    {
        return view('Backend.Widgets.ItemsGatheredList.Core');
    }

    public function GetItemsGatheredListContent(Request $request)
    {
        if (!isset($this->currentCharacter->id)) { return null; }

        $itemsGathered = $this->CreateItemsGatheredArray($request->page);

        return view('Backend.Widgets.ItemsGatheredList.CoreContent', [ "ItemsGathered" => $itemsGathered ]);
    }

    public function GetListDuration()
    {
        /*$widget = Widget::where('widget_name', 'ItemsGatheredList')->first();

        if (!isset($widget->id)) { return 1; }

        $setting = UserWidgetSetting::where('widget_id', $widget->id)
            ->where('setting_name', 'ListDuration')
            ->first();

        if (!isset($setting->id)) { return 1; }

        return $setting->setting_value;*/

        return 1;
    }

    public function CreateItemsGatheredArray($page)
    {
        $listDuration = $this->GetListDuration();

        $itemsGathered = GatheringLog::select('item_name', DB::raw('SUM(amount) as amount'))->where('owner_id', $this->user->id)
            ->where('timestamp', '>', Carbon::now()->subHours($listDuration)->toDateTimeString())
            ->where('player_name', $this->currentCharacter->player_name)
            ->groupBy('item_name')
            ->orderBy('item_name', 'ASC')
            ->get();

        $itemsGatheredList = array();
        foreach ($itemsGathered AS $itemGathered)
        {
            $isHighQuality = false;
            $isCollectable = false;
            $rawName = str_replace("\ue03c", '', $itemGathered['item_name']);
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

            if (strpos($itemGathered['item_name'], '\ue03c') > 0)
            {
                $isHighQuality = true;
            }

            if (strpos($itemGathered['item_name'], '\ue03d') > 0)
            {
                $isCollectable = true;
            }

            array_push($itemsGatheredList, array(
                'xivdb_id' => $xivdb_id,
                'image_url' => $imageURL,
                'name' => urldecode(ucwords($name)),
                'amount' => number_format($itemGathered['amount']),
                'isHighQuality' => $isHighQuality,
                'isCollectable' => $isCollectable)
            );
        }

        return ($itemsGatheredList);
    }
}
