<?php
namespace App\Console\Commands\Socket;



use App\ActionLog;
use App\BuddyLog;
use App\Character;
use App\ChatLog;
use App\CombatLog;
use App\CraftingLog;
use App\DataProcessor;
use App\DataQueue;
use App\DBItem;
use App\ExperienceLog;
use App\GatheringLog;
use App\UserBotBase;
use App\UserPlugin;
use Carbon\Carbon;

class DataProcessorHelper {
    public $db_items;

    function __construct()
    {
        $this->GetItemsDatabase();
    }

    function GetItemsDatabase()
    {
        $this->db_items = DBItem::all();
    }

    function SanitizeData($data)
    {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

    function GetDataQueueItem($queueID)
    {
        $dataQueueItem = DataQueue::where('id', $queueID)->first();

        return $dataQueueItem;
    }

    function DecodeJSON($fromClient)
    {
        $fromClient = mb_convert_encoding($fromClient, "UTF-8");
        $decodedJSON = json_decode($fromClient, true);

        if (json_last_error() != JSON_ERROR_NONE)
        {
            return null;
        }

        return $decodedJSON;
    }

    function DetermineDataType($json)
    {
        return $json['Type'];
    }

    // In Milliseconds
    function UpdateLatency($id, $executionTime, $processedRows)
    {
        $dataProcessor = DataProcessor::where('id', $id)->first();
        $dataProcessor->latency = $executionTime;
        $dataProcessor->processed_rows = $processedRows;
        $dataProcessor->save();
    }

    function ProcessQueue($queueID)
    {
        if (empty($queueID)) { return; }

        $dataQueueItem = $this->GetDataQueueItem($queueID);

        if(!isset($dataQueueItem->id))
        {
            return;
        }

        $jsonArray = $this->DecodeJSON($dataQueueItem->content);

        if ($jsonArray == null)
        {
            return;
        }

        $type = $this->DetermineDataType($jsonArray);

        if ($type == "ChatMessage")
        {
            $this->ProcessChatMessage($dataQueueItem, $jsonArray);
        }
        elseif ($type == "ActionMessage")
        {
            $this->ProcessActionMessage($dataQueueItem, $jsonArray);
        }
        elseif ($type == "ExperienceMessage")
        {
            $this->ProcessExperienceMessage($dataQueueItem, $jsonArray);
        }
        else if ($type == "CombatMessage")
        {
            $this->ProcessCombatMessage($dataQueueItem, $jsonArray);
        }
        elseif ($type == "GatheringMessage")
        {
            $this->ProcessGatheringMessage($dataQueueItem, $jsonArray);
        }
        elseif ($type == "CraftingMessage")
        {
            $this->ProcessCraftingMessage($dataQueueItem, $jsonArray);
        }
        else if ($type == "PlayerDataMessage")
        {
            $this->ProcessPlayerDataMessage($dataQueueItem, $jsonArray);
        }
        else if ($type == "InventoryDataMessage")
        {
            $this->ProcessInventoryDataMessage($dataQueueItem, $jsonArray);
        }
        else if ($type == "BotBotBasesMessage")
        {
            $this->ProcessBotBotBasesMessage($dataQueueItem, $jsonArray);
        }
        else if ($type == "BotPluginsMessage")
        {
            $this->ProcessBotPluginsMessage($dataQueueItem, $jsonArray);
        }
        else if ($type == "BuddyLogMessage")
        {
            $this->ProcessBuddyLogMessage($dataQueueItem, $jsonArray);
        }
        else if ($type == "ItemSellMessage")
        {
            //$this->ProcessItemSellMessage($dataQueueItem, $jsonArray);
        }
        else if ($type == "ItemPurchaseMessage")
        {
            //$this->ProcessItemPurchaseMessage($dataQueueItem, $jsonArray);
        }
        else if ($type == "HeartbeatMessage")
        {
            //$this->ProcessHeartbeatMessage($dataQueueItem, $jsonArray);
        }
    }

    function ProcessChatMessage($dataQueueItem, $chatMessage)
    {
        $dateTime = date_format(date_create($chatMessage['TimeStamp'] ), 'Y-m-d H:i:s');

        $chatLog = new ChatLog();
        $chatLog->player_name = $chatMessage['PlayerName'];
        $chatLog->owner_id = $dataQueueItem['owner_id'];
        $chatLog->timestamp = $dateTime;
        $chatLog->type = $chatMessage['MessageType'];
        $chatLog->sender = $chatMessage['Sender'];
        $chatLog->message = $this->SanitizeData($chatMessage['Message']);
        $chatLog->save();
    }

    function ProcessActionMessage($dataQueueItem, $actionMessage)
    {
        $dateTime = date_format(date_create($actionMessage['TimeStamp'] ), 'Y-m-d H:i:s');

        $actionLog = new ActionLog();
        $actionLog->player_name = $actionMessage['PlayerName'];
        $actionLog->owner_id = $dataQueueItem['owner_id'];
        $actionLog->timestamp = $dateTime;
        $actionLog->type = $actionMessage['MessageType'];
        $actionLog->message = $this->SanitizeData($actionMessage['Message']);
        $actionLog->save();
    }

    function ProcessExperienceMessage($dataQueueItem, $experienceMessage)
    {
        $dateTime = date_format(date_create($experienceMessage['TimeStamp'] ), 'Y-m-d H:i:s');

        $experienceLog = new ExperienceLog();
        $experienceLog->player_name = $experienceMessage['PlayerName'];
        $experienceLog->owner_id = $dataQueueItem['owner_id'];
        $experienceLog->timestamp = $dateTime;
        $experienceLog->skill = $experienceMessage['Skill'];
        $experienceLog->exp_gained = $experienceMessage['ExpGained'];
        $experienceLog->save();
    }

    function ProcessCombatMessage($dataQueueItem, $combatMessage)
    {
        $dateTime = date_format(date_create($combatMessage['TimeStamp'] ), 'Y-m-d H:i:s');

        $combatLog = new CombatLog();
        $combatLog->player_name = $combatMessage['PlayerName'];
        $combatLog->owner_id = $dataQueueItem['owner_id'];
        $combatLog->timestamp = $dateTime;
        $combatLog->attacker = $combatMessage['Attacker'];
        $combatLog->attackee = $combatMessage['Attackee'];
        $combatLog->class = $combatMessage['Class'];
        $combatLog->spell = $combatMessage['Spell'];
        $combatLog->damage = $combatMessage['Damage'];
        $combatLog->is_miss = $combatMessage['IsMiss'];
        $combatLog->is_auto_attack = $combatMessage['IsAutoAttack'];
        $combatLog->is_critical_attack = $combatMessage['IsCriticalAttack'];
        $combatLog->save();
    }

    function ProcessGatheringMessage($dataQueueItem, $gatheringMessage)
    {
        $dateTime = date_format(date_create($gatheringMessage['TimeStamp'] ), 'Y-m-d H:i:s');

        $gatheringLog = new GatheringLog();
        $gatheringLog->player_name = $gatheringMessage['PlayerName'];
        $gatheringLog->owner_id = $dataQueueItem['owner_id'];
        $gatheringLog->timestamp = $dateTime;
        $gatheringLog->amount = $gatheringMessage['Amount'];
        $gatheringLog->item_name = $this->CleanItemName($gatheringMessage['ItemName']);
        $gatheringLog->save();
    }

    function ProcessCraftingMessage($dataQueueItem, $craftingMessage)
    {
        $dateTime = date_format(date_create($craftingMessage['TimeStamp'] ), 'Y-m-d H:i:s');

        $craftingLog = new CraftingLog();
        $craftingLog->player_name = $craftingMessage['PlayerName'];
        $craftingLog->owner_id = $dataQueueItem['owner_id'];
        $craftingLog->timestamp = $dateTime;
        $craftingLog->amount = $craftingMessage['Amount'];
        $craftingLog->item_name = $this->CleanItemName($craftingMessage['ItemName']);
        $craftingLog->save();
    }

    function ProcessPlayerDataMessage($dataQueueItem, $playerDataMessage)
    {
        $playerData = Character::where('owner_id', $dataQueueItem['owner_id'])->where('player_name', $playerDataMessage['PlayerName'])->first();

        /** Support for the new classes, delete later */

        if (!isset($playerDataMessage['SamuraiLevel']))
        {
            $playerDataMessage['SamuraiLevel'] = 0;
        }

        if (!isset($playerDataMessage['RedMageLevel']))
        {
            $playerDataMessage['RedMageLevel'] = 0;
        }

        if (isset($playerData->player_name))
        {
            $character = Character::where('owner_id', $dataQueueItem['owner_id'])->where('player_name', $playerDataMessage['PlayerName'])->first();
            $character->player_name = $playerDataMessage['PlayerName'];
            $character->current_job = $playerDataMessage['CurrentJob'];
            $character->location = $playerDataMessage['Location'];
            $character->id_location = $playerDataMessage['IdLocation'];
            $character->fate_id = $playerDataMessage['FateId'];
            $character->current_health = $playerDataMessage['CurrentHealth'];
            $character->max_health = $playerDataMessage['MaxHealth'];
            $character->current_mana = $playerDataMessage['CurrentMana'];
            $character->max_mana = $playerDataMessage['MaxMana'];
            $character->current_tp = $playerDataMessage['CurrentTP'];
            $character->max_tp = $playerDataMessage['MaxTP'];
            $character->current_experience = $playerDataMessage['CurrentExperience'];
            $character->current_rested_experience = $playerDataMessage['CurrentRestedExperience'];
            $character->experience_required = $playerDataMessage['ExperienceRequired'];
            $character->gladiator_level = $playerDataMessage['GladiatorLevel'];
            $character->pugilist_level = $playerDataMessage['PugilistLevel'];
            $character->marauder_level = $playerDataMessage['MarauderLevel'];
            $character->lancer_level = $playerDataMessage['LancerLevel'];
            $character->archer_level = $playerDataMessage['ArcherLevel'];
            $character->conjurer_level = $playerDataMessage['ConjurerLevel'];
            $character->thaumaturge_level = $playerDataMessage['ThaumaturgeLevel'];
            $character->carpenter_level = $playerDataMessage['CarpenterLevel'];
            $character->blacksmith_level = $playerDataMessage['BlacksmithLevel'];
            $character->armorer_level = $playerDataMessage['ArmorerLevel'];
            $character->goldsmith_level = $playerDataMessage['GoldsmithLevel'];
            $character->leatherworker_level = $playerDataMessage['LeatherworkerLevel'];
            $character->weaver_level = $playerDataMessage['WeaverLevel'];
            $character->alchemist_level = $playerDataMessage['AlchemistLevel'];
            $character->culinarian_level = $playerDataMessage['CulinarianLevel'];
            $character->miner_level = $playerDataMessage['MinerLevel'];
            $character->botanist_level = $playerDataMessage['BotanistLevel'];
            $character->fisher_level = $playerDataMessage['FisherLevel'];
            $character->arcanist_level = $playerDataMessage['ArcanistLevel'];
            $character->rogue_level = $playerDataMessage['RogueLevel'];
            $character->machinist_level = $playerDataMessage['MachinistLevel'];
            $character->darkknight_level = $playerDataMessage['DarkKnightLevel'];
            $character->astrologian_level = $playerDataMessage['AstrologianLevel'];
            $character->samurai_level = $playerDataMessage['SamuraiLevel'];
            $character->redmage_level = $playerDataMessage['RedMageLevel'];
            $character->strength = $playerDataMessage['Strength'];
            $character->dexterity = $playerDataMessage['Dexterity'];
            $character->vitality = $playerDataMessage['Vitality'];
            $character->intelligence = $playerDataMessage['Intelligence'];
            $character->mind = $playerDataMessage['Mind'];
            $character->piety = $playerDataMessage['Piety'];
            $character->fire_resistance = $playerDataMessage['FireResistance'];
            $character->ice_resistance = $playerDataMessage['IceResistance'];
            $character->wind_resistance = $playerDataMessage['WindResistance'];
            $character->earth_resistance = $playerDataMessage['EarthResistance'];
            $character->lightning_resistance = $playerDataMessage['LightningResistance'];
            $character->water_resistance = $playerDataMessage['WaterResistance'];
            $character->accuracy = $playerDataMessage['Accuracy'];
            $character->critical_hit_rate = $playerDataMessage['CriticalHitRate'];
            $character->determination = $playerDataMessage['Determination'];
            $character->defense = $playerDataMessage['Defense'];
            $character->parry = $playerDataMessage['Parry'];
            $character->magic_defense = $playerDataMessage['MagicDefense'];
            $character->attack_power = $playerDataMessage['AttackPower'];
            $character->skill_speed = $playerDataMessage['SkillSpeed'];
            $character->gathering = $playerDataMessage['Gathering'];
            $character->perception = $playerDataMessage['Perception'];
            $character->slow_resistance = $playerDataMessage['SlowResistance'];
            $character->silence_resistance = $playerDataMessage['SilenceResistance'];
            $character->blind_resistance = $playerDataMessage['BlindResistance'];
            $character->poison_resistance = $playerDataMessage['PoisonResistance'];
            $character->stun_resistance = $playerDataMessage['StunResistance'];
            $character->sleep_resistance = $playerDataMessage['SleepResistance'];
            $character->bind_resistance = $playerDataMessage['BindResistance'];
            $character->heavy_resistance = $playerDataMessage['HeavyResistance'];
            $character->save();

            if ($playerDataMessage['CurrentExperience'] > 0)
            {
                $currentJob = $this->GetCharacterClassFromJob($playerDataMessage['CurrentJob']);
                $character = Character::where('owner_id', $dataQueueItem['owner_id'])->where('player_name', $playerDataMessage['PlayerName'])->first();
                $character->{$currentJob . '_current_exp'} = $playerDataMessage['CurrentExperience'];
                $character->save();
            }
        }
        else
        {
            $character = new Character();
            $character->owner_id = $dataQueueItem['owner_id'];
            $character->player_name = $playerDataMessage['PlayerName'];
            $character->current_job = $playerDataMessage['CurrentJob'];
            $character->location = $playerDataMessage['Location'];
            $character->id_location = $playerDataMessage['IdLocation'];
            $character->fate_id = $playerDataMessage['FateId'];
            $character->current_health = $playerDataMessage['CurrentHealth'];
            $character->max_health = $playerDataMessage['MaxHealth'];
            $character->current_mana = $playerDataMessage['CurrentMana'];
            $character->max_mana = $playerDataMessage['MaxMana'];
            $character->current_tp = $playerDataMessage['CurrentTP'];
            $character->max_tp = $playerDataMessage['MaxTP'];
            $character->current_experience = $playerDataMessage['CurrentExperience'];
            $character->current_rested_experience = $playerDataMessage['CurrentRestedExperience'];
            $character->experience_required = $playerDataMessage['ExperienceRequired'];
            $character->gladiator_level = $playerDataMessage['GladiatorLevel'];
            $character->pugilist_level = $playerDataMessage['PugilistLevel'];
            $character->marauder_level = $playerDataMessage['MarauderLevel'];
            $character->lancer_level = $playerDataMessage['LancerLevel'];
            $character->archer_level = $playerDataMessage['ArcherLevel'];
            $character->conjurer_level = $playerDataMessage['ConjurerLevel'];
            $character->thaumaturge_level = $playerDataMessage['ThaumaturgeLevel'];
            $character->carpenter_level = $playerDataMessage['CarpenterLevel'];
            $character->blacksmith_level = $playerDataMessage['BlacksmithLevel'];
            $character->armorer_level = $playerDataMessage['ArmorerLevel'];
            $character->goldsmith_level = $playerDataMessage['GoldsmithLevel'];
            $character->leatherworker_level = $playerDataMessage['LeatherworkerLevel'];
            $character->weaver_level = $playerDataMessage['WeaverLevel'];
            $character->alchemist_level = $playerDataMessage['AlchemistLevel'];
            $character->culinarian_level = $playerDataMessage['CulinarianLevel'];
            $character->miner_level = $playerDataMessage['MinerLevel'];
            $character->botanist_level = $playerDataMessage['BotanistLevel'];
            $character->fisher_level = $playerDataMessage['FisherLevel'];
            $character->arcanist_level = $playerDataMessage['ArcanistLevel'];
            $character->rogue_level = $playerDataMessage['RogueLevel'];
            $character->machinist_level = $playerDataMessage['MachinistLevel'];
            $character->darkknight_level = $playerDataMessage['DarkKnightLevel'];
            $character->astrologian_level = $playerDataMessage['AstrologianLevel'];
            $character->samurai_level = $playerDataMessage['SamuraiLevel'];
            $character->redmage_level = $playerDataMessage['RedMageLevel'];
            $character->strength = $playerDataMessage['Strength'];
            $character->dexterity = $playerDataMessage['Dexterity'];
            $character->vitality = $playerDataMessage['Vitality'];
            $character->intelligence = $playerDataMessage['Intelligence'];
            $character->mind = $playerDataMessage['Mind'];
            $character->piety = $playerDataMessage['Piety'];
            $character->fire_resistance = $playerDataMessage['FireResistance'];
            $character->ice_resistance = $playerDataMessage['IceResistance'];
            $character->wind_resistance = $playerDataMessage['WindResistance'];
            $character->earth_resistance = $playerDataMessage['EarthResistance'];
            $character->lightning_resistance = $playerDataMessage['LightningResistance'];
            $character->water_resistance = $playerDataMessage['WaterResistance'];
            $character->accuracy = $playerDataMessage['Accuracy'];
            $character->critical_hit_rate = $playerDataMessage['CriticalHitRate'];
            $character->determination = $playerDataMessage['Determination'];
            $character->defense = $playerDataMessage['Defense'];
            $character->parry = $playerDataMessage['Parry'];
            $character->magic_defense = $playerDataMessage['MagicDefense'];
            $character->attack_power = $playerDataMessage['AttackPower'];
            $character->skill_speed = $playerDataMessage['SkillSpeed'];
            $character->gathering = $playerDataMessage['Gathering'];
            $character->perception = $playerDataMessage['Perception'];
            $character->slow_resistance = $playerDataMessage['SlowResistance'];
            $character->silence_resistance = $playerDataMessage['SilenceResistance'];
            $character->blind_resistance = $playerDataMessage['BlindResistance'];
            $character->poison_resistance = $playerDataMessage['PoisonResistance'];
            $character->stun_resistance = $playerDataMessage['StunResistance'];
            $character->sleep_resistance = $playerDataMessage['SleepResistance'];
            $character->bind_resistance = $playerDataMessage['BindResistance'];
            $character->heavy_resistance = $playerDataMessage['HeavyResistance'];
            $character->save();
        }
    }

    function ProcessInventoryDataMessage($dataQueueItem, $playerInventoryMessage)
    {
        $playerData = Character::where('owner_id', $dataQueueItem['owner_id'])->where('player_name', $playerInventoryMessage['PlayerName'])->first();

        if (isset($playerData->player_name))
        {
            $playerData->free_inventory_slots = $playerInventoryMessage['FreeSlots'];
            $playerData->inventory_items = json_encode($playerInventoryMessage['InventoryItems']);
            $playerData->equipped_items = json_encode($playerInventoryMessage['EquippedItems']);
            $playerData->armory_items = json_encode($playerInventoryMessage['ArmoryItems']);
            $playerData->currency_items = json_encode($playerInventoryMessage['Currency']);
            $playerData->crystals_items = json_encode($playerInventoryMessage['Crystals']);
            $playerData->keyitems_items = json_encode($playerInventoryMessage['KeyItems']);
            $playerData->save();
        }
    }

    function ProcessBotBotBasesMessage($dataQueueItem, $message)
    {
        $botBase = UserBotBase::where('owner_id', $dataQueueItem['owner_id'])->first();

        if (isset($botBase->owner_id))
        {
            $botBase = UserBotBase::where('owner_id', $dataQueueItem['owner_id'])->first();
            $botBase->bot_bases_data = json_encode($message['BotBases']);
            $botBase->save();
        }
        else
        {
            $log = new UserBotBase();
            $log->owner_id = $dataQueueItem['owner_id'];
            $log->bot_bases_data = json_encode($message['BotBases']);
            $log->save();
        }
    }

    function ProcessBotPluginsMessage($dataQueueItem, $message)
    {
        $plugin = UserPlugin::where('owner_id', $dataQueueItem['owner_id'])->first();

        if (isset($plugin->owner_id))
        {
            $plugin = UserPlugin::where('owner_id', $dataQueueItem['owner_id'])->first();
            $plugin->plugins_data = json_encode($message['Plugins']);
            $plugin->save();
        }
        else
        {
            $log = new UserPlugin();
            $log->owner_id = $dataQueueItem['owner_id'];
            $log->plugins_data = json_encode($message['PlayerName']);
            $log->save();
        }
    }

    function ProcessBuddyLogMessage($dataQueueItem, $message)
    {
        $dateTime = date_format(date_create($message['TimeStamp'] ), 'Y-m-d H:i:s');

        $log = new BuddyLog();
        $log->owner_id = $dataQueueItem['owner_id'];
        $log->player_name = $message['PlayerName'];
        $log->timestamp = $dateTime;
        $log->color = $message['Color'];
        $log->message = $message['Message'];
        $log->save();
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
        if ($job == "Samurai") { $newJob = "Conjurer"; }
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

    public function CleanItemName($name)
    {
        $name = strtolower($name);

        if (strpos($name, 'of') !== false)
        {
            $nameExploded = explode('of', $name);

            $name = $nameExploded[1];
        }

        $matches = array();
        foreach ($this->db_items as $item)
        {
            $compare = levenshtein($name, strtolower($item['name_en']));

            if($compare <= 5)
            {
                $matches[$compare] = $item['name_en'];
            }
        }

        ksort($matches);
        foreach($matches as $key => $value)
        {
            $name = $value;
            break;
        }

        return trim($name);
    }
}