<?php

namespace App\Http\Controllers;

use App\UserDevice;
use Illuminate\Http\Request;

class NotificationsController extends BackendController
{
    public function SetPlayerID(Request $request)
    {
        $deviceExists = UserDevice::where('owner_id', $this->user->id)->where('player_id', $request->PlayerID)->first();

        if (isset($deviceExists->id))
        {
            return;
        }

        $device = new UserDevice();
        $device->owner_id = $this->user->id;
        $device->player_id = $request->PlayerID;
        $device->enabled = 1;
        $device->save();
    }

    public function SetEnabledStatus(Request $request)
    {
        if ($request->Enabled == 1)
        {
            $device = UserDevice::where('owner_id', $this->user->id)->where('player_id', $request->PlayerID)->first();

            if (!isset($device->enabled))
            {
                return;
            }

            $device->enabled = 1;
            $device->save();
        }
        else
        {
            $device = UserDevice::where('owner_id', $this->user->id)->where('player_id', $request->PlayerID)->first();

            if (!isset($device->enabled))
            {
                return;
            }

            $device->enabled = 0;
            $device->save();
        }
    }
}