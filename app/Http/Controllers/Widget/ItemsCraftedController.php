<?php

namespace App\Http\Controllers\Widget;

use App\CraftingLog;
use App\Http\Controllers\BackendController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemsCraftedController extends BackendController
{
    public function Index()
    {
        return view('Backend.Widgets.ItemsCrafted.Core');
    }

    public function GetItemsCraftedContent(Request $request)
    {
        if (!isset($this->currentCharacter->id)) { return null; }

        $ItemsCraftedList = new ItemsCraftedListController();

        $itemsCrafted = CraftingLog::where('owner_id', $this->user->id)
            ->where('timestamp', '>', Carbon::now()->subHours($ItemsCraftedList->GetListDuration($request->page))->toDateTimeString())
            ->where('player_name', $this->currentCharacter->player_name)
            ->orderBy('id', 'DESC')
            ->get();

        $totalCrafted = 0;

        foreach ($itemsCrafted as $itemCrafted)
        {
            $totalCrafted += $itemCrafted['amount'];
        }

        return view('Backend.Widgets.ItemsCrafted.CoreContent', [ "ItemsCrafted" => number_format($totalCrafted) ]);
    }
}
