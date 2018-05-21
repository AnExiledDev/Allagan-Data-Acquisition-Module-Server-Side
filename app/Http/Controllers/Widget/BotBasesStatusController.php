<?php

namespace App\Http\Controllers\Widget;

use App\CommandQueue;
use App\Http\Controllers\BackendController;
use App\UserBotBase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BotBasesStatusController extends BackendController
{
    public function Index()
    {
        return view('Backend.Widgets.BotBasesStatus.Core');
    }

    public function GetBotBasesStatusContent(Request $request)
    {
        $BotBases = UserBotBase::where('owner_id', $this->user->id)->first();

        if (!isset($BotBases->bot_bases_data)) { return array(); }

        $BotBasesDecoded = $this->DecodeJSON($BotBases->bot_bases_data)['Bots'];

        return view('Backend.Widgets.BotBasesStatus.CoreContent', [ "BotBases" => $BotBasesDecoded ]);
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
