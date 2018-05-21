<?php

namespace App\Http\Controllers\Widget;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemsSoldController extends Controller
{
    public function Index()
    {
        return view('Backend.Widgets.ItemsSold.Core');
    }

    public function GetItemsCraftedListContent(Request $request)
    {
        return view('Backend.Widgets.ItemsSold.CoreContent');
    }
}
