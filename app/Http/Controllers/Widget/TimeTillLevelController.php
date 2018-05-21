<?php

namespace App\Http\Controllers\Widget;

use App\ExperienceLog;
use App\Http\Controllers\BackendController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Widget\ExperienceGainedController;

class TimeTillLevelController extends BackendController
{
    public function Index()
    {
        return view('Backend.Widgets.TimeTillLevel.Core');
    }

    public function GetTimeTillLevelContent(Request $request)
    {
        if (!isset($this->currentCharacter->id)) { return null; }

        $ExperienceGained = $this->GetExperienceGained();

        $minutesTillLevel = 0;
        if ($ExperienceGained > 0)
        {
            $expNextLevel = $this->CalculateExperience($this->GetCharacterClassLevel($this->currentCharacter->current_job) + 1);
            $expPerMinute = $ExperienceGained / 10;
            @$minutesTillLevel = ($expNextLevel - $this->currentCharacter->current_experience) / $expPerMinute;
        }

        return view('Backend.Widgets.TimeTillLevel.CoreContent', [ "TimeTillLevel" => number_format(ceil($minutesTillLevel)) ]);
    }

    public function GetExperienceGained()
    {
        $experienceMessages = ExperienceLog::where('owner_id', $this->user->id)
            ->where('skill', $this->currentCharacter->current_job)
            ->where('timestamp', '>', Carbon::now()->subMinutes(10)->toDateTimeString())
            ->where('player_name', $this->currentCharacter->player_name)
            ->get();

        $experienceGained = 0;

        foreach ($experienceMessages AS $expMsg)
        {
            $experienceGained += $expMsg['exp_gained'];
        }

        return $experienceGained;
    }
}
