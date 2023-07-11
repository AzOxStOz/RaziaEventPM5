<?php

namespace AzOxStOz\Task;

use AzOxStOz\Main;
use pocketmine\block\VanillaBlocks;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\math\Vector3;
use pocketmine\utils\Config;

class RaziaTask extends Task
{
    public function onRun(): void
    {
        $startX = 100;
        $startY = 104;
        $startZ = 100;
        $endX = 150;
        $endY = 104;
        $endZ = 150;

        $airBlock = VanillaBlocks::AIR();

        for ($x = $startX; $x <= $endX; $x++) {
            for ($y = $startY; $y <= $endY; $y++) {
                for ($z = $startZ; $z <= $endZ; $z++) {
                    $pos = new Vector3($x, $y, $z);
                    $world = Server::getInstance()->getWorldManager()->getWorld("1");
                    $world->setBlock($pos, $airBlock);
                }
            }
        }
        $this->winnerMessage();
    }

    public function winnerMessage(): void {
        $raziaData = new Config(Main::getInstance()->getDataFolder() . "razia.json", Config::JSON);
        $maxPlayer = "";
        $maxCount = 0;

        foreach ($raziaData->getAll() as $playerName => $playerCount) {
            if ($playerCount > $maxCount) {
                $maxCount = $playerCount;
                $maxPlayer = $playerName;
            }
        }

        if ($maxPlayer !== "") {
            $server = Server::getInstance();
            $server->broadcastMessage("§aThe Razia is finish ! The player with the highest score is:§2 $maxPlayer §a!");
        }
        $raziaData->remove(true);
        $raziaData->save();
    }
}