<?php

namespace App\Console\Commands;

use App\DBItem;
use App\DBItemRecipe;
use Illuminate\Console\Command;

class GenerateItemsDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generatedb:items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fills in the items database from XIVDB.';

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
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, 'https://api.xivdb.com/item');
        $result = curl_exec($ch);
        curl_close($ch);

        DBItem::where('id', '>', 0)->delete();
        DBItemRecipe::where('id', '>', 0)->delete();

        $items = json_decode($result);

        foreach ($items as $item)
        {
            $DBItem = new DBItem();
            $DBItem->xivdb_id = $item->id;
            $DBItem->lodestone_id = $item->lodestone_id;
            $DBItem->xivdb_name = $item->name;
            $DBItem->name_ja = $item->name_ja;
            $DBItem->name_en = $item->name_en;
            $DBItem->name_fr = $item->name_fr;
            $DBItem->name_de = $item->name_de;
            $DBItem->name_cns = $item->name_cns;
            $DBItem->save();

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, 'https://api.xivdb.com/item/' . $item->id);
            $result2 = curl_exec($ch);
            curl_close($ch);

            $itemDetail = json_decode($result2);

            if (isset($itemDetail->craftable[0]->tree))
            {
                foreach ($itemDetail->craftable[0]->tree as $itemReq)
                {
                    $ItemRecipe = new DBItemRecipe();
                    $ItemRecipe->parent_item_id = $itemDetail->id;
                    $ItemRecipe->item_id = $itemReq->id;
                    $ItemRecipe->quantity = $itemReq->quantity;
                    $ItemRecipe->save();
                }
            }
        }
    }
}
