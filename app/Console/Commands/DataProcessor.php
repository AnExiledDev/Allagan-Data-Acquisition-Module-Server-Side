<?php

namespace App\Console\Commands;

use App\Console\Commands\Socket\DataProcessorHelper;
use App\Console\Commands\Socket\SocketHelper;
use App\DataQueue;
use Illuminate\Console\Command;
use Monolog;

class DataProcessor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dataprocessor:start {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts a Data Processor Instance.';

    protected $socket;
    protected $socketConn;
    protected $latencyArray = array();
    protected $dataProcessed = 0;

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
        $this->socket = new SocketHelper();
        $this->socketConn = $this->socket->CreateClientSocket("0.0.0.0", "8000");

        $DataProcessor = new DataProcessorHelper();

        $lastLatencyUpdate = time();
        $dataProcessed = 0;
        while(true)
        {
            $fromServer = $this->socket->ReadData($this->socketConn);

            if (strlen($fromServer) > 0)
            {
                $contentsArray = explode(":;", $fromServer);
                if ($contentsArray[0] == $this->argument('id'))
                {
                    array_shift($contentsArray);

                    foreach ($contentsArray AS $queueID)
                    {
                        $DataProcessor->ProcessQueue($queueID);
                        DataQueue::where('id', $queueID)->delete();
                        $dataProcessed++;
                    }

                    if ((time() - $lastLatencyUpdate) > 60)
                    {
                        $DataProcessor->UpdateLatency($this->argument('id'), (time() - $lastLatencyUpdate), $dataProcessed);
                        $lastLatencyUpdate = time();
                        $dataProcessed = 0;
                    }

                    $this->socket->WriteData($this->socketConn, $fromServer);
                }
            }
        }
    }
}
