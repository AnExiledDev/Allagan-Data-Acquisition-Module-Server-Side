<?php

namespace App\Http\Controllers\Widget;

use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FreeBagSlotsController extends BackendController
{
    public function Index()
    {
        return view('Backend.Widgets.FreeBagSlots.Core');
    }

    public function GetFreeBagSlotsContent(Request $request)
    {
        if (!isset($this->currentCharacter->id)) { return null; }

        return view('Backend.Widgets.FreeBagSlots.CoreContent', [ 'FreeBagSlots' => $this->currentCharacter->free_inventory_slots ]);
    }
}
