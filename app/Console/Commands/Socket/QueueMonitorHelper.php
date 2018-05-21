<?php
namespace App\Console\Commands\Socket;

use App\DataProcessor;
use App\DataQueue;
use App\Setting;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\ProcessUtils;

class QueueMonitorHelper {
    public $db;
    public $dataProcessors;
    public $busyDataProcessors;
    public $logFile;
    public $isUpdateBreaking;
    public $latestVersion;

    function __construct()
    {
        $this->dataProcessors = array();
        $this->busyDataProcessors = array();

        exec("pkill -f dataprocessor:start");

        DataProcessor::truncate();

        $this->isUpdateBreaking = Setting::where('name', 'LatestUpdateIsBreaking')->first();

        if ($this->isUpdateBreaking->setting_value == "true")
        {
            $this->latestVersion = Setting::where('name', 'LatestPluginVersion')->first();

            DataQueue::where('version', '!=', $this->latestVersion->setting_value)->delete();
        }
    }

    function StartDataProcessor()
    {
        $id = count($this->dataProcessors) + 1;

        $binary = str_replace("'", '', ProcessUtils::escapeArgument((new PhpExecutableFinder())->find(false)));
        $artisan = defined('ARTISAN_BINARY') ? ProcessUtils::escapeArgument(ARTISAN_BINARY) : 'artisan';

        exec($binary . ' ' . base_path() . '/' . $artisan . ' dataprocessor:start ' . $id . ' > /dev/null 2>&1 & echo $!;', $output);

        $dataProcessor = new DataProcessor();
        $dataProcessor->latency = 0;
        $dataProcessor->processed_rows = 0;
        $dataProcessor->save();

        array_push($this->dataProcessors, $id);
    }

    function GetDataQueueCount()
    {
        $dataQueueCount = DataQueue::count();

        return $dataQueueCount;
    }

    function GetDataQueue($iteration)
    {
        $dataQueue = DataQueue::orderBy('id', 'ASC')->offset(0)->limit(100)->get();

        return $dataQueue;
    }
}