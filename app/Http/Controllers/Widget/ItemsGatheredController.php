<?php

namespace App\Http\Controllers\Widget;

use App\GatheringLog;
use App\Http\Controllers\BackendController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemsGatheredController extends BackendController
{
    public function Index()
    {
        return view('Backend.Widgets.ItemsGathered.Core');
    }

    public function GetItemsGatheredContent(Request $request)
    {
        if (!isset($this->currentCharacter->id)) { return null; }

        $ItemsGatheredList = new ItemsGatheredListController();

        $itemsGathered = GatheringLog::where('owner_id', $this->user->id)
            ->where('timestamp', '>', Carbon::now()->subHours($ItemsGatheredList->GetListDuration($request->page))->toDateTimeString())
            ->where('player_name', $this->currentCharacter->player_name)
            ->orderBy('id', 'DESC')
            ->get();

        $totalGathered = 0;

        foreach ($itemsGathered as $itemGathered)
        {
            $totalGathered += $itemGathered['amount'];
        }

        return view('Backend.Widgets.ItemsGathered.CoreContent', [ "ItemsGathered" => number_format($totalGathered) ]);
    }
}
