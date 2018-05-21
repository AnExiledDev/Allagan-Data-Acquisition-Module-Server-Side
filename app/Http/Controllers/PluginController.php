<?php

namespace App\Http\Controllers;

use App\AuthKey;
use App\BillingHistory;
use App\ChatQueue;
use App\Setting;
use App\Socket;
use App\Subscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminated\Helpers\Artisan\Command;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\ProcessUtils;

class PluginController extends Controller
{
    public function LatestVersion()
    {
        $latestVersion = Setting::where('name', 'LatestPluginVersion')->first();

        echo $latestVersion->setting_value;
    }

    public function ValidateKey()
    {
        $checkKey = $this->SanitizeData($_GET['key']);

        $key = AuthKey::where('auth_key', $checkKey)->first();

        if(isset($key->id))
        {
            echo "true";
        }
        else
        {
            echo "false";
        }
    }

    public function GetChatLine()
    {
        $CoreAuthKey = $_GET['CoreAuthKey'];
        $PlayerName = $_GET['PlayerName'];

        $owner_id = AuthKey::where('auth_key', $CoreAuthKey)->first();

        $chatLine = ChatQueue::where('owner_id', $owner_id->owner_id)
            ->where('sent', 0)
            ->where('player_name', $PlayerName)
            ->where('timestamp', '>', Carbon::now()->subMinutes(30)->toDateTimeString())
            ->first();

        if (isset($chatLine->id))
        {
            $markAsSent = ChatQueue::where('id', $chatLine->id)->first();
            $markAsSent->sent = 1;
            $markAsSent->save();

            echo $chatLine->message;
        }
        else
        {
            echo "No Messages!";
        }
    }

    public function AvailablePort(Request $request)
    {
        $usedSockets = array();
        $sockets = Socket::all();

        foreach ($sockets AS $socket)
        {
            $usedSockets[$socket['port']] = $socket['port'];
        }

        for ($i = 8100; $i < 8600; $i++)
        {
            if (array_key_exists($i, $usedSockets) == false)
            {
                $authKey = AuthKey::where('auth_key', $request->CoreAuthKey)->where('type', 'Core')->first();

                if (!isset($authKey->id))
                {
                    exit ("Incorrect auth key.");
                }

                /*$billingHistory = BillingHistory::where('owner_id', $authKey->owner_id)->orderBy('created_at', 'DESC')->get();

                $accountBalance = 0;
                foreach ($billingHistory as $history)
                {
                    $accountBalance += $history->amount;
                }

                if ($accountBalance > 1 && Carbon::now()->day >= 4)
                {
                    exit ("You have an outstanding balance that must be paid. You will be unable to connect to our servers until you do so.");
                }*/

                /*$subscription = Subscription::where('owner_id', $authKey->owner_id)->where('module_id', 1)->first();

                if ($subscription->expires_at < Carbon::now())
                {
                    exit ("Your subscription has expired, please go to the ADAM website to pay your subscription.");
                }*/

                $binary = str_replace("'", '', ProcessUtils::escapeArgument((new PhpExecutableFinder())->find(false)));
                $artisan = defined('ARTISAN_BINARY') ? ProcessUtils::escapeArgument(ARTISAN_BINARY) : 'artisan';

                exec($binary . ' ' . base_path() . '/' . $artisan . ' server:start ' . $authKey->owner_id . ' ' . $i . ' > /dev/null 2>&1 & echo $!;', $output);

                $socket = new Socket();
                $socket->player_name = "";
                $socket->owner_id = $authKey->owner_id;
                $socket->port = $i;
                $socket->process_id = $output[0];
                $socket->last_message = Carbon::now();
                $socket->save();

                echo $i;
                break;
            }
        }
    }
}
