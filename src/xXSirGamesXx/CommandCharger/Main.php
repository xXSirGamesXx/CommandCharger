<?php
	
namespace xXSirGamesXx\CommandCharger;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat as C;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use onebone\economyapi\EconomyAPI;

class Main extends PluginBase implements Listener {
	const PREFIX_SUCCESS = C::WHITE . "[" . C::RED . "CommandCharger" . C::WHITE . "] " . C::GREEN; 
		
		public function onLoad() {
		$this->getLogger()->info("Loading CommandCharger");
	}
	
	public function onEnable() { 
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info("CommandCharger by xXSirGamesXx enabled!");
	}
	
	public function onDisable() { 
		$this->getLogger()->info("CommandCharger by xXSirGamesXx disabled!");
		$this->saveDefaultCnfig();
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) {
		if($cmd->getName() == "commandcharge") { 
			$sender->sendMessage(self::PREFIX_SUCCESS . "CommandCharger by xXSirGamesXx.");
		}
	}
	public function onPCommand(PlayerCommandPreprocessEvent $e){
		$player = $e->getPlayer();
		$msg = $e->getMessage();
	}
}
