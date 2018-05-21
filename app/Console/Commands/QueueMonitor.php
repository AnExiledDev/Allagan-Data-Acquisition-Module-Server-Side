<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\Socket\SocketHelper;
use App\Console\Commands\Socket\QueueMonitorHelper;
use Illuminate\Support\Facades\Log;
use Monolog;

class QueueMonitor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queuemonitor:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts the QueueMonitor script.';

    protected $socket;
    protected $socketConn;
    protected $accept;

    protected $dataProcessorCount;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->dataProcessors = array();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->socket = new SocketHelper();
        @$this->socketConn = $this->socket->CreateServerSocket("0.0.0.0", "8000");
        $this->socket->Listen($this->socketConn);

        $QueueMonitorHelper = new QueueMonitorHelper();

        $sleepTime = "100000";
        while(true)
        {
            if ($this->accept == null)
            {
                $DataProcessorsCount = count($QueueMonitorHelper->dataProcessors);

                if ($DataProcessorsCount == 0)
                {
                    $QueueMonitorHelper->StartDataProcessor();
                    $this->dataProcessorCount++;
                }

                $this->accept = $this->socket->AcceptData($this->socketConn);
            }
            else
            {
                //usleep($sleepTime);

                $iteration = 1;
                foreach ($QueueMonitorHelper->dataProcessors AS $dataProcessor)
                {
                    /*if ($this->dataProcessorCount < 2)
                    {
                        $QueueMonitorHelper->StartDataProcessor();
                        $this->dataProcessorCount++;
                    }*/

                    if (array_key_exists($dataProcessor, $QueueMonitorHelper->busyDataProcessors)) { continue; }

                    $DataQueueSize = $QueueMonitorHelper->GetDataQueueCount();

                    if ($DataQueueSize == 0) { continue 1; }

                    $dataQueue = $QueueMonitorHelper->GetDataQueue($iteration);

                    $dataString = $iteration . ":;";
                    foreach ($dataQueue AS $data)
                    {
                        $dataString .= $data['id'] . ":;";
                    }

                    $this->socket->WriteData($this->accept, $dataString);

                    array_push($QueueMonitorHelper->busyDataProcessors, $iteration);

                    $iteration++;
                }

                $fromServer = $this->socket->ReadData($this->accept);

                if (strlen($fromServer) > 0)
                {
                    $contentsArray = explode(":;", $fromServer);

                    if (($key = array_search($contentsArray[0], $QueueMonitorHelper->busyDataProcessors)) !== false)
                    {
                        unset($QueueMonitorHelper->busyDataProcessors[$key]);
                    }
                }
            }
        }
    }
}
