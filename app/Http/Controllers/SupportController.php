<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\Auth;

class SupportController extends BackendController
{
    public function Index()
    {
        return view('Backend.Support');
    }
}
