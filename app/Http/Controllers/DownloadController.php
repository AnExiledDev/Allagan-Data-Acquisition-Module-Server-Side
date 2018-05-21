<?php

namespace App\Http\Controllers;

use App\AuthKey;
use Illuminate\Http\Request;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\Auth;

class DownloadController extends BackendController
{
    public function Index()
    {
        $coreAuthKey = AuthKey::where('owner_id', $this->user->id)->where('type', 'Core')->first();

        return view('Backend.Download', [ 'CoreAuthKey' => $coreAuthKey ]);
    }
}