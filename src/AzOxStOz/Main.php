<?php

namespace AzOxStOz;

use AzOxStOz\Listener\RaziaListener;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use AzOxStOz\Command\RaziaCommand;

class Main extends PluginBase
{
    public static Main $instance;

    public function onEnable(): void
    {
        self::$instance = $this;
        Server::getInstance()->getLogger()->notice("§d»§f RaziaEvent is loaded ! (By AzOxStOz)");
        $this->getServer()->getPluginManager()->registerEvents(new RaziaListener(), $this);
        $this->getServer()->getCommandMap()->register("raziaCommand", new RaziaCommand("razia", "Start/Stop/Teleport to the razia event.", ["raziaevent"]));
    }

    public static function getInstance() : Main
    {
        return self::$instance;
    }
}