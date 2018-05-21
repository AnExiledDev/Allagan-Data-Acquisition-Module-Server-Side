<?php

namespace App\Http\Controllers;

use App\DBItem;
use Illuminate\Http\Request;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\Auth;

class InventoryController extends BackendController
{
    public function Index()
    {
        return view('Backend.ModuleNotAvailable');
    }
}