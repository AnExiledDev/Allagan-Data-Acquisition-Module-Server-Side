<?php

namespace App\Http\Controllers;

use App\CommandQueue;
use App\UserBotBase;
use App\UserPlugin;
use Illuminate\Http\Request;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\Auth;

class BotInfoController extends BackendController
{
    public $BotBaseRunning;
    public $SelectedBotBase;

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

    public function Index()
    {
        return view('Backend.BotInformation.Index');
    }

    public function GetBotStatus()
    {
        $BotBases = UserBotBase::where('owner_id', $this->user->id)->first();

        if (!isset($BotBases->bot_bases_data))
        {
            return;
        }

        $BotBasesDecoded = $this->DecodeJSON($BotBases->bot_bases_data)['Bots'];

        foreach ($BotBasesDecoded as $BotBase)
        {
            if ($BotBase['IsSelected'] == true)
            {
                $this->SelectedBotBase = $BotBase['Name'];
            }

            if ($BotBase['IsRunning'] == true)
            {
                $this->BotBaseRunning = true;
            }
        }
    }

    public function DisplayBotStatus()
    {
        $this->GetBotStatus();
        return view('Backend.BotInformation.BotStatusTableStructure', [ 'IsBotBaseRunning' => $this->BotBaseRunning, 'SelectedBotBase' => $this->SelectedBotBase ]);
    }

    public function GetBotBases()
    {
        $BotBases = UserBotBase::where('owner_id', $this->user->id)->first();

        if (!isset($BotBases->bot_bases_data))
        {
            return array();
        }

        $BotBasesDecoded = $this->DecodeJSON($BotBases->bot_bases_data)['Bots'];

        return $BotBasesDecoded;
    }

    public function DisplayBotBases()
    {
        return view('Backend.BotInformation.BotBasesTableStructure', [ 'BotBases' => $this->GetBotBases() ]);
    }

    public function GetPlugins()
    {
        $Plugins = UserPlugin::where('owner_id', $this->user->id)->first();

        if (!isset($Plugins->plugins_data))
        {
            return array();
        }

        $PluginsDecoded = $this->DecodeJSON($Plugins->plugins_data)['Plugins'];

        return $PluginsDecoded;
    }

    public function DisplayPlugins()
    {
        return view('Backend.BotInformation.PluginsTableStructure', [ 'Plugins' => $this->GetPlugins() ]);
    }

    public function StartStopBotBase()
    {
        $this->GetBotStatus();

        if ($this->BotBaseRunning == true)
        {
            $Command = new CommandQueue();
            $Command->owner_id = $this->user->id;
            $Command->player_name = $this->currentCharacter->player_name;
            $Command->type = "StopBotBase";
            $Command->command = "";
            $Command->save();
        }
        else
        {
            $Command = new CommandQueue();
            $Command->owner_id = $this->user->id;
            $Command->player_name = $this->currentCharacter->player_name;
            $Command->type = "StartBotBase";
            $Command->command = "";
            $Command->save();
        }
    }

    public function SelectBotBase(Request $request)
    {
        $BotBase = urldecode($request->BotBase);

        $Command = new CommandQueue();
        $Command->owner_id = $this->user->id;
        $Command->player_name = $this->currentCharacter->player_name;
        $Command->type = "StopBotBase";
        $Command->command = "";
        $Command->save();

        $Command = new CommandQueue();
        $Command->owner_id = $this->user->id;
        $Command->player_name = $this->currentCharacter->player_name;
        $Command->type = "SetBotBase";
        $Command->command = $BotBase;
        $Command->save();
    }

    public function SelectAndStartBotBase(Request $request)
    {
        $BotBase = urldecode($request->BotBase);

        $Command = new CommandQueue();
        $Command->owner_id = $this->user->id;
        $Command->player_name = $this->currentCharacter->player_name;
        $Command->type = "StopBotBase";
        $Command->command = "";
        $Command->save();

        $Command = new CommandQueue();
        $Command->owner_id = $this->user->id;
        $Command->player_name = $this->currentCharacter->player_name;
        $Command->type = "SetBotBase";
        $Command->command = $BotBase;
        $Command->save();

        $Command = new CommandQueue();
        $Command->owner_id = $this->user->id;
        $Command->player_name = $this->currentCharacter->player_name;
        $Command->type = "StartBotBase";
        $Command->command = "";
        $Command->save();
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
}
