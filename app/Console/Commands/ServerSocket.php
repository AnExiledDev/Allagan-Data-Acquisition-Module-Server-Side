<?php

namespace App\Console\Commands;

use App\AuthKey;
use App\CommandQueue;
use App\DataQueue;
use App\Socket;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Console\Commands\Socket\SocketHelper;
use Illuminate\Support\Facades\Log;
use Monolog;

/**
 * Class ServerSocket
 * @package App\Console\Commands
 */
class ServerSocket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'server:start {owner_id} {port}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts a socket server instance.';

    /**
     * @var SocketHelper
     */
    protected $socket;

    /**
     * @var null
     */
    protected $accept = null;

    /**
     * @var resource
     */
    protected $socketConn;

    /**
     * @var bool
     */
    protected $connected = false;

    /**
     * @var bool
     */
    protected $isProcessing = false;

    protected $checkedCommands = 0;
    protected $socketPlayerName;
    protected $lastMessageTime = null;

    /**
     * Create a new command instance.
     *
     * @param SocketHelper $socket
     *
     * @return \App\Console\Commands\ServerSocket
     */
    public function __construct(SocketHelper $socket)
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
        $log = new Monolog\Logger(__METHOD__);
        $log->pushHandler(new Monolog\Handler\StreamHandler(storage_path() . '/logs/SocketServerLogs/' . $this->argument('owner_id') . '-' . $this->argument('port') . '-' . date("Y") . '_' . date("m") . '_' . date("d") . '__' . date("G") . '.log'));

        //$log->addInfo("Starting socket server for port: " . $this->argument('port') . " for owner ID: " . $this->argument('owner_id'));

        $this->socket = new SocketHelper();
        $this->socketConn = $this->socket->CreateServerSocket("0.0.0.0", $this->argument('port'));
        $this->socket->Listen($this->socketConn);

        $this->lastMessageTime = time();

        $loop = 0;
        while(true)
        {
            $loop++;
            if ($this->accept == null)
            {
                $this->accept = $this->socket->AcceptData($this->socketConn);
                //$log->addInfo("Socket has been accepted at: " . time() . " with value " . $this->accept);
            }
            else
            {
                $owner_id = $this->argument('owner_id');

                if ((time() - $this->checkedCommands) > 2 && strlen($this->socketPlayerName) > 0 && isset($owner_id))
                {
                    $commands = CommandQueue::where('owner_id', $owner_id)
                        ->where('player_name', $this->socketPlayerName)
                        ->where('created_at', '>', Carbon::now()->subMinutes(1)->toDateTimeString())
                        ->orderBy('id', 'ASC')
                        ->get();

                    if (count($commands) > 0)
                    {
                        foreach ($commands as $command)
                        {
                            $this->socket->WriteData($this->accept, '{"Type":"' . $command['type'] . '","Command":"' . addslashes($command['command']) . '"}');

                            CommandQueue::where('id', $command['id'])->delete();

                            //$log->addInfo("Sent command: " . '{"Type":"' . $command['type'] . '","Command":"' . addslashes($command['command']) . '"}');
                        }
                    }

                    $this->checkedCommands = time();
                }

                $startReadClientData = time();
                $fromClient = $this->socket->ReadClientData($this->accept);
                $endReadClientData = time();

                if (($endReadClientData - $startReadClientData) > 30)
                {
                    //$log->addInfo("ReadClientData operation took more than 30 seconds to run.");
                }

                if (time() - $this->lastMessageTime > 30)
                {
                    //$log->addInfo("User has probably disconnected, we're shutting down the server.");
                    $this->connected = false;

                    exit("USER HAS DISCONNECTED!");
                }

                $this->connected = true;
                $fromClientArray = explode("\\END", $fromClient);

                foreach ($fromClientArray as $fromClient)
                {
                    if (strlen($fromClient) > 0)
                    {
                        $this->lastMessageTime = time();

                        $fromClient = mb_convert_encoding($fromClient, "UTF-8");
                        $decodedJSON = json_decode($fromClient, true);

                        if (json_last_error() != JSON_ERROR_NONE)
                        {
                            $log->addDebug("Encountered error parsing JSON. Error is JSON_ERROR_NONE");
                            continue;
                        }

                        $log->addDebug("Received data from client: " . $fromClient);

                        $owner = AuthKey::where('auth_key', $decodedJSON['CoreAuthKey'])->first();

                        if (!isset($owner->owner_id))
                        {
                            $log->addDebug("Auth key is invalid. Exiting.");
                            exit("Unable to find owner.");
                        }

                        if ($owner->owner_id != $this->argument('owner_id'))
                        {
                            //$log->addInfo("User owner ID's do not match. Expected owner ID: " . $this->argument('owner_id') . " received auth key for owner ID: " . $owner->owner_id . ". Exiting.");
                            exit("Wrong owner.");
                        }

                        $dataQueue = new DataQueue();
                        $dataQueue->player_name = $decodedJSON['PlayerName'];
                        $dataQueue->owner_id = $this->argument('owner_id');
                        $dataQueue->port = $this->argument('port');
                        $dataQueue->version = $decodedJSON['Version'];
                        $dataQueue->content = $fromClient;
                        $dataQueue->save();

                        $socket = Socket::where('port', $this->argument('port'))->first();
                        $socket->player_name = $decodedJSON['PlayerName'];
                        $socket->last_message = Carbon::now();
                        $socket->save();

                        $this->socketPlayerName = $decodedJSON['PlayerName'];
                    }
                }
            }

            if ($loop > 10000)
            {
                //$log->addInfo("Loop over 10,000. Resetting loop.");
                $loop = 0;
            }
        }
    }
}
