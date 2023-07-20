<?php

namespace SVega9848\VegaReload\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;
use pocketmine\utils\TextFormat;
use SVega9848\VegaReload\Loader;

class ReloadCommand extends Command implements PluginOwned {

    public function __construct() {
        parent::__construct("vegareload", "Reload all of your plugins data with one command!", "", ["reload"]);
        $this->setPermission("vegareload.cmd");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        $plugin = $this->getOwningPlugin();
        
            if($sender->hasPermission("vegareload.cmd")) {
                $currentplugins = Loader::getInstance()->getServer()->getPluginManager()->getPlugins();
                foreach($currentplugins as $plugin) {
                    if(!in_array($plugin->getName() ,Loader::getInstance()->plugins->get("disabled-plugins"))) {
                        Loader::getInstance()->getServer()->getPluginManager()->disablePlugin($plugin);
                        Loader::getInstance()->getServer()->getPluginManager()->enablePlugin($plugin);
                    }
                }
                $sender->sendMessage(TextFormat::GREEN. "Done!");
            } else {
                $sender->sendMessage(TextFormat::RED. "You do not have permissions to use this command");
            }
    }

    public function getOwningPlugin(): Plugin {
        return Loader::getInstance();
    }
}
