<?php

namespace App\Http\Controllers;

use App\Announcement;
use App\Character;
use App\ElementSetting;
use App\Socket;
use App\Subscription;
use App\UserDevice;
use App\UserPage;
use App\UserWidget;
use App\Widget;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class BackendController extends Controller
{
    protected $user;
    protected $characters;
    protected $connectedCharacters;
    protected $currentCharacter;
    protected $timezone;
    protected $subscriptions;
    protected $coreSubscription;
    protected $enabledDevices;
    protected $notificationSettings;
    protected $widgets;
    protected $user_widgets;
    protected $user_pages;
    protected $PageID;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!isset(Auth::user()->id)) { return redirect()->intended(route('Login')); }

            $this->user = Auth::user();
            $this->characters = Character::where('owner_id', $this->user->id)->get();
            $this->connectedCharacters = Socket::where('owner_id', $this->user->id)->get();
            $this->currentCharacter = Character::where('id', $this->user->current_character)->where('owner_id', $this->user->id)->first();
            $this->timezone = ElementSetting::where('owner_id', $this->user->id)->where('page', 'Global')->where('element', 'Timezone')->first();
            $this->subscriptions = Subscription::where('owner_id', $this->user->id)->where('expires_at', '>', Carbon::now())->get();
            $this->enabledDevices = UserDevice::where('owner_id', $this->user->id)->where('enabled', 1)->get();
            $this->notificationSettings = ElementSetting::where('owner_id', $this->user->id)->where('page', 'Notifications')->where('element', 'Chat')->get();
            $this->widgets = Widget::all();
            $this->user_widgets = UserWidget::where('owner_id', $this->user->id)->orderBy('y_position', 'ASC')->orderBy('x_position', 'ASC')->get();
            $this->user_pages = UserPage::where('owner_id', $this->user->id)->get();

            if (!isset($this->timezone->setting))
            {
                $insertSetting = new ElementSetting();
                $insertSetting->owner_id = $this->user->id;
                $insertSetting->page = 'Global';
                $insertSetting->element = 'Timezone';
                $insertSetting->type = 'UTC';
                $insertSetting->setting = '0';
                $insertSetting->save();
            }

            $this->coreSubscription = null;
            foreach ($this->subscriptions as $subscription)
            {
                if ($subscription['module_id'] == 1 && $subscription['expires_at'] > Carbon::now())
                {
                    $this->coreSubscription = $subscription;
                }
            }

            if (!isset($request->Page))
            {
                $request->page = 0;
                $this->PageID = 0;
            }
            else
            {
                $this->PageID = $request->Page;
            }

            View::share('user', $this->user);
            View::share('characters', $this->characters);
            View::share('connectedCharacters', $this->connectedCharacters);
            View::share('currentCharacter', $this->currentCharacter);
            View::share('timezone', $this->timezone);
            View::share('subscriptions', $this->subscriptions);
            View::share('coreSubscription', $this->coreSubscription);
            View::share('notificationSettings', $this->notificationSettings);
            View::share('Widgets', $this->widgets);
            View::share('UserWidgets', $this->user_widgets);
            View::share('UserPages', $this->user_pages);
            View::share('PageID', $this->PageID);

            return $next($request);
        });
    }

    public function CalculateExperience($level)
    {
        $expArray = array(
            1 => 0,
            2 => 300,
            3 => 600,
            4 => 1100,
            5 => 1700,
            6 => 2300,
            7 => 4200,
            8 => 6000,
            9 => 7350,
            10 => 9930,
            11 => 11800,
            12 => 15600,
            13 => 19600,
            14 => 23700,
            15 => 26400,
            16 => 30500,
            17 => 35400,
            18 => 40500,
            19 => 45700,
            20 => 51000,
            21 => 56600,
            22 => 63900,
            23 => 71400,
            24 => 79100,
            25 => 87100,
            26 => 95200,
            27 => 109800,
            28 => 124800,
            29 => 140200,
            30 => 155900,
            31 => 162500,
            32 => 175900,
            33 => 189600,
            34 => 203500,
            35 => 217900,
            36 => 232320,
            37 => 249900,
            38 => 267800,
            39 => 286200,
            40 => 304900,
            41 => 324000,
            42 => 340200,
            43 => 356800,
            44 => 373700,
            45 => 390800,
            46 => 408200,
            47 => 437600,
            48 => 467500,
            49 => 498000,
            50 => 529000,
            51 => 864000,
            52 => 1058400,
            53 => 1267200,
            54 => 1555200,
            55 => 1872000,
            56 => 2217600,
            57 => 2592100,
            58 => 2995200,
            59 => 3427200,
            60 => 3888000,
            61 => 4873000,
            62 => 5316000,
            63 => 5809000,
            64 => 6364000,
            65 => 6995000,
            66 => 7722000,
            67 => 8575000,
            68 => 9593000,
            69 => 10826000,
            70 => 12310000
        );

        return $expArray[$level];
    }
    
    public function GetCharacterClassFromJob($job)
    {
        if ($job == "Bard") { $newJob = "Archer"; }
        if ($job == "Paladin") { $newJob = "Gladiator"; }
        if ($job == "Dragoon") { $newJob = "Lancer"; }
        if ($job == "Warrior") { $newJob = "Marauder"; }
        if ($job == "Ninja") { $newJob = "Rogue"; }
        if ($job == "Monk") { $newJob = "Pugilist"; }
        if ($job == "Scholar") { $newJob = "Arcanist"; }
        if ($job == "Summoner") { $newJob = "Arcanist"; }
        if ($job == "BlackMage") { $newJob = "Thaumaturge"; }
        if ($job == "WhiteMage") { $newJob = "Conjurer"; }

        if (isset($newJob))
        {
            return $newJob;
        }
        else
        {
            return $job;
        }
    }

    public function GetCharacterClassLevel($class)
    {
        $isValid = null;
        $job = $this->GetCharacterClassFromJob($class);

        if ($job == "Archer") {     return $this->currentCharacter->archer_level; }
        if ($job == "Gladiator") {  return $this->currentCharacter->gladiator_level; }
        if ($job == "Lancer") {     return $this->currentCharacter->lancer_level; }
        if ($job == "Marauder") {   return $this->currentCharacter->marauder_level; }
        if ($job == "Rogue") {      return $this->currentCharacter->rogue_level; }
        if ($job == "Pugilist") {   return $this->currentCharacter->pugilist_level; }
        if ($job == "Arcanist") {   return $this->currentCharacter->arcanist_level; }
        if ($job == "Thaumaturge"){ return $this->currentCharacter->thaumaturge_level; }
        if ($job == "Conjurer") {   return $this->currentCharacter->conjurer_level; }

        $isValid = $this->currentCharacter->{strtolower($job) . "_level"};

        if ($isValid != null) { return $isValid; }

        return 0;
    }

    public function GenerateRandomString($length = 25) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
