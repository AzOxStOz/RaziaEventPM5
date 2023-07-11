<?php

namespace AzOxStOz;

use AzOxStOz\Listener\RaziaListener;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use AzOxStOz\Command\RaziaCommand;
use pocketmine\utils\SingletonTrait;

class Main extends PluginBase
{
    use SingletonTrait;

    public function onLoad(): void
    {
        self::setInstance($this);
    }

    public function onEnable(): void
    {
        Server::getInstance()->getLogger()->notice("§d»§f RaziaEvent is loaded ! (By AzOxStOz)");
        $this->getServer()->getPluginManager()->registerEvents(new RaziaListener(), $this);
        $this->getServer()->getCommandMap()->register("raziaCommand", new RaziaCommand("razia", "Start/Stop/Teleport to the razia event.", ["raziaevent"]));
    }
}