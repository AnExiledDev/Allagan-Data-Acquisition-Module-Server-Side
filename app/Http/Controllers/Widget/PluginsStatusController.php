<?php

namespace App\Http\Controllers\Widget;

use App\CommandQueue;
use App\Http\Controllers\BackendController;
use App\UserPlugin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PluginsStatusController extends BackendController
{
    public function Index()
    {
        return view('Backend.Widgets.PluginsStatus.Core');
    }

    public function GetPluginsStatusContent(Request $request)
    {
        $Plugins = UserPlugin::where('owner_id', $this->user->id)->first();

        if (!isset($Plugins->plugins_data))
        {
            $PluginsDecoded = array();
        }
        else
        {
            $PluginsDecoded = $this->DecodeJSON($Plugins->plugins_data)['Plugins'];
        }

        return view('Backend.Widgets.PluginsStatus.CoreContent', [ "Plugins" => $PluginsDecoded ]);
    }

    public function EnableDisablePlugin(Request $request)
    {
        $Plugin = urldecode($request->Plugin);
        $Action = $request->Action;

        if ($Action == "Enable")
        {
            $Command = new CommandQueue();
            $Command->owner_id = $this->user->id;
            $Command->player_name = $this->currentCharacter->player_name;
            $Command->type = "EnablePlugin";
            $Command->command = $Plugin;
            $Command->save();
        }
        else
        {
            $Command = new CommandQueue();
            $Command->owner_id = $this->user->id;
            $Command->player_name = $this->currentCharacter->player_name;
            $Command->type = "DisablePlugin";
            $Command->command = $Plugin;
            $Command->save();
        }
    }

    private function DecodeJSON($json)
    {
        $json = mb_convert_encoding($json, "UTF-8");
        $decodedJSON = json_decode($json, true);

        if (json_last_error() != JSON_ERROR_NONE)
        {
            return null;
        }

        return $decodedJSON;
    }
}
