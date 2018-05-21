<?php

namespace App\Http\Controllers\Widget;

use App\ExperienceLog;
use App\Http\Controllers\BackendController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExperienceGainedController extends BackendController
{
    public function Index()
    {
        return view('Backend.Widgets.ExperienceGained.Core');
    }

    public function GetExperienceGainedContent(Request $request)
    {
        if (!isset($this->currentCharacter->id)) { return null; }

        $experienceGained = $this->GetExperienceGained();

        return view('Backend.Widgets.ExperienceGained.CoreContent', [ 'ExperienceGained' => number_format($experienceGained) ]);
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
