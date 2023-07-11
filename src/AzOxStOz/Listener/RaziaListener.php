<?php

namespace AzOxStOz\Listener;

use AzOxStOz\Main;
use pocketmine\block\VanillaBlocks;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\utils\Config;

class RaziaListener implements Listener
{
    /**
     * @param PlayerInteractEvent $event
     * @return void
     * @throws \JsonException
     */
    public function onPlayerInteractEvent(PlayerInteractEvent $event)
    {
        $player = $event->getPlayer();

        $minX = 100;
        $minY = 103;
        $minZ = 100;
        $maxX = 150;
        $maxY = 108;
        $maxZ = 150;

        $playerX = $player->getPosition()->getX();
        $playerY = $player->getPosition()->getY();
        $playerZ = $player->getPosition()->getZ();

        if ($playerX >= $minX && $playerX <= $maxX && $playerY >= $minY && $playerY <= $maxY && $playerZ >= $minZ && $playerZ <= $maxZ) {
            if ($event->getAction() === PlayerInteractEvent::RIGHT_CLICK_BLOCK) {
                $block = $event->getBlock();
                if ($block->getTypeId() === VanillaBlocks::AMETHYST()->getTypeId()) {
                    $block->getPosition()->getWorld()->setBlock($block->getPosition(), VanillaBlocks::AIR());
                    $money = mt_rand(5, 30);
                    $player->sendJukeboxPopup("§aYou've recieve §2{$money}$ §a!");

                    $raziaData = new Config(Main::getInstance()->getDataFolder() . "razia.json", Config::JSON);
                    $playerName = $player->getName();
                    $playerCount = $raziaData->get($playerName, 0) + 1;
                    $raziaData->set($playerName, $playerCount);
                    $raziaData->save();
                }
            }
        }
    }
}