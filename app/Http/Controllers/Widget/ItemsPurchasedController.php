<?php

namespace App\Http\Controllers\Widget;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemsPurchasedController extends Controller
{
    public function Index()
    {
        return view('Backend.Widgets.ItemsPurchased.Core');
    }

    public function GetItemsCraftedListContent(Request $request)
    {
        return view('Backend.Widgets.ItemsPurchased.CoreContent');
    }
}
