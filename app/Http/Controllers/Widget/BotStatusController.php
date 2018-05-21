<?php

namespace App\Http\Controllers\Widget;

use App\CommandQueue;
use App\Http\Controllers\BackendController;
use App\UserBotBase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BotStatusController extends BackendController
{
    public $BotBaseRunning = false;
    public $SelectedBotBase = "";

    public function Index()
    {
        return view('Backend.Widgets.BotStatus.Core');
    }

    public function GetBotStatusContent(Request $request)
    {
        $this->GetBotStatus();

        return view('Backend.Widgets.BotStatus.CoreContent', [ 'IsBotBaseRunning' => $this->BotBaseRunning, 'SelectedBotBase' => $this->SelectedBotBase ]);
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
