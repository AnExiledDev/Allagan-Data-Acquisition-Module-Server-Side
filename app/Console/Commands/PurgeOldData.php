<?php

namespace App\Console\Commands;

use App\ActionLog;
use App\BuddyLog;
use App\Character;
use App\ChatLog;
use App\ChatQueue;
use App\CombatLog;
use App\CommandQueue;
use App\CraftingLog;
use App\ExperienceLog;
use App\GatheringLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PurgeOldData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:purgeolddata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ActionLog::where('created_at', '<', Carbon::now()->subDays(1))->delete();
        ChatLog::where('created_at', '<', Carbon::now()->subDays(1))->delete();
        CommandQueue::where('created_at', '<', Carbon::now()->subMinutes(10))->delete();
        CombatLog::where('created_at', '<', Carbon::now()->subDays(1))->delete();
        CraftingLog::where('created_at', '<', Carbon::now()->subDays(1))->delete();
        ExperienceLog::where('created_at', '<', Carbon::now()->subDays(1))->delete();
        GatheringLog::where('created_at', '<', Carbon::now()->subDays(1))->delete();
        BuddyLog::where('created_at', '<', Carbon::now()->subMinutes(10))->delete();

        Character::where('updated_at', '<', Carbon::now()->subDays(60))->delete();
    }
}
