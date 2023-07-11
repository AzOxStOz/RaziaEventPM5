<?php

namespace AzOxStOz;

use AzOxStOz\Listener\RaziaListener;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use AzOxStOz\Command\RaziaCommand;

class Main extends PluginBase
{

    public function onLoad(): void
    {
        self::$instance = $this;
    }

    public function onEnable(): void
    {
        Server::getInstance()->getLogger()->notice("§d»§f RaziaEvent is loaded ! (By AzOxStOz)");
        $this->getServer()->getPluginManager()->registerEvents(new RaziaListener(), $this);
        $this->getServer()->getCommandMap()->register("raziaCommand", new RaziaCommand("razia", "Start/Stop/Teleport to the razia event.", ["raziaevent"]));
    }
}