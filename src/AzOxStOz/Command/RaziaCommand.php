<?php

namespace AzOxStOz\Command;

use AzOxStOz\Main;
use AzOxStOz\Task\RaziaTask;
use pocketmine\block\VanillaBlocks;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\world\Position;

class RaziaCommand extends Command
{
    /**
     * @param string $name
     * @param string $description
     * @param array $aliases
     */
    public function __construct(string $name, string $description, array $aliases)
    {
        parent::__construct($name, $description, null, $aliases);
        $this->setPermission("razia.cmd");
        $this->setPermissionMessage("§cYou don't have the permission !");
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return mixed|void
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): void
    {
        if (!$sender instanceof Player) {
            $sender->sendMessage("§cYou must be a player !");
            return;
        }

        if (isset($args[0])) {
            switch ($args[0]) {
                case "start":
                    if ($sender->hasPermission("razia.start.cmd")) {
                        $startX = 100;
                        $startY = 104;
                        $startZ = 100;
                        $endX = 150;
                        $endY = 104;
                        $endZ = 150;

                        $positions = [];

                        for ($i = 0; $i < 50; $i++) {
                            $x = mt_rand($startX, $endX);
                            $y = mt_rand($startY, $endY);
                            $z = mt_rand($startZ, $endZ);

                            $positions[] = [$x, $y, $z];
                        }

                        foreach ($positions as $position) {
                            $x = $position[0];
                            $y = $position[1];
                            $z = $position[2];

                            $sender->getWorld()->setBlock(new Vector3($x, $y, $z), VanillaBlocks::AMETHYST());
                        }
                        Main::getInstance()->getScheduler()->scheduleDelayedTask(new RaziaTask(), 20 * 20);

                        $server = Server::getInstance();
                        $server->broadcastMessage("§aThe Razia start ! Pickup the maximum amethyst you can !");
                    } else {
                        $sender->sendMessage("You can't start the Razia because you don't have the permission !");
                    }
                    break;
                case "stop":
                    if ($sender->hasPermission("razia.stop.cmd")) {
                        $startX = 100;
                        $startY = 104;
                        $startZ = 100;
                        $endX = 150;
                        $endY = 104;
                        $endZ = 150;

                        for ($x = $startX; $x <= $endX; $x++) {
                            for ($y = $startY; $y <= $endY; $y++) {
                                for ($z = $startZ; $z <= $endZ; $z++) {
                                    $sender->getWorld()->setBlock(new Vector3($x, $y, $z), VanillaBlocks::AIR());
                                }
                            }
                        }

                        Server::getInstance()->broadcastMessage("§cThe Razia was interrupted !");
                        $raziaData = new Config(Main::getInstance()->getDataFolder() . "razia.json", Config::JSON);
                        $raziaData->setAll([]);
                    } else {
                        $sender->sendMessage("You can't stop the Razia because you don't have the permission !");
                    }
                    break;
                default:
                    $sender->sendMessage("§cUsage: §7/razia start, /razia stop or /razia.");
                    break;
            }
        } else {
            $sender->teleport(new Position(100, 105, 100, $sender->getWorld()));
            $sender->sendMessage("§aYou've been teleported to the Razia, good luck !");
        }
    }
}